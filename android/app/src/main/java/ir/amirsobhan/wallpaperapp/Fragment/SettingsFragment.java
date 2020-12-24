package ir.amirsobhan.wallpaperapp.Fragment;

import android.os.Bundle;

import androidx.preference.PreferenceFragmentCompat;

import ir.amirsobhan.wallpaperapp.R;

public class SettingsFragment extends PreferenceFragmentCompat {

    @Override
    public void onCreatePreferences(Bundle savedInstanceState, String rootKey) {
        setPreferencesFromResource(R.xml.root_preferences, rootKey);
    }
}