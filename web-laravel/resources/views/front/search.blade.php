@extends('front.layout')
@section('title','Search Result')
@section('search_value',$value)

@section('content')
    @foreach($data as $wallpaper)
    <div class="container-style" onclick="window.open('{{route('single_wallpaper',['id'=>$wallpaper->id])}}','_parent')">
        <div class="img-container">
            <img src="{{$wallpaper->temp_url}}" alt="{{$wallpaper->title}}">
        </div>
        <ul class="wallpaper-info">
            <li><a href="#" target=""><i class="fa fa-heart"></i><span>{{$wallpaper->likes}}</span></a></li>
            <li><a href="#"><i class="fa fa-download"></i><span>{{$wallpaper->downloads}}</span></a></li>
            <li><a href="#"><i class="fa fa-eye"></i><span>{{$wallpaper->views}}</span></a></li>
        </ul>
        <div class="wallpaper-head">
            <h2>{{$wallpaper->title}}</h2>
        </div>
    </div>
    @endforeach
@endsection
