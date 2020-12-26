package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

import androidx.preference.Preference;
import androidx.preference.PreferenceFragmentCompat;
import androidx.preference.SwitchPreferenceCompat;

import com.google.android.material.snackbar.BaseTransientBottomBar;
import com.google.android.material.snackbar.Snackbar;

import ir.amirsobhan.wallpaperapp.MainActivity;
import ir.amirsobhan.wallpaperapp.R;

public class SettingsFragment extends PreferenceFragmentCompat {
    SwitchPreferenceCompat switchDark;

    @Override
    public void onCreatePreferences(Bundle savedInstanceState, String rootKey) {
        setPreferencesFromResource(R.xml.root_preferences, rootKey);


        switchDark = findPreference("dark");
        switchDark.setOnPreferenceChangeListener(new Preference.OnPreferenceChangeListener() {
            @Override
            public boolean onPreferenceChange(Preference preference, Object newValue) {
                Snackbar.make(getView(), "Saved,The app must be restarted to apply the new theme", BaseTransientBottomBar.LENGTH_INDEFINITE)
                        .setAnchorView(getActivity().findViewById(R.id.bottom_navigation))
                        .setAction("Restart", new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                startActivity(new Intent(getActivity(), MainActivity.class));
                                getActivity().finish();
                            }
                        })
                        .show();
                return true;
            }
        });
    }
}