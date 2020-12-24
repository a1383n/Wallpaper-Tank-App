package ir.amirsobhan.wallpaperapp.Adapter;

import android.content.Context;
import android.content.res.Configuration;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;

import java.util.List;

import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;

public class WallpaperAdapter extends RecyclerView.Adapter<WallpaperAdapter.WallpaperViewHolder> {
    private Context context;
    private List<Wallpaper> wallpaperList;

    public WallpaperAdapter(Context context, List<Wallpaper> wallpaperList) {
        this.context = context;
        this.wallpaperList = wallpaperList;
    }

    @NonNull
    @Override
    public WallpaperViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
       View view = LayoutInflater.from(context).inflate(R.layout.wallpaper_recycler_row,parent,false);
        return new WallpaperViewHolder(view,context);
    }

    @Override
    public void onBindViewHolder(@NonNull WallpaperViewHolder holder, int position) {
        Wallpaper wallpaper = wallpaperList.get(position);
        Glide.with(context).load(wallpaper.getTempUrl()).into(holder.imageView);
        holder.title.setText(wallpaper.getTitle());
        holder.likes.setText(wallpaper.getLikeCount()+"");

        // Check android version
        // If Android version 24 and above shows the animation effect,ELSE will show the icon without animation
        if (Build.VERSION.SDK_INT >= 24 /*Android 7 Nougat*/ ){
            holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_checked_to_unchecked));
        }else{
            holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_border_24);
        }
    }

    @Override
    public int getItemCount() {
        return wallpaperList.size();
    }

    public static class WallpaperViewHolder extends RecyclerView.ViewHolder{
        ImageView imageView,likeBtn;
        TextView title,likes;
        public WallpaperViewHolder(@NonNull View itemView,Context context) {
            super(itemView);
            imageView = itemView.findViewById(R.id.wallpaper_title_imageView);
            likeBtn = itemView.findViewById(R.id.wallpaper_row_like_drw);
            title = itemView.findViewById(R.id.wallpaper_row_title);
            likes = itemView.findViewById(R.id.wallpaper_row_like);
        }
    }
}
