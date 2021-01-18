package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import com.google.firebase.messaging.FirebaseMessaging;

import java.util.ArrayList;
import java.util.List;

import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.Firebase.Config;
import ir.amirsobhan.wallpaperapp.Model.ApiResult;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class HomeFragment extends Fragment {
    ApiInterface apiInterface;
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
        //initial api interface
        apiInterface = RetrofitClient.getApiInterface();

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

        apiInterface.getWallpapers().enqueue(new Callback<List<Wallpaper>>() {
            @Override
            public void onResponse(Call<List<Wallpaper>> call, Response<List<Wallpaper>> response) {
                //Sync local database with server
                for (Wallpaper wallpaper : response.body()) {
                    if (!db.isExist(wallpaper.getId())) {
                        db.Insert(wallpaper);
                        BottomNavigationView navigationView = getActivity().findViewById(R.id.bottom_navigation);
                        navigationView.getOrCreateBadge(R.id.menu_home).setNumber(navigationView.getOrCreateBadge(R.id.menu_home).getNumber() + 1);
                    }
                }

                //set adapter and show recyclerView
                adapter = new WallpaperAdapter(getContext(), response.body());
                recyclerView.setAdapter(adapter);
                recyclerView.setVisibility(View.VISIBLE);

                //hide progress bar
                progressBar.setVisibility(View.GONE);
                refreshLayout.setRefreshing(false);

                if (getContext().getSharedPreferences("root", Context.MODE_PRIVATE).getString("token",null) == null){
                    SharedPreferences sharedPreferences = getContext().getSharedPreferences("root", Context.MODE_PRIVATE);

                    FirebaseMessaging.getInstance().getToken().addOnCompleteListener(new OnCompleteListener<String>() {
                        @Override
                        public void onComplete(@NonNull Task<String> task) {
                            if (!task.isSuccessful()) {
                                Log.w("token", "Fetching FCM registration token failed", task.getException());
                                return;
                            }

                            // Get FCM registration token
                            String token = task.getResult();

                            //Send to server
                            apiInterface.newToken(Config.PRIVATE_KEY,token).enqueue(new Callback<ApiResult>() {
                                @Override
                                public void onResponse(Call<ApiResult> call, Response<ApiResult> response) {
                                    if (response.code() == 200 && response.body().getOk()) {
                                        sharedPreferences.edit().putString("token",response.body().getToken()).apply();
                                    }
                                }

                                @Override
                                public void onFailure(Call<ApiResult> call, Throwable t) {
                                    sharedPreferences.edit().putString("token",null).apply();
                                }
                            });
                        }
                    });
                }
            }

            @Override
            public void onFailure(Call<List<Wallpaper>> call, Throwable t) {
                MaterialAlertDialogBuilder dialogBuilder = new MaterialAlertDialogBuilder(getContext())
                        .setTitle("Server not responding")
                        .setMessage("Check your connection and try again")
                        .setCancelable(false)
                        .setIcon(R.drawable.ic_baseline_wifi_off_24)
                        .setPositiveButton("try again", new DialogInterface.OnClickListener() {
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
                AlertDialog alertDialog = dialogBuilder.create();
                alertDialog.show();
            }
        });
    }
}