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
                <button class="btn btn-danger d-inline-block float-right m-2" id="like-btn"
                        onclick="Like({{$wallpaper->id}})"><span>{{$wallpaper->likes}}</span>&nbsp;<li
                        class="{{(\App\Models\WallpaperLikes::isUserLiked($wallpaper->id)) ? 'fa fa-heart' : 'fa fa-heart-o'}}"></li>
                </button>
                <button class="btn btn-primary d-inline-block float-right m-2" onclick="Download()">
                    Download&nbsp;<li
                        class="fa fa-download"></li>
                </button>
            </div>
            <div class="box-info">
                @php
                    $category = \App\Models\Category::find($wallpaper->category_id);
                @endphp
                <h4>Category: <a href="/search?q=category:{{$category->name}}">{{$category->name}}</a></h4>
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
    <script>
        function Like(id) {
            const likeBtn = document.getElementById('like-btn');
            const value = likeBtn.getElementsByTagName('span')[0];
            const formData = new FormData();
            formData.append('id', id);
            if (likeBtn.getElementsByTagName('li')[0].classList[1] == 'fa-heart-o') {
                formData.append('action', 'INCREASE');
            } else {
                formData.append('action', 'DECREASE');
            }
            $.ajax({
                url: '/like',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function (responseJSON) {
                    if (responseJSON['ok']) {
                        value.innerHTML = responseJSON['count'];
                        if (likeBtn.getElementsByTagName('li')[0].classList[1] == 'fa-heart-o') {
                            likeBtn.getElementsByTagName('li')[0].classList.remove('fa-heart-o');
                            likeBtn.getElementsByTagName('li')[0].classList.add('fa-heart');
                        } else {
                            likeBtn.getElementsByTagName('li')[0].classList.remove('fa-heart');
                            likeBtn.getElementsByTagName('li')[0].classList.add('fa-heart-o');
                        }
                    }
                }
            });
        }

        function Download() {
            const formData = new FormData();
            formData.append('id',{{$wallpaper->id}});
            formData.append('action','DOWNLOAD');

            $.ajax({
                url: "/download",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function (responseJSON) {

                }
            });
            var a = document.createElement('a');
            a.href = "{{$wallpaper->wallpaper_url}}";
            a.download = "{{$wallpaper->id."-".basename($wallpaper->wallpaper_url)}}";
            a.target = "_blank";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }


    </script>
@endsection
