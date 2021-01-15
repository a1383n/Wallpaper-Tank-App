<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class WallpapersDownload extends Model
{
    use HasFactory;

    /**
     * Check user liked wallpaper or not
     * @param $id wallpaper_id
     * @return bool Result
     */
    public static function isUserDownloaded($id){
        return sizeof(WallpapersDownload::where('session_id',Request::getSession()->getId())->where('wallpaper_id',$id)->get()) > 0;
    }

    /**
     * Increase downloads count
     * @param Wallpaper $wallpaper
     */
    public static function increase(Wallpaper $wallpaper){
        // if user dont download wallpaper
        if (!self::isUserDownloaded($wallpaper->id)){
            $likeLog = new WallpapersDownload();
            $likeLog->session_id = Request::getSession()->getId();
            $likeLog->wallpaper_id = $wallpaper->id;
            $likeLog->save();

            $wallpaper->downloads++;
            return $wallpaper->save();
        }
        return false;
    }

}
