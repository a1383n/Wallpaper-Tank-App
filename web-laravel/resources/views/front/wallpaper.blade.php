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
        body{
            background: #333;
            margin: 0;
            padding: 0;
            border: 0;
            font-family: 'Open Sans',sans-serif;
        }
        .box {
            background: #fff;
            border-radius: 2px;
            height: 500px;
            margin: 1rem;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .box-image{
            width: 30%;
            height: 500px;
            display: inline-block;
        }

        .box-image img{
            width: 100%;
            height: 500px;
        }
        .box-body{
            width: 70%;
            height: 500px;
            display: inline-block;
            float: right;
            padding: 15px;
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
                <h2 class="h2">
                    {{$wallpaper->title}}
                </h2>
            </div>
            <div class="box-info">
                <h4>Category: {{$wallpaper->category_id}}</h4>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
