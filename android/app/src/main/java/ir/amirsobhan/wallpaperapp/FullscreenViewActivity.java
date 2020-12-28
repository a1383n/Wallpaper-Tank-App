package ir.amirsobhan.wallpaperapp;

import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.preference.PreferenceManager;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.DataSource;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.load.engine.GlideException;
import com.bumptech.glide.request.RequestListener;
import com.bumptech.glide.request.target.Target;
import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;
import com.google.android.material.snackbar.BaseTransientBottomBar;
import com.google.android.material.snackbar.Snackbar;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;

import ir.amirsobhan.wallpaperapp.Model.Wallpaper;

public class FullscreenViewActivity extends AppCompatActivity {
    private final String TAG = this.getClass().getSimpleName();
    private Wallpaper wallpaper;
    private ImageView imageView, backBtn;
    private ProgressBar progressBar;
    private TextView toolbar_title, sheetTitle, sheetCategory,sheetViews,sheetDownloads;
    private ConstraintLayout constraintLayout;
    private BottomSheetBehavior sheetBehavior;
    private ChipGroup chipGroup;
    private boolean isFullScreen = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        applyTheme();
        setContentView(R.layout.activity_fullscreen_view);

        Initialization();
        // Set toolbar title as wallpaper title
        toolbar_title.setText(wallpaper.getTitle());

        //Set bottomSheet textViews values
        sheetTitle.setText(wallpaper.getTitle());
        sheetCategory.setText(wallpaper.getCategory());
        sheetViews.setText(wallpaper.getViews()+"");
        sheetDownloads.setText(wallpaper.getDownloads()+"");

        //Set source wallpaper
        Glide.with(this).load(wallpaper.getWallpaper())
                .diskCacheStrategy(DiskCacheStrategy.AUTOMATIC)
                .addListener(new RequestListener<Drawable>() {
                    @Override
                    public boolean onLoadFailed(@Nullable GlideException e, Object model, Target<Drawable> target, boolean isFirstResource) {
                        return false;
                    }

                    @Override
                    public boolean onResourceReady(Drawable resource, Object model, Target<Drawable> target, DataSource dataSource, boolean isFirstResource) {
                        progressBar.setVisibility(View.GONE);
                        constraintLayout.setVisibility(View.VISIBLE);
                        return false;
                    }
                })
                .into(imageView);

        //set chips
        String[] tag_array = wallpaper.getTags().split(",");
        for (int i = 0; i < tag_array.length; i++) {
            Chip chip = new Chip(this);
            chip.setText(tag_array[i]);
            chipGroup.addView(chip, i);
        }
    }

    private void Initialization() {
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("");

        Type type = new TypeToken<Wallpaper>() {
        }.getType();
        wallpaper = new Gson().fromJson(getIntent().getStringExtra("json"), type);

        constraintLayout = findViewById(R.id.full_info_layout);
        sheetBehavior = BottomSheetBehavior.from(constraintLayout);
        imageView = findViewById(R.id.full_wallpaper);
        progressBar = findViewById(R.id.full_progress);
        toolbar_title = findViewById(R.id.full_toolbar_title);
        backBtn = findViewById(R.id.full_back_btn);
        sheetTitle = findViewById(R.id.full_sheet_title);
        sheetCategory = findViewById(R.id.full_sheet_category);
        chipGroup = findViewById(R.id.chipGroup);
        sheetViews = findViewById(R.id.textView);
        sheetDownloads = findViewById(R.id.textView2);


        //Back btn action
        backBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        constraintLayout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                sheetBehavior.setState(BottomSheetBehavior.STATE_EXPANDED);
            }
        });

        imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (sheetBehavior.getState() == BottomSheetBehavior.STATE_EXPANDED) {
                    sheetBehavior.setState(BottomSheetBehavior.STATE_COLLAPSED);
                }
            }
        });

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

    public void fullScreen() {

        // BEGIN_INCLUDE (get_current_ui_flags)
        // The UI options currently enabled are represented by a bitfield.
        // getSystemUiVisibility() gives us that bitfield.
        int uiOptions = getWindow().getDecorView().getSystemUiVisibility();
        int newUiOptions = uiOptions;
        // END_INCLUDE (get_current_ui_flags)
        // BEGIN_INCLUDE (toggle_ui_flags)
        boolean isImmersiveModeEnabled =
                ((uiOptions | View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY) == uiOptions);
        if (isImmersiveModeEnabled) {
            Log.i(TAG, "Turning immersive mode mode off. ");
        } else {
            Log.i(TAG, "Turning immersive mode mode on.");
        }

        newUiOptions ^= View.SYSTEM_UI_FLAG_HIDE_NAVIGATION;
        newUiOptions ^= View.SYSTEM_UI_FLAG_FULLSCREEN;
        newUiOptions ^= View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY;

        getWindow().getDecorView().setSystemUiVisibility(newUiOptions);
        //END_INCLUDE (set_ui_flags)

        isFullScreen = true;
        getSupportActionBar().hide();

        constraintLayout.setVisibility(View.GONE);

    }

    public void exitFullScreen(){
        getWindow().getDecorView().setSystemUiVisibility(View.VISIBLE);
        getSupportActionBar().show();
        constraintLayout.setVisibility(View.VISIBLE);
        isFullScreen = false;
    }
    @Override
    public void onBackPressed() {
        if (!isFullScreen) {
            if (sheetBehavior.getState() == BottomSheetBehavior.STATE_EXPANDED) {
                sheetBehavior.setState(BottomSheetBehavior.STATE_COLLAPSED);
            } else {
                super.onBackPressed();
            }
        } else {
            exitFullScreen();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.full_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()) {
            case R.id.go_fullscreen:
                fullScreen();
                Snackbar.make(imageView,"To exit fullscreen.Press back button", BaseTransientBottomBar.LENGTH_INDEFINITE)
                        .setAction("Exit Now", new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                exitFullScreen();
                            }
                        })
                        .show();
                break;
        }

        return super.onOptionsItemSelected(item);
    }
}