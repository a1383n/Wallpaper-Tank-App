package ir.amirsobhan.wallpaperapp;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;
import androidx.viewpager.widget.ViewPager;

import android.os.Bundle;
import android.view.MenuItem;
import android.widget.Toast;

import com.google.android.material.bottomnavigation.BottomNavigationView;

import ir.amirsobhan.wallpaperapp.Adapter.MainViewPagerAdapter;
import ir.amirsobhan.wallpaperapp.Fragment.CategoryFragment;
import ir.amirsobhan.wallpaperapp.Fragment.HomeFragment;
import ir.amirsobhan.wallpaperapp.Fragment.SettingsFragment;

public class MainActivity extends AppCompatActivity {
    private BottomNavigationView navigationView;
    private ViewPager viewPager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
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
                        break;
                    case 1:
                        navigationView.getMenu().findItem(R.id.menu_category).setChecked(true);
                        break;
                    case 2:
                        navigationView.getMenu().findItem(R.id.menu_setting).setChecked(true);
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
    }
    private void Initialization(){
        navigationView = findViewById(R.id.bottom_navigation);
        viewPager = findViewById(R.id.main_viewpager);
        viewPager.setAdapter(new MainViewPagerAdapter(getSupportFragmentManager()));
    }
}