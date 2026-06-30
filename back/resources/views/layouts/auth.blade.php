
<!DOCTYPE html>
<html lang="en">
<style>
/* استایل برای آیکون موکایی */
.btn-icon.btn-mocha-soft {
    background-color: #f0e6e0; /* رنگ زمینه خیلی ملایم نزدیک به موکایی */
    color: #967969;           /* رنگ خود آیکون (موکایی) */
    border: none;
}

.btn-icon.btn-mocha-soft:hover {
    background-color: #967969; /* رنگ زمینه وقتی موس میره روش */
    color: #ffffff;           /* سفید شدن آیکون هنگام هاور */
}
</style>
<head>
    <meta charset="utf-8" />
    <title>@yield('title') - صفحه اصلی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">
    <!-- Bootstrap -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{asset('assets/css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/unicons.iconscout.com/release/v3.0.6/css/line.css')}}">
    <!-- Main Css -->
    <link href="{{asset('assets/css/style.min.css')}}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{asset('assets/css/colors/default.css')}}" rel="stylesheet" id="color-opt">
    <link href="{{asset('assets/css/front-custom.css')}}" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


</head>

<body>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Loader -->

    <div class="back-to-home rounded d-none d-sm-block">
<a href="{{url('/')}}" class="btn btn-icon btn-mocha-soft">
    <i data-feather="home" class="icons"></i>
</a>    </div>

    @yield('content')

    <!-- javascript -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Icons -->
    <script src="{{asset('assets/js/feather.min.js')}}"></script>
    <!-- Switcher -->
    <script src="{{asset('assets/js/switcher.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assets/js/plugins.init.js')}}"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
    <script src="{{asset('assets/js/app.js')}}"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->


    <script>
        $("#mobile").change(function(){
    
            this.value = this.value.replace(/^0+/,'');
    
        });
    
    
    </script>
</body>

</html>
