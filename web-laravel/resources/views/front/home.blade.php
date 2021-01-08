<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
    <style>
        body {
            background-color: #2C3A47;
            display: flex;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
        }

        a {
            text-decoration: none;
        }

        .container {
            position: relative;
            height: 500px;
            width: 350px;
            margin-right: 20px;
            overflow: hidden;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
            transition: box-shadow 0.3s ease-out;
            cursor: pointer;
        }

        .container:hover {
            box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .img-container {
            background-color: #000;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            transition: transform 0.3s ease-out;
            z-index: 2;
        }

        .img-container:hover {
            cursor: pointer;
        }

        .container:hover .img-container {
            transform: translateY(-100px);
        }

        .img-container > img {
            height: 100%;
            width: 100%;
            transition: opacity 0.3s ease-out;
        }

        .container:hover > .img-container > img {
            opacity: 0.5;
        }

        .wallpaper-info {
            display: flex;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 3;
            margin: 0;
            padding: 0;
        }

        .wallpaper-info > li {
            list-style: none;
        }

        .wallpaper-info > li > a {
            display: block;
            height: 50px;
            width: 50px;
            background-color: #FFF;
            text-align: center;
            color: #262626;
            margin: 0 5px;
            border-radius: 50%;
            opacity: 0;
            transform: translateY(200px);
            transition: all 0.3s ease-out;
        }

        .container:hover > .wallpaper-info > li > a {
            transform: translateY(0);
            opacity: 1;
        }

        .wallpaper-info > li > a > .fa {
            font-size: 24px;
            line-height: 50px;
            transition: transform 0.3s ease-out;
        }

        .wallpaper-info > li > a:hover > .fa {
            transform: rotateY(360deg);
        }

        .container:hover .wallpaper-info li:nth-child(1) a {
            transition-delay: 0s;
        }

        .container:hover .wallpaper-info li:nth-child(2) a {
            transition-delay: 0.1s;
        }

        .container:hover .wallpaper-info li:nth-child(3) a {
            transition-delay: 0.2s;
        }

        .wallpaper-info a span {
            margin-left: 3px;
        }

        .wallpaper-head {
            position: absolute;
            bottom: 0;
            left: 0;
            background-color: #FFF;
            height: 100px;
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            text-align: center
        }

        .wallpaper-head > h2 {
            padding: 0;
            margin: 10px 0;
        }

        .wallpaper-head > span {
            color: #262626;
            font-size: 16px;
        }
    </style>
</head>
<body>
@foreach($data as $wallpaper)
    <div class="container" onclick="window.open('{{route('single_wallpaper',['id'=>$wallpaper->id])}}')">
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
</body>
</html>
