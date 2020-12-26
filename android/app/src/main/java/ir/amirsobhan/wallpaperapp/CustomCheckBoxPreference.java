package ir.amirsobhan.wallpaperapp;

import android.content.Context;
import android.content.res.TypedArray;
import android.graphics.Color;
import android.util.AttributeSet;
import android.widget.TextView;

import androidx.preference.CheckBoxPreference;
import androidx.preference.PreferenceViewHolder;

public class CustomCheckBoxPreference extends CheckBoxPreference {
    int summaryColor;

    public CustomCheckBoxPreference(Context context, AttributeSet attrs) {
        super(context, attrs);
        TypedArray a = context.getTheme().obtainStyledAttributes(
                attrs,
                R.styleable.customcheck,
                0, 0);

            summaryColor = a.getColor(R.styleable.customcheck_summaryColor,Color.WHITE);
            a.recycle();
    }

    public CustomCheckBoxPreference(Context context) {
        super(context);
    }

    @Override
    public void onBindViewHolder(PreferenceViewHolder holder) {
        super.onBindViewHolder(holder);
        TextView textView = (TextView) holder.findViewById(android.R.id.summary);
        textView.setTextColor(summaryColor);
    }
}
