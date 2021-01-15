<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Wallpaper;
use App\Models\WallpaperLikes;
use App\Models\WallpaperViews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WallpaperController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.home', ['data' => Wallpaper::orderBy('id', 'desc')->get()]);
    }

    public function router(Request $request)
    {
        switch ($request->input('action')) {
            case 'PUT';
                return $this->store($request);
                break;
            case 'EDIT':
                return $this->update($request);
                break;
            case 'DELETE':
                return $this->destroy($request);
                break;
            case 'INCREASE':
                return $this->increaseLike($request->input('id'));
                break;
            case 'DECREASE':
                return $this->decreaseLike($request->input('id'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Wallpaper $wallpaper
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(Wallpaper $wallpaper, $id)
    {
        WallpaperViews::createViewLog($wallpaper->find($id));
        return view('front.wallpaper', ['wallpaper' => $wallpaper->findOrFail($id)]);
    }

    public function search(Request $request)
    {
        $value = explode(':', $request->input('q'));

        if ($request->input('q') != "") {
            switch (sizeof($value)) {
                case 1:
                    $result = Wallpaper::where('title', 'like', '%' . $value[0] . '%')->orWhere('tags', 'like', '%' . $value[0] . '%')->get();
                    if (sizeof($result) > 0) {
                        return view('front.home', ['search_value' => $value[0], 'data' => $result]);
                    } else {
                        abort(404);
                    }
                    break;
                case 2:
                    if ($value[0] == 'category') {
                        $category = Category::where('name', $value[1])->get();
                        $result = Wallpaper::where('category_id', $category[0]->id)->get();
                        if (sizeof($result) > 0) {
                            return view('front.home', ['search_value' => $value[1], 'data' => $result]);
                        } else {
                            abort(404);
                        }
                    }
                    break;
            }
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|int',
            'tags' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120'/*5M*/
        ]);

        $wallpaper = new Wallpaper();
        $wallpaper->title = $request->input('title');
        $wallpaper->category_id = $request->input('category_id');
        $wallpaper->tags = $request->input('tags');
        $wallpaper->user_id = Auth::id();

        // Create md5 path
        $path = md5(microtime());
        $wallpaper->path = $path;

        $image = $request->file('image');

        $image->storePubliclyAs('wallpapers/' . $path, 'wallpaper.' . $image->extension(), 'public');
        $wallpaper_url = env('APP_URL') . Storage::url('wallpapers/' . $path . '/wallpaper.' . $image->extension());
        $temp_image = Image::make($image->getRealPath());
        $resize_height = floor($temp_image->height() * (300 / $temp_image->width()));
        $temp_image->resize(300, $resize_height);
        $temp_image->save('storage/wallpapers/' . $path . '/temp.' . $image->extension());
        $temp_url = env('APP_URL') . Storage::url('wallpapers/' . $path . '/temp.' . $image->extension());

        $wallpaper->wallpaper_url = $wallpaper_url;
        $wallpaper->temp_url = $temp_url;


        if ($wallpaper->saveOrFail()) {
            $category = Category::find($wallpaper->category_id);
            $category->items_count++;
            $category->save();
            return ['ok' => true];
        } else {
            return ['ok' => false, 'des' => 'Error while store value in database'];
            Storage::delete(['wallpapers/' . $path . '/wallpaper.' . $image->extension(), 'wallpapers/' . $path . '/temp.' . $image->extension()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wallpaper $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'category_id' => 'required',
            'tags' => 'required'
        ]);

        $wallpaper = Wallpaper::findOrfail($request->input('id'));
        $wallpaper->title = $request->input('title');
        $wallpaper->category_id = $request->input('category_id');
        $wallpaper->tags = $request->input('tags');
        $wallpaper->save();

        return ['ok' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id'=>'required'
        ]);

        Wallpaper::findOrfail($request->input('id'))->delete();

        $category = Category::find(Wallpaper::find($request->input('id'))->category_id);
        $category->items_count--;
        $category->save();

        return ['ok'=>true];
    }

    /**
     * Increase Like count
     * @param $id The id of wallpaper must increase likes
     * @return array
     */
    public function increaseLike($id){
        return ['ok'=>WallpaperLikes::increase(Wallpaper::findOrfail($id)),'count'=>Wallpaper::find($id)->likes];
    }

    /**
     * Decrease Like count
     * @param $id The id of wallpaper must increase likes
     * @return array
     */
    public function decreaseLike($id){
        return ['ok'=>WallpaperLikes::decrease(Wallpaper::findOrfail($id)),'count'=>Wallpaper::find($id)->likes];
    }

}
