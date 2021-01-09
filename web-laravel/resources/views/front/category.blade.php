@extends('front.layout')

@section('title','categories')

@section('content')
    @foreach($data as $category)
    <div class="card" style="width: 15rem; cursor: pointer"onclick="window.open('{{route('single_categories',['id'=>$category->id])}}')">
            <div class="card-img" style="background: {{$category->color}}; border-bottom-right-radius: 0;border-bottom-left-radius: 0"><br><br><br><br></div>
        <div class="card-body">
            <h4 class="card-text">{{$category->title}}</h4>
        </div>
    </div>
    @endforeach
@endsection
