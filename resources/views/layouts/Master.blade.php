<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <!--the same head :包含jquery bootstrop的引入-->
    @section('same_head')
        @include('partials.head.Head')
    @show
    <!--the anyone head :包含各自javascript css-->
    @section('anyone_head')
    	@yield('anyone_head')
    @show
</head>
<body>
	<div class="container">
	@section('enter')
		@yield('content')
	@show
	</div>
	@section('message')
		@yield('message')
	@show

	@section('js_area')
    	@yield('js_area')
    @show
</body>
</html>