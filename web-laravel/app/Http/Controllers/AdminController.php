<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Wallpaper;
use App\Models\WallpaperViews;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $views = WallpaperViews::
        whereDate("created_at",Carbon::today())
            ->get();

        return view('admin.home',['where'=>'index',
            'wallpaper'=>Wallpaper::get(),
            'category'=>Category::get(),
            'views'=>$views,
            'chart_days'=>WallpaperViews::getLast5Day(),
            'chart_values'=>WallpaperViews::getLast5DayValues()
        ]);
    }

    public function wallpapers(){
        return view('admin.wallpapers',['where'=>'wallpapers','categories'=>Category::get()]);
    }

    public function category(){
        return view('admin.categories',['where'=>'categories','categories'=>Category::get()]);
    }
}
