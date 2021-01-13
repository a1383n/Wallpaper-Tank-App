<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        return view('admin.home',['where'=>'index']);
    }

    public function wallpapers(){
        return view('admin.wallpapers',['where'=>'wallpapers','categories'=>Category::get()]);
    }
}
