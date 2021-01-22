package ir.amirsobhan.wallpaperapp;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.fragment.app.Fragment;
import androidx.localbroadcastmanager.content.LocalBroadcastManager;
import androidx.viewpager.widget.ViewPager;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.firebase.analytics.FirebaseAnalytics;
import com.google.firebase.messaging.FirebaseMessaging;

import ir.amirsobhan.wallpaperapp.Adapter.MainViewPagerAdapter;
import ir.amirsobhan.wallpaperapp.Firebase.Config;
import ir.amirsobhan.wallpaperapp.Firebase.NotificationUtils;
import ir.amirsobhan.wallpaperapp.Model.ApiResult;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import ir.amirsobhan.wallpaperapp.UI.BottomNavigationBehavior;
import ir.amirsobhan.wallpaperapp.UI.ThemeManager;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {
    private BottomNavigationView navigationView;
    private ViewPager viewPager;

    private static final String TAG = MainActivity.class.getSimpleName();
    private BroadcastReceiver mRegistrationBroadcastReceiver;
    private FirebaseAnalytics mFirebaseAnalytics;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setTheme(ThemeManager.getTheme(this));

        setContentView(R.layout.activity_main);
        // Initialization Views
        Initialization();

        // Add viewpager listener
        viewPager.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                switch (position) {
                    case 0:
                        navigationView.getMenu().findItem(R.id.menu_home).setChecked(true);
                        findViewById(R.id.search_btn).setVisibility(View.VISIBLE);
                        break;
                    case 1:
                        navigationView.getMenu().findItem(R.id.menu_category).setChecked(true);
                        findViewById(R.id.search_btn).setVisibility(View.GONE);
                        break;
                    case 2:
                        navigationView.getMenu().findItem(R.id.menu_setting).setChecked(true);
                        findViewById(R.id.search_btn).setVisibility(View.GONE);
                        break;
                }
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });

        // Add navigationView listener
        navigationView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                Fragment fragment = null;
                switch (item.getItemId()) {
                    case R.id.menu_home:
                        viewPager.setCurrentItem(0);
                        return true;
                    case R.id.menu_category:
                        viewPager.setCurrentItem(1);
                        return true;
                    case R.id.menu_setting:
                        viewPager.setCurrentItem(2);
                        return true;
                }

                return false;
            }
        });

        //When user switch between pages, previous page data don't destroyed
        viewPager.setOffscreenPageLimit(3);

        //When user scroll, hide/show bottomNavigationView
        CoordinatorLayout.LayoutParams layoutParams = (CoordinatorLayout.LayoutParams) navigationView.getLayoutParams();
        layoutParams.setBehavior(new BottomNavigationBehavior());
    }

    private void Initialization() {
        navigationView = findViewById(R.id.bottom_navigation);
        viewPager = findViewById(R.id.main_viewpager);
        viewPager.setAdapter(new MainViewPagerAdapter(getSupportFragmentManager()));

        mFirebaseAnalytics = FirebaseAnalytics.getInstance(this);

        mRegistrationBroadcastReceiver = new BroadcastReceiver() {
            @Override
            public void onReceive(Context context, Intent intent) {

                // checking for type intent filter
                if (intent.getAction().equals(Config.REGISTRATION_COMPLETE)) {
                    // gcm successfully registered
                    // now subscribe to `global` topic to receive app wide notifications
                    FirebaseMessaging.getInstance().subscribeToTopic(Config.TOPIC_GLOBAL);

                } else if (intent.getAction().equals(Config.PUSH_NOTIFICATION)) {
                    // new push notification is received

                    String message = intent.getStringExtra("message");

                    Toast.makeText(getApplicationContext(), "Push notification: " + message, Toast.LENGTH_LONG).show();
                }
            }
        };


        if (RetrofitClient.getAuthorizationToken(getApplicationContext()) == null){
            FirebaseMessaging.getInstance().getToken().addOnCompleteListener(new OnCompleteListener<String>() {
                @Override
                public void onComplete(@NonNull Task<String> task) {
                    if (!task.isSuccessful()) {
                        Log.w("token", "Fetching FCM registration token failed", task.getException());
                        return;
                    }

                    // Get FCM registration token
                    String token = task.getResult();

                    ApiInterface apiInterface = RetrofitClient.getApiInterface();

                    //Send to server
                    apiInterface.newToken(Config.PRIVATE_KEY,token).enqueue(new Callback<ApiResult>() {
                        @Override
                        public void onResponse(Call<ApiResult> call, Response<ApiResult> response) {
                            Log.d("token",response.body().toString());
                            if (response.code() == 200 && response.body().getOk()) {
                                RetrofitClient.storeAuthorizationToken(getApplicationContext(),response.body().getToken());
                            }
                        }

                        @Override
                        public void onFailure(Call<ApiResult> call, Throwable t) {
                            RetrofitClient.storeAuthorizationToken(getApplicationContext(),null);
                        }
                    });
                }
            });
        }else{
            Log.d("token",RetrofitClient.getAuthorizationToken(getApplicationContext()));
        }
    }

    @Override
    protected void onResume() {
        super.onResume();

        // register GCM registration complete receiver
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                new IntentFilter(Config.REGISTRATION_COMPLETE));

        // register new push message receiver
        // by doing this, the activity will be notified each time a new message arrives
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                new IntentFilter(Config.PUSH_NOTIFICATION));

        // clear the notification area when the app is opened
        NotificationUtils.clearNotifications(getApplicationContext());
    }

    @Override
    protected void onPause() {
        super.onPause();
        LocalBroadcastManager.getInstance(this).unregisterReceiver(mRegistrationBroadcastReceiver);
    }
}