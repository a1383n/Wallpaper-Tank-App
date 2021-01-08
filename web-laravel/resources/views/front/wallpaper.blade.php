<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>{{$wallpaper->title}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    <style>
        body {
            background: #333;
            margin: 0;
            padding: 0;
            border: 0;
            font-family: 'Open Sans', sans-serif;
            overflow: hidden;
        }

        .box {
            background: #fff;
            border-radius: 2px;
            height: auto;
            margin: 1rem;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .box-image {
            width: 30%;
            height: auto;
            display: inline-block;
        }

        .box-image img {
            width: 100%;
            height: 500px;
        }

        .box-body {
            width: 70%;
            height: auto;
            display: inline-block;
            float: right;
            padding: 15px;
        }

        .box-info {
            height: 370px;
        }

        .tags {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .box-footer {

        }
    </style>
</head>
<body>
<div class="container">
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
                <h4>Category: <a href="#">{{\App\Models\Category::find($wallpaper->category_id)->title}}</a></h4>
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
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
