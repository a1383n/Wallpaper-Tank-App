package ir.amirsobhan.wallpaperapp.Adapter;

import android.content.Context;
import android.content.res.Configuration;
import android.graphics.drawable.AnimatedVectorDrawable;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;

import java.util.List;

import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;

public class WallpaperAdapter extends RecyclerView.Adapter<WallpaperAdapter.WallpaperViewHolder> {
    private Context context;
    private List<Wallpaper> wallpaperList;
    private WallpaperDB db;

    public WallpaperAdapter(Context context, List<Wallpaper> wallpaperList) {
        this.context = context;
        this.wallpaperList = wallpaperList;
        db = new WallpaperDB(context);
    }

    @NonNull
    @Override
    public WallpaperViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.wallpaper_recycler_row, parent, false);
        return new WallpaperViewHolder(view, context);
    }

    @Override
    public void onBindViewHolder(@NonNull final WallpaperViewHolder holder, int position) {
        final Wallpaper wallpaper = wallpaperList.get(position);
        Glide.with(context).load(wallpaper.getTemp()).into(holder.imageView);
        holder.title.setText(wallpaper.getTitle());
        holder.likes.setText(wallpaper.getLikes() + "");

        // Check android version
        // If Android version 23 and above shows the animation effect,ELSE will show the icon without animation
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M /*Android 6 Marshmallow*/) {
            if (db.isLiked(wallpaper.getId())) {
                holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_unchecked_to_checked));
                AnimatedVectorDrawable vectorDrawable = (AnimatedVectorDrawable) holder.likeBtn.getDrawable();
                vectorDrawable.start();
            } else {
                holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_checked_to_unchecked));
                AnimatedVectorDrawable vectorDrawable = (AnimatedVectorDrawable) holder.likeBtn.getDrawable();
                vectorDrawable.start();
            }
            holder.likeBtn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (db.isLiked(wallpaper.getId())) {
                        db.setLike(wallpaper.getId(), false);
                        holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_checked_to_unchecked));
                        AnimatedVectorDrawable vectorDrawable = (AnimatedVectorDrawable) holder.likeBtn.getDrawable();
                        vectorDrawable.start();
                    } else {
                        db.setLike(wallpaper.getId(), true);
                        holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_unchecked_to_checked));
                        AnimatedVectorDrawable vectorDrawable = (AnimatedVectorDrawable) holder.likeBtn.getDrawable();
                        vectorDrawable.start();
                    }
                }
            });
        } else {
            if (db.isLiked(wallpaper.getId())) {
                holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_24);
            } else {
                holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_border_24);
            }
            holder.likeBtn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (db.isLiked(wallpaper.getId())) {
                        db.setLike(wallpaper.getId(), false);
                        holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_border_24);
                    } else {
                        db.setLike(wallpaper.getId(), true);
                        holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_24);
                    }
                }
            });
        }
    }

    @Override
    public int getItemCount() {
        return wallpaperList.size();
    }

    public static class WallpaperViewHolder extends RecyclerView.ViewHolder {
        ImageView imageView, likeBtn;
        TextView title, likes;

        public WallpaperViewHolder(@NonNull View itemView, Context context) {
            super(itemView);
            imageView = itemView.findViewById(R.id.wallpaper_title_imageView);
            likeBtn = itemView.findViewById(R.id.wallpaper_row_like_drw);
            title = itemView.findViewById(R.id.wallpaper_row_title);
            likes = itemView.findViewById(R.id.wallpaper_row_like);
        }
    }
}
