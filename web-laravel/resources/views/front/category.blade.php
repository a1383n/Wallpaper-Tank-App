@extends('front.layout')

@section('title','Categories')

@section('content')
    <div class="row row-cols-md-5">
    @foreach($data as $category)
    <div class="card col-" style="width: 15rem; cursor: pointer"onclick="window.open('/search?q=category:{{$category->name}}','_parent')">
            <div class="card-img" style="background: {{$category->color}}; border-bottom-right-radius: 0;border-bottom-left-radius: 0"><br><br><br><br></div>
        <div class="card-body">
            <h4 class="card-text">{{$category->name}}</h4>
        </div>
    </div>
    @endforeach
    </div>
@endsection
