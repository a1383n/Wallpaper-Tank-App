@extends('front.layout')

@section('title','Home')

@if(isset($search_value))
    @section('search_value',$search_value)
@endif

@section('content')
    <div class="row row-cols-1 row-cols-md-3">
@foreach($data as $wallpaper)
    <div class="container-style col" onclick="window.open('{{route('single_wallpaper',['id'=>$wallpaper->id])}}','_parent')">
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
    </div>
@endsection
