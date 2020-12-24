package ir.amirsobhan.wallpaperapp.Fragment;

import android.content.res.Configuration;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import java.util.ArrayList;
import java.util.List;

import ir.amirsobhan.wallpaperapp.Adapter.WallpaperAdapter;
import ir.amirsobhan.wallpaperapp.Model.Wallpaper;
import ir.amirsobhan.wallpaperapp.R;

public class HomeFragment extends Fragment {
    RecyclerView recyclerView;
    WallpaperAdapter adapter;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);;

        recyclerView = view.findViewById(R.id.wallpaper_recycler);
        RecyclerView.LayoutManager layoutManager = null;

        // Check device screen size
        if ((getContext().getResources().getConfiguration().screenLayout & Configuration.SCREENLAYOUT_SIZE_MASK) == Configuration.SCREENLAYOUT_SIZE_LARGE) {
            // large screen device
            layoutManager = new GridLayoutManager(getContext(),2);
        }else{
            // Small and Normal screen size
            layoutManager = new LinearLayoutManager(getContext(),RecyclerView.VERTICAL,false);
        }

        recyclerView.setLayoutManager(layoutManager);
        List<Wallpaper> wallpaperList = new ArrayList<>();
        wallpaperList.add(new Wallpaper("Title","","","Category",20,0,0,"","","https://api.amirsobhan.ir/foodapp/asiafood1.png",""));
        adapter = new WallpaperAdapter(getContext(),wallpaperList);
        recyclerView.setAdapter(adapter);

        return view;
    }
}