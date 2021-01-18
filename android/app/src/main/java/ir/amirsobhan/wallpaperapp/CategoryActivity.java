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
<<<<<<< Updated upstream
=======
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import ir.amirsobhan.wallpaperapp.UI.ThemeManager;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
>>>>>>> Stashed changes

public class CategoryActivity extends AppCompatActivity {
    private Category category;
    private RecyclerView recyclerView;
    private WallpaperAdapter adapter;
    private List<Wallpaper> list = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        // Set Activity Theme
        setTheme(ThemeManager.getTheme(this));
        setContentView(R.layout.activity_category);

        // Get json from Intent and convert to Category
        Type type = new TypeToken<Category>() {
        }.getType();
        category = new Gson().fromJson(getIntent().getStringExtra("json"), type);

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

    /**
     * Get Wallpapers in this category from server
     */
    private void getCategoryWallpaper() {
<<<<<<< Updated upstream
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
=======
      apiInterface.getWallpaperWhereCategory(category.getId()).enqueue(new Callback<List<Wallpaper>>() {
          @Override
          public void onResponse(Call<List<Wallpaper>> call, Response<List<Wallpaper>> response) {
              if (response.isSuccessful()){
                  //Put response to adapter and set to recyclerview
                  adapter = new WallpaperAdapter(getApplicationContext(),response.body());
                  recyclerView.setAdapter(adapter);
                  recyclerView.setVisibility(View.VISIBLE);
              }else{
                  Toast.makeText(CategoryActivity.this, response.errorBody().toString(), Toast.LENGTH_SHORT).show();
              }
          }

          @Override
          public void onFailure(Call<List<Wallpaper>> call, Throwable t) {
              //Show ErrorDialog
              ThemeManager.getNetworkErrorDialog(CategoryActivity.this, new DialogInterface.OnClickListener() {
                  @Override
                  public void onClick(DialogInterface dialog, int which) {
                      getCategoryWallpaper();
                  }
              }).show();
          }
      });
>>>>>>> Stashed changes
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == android.R.id.home){
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}