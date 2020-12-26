package ir.amirsobhan.wallpaperapp.Fragment;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import ir.amirsobhan.wallpaperapp.Adapter.CategoryAdapter;
import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Databases.CategoryDB;
import ir.amirsobhan.wallpaperapp.Model.Category;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;
public class CategoryFragment extends Fragment {
    RecyclerView recyclerView;
    CategoryAdapter categoryAdapter;
    ProgressBar progressBar;
    List<Category> categoryList = new ArrayList<Category>();
    CategoryDB db;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_category, container, false);
        Initialization(view);

        getCategory();

        return view;
    }
    private void Initialization(View view){
        recyclerView = view.findViewById(R.id.category_recycler);
        progressBar = view.findViewById(R.id.category_recycler_progressBar);

        db = new CategoryDB(getContext());

        RecyclerView.LayoutManager layoutManager = new GridLayoutManager(getContext(), 2);
        recyclerView.setLayoutManager(layoutManager);
    }

    private void getCategory(){
        RequestQueue queue = Volley.newRequestQueue(getContext());
        String url = "https://amirsobhan.ir/wallpaper/api/web/getCategory";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                //Initialization GSON
                GsonBuilder gsonBuilder = new GsonBuilder();
                Gson gson = gsonBuilder.create();

                // Set TypeToken
                Type type = new TypeToken<List<Category>>() {
                }.getType();

                // Convert JSON to OBJECT
                categoryList = gson.fromJson(response, type);

                categoryAdapter = new CategoryAdapter(getContext(), categoryList);
                recyclerView.setAdapter(categoryAdapter);

                progressBar.setVisibility(View.GONE);
                recyclerView.setVisibility(View.VISIBLE);

                //Sync SERVER with local database
                for (int i = 0; i < categoryList.size(); i++) {
                    if (!db.isExist(categoryList.get(i).getId())) {
                        db.Insert(categoryList.get(i));
                        BottomNavigationView navigationView = getActivity().findViewById(R.id.bottom_navigation);
                        navigationView.getOrCreateBadge(R.id.menu_category).setNumber(navigationView.getOrCreateBadge(R.id.menu_category).getNumber()+1);
                    }
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }){
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("Authentication", "123456789");

                return params;
            }
        };
        queue.add(stringRequest);
    }
}