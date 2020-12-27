package ir.amirsobhan.wallpaperapp.Adapter;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.graphics.drawable.AnimatedVectorDrawable;
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

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import ir.amirsobhan.wallpaperapp.Databases.WallpaperDB;
import ir.amirsobhan.wallpaperapp.FullscreenViewActivity;
import ir.amirsobhan.wallpaperapp.Model.ApiResult;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;

public class WallpaperAdapter extends RecyclerView.Adapter<WallpaperAdapter.WallpaperViewHolder> {
    private Context context;
    private List<Wallpaper> wallpaperList;
    private WallpaperDB db;
    private boolean newLike_ok;
    private boolean removeLike_ok;

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
                context.startActivity(new Intent(context, FullscreenViewActivity.class));
            }
        });
    }

    private boolean newLike(final int id) {
        RequestQueue queue = Volley.newRequestQueue(context);
        final String url = "https://amirsobhan.ir/wallpaper/api/web/newLike";

        // sync this action with database
        db.setLike(id, true);

        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("Action Url",url);

                //Initialization GSON
                GsonBuilder gsonBuilder = new GsonBuilder();
                Gson gson = gsonBuilder.create();

                // Set TypeToken
                Type type = new TypeToken<ApiResult>() {
                }.getType();

                // Convert JSON to OBJECT
                ApiResult result;
                result = gson.fromJson(response, type);

                //Check response
                newLike_ok = result.getOk();

                Log.d("Result", result.getOk() + "");
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                removeLike_ok = false;
            }
        }){
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("Authentication", "123456789");

                return params;
            }

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("id", id+"");

                return params;
            }
        };
        queue.add(request);
        return newLike_ok;
    }

    private boolean removeLike(final int id) {
        RequestQueue queue = Volley.newRequestQueue(context);
        final String url = "https://amirsobhan.ir/wallpaper/api/web/removeLike";

        // sync this action with database
        db.setLike(id, false);

        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("Action Url",url);

                //Initialization GSON
                GsonBuilder gsonBuilder = new GsonBuilder();
                Gson gson = gsonBuilder.create();

                // Set TypeToken
                Type type = new TypeToken<ApiResult>() {
                }.getType();

                // Convert JSON to OBJECT
                ApiResult result;
                result = gson.fromJson(response, type);

                //Check response
                removeLike_ok = result.getOk();

                Log.d("Result", result.getOk() + "");
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                removeLike_ok = false;
            }
        }){
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("Authentication", "123456789");

                return params;
            }

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("id", id+"");

                return params;
            }
        };
        queue.add(request);
        return removeLike_ok;
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
