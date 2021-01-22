package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.Context;
import android.content.DialogInterface;
import android.content.res.Configuration;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ProgressBar;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.bottomnavigation.BottomNavigationView;

import java.util.ArrayList;
import java.util.List;

import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import ir.amirsobhan.wallpaperapp.UI.ThemeManager;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class HomeFragment extends Fragment {
    ApiInterface apiInterface;
    RecyclerView recyclerView;
    ProgressBar progressBar;
    WallpaperAdapter adapter;
    List<Wallpaper> wallpaperList = new ArrayList<Wallpaper>();
    List<Wallpaper> search_result = new ArrayList<Wallpaper>();
    WallpaperDB db;
    SwipeRefreshLayout refreshLayout;
    EditText searchBox;
    ImageView searchBtn;

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
                searchBox.setVisibility(View.GONE);
                getWallpaperList();
            }
        });

        //When search button click
        searchBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // If searchBox VISIBLE hide it
               if (searchBox.getVisibility() == View.VISIBLE){
                   searchBtn.setImageResource(R.drawable.ic_w_baseline_search_24);
                   searchBox.setVisibility(View.GONE);
                   searchBox.setText("");
                   adapter.updateList(wallpaperList);

                   //hide keyboard
                   InputMethodManager imm = (InputMethodManager) getContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                   imm.hideSoftInputFromWindow(searchBox.getWindowToken(), 0);
               } // If searchBox GONE show it
               else {
                   searchBtn.setImageResource(R.drawable.ic_baseline_close_24);
                   searchBox.setVisibility(View.VISIBLE);
                   searchBox.requestFocus();

                   // show keyboard
                   InputMethodManager imm = (InputMethodManager) getContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                   imm.showSoftInput(searchBox, InputMethodManager.SHOW_IMPLICIT);
               }
            }
        });

        // On text change in searchBox
        searchBox.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {

            }

            @Override
            public void afterTextChanged(Editable s) {
                if(TextUtils.isEmpty(s.toString())){
                    adapter.updateList(wallpaperList);
                }else{
                    search_result.clear();
                    for (Wallpaper wallpaper : wallpaperList) {
                        if(wallpaper.getTitle().toLowerCase().indexOf(s.toString().toLowerCase(),0) != -1){
                            search_result.add(wallpaper);
                        }
                    }
                    adapter.updateList(search_result);
                }
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
        searchBtn = getActivity().findViewById(R.id.search_btn);
        searchBox = view.findViewById(R.id.search_box);

        //if list scroll down hide searchBox
        recyclerView.setOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrolled(@NonNull RecyclerView recyclerView, int dx, int dy) {
                super.onScrolled(recyclerView, dx, dy);
                if (dy > 0){
                    if (searchBox.getVisibility() == View.VISIBLE) {
                        searchBtn.setImageResource(R.drawable.ic_w_baseline_search_24);
                        searchBox.setVisibility(View.GONE);
                        searchBox.setText("");
                        adapter.updateList(wallpaperList);

                        //hide keyboard
                        InputMethodManager imm = (InputMethodManager) getContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                        imm.hideSoftInputFromWindow(searchBox.getWindowToken(), 0);
                    }
                }
            }
        });
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
                wallpaperList = response.body();
                adapter = new WallpaperAdapter(getContext(), wallpaperList);
                recyclerView.setAdapter(adapter);
                recyclerView.setVisibility(View.VISIBLE);

                //hide progress bar
                progressBar.setVisibility(View.GONE);
                refreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(Call<List<Wallpaper>> call, Throwable t) {
                ThemeManager.getNetworkErrorDialog(getActivity(), new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        getWallpaperList();
                    }
                }).show();
            }
        });
    }
}