<!doctype html>
<html lang="en">
@include('front.include.head')
<body>
@include('front.include.navbar')
<div class="container">
@yield('content')
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
