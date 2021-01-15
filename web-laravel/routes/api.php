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

Route::get('/wallpapers', function (Request $request) {
    $wallpapers = Wallpaper::get();
    //Check if request from dataTable plugin
    if (!empty($request->input('_')) && $request->ajax()) {
        $data = array();
        foreach ($wallpapers as $wallpaper) {
            array_push($data, [
                $wallpaper->id,
                $wallpaper->title,
                Category::find($wallpaper->category_id)->title,
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
        return $wallpapers;
    }
});

Route::get('wallpapers/{id}', function ($id) {
    return Wallpaper::findOrfail($id);
})->where('id', '[0-9]+');

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
