<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Wallpaper;
use Illuminate\Http\Request;

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

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Wallpaper $wallpaper
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(Wallpaper $wallpaper, $id)
    {
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
                        return view('front.search', ['value' => $value[0], 'data' => $result]);
                    } else {
                        abort(404);
                    }
                    break;
                case 2:
                    if ($value[0] == 'category') {
                        $category = Category::where('name', $value[1])->get();
                        $result = Wallpaper::where('category_id', $category[0]->id)->get();
                        if (sizeof($result) > 0) {
                            return view('front.search', ['value' => $value[1], 'data' => $result]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Wallpaper $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallpaper $wallpaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wallpaper $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallpaper $wallpaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wallpaper $wallpaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallpaper $wallpaper)
    {
        //
    }
}
