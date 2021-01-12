<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Wallpaper;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/wallpapers',function (Request $request){
    $wallpapers = Wallpaper::get();
    //Check if request from dataTable plugin
    if (!empty($request->input('_')) && $request->ajax()){
        $data = array();
        foreach ($wallpapers as $wallpaper){
            array_push($data,[
                $wallpaper->id,
                $wallpaper->title,
                Category::find($wallpaper->category_id)->title,
                $wallpaper->tags
            ]);
        }

        return ['draw'=>$request->input('_'),'recordsTotal'=>sizeof($wallpapers),'data'=>$data];
    }else{
        return $wallpapers;
    }
});
