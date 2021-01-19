<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Token;
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
Route::post('/newToken',function (Request $request){
   if (env('PRIVATE_KEY') == $request->input('private_key')){
        $token = Token::store($request);
        return ($token) ? ['ok'=>true,'token'=>$token] : ['ok'=>false,'des'=>'Error while creating token'];
   }else{
       return ['ok'=>false,'des'=>'private_key is empty or incorrect'];
   }
});


Route::get('/wallpapers', function (Request $request) {
    $wallpapers = Wallpaper::get();
    //Check if request from dataTable plugin
    if (!empty($request->input('_')) && $request->ajax()) {
        $data = array();
        foreach ($wallpapers as $wallpaper) {
            array_push($data, [
                $wallpaper->id,
                $wallpaper->title,
                Category::find($wallpaper->category_id)->name,
                $wallpaper->tags,
                '<li class="fa fa-heart"></li>&nbsp;<span>' . $wallpaper->likes . '</span><br>' .
                '<li class="fa fa-eye"></li>&nbsp;<span>' . $wallpaper->views . '</span><br>' .
                '<li class="fa fa-download">&nbsp;</li><span>' . $wallpaper->downloads . '</span><br>',

                '<div class="btn-group" role="group"><buttom type="buttom" name="view" id="' . $wallpaper->id . '" class="btn btn-primary" onclick="viewButton(' . $wallpaper->id . ')">View</buttom>' .
                '<buttom type="buttom" name="edit" id="' . $wallpaper->id . '" class="btn btn-secondary" onclick="editButton(' . $wallpaper->id . ')">Edit</buttom>' .
                '<buttom type="buttom" name="delete" id="' . $wallpaper->id . '" class="btn btn-danger" onclick="deleteButton(' . $wallpaper->id . ')">Delete</buttom></div>'
            ]);
        }

        return ['draw' => $request->input('_'), 'recordsTotal' => sizeof($wallpapers), 'data' => $data];
    } else {
        $data = array();
        foreach ($wallpapers as $wallpaper) {
            array_push($data, [
               'id'=>$wallpaper->id,
			   'title'=>$wallpaper->title,
			   'category'=>Category::find($wallpaper->category_id),
			   'tags'=>$wallpaper->tags,
			   'likes'=>$wallpaper->likes,
			   'views'=>$wallpaper->views,
			   'downloads'=>$wallpaper->downloads,
			   'user_id'=>$wallpaper->user_id,
			   'path'=>$wallpaper->path,
			   'temp_url'=>$wallpaper->temp_url,
			   'wallpaper_url'=>$wallpaper->wallpaper_url,
			   'created_at'=>$wallpaper->created_at,
			   'updated_at'=>$wallpaper->updated_at
            ]);
        }

        return $data;
    }    

});

Route::get('wallpapers/{id}', function ($id) {
    return Wallpaper::findOrfail($id);
})->where('id', '[0-9]+');

//Like Wallpaper API route
Route::get('wallpapers/{id}/like',function ($id,Request $request){
    return (\App\Models\WallpaperLikes::increase(Wallpaper::findOrfail($id))) ? ['ok'=>true] : ['ok'=>false];
})->middleware(\App\Http\Middleware\isAuthorized::class)->where('id','[0-9]+');

//Dislike Wallpaper API route
Route::get('wallpapers/{id}/dislike',function ($id,Request $request){
    return (\App\Models\WallpaperLikes::decrease(Wallpaper::findOrfail($id))) ? ['ok'=>true] : ['ok'=>false];
})->middleware(\App\Http\Middleware\isAuthorized::class)->where('id','[0-9]+');

//View Wallpaper API route
Route::get('wallpapers/{id}/view',function ($id,Request $request){
    return (\App\Models\WallpaperViews::createViewLog(Wallpaper::findOrfail($id))) ? ['ok'=>true] : ['ok'=>false];
})->middleware(\App\Http\Middleware\isAuthorized::class)->where('id','[0-9]+');

//Download Wallpaper API route
Route::get('wallpapers/{id}/download',function ($id,Request $request){
    return (\App\Models\WallpapersDownload::increase(Wallpaper::findOrfail($id))) ? ['ok'=>true] : ['ok'=>false];
})->middleware(\App\Http\Middleware\isAuthorized::class)->where('id','[0-9]+');

Route::get('categories', function (Request $request) {
    $categories = Category::get();

    //Check if request from dataTable plugin
    if (!empty($request->get('_')) && $request->ajax()) {
        $data = array();
        foreach ($categories as $category) {
            array_push($data, [
                $category->id,
                $category->name,
                $category->items_count,
                '<div role="group" class="btn-group">
                    <button class="btn btn-secondary" onclick="editCategory(' . $category->id . ')">Edit</button>
                    <button class="btn btn-danger" onclick="deleteCategory(' . $category->id . ')">Delete</button>
                    </div>'
            ]);
        }
        return ['draw' => $request->input('_'), 'recordsTotal' => sizeof($categories), 'data' => $data];

    } else {
        return $categories;
    }
});

Route::get('categories/{id}', function ($id) {
    return Category::findOrfail($id);
});

Route::get('categories/{id}/wallpapers',function ($id){
    $wallpapers = Wallpaper::where('category_id', Category::findOrfail($id)->id)->get();
    $data = array();
    foreach ($wallpapers as $wallpaper) {
        array_push($data, [
           'id'=>$wallpaper->id,
           'title'=>$wallpaper->title,
           'category'=>Category::find($wallpaper->category_id),
           'tags'=>$wallpaper->tags,
           'likes'=>$wallpaper->likes,
           'views'=>$wallpaper->views,
           'downloads'=>$wallpaper->downloads,
           'user_id'=>$wallpaper->user_id,
           'path'=>$wallpaper->path,
           'temp_url'=>$wallpaper->temp_url,
           'wallpaper_url'=>$wallpaper->wallpaper_url,
           'created_at'=>$wallpaper->created_at,
           'updated_at'=>$wallpaper->updated_at
        ]);
    }

    return $data;
})->where('id','[0-9]+');

Route::get('symlink',function (){
$targetFolder = $_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
symlink($targetFolder, $linkFolder) or die("error creating symlink");
echo 'Symlink process successfully completed';});
