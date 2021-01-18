package ir.amirsobhan.wallpaperapp.Retrofit;

import java.util.List;

import ir.amirsobhan.wallpaperapp.Model.ApiResult;
import ir.amirsobhan.wallpaperapp.Model.Category;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.Path;

public interface ApiInterface {
    @GET("wallpapers")
    Call<List<Wallpaper>> getWallpapers();

    @GET("categories")
    Call<List<Category>> getCategories();

    @FormUrlEncoded
    @POST("newToken")
    Call<ApiResult> newToken(@Field("private_key") String private_token, @Field("push_notification_token") String push_notification_token);

    @GET("wallpapers/{id}/like")
    Call<ApiResult> like(@Header("Authorization") String token, @Path("id") int wallpaper_id);

    @GET("wallpapers/{id}/dislike")
    Call<ApiResult> dislike(@Header("Authorization") String token, @Path("id") int wallpaper_id);

    @GET("wallpapers/{id}/view")
    Call<ApiResult> view(@Header("Authorization") String token,@Path("id") int wallpaper_id);

    @GET("wallpapers/{id}/download")
    Call<ApiResult> download(@Header("Authorization") String token,@Path("id") int wallpaper_id);

    @GET("categories/{id}/wallpapers")
    Call<List<Wallpaper>> getWallpaperWhereCategory(@Path("id") int category_id);
}
