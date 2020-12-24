package ir.amirsobhan.wallpaperapp.Adapter;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentStatePagerAdapter;

import ir.amirsobhan.wallpaperapp.Fragment.CategoryFragment;
import ir.amirsobhan.wallpaperapp.Fragment.HomeFragment;
import ir.amirsobhan.wallpaperapp.Fragment.SettingsFragment;

public class MainViewPagerAdapter extends FragmentStatePagerAdapter {

    public MainViewPagerAdapter(@NonNull FragmentManager fm) {
        super(fm);
    }

    @NonNull
    @Override
    public Fragment getItem(int position) {
        switch (position) {
            case 0:
                return new HomeFragment();
            case 1:
                return new CategoryFragment();
            case 2:
                return new SettingsFragment();
        }
        return null;    }

    @Override
    public int getCount() {
        return 3;
    }
}
