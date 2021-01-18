package ir.amirsobhan.wallpaperapp;

import android.Manifest;
import android.app.WallpaperManager;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.os.Build;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
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
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import com.google.android.material.snackbar.BaseTransientBottomBar;
import com.google.android.material.snackbar.Snackbar;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.io.IOException;
import java.lang.reflect.Type;
import java.util.Date;

import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.Model.ApiResult;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class WallpaperSetActivity extends AppCompatActivity {
    private final String TAG = this.getClass().getSimpleName();
    private Wallpaper wallpaper;
    private ImageView imageView, backBtn;
    private ProgressBar progressBar;
    private TextView toolbar_title, sheetTitle, sheetCategory, sheetViews, sheetDownloads;
    private ConstraintLayout constraintLayout;
    private BottomSheetBehavior sheetBehavior;
    private ChipGroup chipGroup;
    private boolean isFullScreen = false;
    private Snackbar snackbar;
    private AlertDialog alertDialog;
    private MaterialAlertDialogBuilder setDialog;
    private final String[] setDialogListItem = new String[]{"Home Screen", "Lock Screen", "Both", "Save to gallery"};
    private int setDialogListSelect = 0;
    private ApiInterface apiInterface;
    private WallpaperDB db;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        applyTheme();
        setContentView(R.layout.activity_wallpaper_set);

        Initialization();
        // Set toolbar title as wallpaper title
        toolbar_title.setText(wallpaper.getTitle());

        //Set bottomSheet textViews values
        sheetTitle.setText(wallpaper.getTitle());
        sheetCategory.setText(wallpaper.getCategory().getName());
        sheetViews.setText(wallpaper.getViews() + "");
        sheetDownloads.setText(wallpaper.getDownloads() + "");

        //Set source wallpaper
        Glide.with(this).load(wallpaper.getWallpaperUrl())
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
                }else if (!isFullScreen){
                    fullScreen();
                }else {
                    exitFullScreen();
                }
            }
        });

        sheetBehavior.setState(BottomSheetBehavior.STATE_EXPANDED);

        apiInterface = RetrofitClient.getApiInterface();

        db = new WallpaperDB(this);
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

   //     newUiOptions ^= View.SYSTEM_UI_FLAG_HIDE_NAVIGATION;
        newUiOptions ^= View.SYSTEM_UI_FLAG_FULLSCREEN;
        newUiOptions ^= View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY;

        getWindow().getDecorView().setSystemUiVisibility(newUiOptions);
        //END_INCLUDE (set_ui_flags)

        isFullScreen = true;
        getSupportActionBar().hide();
        constraintLayout.setVisibility(View.GONE);

        constraintLayout.setVisibility(View.GONE);
        ViewGroup.LayoutParams layoutParams = imageView.getLayoutParams();
        layoutParams.width = getWindowManager().getDefaultDisplay().getWidth();
        layoutParams.height = getWindowManager().getDefaultDisplay().getHeight();
        imageView.setLayoutParams(layoutParams);

        snackbar = Snackbar.make(imageView, "Press back button\nFor exit fullscreen", BaseTransientBottomBar.LENGTH_SHORT)
                .setAction("Exit Now", new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        exitFullScreen();
                    }
                });

        snackbar.show();

    }

    public void exitFullScreen() {
        getWindow().getDecorView().setSystemUiVisibility(View.VISIBLE);
        getSupportActionBar().show();
        constraintLayout.setVisibility(View.VISIBLE);
        isFullScreen = false;
        snackbar.dismiss();
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
                break;
            case R.id.set_wallpaper:
                setDialogListSelect = 0;
                setDialog = new MaterialAlertDialogBuilder(this);
                setDialog.setTitle("Set wallpaper as ...");
                setDialog.setIcon(R.drawable.ic_baseline_wallpaper_24);
                setDialog.setSingleChoiceItems(setDialogListItem, 0, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        setDialogListSelect = which;
                        if (which == 3) {
                            if (!checkStoragePermission()) {
                                MaterialAlertDialogBuilder permissionDialog = new MaterialAlertDialogBuilder(WallpaperSetActivity.this)
                                        .setTitle("Requires permission")
                                        .setMessage("We need a storage permission to save the photo in the gallery")
                                        .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialog, int which) {
                                                requestStoragePermission();
                                            }
                                        })
                                        .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialog, int which) {
                                                setDialogListSelect = 0;
                                                alertDialog.cancel();
                                                alertDialog = setDialog.create();
                                                alertDialog.show();
                                            }
                                        });
                                alertDialog.cancel();
                                alertDialog = permissionDialog.create();
                                alertDialog.show();
                            }
                        }
                    }
                });
                setDialog.setNegativeButton("Cancel", null);
                setDialog.setPositiveButton("Set", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        switch (setDialogListSelect){
                            case 0:
                                setWallpaper(WallpaperManager.FLAG_SYSTEM);
                                Snackbar.make(imageView,"Applied.Check your HomeScreen background",BaseTransientBottomBar.LENGTH_LONG)
                                        .setAnchorView(constraintLayout).show();
                                break;
                            case 1:
                                setWallpaper(WallpaperManager.FLAG_LOCK);
                                Snackbar.make(imageView,"Applied.Check your LockScreen background",BaseTransientBottomBar.LENGTH_LONG)
                                        .setAnchorView(constraintLayout).show();
                                break;
                            case 2:
                                setWallpaper(WallpaperManager.FLAG_SYSTEM | WallpaperManager.FLAG_LOCK);
                                Snackbar.make(imageView,"Applied.Check your Screen background",BaseTransientBottomBar.LENGTH_LONG)
                                        .setAnchorView(constraintLayout).show();
                                break;
                            case 3:
                                saveWallpaper();
                                Snackbar.make(imageView,"Saved.Check your gallery",BaseTransientBottomBar.LENGTH_LONG)
                                        .setAnchorView(constraintLayout).show();
                                break;
                        }
                    }
                });

                alertDialog =  setDialog.create();
                alertDialog.show();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    private boolean checkStoragePermission() {
        return ContextCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE) == PackageManager.PERMISSION_GRANTED;
    }

    private void requestStoragePermission() {
        ActivityCompat.requestPermissions(WallpaperSetActivity.this, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE}, 100);
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == 100) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                alertDialog.cancel();
                alertDialog = setDialog.setSingleChoiceItems(setDialogListItem, 3, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {

                    }
                }).create();
                alertDialog.show();

            }else{
                Toast.makeText(this, "Could't access to Storage.Need Permission ", Toast.LENGTH_SHORT).show();
            }
        }
    }

    private void setWallpaper(int flag) {
        WallpaperManager wallpaperManager = (WallpaperManager) getSystemService(WALLPAPER_SERVICE);

        sendDownloadStatusToServer(wallpaper.getId());

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            if (wallpaperManager.isSetWallpaperAllowed()){
                try {
                    wallpaperManager.setBitmap(getImageBitmap(),null,true,flag);
                } catch (IOException e) {
                    e.printStackTrace();
                }
                wallpaperManager.suggestDesiredDimensions(getWindowManager().getDefaultDisplay().getWidth(),getWindowManager().getDefaultDisplay().getHeight());
            }
        }else{
            alertDialog.cancel();
            alertDialog = errorDialog();
            alertDialog.show();
        }
    }

    private AlertDialog errorDialog(){
        MaterialAlertDialogBuilder materialAlertDialogBuilder = new MaterialAlertDialogBuilder(WallpaperSetActivity.this);
        materialAlertDialogBuilder.setTitle("Sorry");
        materialAlertDialogBuilder.setMessage("We can't set wallpaper automatic\nYour device doesn't support this feature But You can save wallpaper in gallery and set manually");
        materialAlertDialogBuilder.setNegativeButton("Ok",null);
        return materialAlertDialogBuilder.create();
    }

    private void saveWallpaper(){
        sendDownloadStatusToServer(wallpaper.getId());

        MediaStore.Images.Media.insertImage(getContentResolver(),getImageBitmap(),wallpaper.getTitle(),new Date().toString());
    }

    private Bitmap getImageBitmap(){
        BitmapDrawable bitmapDrawable = (BitmapDrawable) imageView.getDrawable();
        return bitmapDrawable.getBitmap();
    }

    private void sendDownloadStatusToServer(int id){
        apiInterface.download(RetrofitClient.getAuthorizationToken(this),id).enqueue(new Callback<ApiResult>() {
            @Override
            public void onResponse(Call<ApiResult> call, Response<ApiResult> response) {
                if (response.isSuccessful()){
                    if (response.body().getOk()) {
                        db.setDownloaded(id);
                        wallpaper.setDownloads(wallpaper.getDownloads() + 1);
                        sheetDownloads.setText(wallpaper.getDownloads() + "");
                    }
                }
                Log.d("Download",response.message());
            }

            @Override
            public void onFailure(Call<ApiResult> call, Throwable t) {
                Log.d("Download",t.toString());

            }
        });
    }
}