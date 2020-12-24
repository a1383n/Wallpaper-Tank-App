package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.res.Configuration;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
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
    WallpaperAdapter adapter;
    List<Wallpaper> wallpaperList = new ArrayList<Wallpaper>();
    WallpaperDB db;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);
        Initialization();

        recyclerView = view.findViewById(R.id.wallpaper_recycler);
        RecyclerView.LayoutManager layoutManager = null;

        // Check device screen size
        if ((getContext().getResources().getConfiguration().screenLayout & Configuration.SCREENLAYOUT_SIZE_MASK) == Configuration.SCREENLAYOUT_SIZE_LARGE) {
            // large screen device
            layoutManager = new GridLayoutManager(getContext(), 2);
        } else {
            // Small and Normal screen size
            layoutManager = new LinearLayoutManager(getContext(), RecyclerView.VERTICAL, false);
        }
        recyclerView.setLayoutManager(layoutManager);
        getWallpaperList();
        return view;
    }

    private void Initialization() {
        db = new WallpaperDB(getContext());
    }

    private void getWallpaperList() {
        // Instantiate the RequestQueue.
        RequestQueue queue = Volley.newRequestQueue(getContext());

        String url = "https://amirsobhan.ir/wallpaper/api/web/getWallpapers";
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                //Initialization GSON
                GsonBuilder gsonBuilder = new GsonBuilder();
                Gson gson = gsonBuilder.create();

                // Set TypeToken
                Type type = new TypeToken<List<Wallpaper>>() {}.getType();

                // Convert JSON to OBJECT
                wallpaperList = gson.fromJson(response, type);

                adapter = new WallpaperAdapter(getContext(), wallpaperList);
                recyclerView.setAdapter(adapter);

                //Sync SERVER with local database
                for (int i = 0; i < wallpaperList.size(); i++){
                    if (!db.isExist(wallpaperList.get(i).getId())){
                        db.Insert(wallpaperList.get(i));
                    }
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                // TODO : HANDLE ERROR
            }
        }) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("Authentication", "123456789");

                return params;
            }
        };

        //Add to RequestQueue
        queue.add(stringRequest);
    }
}