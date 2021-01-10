@extends('front.layout')

@section('title',$wallpaper->title)

@section('content')
<div class="box">
    <div class="box-image">
        <img src="{{$wallpaper->temp_url}}" alt="{{$wallpaper->title}}">
    </div>
    <div class="box-body">
        <div class="box-title">
            <h1 class="h1 d-inline-block">
                {{$wallpaper->title}}
            </h1>
            <button class="btn btn-danger d-inline-block float-right m-2">Like&nbsp;<li class="fa fa-heart"></li>
            </button>
            <button class="btn btn-primary d-inline-block float-right m-2">Download&nbsp;<li
                    class="fa fa-download"></li>
            </button>
        </div>
        <div class="box-info">
            @php
                $category = \App\Models\Category::find($wallpaper->category_id);
            @endphp
            <h4>Category: <a href="/search?q=category:{{$category->name}}">{{$category->title}}</a></h4>
            <h4>Author: {{\App\Models\User::find($wallpaper->user_id)->name}}</h4>
            <h4>Tags:</h4>
            <div class="tags-list">
                @foreach(explode(",",$wallpaper->tags) as $tag)
                    <button class="btn btn-secondary tags">{{$tag}}</button>
                @endforeach
            </div>
        </div>
        <div class="box-footer">
            <div class="d-inline-block">
                    <span class="badge">
                    Create at: {{$wallpaper->created_at}}
                    </span>
                <br>
                <span class="badge">
                    Last update at: {{$wallpaper->updated_at}}
                    </span>
            </div>
            <div class="d-inline-block float-right">
                <br>
                <p class="badge badge-dark">{{$wallpaper->views}}&nbsp;Views</p>
            </div>
        </div>
    </div>
</div>
@endsection
