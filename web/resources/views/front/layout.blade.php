<!doctype html>
<html lang="en">
@include('front.include.head')
<body>
@include('front.include.navbar')
<div class="container">
    @hasSection('search_value')
    <div class="row">
        <h1>Search result for: @yield('search_value')</h1>
    </div>
        <br>
    @endif

    @yield('content')
</div>
<div class="navbar">

</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
</body>
</html>
