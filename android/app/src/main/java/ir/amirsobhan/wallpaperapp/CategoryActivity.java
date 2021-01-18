package ir.amirsobhan.wallpaperapp;

import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.preference.PreferenceManager;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.appbar.CollapsingToolbarLayout;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.List;

import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Model.Category;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CategoryActivity extends AppCompatActivity {
    private Category category;
    private RecyclerView recyclerView;
    private WallpaperAdapter adapter;
    private ApiInterface apiInterface;

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
        toolBarLayout.setTitle(category.getName());
        getSupportActionBar().setTitle(category.getName());
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

        apiInterface = RetrofitClient.getApiInterface();
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
      apiInterface.getWallpaperWhereCategory(category.getId()).enqueue(new Callback<List<Wallpaper>>() {
          @Override
          public void onResponse(Call<List<Wallpaper>> call, Response<List<Wallpaper>> response) {
              if (response.isSuccessful()){
                  adapter = new WallpaperAdapter(getApplicationContext(),response.body());
                  recyclerView.setAdapter(adapter);
                  recyclerView.setVisibility(View.VISIBLE);
              }else{
                  Toast.makeText(CategoryActivity.this, response.errorBody().toString(), Toast.LENGTH_SHORT).show();
              }
          }

          @Override
          public void onFailure(Call<List<Wallpaper>> call, Throwable t) {

              Log.d("TAG",t.getMessage());

              MaterialAlertDialogBuilder dialogBuilder = new MaterialAlertDialogBuilder(CategoryActivity.this)
                      .setTitle("Server not responding")
                      .setMessage("Check your connection and try again")
                      .setCancelable(false)
                      .setIcon(R.drawable.ic_baseline_wifi_off_24)
                      .setPositiveButton("try again", new DialogInterface.OnClickListener() {
                          @Override
                          public void onClick(DialogInterface dialog, int which) {
                              getCategoryWallpaper();
                          }
                      })
                      .setNegativeButton("Back", new DialogInterface.OnClickListener() {
                          @Override
                          public void onClick(DialogInterface dialog, int which) {
                              finish();
                          }
                      });
              AlertDialog alertDialog = dialogBuilder.create();
              alertDialog.show();
          }
      });
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == android.R.id.home){
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}