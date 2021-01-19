<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class WallpaperViews extends Model
{
    use HasFactory;

    public static function createViewLog(Wallpaper $wallpaper){
        $before = (Request::getSession())
            ? WallpaperViews::where('session_id',Request::getSession()->getId())->where('wallpaper_id',$wallpaper->id)->get()
            : WallpaperViews::where('session_id',Request::header('Authorization'))->where('wallpaper_id',$wallpaper->id)->get();

        if (sizeof($before) == 0){

            $wallpaperView = new WallpaperViews();
            $wallpaperView->wallpaper_id = $wallpaper->id;
            $wallpaperView->url = Request::url();
            $wallpaperView->session_id = (Request::getSession()) ? Request::getSession()->getId() : Request::header('Authorization');
            $wallpaperView->user_id = (Auth::check()) ? Auth::id() : 0;
            $wallpaperView->ip = Request::ip();
            $wallpaperView->agent = Request::userAgent();

            $wallpaperView->save();
            $wallpaper->views++;
            $wallpaper->save();
        }

    }

    public static function getLast5Day(){
        return [
            date("m-d", strtotime('-1 day', time())),
            date("m-d", strtotime('-2 day', time())),
            date("m-d", strtotime('-3 day', time())),
            date("m-d", strtotime('-4 day', time())),
            date("m-d", strtotime('-5 day', time()))
        ];
    }

    public static function getLast5DayValues(){
        $array = array();
        for ($i = 0; $i < 5;$i++){
            $views = WallpaperViews::
            whereDate("created_at",Carbon::now()->subDays($i))
                ->get();
            array_push($array,$views->count());
        }
        return $array;
    }
}
