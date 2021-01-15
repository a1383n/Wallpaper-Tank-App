<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class WallpaperLikes extends Model
{
    use HasFactory;

    /**
     * Check user liked wallpaper or not
     * @param $id wallpaper_id
     * @return bool Result
     */
    public static function isUserLiked($id){
        return sizeof(WallpaperLikes::where('session_id',Request::getSession()->getId())->where('wallpaper_id',$id)->get()) > 0;
    }

    /**
     * Increase likes count
     * @param Wallpaper $wallpaper
     */
    public static function increase(Wallpaper $wallpaper){
        // if user dont like wallpaper
        if (!self::isUserLiked($wallpaper->id)){
            $likeLog = new WallpaperLikes();
            $likeLog->session_id = Request::getSession()->getId();
            $likeLog->wallpaper_id = $wallpaper->id;
            $likeLog->save();

            $wallpaper->likes++;
            return $wallpaper->save();
        }
        return false;
    }

    /**
     * Decrease likes count
     * @param Wallpaper $wallpaper
     */
    public static function decrease(Wallpaper $wallpaper){
        // if user liked wallpaper
        if (self::isUserLiked($wallpaper->id)){
            WallpaperLikes::where('session_id',Request::getSession()->getId())->where('wallpaper_id',$wallpaper->id)->delete();
            $wallpaper->likes--;
            return $wallpaper->save();
        }
        return false;
    }

}
