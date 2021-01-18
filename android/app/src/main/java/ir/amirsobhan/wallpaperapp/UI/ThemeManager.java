package ir.amirsobhan.wallpaperapp.UI;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.content.res.Configuration;

import androidx.appcompat.app.AlertDialog;
import androidx.preference.PreferenceManager;

import com.google.android.material.dialog.MaterialAlertDialogBuilder;

import ir.amirsobhan.wallpaperapp.CategoryActivity;
import ir.amirsobhan.wallpaperapp.R;

public class ThemeManager {

    /**
     * Get saved Theme
     * @param context
     * @return
     */
    public static int getTheme(Context context){
        // Get default SharedPreferences storage
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(context);

        switch (preferences.getString("theme", "Light")) {
            case "Light":
                return R.style.AppTheme;
            case "Dark":
                return R.style.DarkTheme;
            case "System Default":
                switch (context.getResources().getConfiguration().uiMode & Configuration.UI_MODE_NIGHT_MASK) {
                    case Configuration.UI_MODE_NIGHT_YES:
                        return R.style.DarkTheme;
                    case Configuration.UI_MODE_NIGHT_NO:
                        return R.style.AppTheme;
                }
                break;
        }
        return R.style.AppTheme;
    }

    /**
     * @param activity
     * @param positiveButton_callback
     * @return AlertDialog
     */
    public static AlertDialog getNetworkErrorDialog(Activity activity,DialogInterface.OnClickListener positiveButton_callback){
        MaterialAlertDialogBuilder dialogBuilder = new MaterialAlertDialogBuilder(activity)
                .setTitle("Server not responding")
                .setMessage("Check your connection and try again")
                .setCancelable(false)
                .setIcon(R.drawable.ic_baseline_wifi_off_24)
                .setPositiveButton("try again",positiveButton_callback)
                .setNegativeButton("Back", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        activity.finish();
                    }
                });
        return dialogBuilder.create();
    }
}
