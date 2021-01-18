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
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;

import java.util.ArrayList;
import java.util.List;

import ir.amirsobhan.wallpaperapp.Adapter.CategoryAdapter;
import ir.amirsobhan.wallpaperapp.Databases.CategoryDB;
import ir.amirsobhan.wallpaperapp.Model.Category;
import ir.amirsobhan.wallpaperapp.R;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import ir.amirsobhan.wallpaperapp.UI.ThemeManager;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CategoryFragment extends Fragment {
    ApiInterface apiInterface;
    RecyclerView recyclerView;
    CategoryAdapter categoryAdapter;
    ProgressBar progressBar;
    List<Category> categoryList = new ArrayList<Category>();
    CategoryDB db;
    SwipeRefreshLayout refreshLayout;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_category, container, false);
        Initialization(view);

        getAllCategory();

        refreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                getAllCategory();
            }
        });
        return view;
    }
    private void Initialization(View view){
        apiInterface = RetrofitClient.getApiInterface();

        recyclerView = view.findViewById(R.id.category_recycler);
        progressBar = view.findViewById(R.id.category_recycler_progressBar);
        refreshLayout = view.findViewById(R.id.category_refresh);

        db = new CategoryDB(getContext());

        //Setup layoutManager
        RecyclerView.LayoutManager layoutManager = null;

        // Check device screen size
        if ((getContext().getResources().getConfiguration().screenLayout & Configuration.SCREENLAYOUT_SIZE_MASK) == Configuration.SCREENLAYOUT_SIZE_LARGE) {
            // Large screen device
            // Show grid
            layoutManager = new GridLayoutManager(getContext(), 3);
        } else {
            // Small and Normal screen size
            // Show vertical list
            layoutManager = new GridLayoutManager(getContext(), 2);
        }
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setItemAnimator(new DefaultItemAnimator());
    }

    private void getAllCategory(){
        apiInterface.getCategories().enqueue(new Callback<List<Category>>() {
            @Override
            public void onResponse(Call<List<Category>> call, Response<List<Category>> response) {
                //Sync local database with server
                for (Category category : response.body()) {
                    if (!db.isExist(category.getId())){
                        db.Insert(category);
                        BottomNavigationView navigationView = getActivity().findViewById(R.id.bottom_navigation);
                        navigationView.getOrCreateBadge(R.id.menu_category).setNumber(navigationView.getOrCreateBadge(R.id.menu_category).getNumber() + 1);
                    }

                    //set adapter and show recyclerView
                    categoryAdapter = new CategoryAdapter(getContext(),response.body());
                    recyclerView.setAdapter(categoryAdapter);
                    recyclerView.setVisibility(View.VISIBLE);

                    //hide progress bar
                    progressBar.setVisibility(View.GONE);
                    refreshLayout.setRefreshing(false);
                }
                categoryAdapter = new CategoryAdapter(getContext(),response.body());
                recyclerView.setAdapter(categoryAdapter);
            }

            @Override
            public void onFailure(Call<List<Category>> call, Throwable t) {
                ThemeManager.getNetworkErrorDialog(getActivity(), new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        getAllCategory();
                    }
                });
            }
        });
    }
}