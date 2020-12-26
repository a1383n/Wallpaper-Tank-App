package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

import androidx.preference.Preference;
import androidx.preference.PreferenceFragmentCompat;
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

import java.util.HashMap;
import java.util.Map;

import ir.amirsobhan.wallpaperapp.MainActivity;
import ir.amirsobhan.wallpaperapp.R;

public class SettingsFragment extends PreferenceFragmentCompat {
    SwitchPreferenceCompat switchDark;
    SwitchPreferenceCompat switchNotification;
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

        switchNotification = findPreference("notification");
        switchNotification.setOnPreferenceChangeListener(new Preference.OnPreferenceChangeListener() {
            @Override
            public boolean onPreferenceChange(Preference preference, Object newValue) {
                sendRegistrationToServer(FirebaseInstanceId.getInstance().getToken());
                return true;
            }
        });
    }
    private void sendRegistrationToServer(final String token) {
        // sending gcm token to server
        RequestQueue queue = Volley.newRequestQueue(getContext());
        String url = "https://amirsobhan.ir/wallpaper/api/web/newToken";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

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
                params.put("token", token);

                return params;
            }
        };
        queue.add(stringRequest);
    }

}