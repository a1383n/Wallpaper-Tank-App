package ir.amirsobhan.wallpaperapp.UI;

import android.content.Context;
import android.content.res.TypedArray;
import android.graphics.Color;
import android.util.AttributeSet;
import android.widget.TextView;

import androidx.preference.ListPreference;
import androidx.preference.PreferenceViewHolder;

import ir.amirsobhan.wallpaperapp.R;

public class CustomListPreference extends ListPreference {
    int summeryColor;

    public CustomListPreference(Context context, AttributeSet attrs) {
        super(context, attrs);
        TypedArray a = context.getTheme().obtainStyledAttributes(
                attrs,
                R.styleable.customcheck,
                0, 0);

        summeryColor = a.getColor(R.styleable.customlist_listSummaryColor, Color.WHITE);
        a.recycle();
    }

    public CustomListPreference(Context context) {
        super(context);
    }

    @Override
    public void onBindViewHolder(PreferenceViewHolder holder) {
        super.onBindViewHolder(holder);
        TextView textView = (TextView) holder.findViewById(android.R.id.summary);
        textView.setTextColor(summeryColor);
    }
}
