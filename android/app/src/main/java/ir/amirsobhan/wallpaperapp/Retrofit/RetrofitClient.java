package ir.amirsobhan.wallpaperapp.Retrofit;

import android.content.Context;
import android.content.SharedPreferences;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class RetrofitClient {
    private static Retrofit retrofit;
    private static final String BASE_URL = "http://wallpaper.amirsobhan.ir/api/";

    public static Retrofit getRetrofitInstance(){
        if (retrofit == null){
            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return retrofit;
    }

    public static ApiInterface getApiInterface(){
        return getRetrofitInstance().create(ApiInterface.class);
    }

    public static void storeAuthorizationToken(Context context,String token){
        context.getSharedPreferences("root",context.MODE_PRIVATE).edit().putString("token",token).apply();
    }

    public static String getAuthorizationToken(Context context){
        return context.getSharedPreferences("root",context.MODE_PRIVATE).getString("token",null);
    }
}
