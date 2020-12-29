package ir.amirsobhan.wallpaperapp;

import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.graphics.Color;
import android.os.Bundle;
import android.view.MenuItem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.preference.PreferenceManager;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.appbar.CollapsingToolbarLayout;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Model.Category;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;

public class CategoryActivity extends AppCompatActivity {
    private Category category;
    private RecyclerView recyclerView;
    private WallpaperAdapter adapter;
    private List<Wallpaper> list = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        applyTheme();
        setContentView(R.layout.activity_category);
        Type type = new TypeToken<Category>() {
        }.getType();
        category = new Gson().fromJson(getIntent().getStringExtra("json"), type);

        // Initialization
        Initialization();

        getCategoryWallpaper();
    }

    private void Initialization() {
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        CollapsingToolbarLayout toolBarLayout = findViewById(R.id.toolbar_layout);
        toolBarLayout.setTitle(category.getTitle());
        getSupportActionBar().setTitle(category.getTitle());
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        toolBarLayout.setContentScrimColor(Color.parseColor(category.getColor()));
        findViewById(R.id.app_bar).setBackgroundColor(Color.parseColor(category.getColor()));

        recyclerView = findViewById(R.id.category_wallpaper_recycler);

        //Setup layoutManager
        RecyclerView.LayoutManager layoutManager = null;

        // Check device screen size
        if ((getResources().getConfiguration().screenLayout & Configuration.SCREENLAYOUT_SIZE_MASK) == Configuration.SCREENLAYOUT_SIZE_LARGE) {
            // Large screen device
            // Show grid
            layoutManager = new GridLayoutManager(this, 2);
        } else {
            // Small and Normal screen size
            // Show vertical list
            layoutManager = new LinearLayoutManager(this, RecyclerView.VERTICAL, false);
        }
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setItemAnimator(new DefaultItemAnimator());
    }

    private void applyTheme() {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(this);
        switch (preferences.getString("theme", "Light")) {
            case "Light":
                setTheme(R.style.AppTheme);
                break;
            case "Dark":
                setTheme(R.style.DarkTheme);
                break;
            case "System Default":
                switch (getResources().getConfiguration().uiMode & Configuration.UI_MODE_NIGHT_MASK) {
                    case Configuration.UI_MODE_NIGHT_YES:
                        setTheme(R.style.DarkTheme);
                        break;
                    case Configuration.UI_MODE_NIGHT_NO:
                        setTheme(R.style.AppTheme);
                        break;
                }
                break;
        }
    }

    private void getCategoryWallpaper() {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        String url = "https://amirsobhan.ir/wallpaper/api/web/getWallpapers";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Type type = new TypeToken<ArrayList<Wallpaper>>() {
                }.getType();
                list = new Gson().fromJson(response, type);

                adapter = new WallpaperAdapter(getApplicationContext(), list);

                recyclerView.setAdapter(adapter);
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                //Send Authentication in header
                params.put("Authentication", "123456789");

                return params;
            }

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("category", category.getName());

                return params;
            }
        };
        requestQueue.add(stringRequest);
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == android.R.id.home){
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}