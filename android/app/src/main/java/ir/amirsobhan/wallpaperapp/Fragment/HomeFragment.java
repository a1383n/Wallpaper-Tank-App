package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.DialogInterface;
import android.content.res.Configuration;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;

public class HomeFragment extends Fragment {
    RecyclerView recyclerView;
    ProgressBar progressBar;
    WallpaperAdapter adapter;
    List<Wallpaper> wallpaperList = new ArrayList<Wallpaper>();
    WallpaperDB db;
    SwipeRefreshLayout refreshLayout;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        //Inflate layout
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        // Initialization
        Initialization(view);

        //Setup layoutManager
        RecyclerView.LayoutManager layoutManager = null;

        // Check device screen size
        if ((getContext().getResources().getConfiguration().screenLayout & Configuration.SCREENLAYOUT_SIZE_MASK) == Configuration.SCREENLAYOUT_SIZE_LARGE) {
            // Large screen device
            // Show grid
            layoutManager = new GridLayoutManager(getContext(), 2);
        } else {
            // Small and Normal screen size
            // Show vertical list
            layoutManager = new LinearLayoutManager(getContext(), RecyclerView.VERTICAL, false);
        }
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setItemAnimator(new DefaultItemAnimator());

        //Get Data from server and set to list
        getWallpaperList();

        //setup swipeRefreshLayout
        refreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                getWallpaperList();
            }
        });

        return view;
    }

    private void Initialization(View view) {
        //initial local Database
        db = new WallpaperDB(getContext());

        //Find views
        recyclerView = view.findViewById(R.id.wallpaper_recycler);
        progressBar = view.findViewById(R.id.wallpaper_recycler_progress);
        refreshLayout = view.findViewById(R.id.home_refresh);
    }

    private void getWallpaperList() {
        // Hide RecyclerView
        recyclerView.setVisibility(View.GONE);

        // Instantiate the RequestQueue.
        RequestQueue queue = Volley.newRequestQueue(getContext());
        String url = "https://amirsobhan.ir/wallpaper/api/web/getWallpapers";

        // New string Request
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                //Initialization GSON
                GsonBuilder gsonBuilder = new GsonBuilder();
                Gson gson = gsonBuilder.create();

                // Set TypeToken
                Type type = new TypeToken<List<Wallpaper>>() {
                }.getType();

                // Convert JSON to OBJECT
                wallpaperList = gson.fromJson(response, type);

                //Create Adapter and set to recyclerView
                adapter = new WallpaperAdapter(getContext(), wallpaperList);
                recyclerView.setAdapter(adapter);

                //Show recyclerView
                progressBar.setVisibility(View.GONE);
                recyclerView.setVisibility(View.VISIBLE);

                //Stop refreshing
                refreshLayout.setRefreshing(false);

                //Sync local database with Server
                for (int i = 0; i < wallpaperList.size(); i++) {
                    if (!db.isExist(wallpaperList.get(i).getId())) {
                        db.Insert(wallpaperList.get(i));
                        BottomNavigationView navigationView = getActivity().findViewById(R.id.bottom_navigation);
                        navigationView.getOrCreateBadge(R.id.menu_home).setNumber(navigationView.getOrCreateBadge(R.id.menu_home).getNumber()+1);
                    }
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                MaterialAlertDialogBuilder dialogBuilder = new MaterialAlertDialogBuilder(getContext())
                        .setTitle("Server not responding")
                        .setMessage("Check your connection and try again")
                        .setCancelable(false)
                        .setIcon(R.drawable.ic_baseline_wifi_off_24)
                        .setPositiveButton("Try again", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                getWallpaperList();
                            }
                        })
                        .setNegativeButton("Exit", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                getActivity().finish();
                            }
                        });
                AlertDialog dialog = dialogBuilder.create();
                dialog.show();
            }
        }) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                //Send Authentication in header
                params.put("Authentication", "123456789");

                return params;
            }
        };

        //Add to RequestQueue
        queue.add(stringRequest);
    }
}