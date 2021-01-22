package ir.amirsobhan.wallpaperapp.Adapter;

import android.app.Activity;
import android.app.ActivityManager;
import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.AnimatedVectorDrawable;
import android.net.ConnectivityManager;
import android.os.Build;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.google.gson.Gson;

import java.io.IOException;
import java.util.List;

import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.Model.ApiResult;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;
import ir.amirsobhan.wallpaperapp.Retrofit.ApiInterface;
import ir.amirsobhan.wallpaperapp.Retrofit.RetrofitClient;
import ir.amirsobhan.wallpaperapp.WallpaperSetActivity;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class WallpaperAdapter extends RecyclerView.Adapter<WallpaperAdapter.WallpaperViewHolder> {
    private final Context context;
    private List<Wallpaper> wallpaperList;
    private final WallpaperDB db;
    private boolean newLike_ok;
    private boolean removeLike_ok;
    private ApiInterface apiInterface;
    private String token = null;

    public WallpaperAdapter(Context context, List<Wallpaper> wallpaperList) {
        this.context = context;
        this.wallpaperList = wallpaperList;
        db = new WallpaperDB(context);
        apiInterface = RetrofitClient.getApiInterface();
        token = RetrofitClient.getAuthorizationToken(context);
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
        Glide.with(context)
                .load(wallpaper.getTempUrl())
                .placeholder(R.drawable.download)
                .into(holder.imageView);

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
                        holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_checked_to_unchecked));
                        AnimatedVectorDrawable vectorDrawable = (AnimatedVectorDrawable) holder.likeBtn.getDrawable();
                        vectorDrawable.start();
                        removeLike(wallpaper.getId());
                        holder.likes.setText(Integer.parseInt(holder.likes.getText().toString())-1+"");
                    } else {
                        holder.likeBtn.setImageDrawable(context.getDrawable(R.drawable.heart_unchecked_to_checked));
                        AnimatedVectorDrawable vectorDrawable = (AnimatedVectorDrawable) holder.likeBtn.getDrawable();
                        vectorDrawable.start();
                        newLike(wallpaper.getId());
                        holder.likes.setText(Integer.parseInt(holder.likes.getText().toString())+1+"");
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
                        holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_border_24);
                        removeLike(wallpaper.getId());
                        holder.likes.setText(Integer.parseInt(holder.likes.getText().toString())-1+"");
                    } else {
                        holder.likeBtn.setImageResource(R.drawable.ic_baseline_favorite_24);
                        newLike(wallpaper.getId());
                        holder.likes.setText(Integer.parseInt(holder.likes.getText().toString())+1+"");
                    }
                }
            });
        }

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                apiInterface.view(token,wallpaper.getId()).enqueue(new Callback<ApiResult>() {
                    @Override
                    public void onResponse(Call<ApiResult> call, Response<ApiResult> response) {
                        if(response.isSuccessful()){
                            db.setView(wallpaper.getId());
                        }
                    }

                    @Override
                    public void onFailure(Call<ApiResult> call, Throwable t) {

                    }
                });
                Intent intent = new Intent(context, WallpaperSetActivity.class);
                wallpaper.setViews(wallpaper.getViews() + 1);
                intent.putExtra("json",new Gson().toJson(wallpaper));
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                context.startActivity(intent);
            }
        });
    }

    private void newLike(final int id) {
        apiInterface.like(token,id).enqueue(new Callback<ApiResult>() {
            @Override
            public void onResponse(Call<ApiResult> call, retrofit2.Response<ApiResult> response) {
                // sync this action with database
                if (response.isSuccessful()){
                    db.setLike(id,true);
                }
            }

            @Override
            public void onFailure(Call<ApiResult> call, Throwable t) {
                Toast.makeText(context, "Error!", Toast.LENGTH_SHORT).show();
            }
        });


    }

    private void removeLike(final int id) {
        apiInterface.dislike(token,id).enqueue(new Callback<ApiResult>() {
            @Override
            public void onResponse(Call<ApiResult> call, retrofit2.Response<ApiResult> response) {
                // sync this action with database
                if (response.isSuccessful()){
                    db.setLike(id,false);
                }
            }

            @Override
            public void onFailure(Call<ApiResult> call, Throwable t) {
                Toast.makeText(context, "Error!", Toast.LENGTH_SHORT).show();
            }
        });

    }

    public void updateList(List<Wallpaper> list){
        wallpaperList = list;
        notifyDataSetChanged();
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
