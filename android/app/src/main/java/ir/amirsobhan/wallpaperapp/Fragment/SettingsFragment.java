package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;

import androidx.preference.Preference;
import androidx.preference.PreferenceFragmentCompat;
import androidx.preference.PreferenceManager;
import androidx.preference.SwitchPreferenceCompat;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.snackbar.BaseTransientBottomBar;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.messaging.FirebaseMessaging;

import java.util.HashMap;
import java.util.Map;

import ir.amirsobhan.wallpaperapp.CustomCheckBoxPreference;
import ir.amirsobhan.wallpaperapp.Firebase.Config;
import ir.amirsobhan.wallpaperapp.MainActivity;
import ir.amirsobhan.wallpaperapp.R;

public class SettingsFragment extends PreferenceFragmentCompat {
    SwitchPreferenceCompat switchDark;
    SwitchPreferenceCompat switchNotification;
    CustomCheckBoxPreference switchWallpaperNotification,switchCategoryNotification;

    SharedPreferences sharedPreferences;
    @Override
    public void onCreatePreferences(Bundle savedInstanceState, String rootKey) {
        setPreferencesFromResource(R.xml.root_preferences, rootKey);
        sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getContext());

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

        switchNotification = findPreference("notification");

        if (sharedPreferences.getBoolean(switchNotification.getKey(),true)){
            switchNotification.setChecked(true);
            FirebaseMessaging.getInstance().subscribeToTopic(Config.TOPIC_GLOBAL);
        }else{
            FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_GLOBAL);
            FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_WALLPAPER);
            FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_CATEGORY);

        }

        switchNotification.setOnPreferenceChangeListener(new Preference.OnPreferenceChangeListener() {
            @Override
            public boolean onPreferenceChange(Preference preference, Object newValue) {
                if ((boolean) newValue){
                    FirebaseMessaging.getInstance().subscribeToTopic(Config.TOPIC_GLOBAL);
                }else {
                    FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_GLOBAL);
                    FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_WALLPAPER);
                    FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_CATEGORY);

                    switchWallpaperNotification.setChecked(false);
                    switchCategoryNotification.setChecked(false);
                }
                return true;
            }
        });


        switchWallpaperNotification = findPreference("wallpaper_notify");
        switchCategoryNotification = findPreference("category_notify");

        switchWallpaperNotification.setOnPreferenceChangeListener(new Preference.OnPreferenceChangeListener() {
            @Override
            public boolean onPreferenceChange(Preference preference, Object newValue) {
                if ((boolean) newValue){
                    FirebaseMessaging.getInstance().subscribeToTopic(Config.TOPIC_WALLPAPER);
                }else{
                    FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_WALLPAPER);
                }
                return true;
            }
        });

        switchCategoryNotification.setOnPreferenceChangeListener(new Preference.OnPreferenceChangeListener() {
            @Override
            public boolean onPreferenceChange(Preference preference, Object newValue) {
                if ((boolean) newValue){
                    FirebaseMessaging.getInstance().subscribeToTopic(Config.TOPIC_CATEGORY);
                }else {
                    FirebaseMessaging.getInstance().unsubscribeFromTopic(Config.TOPIC_CATEGORY);
                }
                return true;
            }
        });
    }

}