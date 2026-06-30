<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') - فروشگاه نارنید</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
<link rel="shortcut icon" href="{{ asset('storage/settings/123456.png') }}?v=2">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
    <link href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/unicons.iconscout.com/release/v3.0.6/css/line.css') }}">
    <!-- Main Css -->

    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link href="{{ asset('assets/css/front-custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/new-custom.css') }}" rel="stylesheet">
    <!-- استایل -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    @yield('meta')

    <style>
    .btn-mochalight{
        background-color: #D5C4B4  !important;
    border: 2px solid #6F4E37 !important;
    color: #ffffff !important;
    border-radius: 5px !important;
    padding: 10px 20px; /* اضافه کردن پدینگ برای زیبایی بیشتر */
    transition: all 0.3s ease; /* افکت نرم هنگام کلیک یا هاور */
}
    
    .btn-mocha {
    background-color: #6F4E37 !important;
    border: 2px solid #6F4E37 !important;
    color: #ffffff !important;
    border-radius: 5px !important;
    padding: 10px 20px; /* اضافه کردن پدینگ برای زیبایی بیشتر */
    transition: all 0.3s ease; /* افکت نرم هنگام کلیک یا هاور */
}
/* افکت هاور (زمانی که موس میره روی دکمه) */
.btn-mocha:hover {
    background-color: #5c412d !important;
    border-color: #5c412d !important;
    cursor: pointer;
}
 /* استایل‌های اصلی منو */
.main-menu li {
    position: relative; /* برای اینکه زیرمنو نسبت به والدش موقعیت بگیره */
    display: inline-block; /* یا flex بسته به نوع منوتون */
    margin-right: 20px;
}

.main-menu a {
    text-decoration: none;
    color: #333;
    padding: 10px 15px;
    display: block;
}

/* استایل زیرمنو */
.submenu {
    display: none; /* مخفی */
    position: absolute;
    top: 100%; /* زیر لینک اصلی */
    left: 0;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 1000; /* بالاتر از بقیه عناصر */
    min-width: 180px; /* عرض دلخواه */
    padding: 10px;
}

.submenu li {
    display: block; /* آیتم‌های زیرمنو رو عمودی نشون بده */
    margin: 0;
}

.submenu .category-dropdown {
    padding: 5px 0;
}

#category-select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* نمایش زیرمنو موقع هاور روی آیتم اصلی */
.parent-menu-item:hover > .submenu {
    display: block;
}

/* اگر خواستید با کلیک باز بشه */
.submenu.active { /* کلاسی که جاوااسکریپت اضافه میکنه */
    display: block;
}

        .footer-mobile .col-2 a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        .footer-mobile .col-2 a img {
            transition: transform 0.3s ease-in-out;
        }

        .footer-mobile .col-2 a:hover,
        .footer-mobile .col-2 a.active {
            background-color: transparent; /* پس‌زمینه حذف می‌شود */
        }

        .footer-mobile .col-2 a.active img {
            transform: scale(1.3); /* تصویر کمی بزرگ‌تر می‌شود */
        }

        @media (max-width: 767px) {
            .cart-icon {
                display: none !important;
            }
        }
        .cart-icon {
            margin-right: 10px;
        }
        

@media (max-width: 991px) {
    .navigation-menu .submenu {
        display: none; /* پیش‌فرض مخفی */
        padding-left: 20px;
    }
    .navigation-menu .submenu.open {
        display: block !important;
    }
}
/* 1. اصلاح کلی برای موبایل */
html, body {
    overflow-x: hidden; /* جلوگیری از اسکرول افقی */
    width: 100%;
}

/* 2. اصلاح عرض هدر */
#topnav {
    width: 100% !important;
    padding: 0 15px !important;
}

/* 3. اصلاح منوی موبایل */
@media (max-width: 991px) {
    #navigation {
        display: block;
        width: 100%;
        background: #fff;
        max-height: 80vh;
        overflow-y: auto; /* اگر منو طولانی بود اسکرول بخوره */
    }
    
    .navigation-menu {
        flex-direction: column !important;
    }

    .navigation-menu > li {
        width: 100%;
        display: block !important;
    }

    .submenu {
        position: relative !important;
        width: 100% !important;
        display: none;
        box-shadow: none !important;
        background: #fdfdfd !important;
    }
}

/* 4. اصلاح دکمه‌های ورود و سبد */
.buy-button {
    display: flex;
    align-items: center;
    gap: 10px;
}
@media (max-width: 576px) {
    .login-btn-primary, .login-btn-secondary {
        font-size: 12px;
        padding: 5px 10px !important;
    }
}

/* 5. جلوگیری از بیرون‌زدگی تصاویر و جداول */
img, table {
    max-width: 100% !important;
    height: auto !important;
}


    </style>
</head>

<body>
<!-- اسکریپت (دقت کن اول jQuery باشه بعد Owl) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <!-- Loader -->
    {{-- <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <d7iv class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div
            </div>
        </div>
        <!-- Loader --> --}}

    <header id="topnav" class="container-xxl defaultscroll sticky nav-sticky-new">
        <div class="container">
            <!-- Logo container-->
            <div>

                <a class="logo" href="{{ url('/') }}">
                    <img src="/storage/settings/123456.png"  class="l-dark" height="15"
                        alt="">
                    <img src="/storage/settings/123456.png"  class="l-light" height="5"
                        alt=""> 



            </a>
            </div>
            <div class="buy-button" style="line-height: initial;">
                @auth
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)

                        <a href="{{ route('admin.marketers.index') }}">
                            <div class="btn btn-mochalight login-btn-secondary">پنل بازاریابان </div>
                            <div class="btn btn-light login-btn-light">پنل بازاریابان </div>
                        </a>

                        <a href="{{ route('voyager.dashboard') }}">
                            <div class="btn btn-mocha  login-btn-primary">پنل مدیریت </div>
                            <div class="btn btn-light login-btn-light">پنل مدیریت </div>
                        </a>

                    @else

                    
                    <div style="display: flex">

                        <a href="{{ route('desktop.profile') }}">
                            <div style="border: 1px solid silver; padding: 3px 10px; margin-top: 15px; border-radius: 4px;">
                                <img src="{{ url('storage', auth()->user()->avatar) }}"
                                    style="border-radius: 50%; width: 35px;    height: 35px;" alt="">
                                <span style="color: #555">{{ auth()->user()->name }}</span>
                            </div>
                           
                            {{-- <div class="btn btn-light login-btn-light">حساب کاربری </div> --}}
                        </a>
                        <a href="https://narnid.com/desktop/logout" style="    height: 43px;
                        margin: 15px;" class="btn btn-danger login-btn-primary">خروج  </a> 
                  
                    </div>
                        
                    @endif
                @else
                    <a href="{{ route('login') }}">
    <!-- رنگ موکایی به استایل اضافه شد -->
    <div class="btn btn-primary login-btn-primary" style="background-color: #6F4E37 !important; border-color: #6F4E37 !important;">ورود </div>
    <div class="btn btn-light login-btn-light">ورود </div>
</a>
                @endauth

                @if(Auth::check())
      
                    <a href="{{ route('add.shop.cart') }}" title="سبد خرید" 
                    style="position: relative; display: inline-block;" class="cart-icon" >
<img src="/storage/settings/shopping.png" alt="shopping" height="30px" width="30px">

                        @php
                            $cart = json_decode(Cookie::get('cart', '[]'), true);
                            $cartCount = count($cart);
                        @endphp

                        @if($cartCount > 0)
                            <span style="
                                position: absolute;
                                top: 8px;
                                right: -5px;
                                background: red;
                                color: white;
                                font-size: 12px;
                                font-weight: bold;
                                border-radius: 50%;
                                padding: 1px 7px;
                                min-width: 20px;
                                text-align: center;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
           
                @endif

            </div>
            <!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu nav-light">
@php $menus = menu('Main Menu', '_json'); @endphp
@if (!$menus)
    منو وجود ندارد
@else
    <ul class="main-menu"> {{-- یک اولترا برای منوی اصلی --}}
        @foreach ($menus as $menu)
            <li class="parent-menu-item" id="menu-item-{{ Str::slug(data_get($menu, 'title', '')) }}">
                <a href="{{ data_get($menu, 'url', '#') }}"
                   target="{{ data_get($menu, 'target', '_self') }}"
                   class="menu-link"
                   style="color: #6F4E37 !important; font-weight: 500; transition: 0.3s;"> {{-- کلاس کلی برای لینک های منو --}}
                    {{ data_get($menu, 'title', '') }}
                </a>

                {{-- اینجا بخش زیرمنو برای محصولات اضافه میشه --}}
                @if (data_get($menu, 'title', '') === 'محصولات')
                    <ul class="submenu"> 
    @if(isset($categories))
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('category.products', $category->slug) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    @endif
</ul>

                @endif
            </li>
        @endforeach
    </ul>
@endif
                </ul>
                <!--end navigation menu-->
                <!--end login button-->
            </div>
            <!--end navigation-->
        </div>
        <!--end container-->

 <script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. مدیریت زیرمنوی محصولات (برای موبایل)
    // پیدا کردن آیتم محصولات
    const productItem = document.querySelector('.parent-menu-item'); 
    if(productItem) {
        // تغییر از 'click' به شناسایی کلاس برای همخوانی با ساختار قالب
        productItem.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                // جلوگیری از عملکرد پیش‌فرض فقط در صورتی که زیرمنو وجود دارد
                const sub = this.querySelector('.submenu');
                if(sub) {
                    e.preventDefault();
                    e.stopPropagation();
                    // استفاده از منطقِ خودِ قالب برای کلاس open
                    sub.classList.toggle('open');
                    sub.style.display = sub.classList.contains('open') ? 'block' : 'none';
                }
            }
        });
    }
});
</script>


        @yield('header-links')


     

          





    </header>
    @yield('content')

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                    <a href="{{ url('/') }}" class="logo-footer">
                        <img src="/storage/settings/12345.png"  height="26" alt="">
                    </a>
                    {!! setting('footer.enamad') !!}
                    <p class="mt-4">{!! setting('footer.description') !!}</p>
                    <ul class="list-unstyled social-icon foot-social-icon mb-0 mt-4">
                        <li class="list-inline-item"><a href="{{ setting('social.facebook') }}" class="rounded"><i
                                    data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="{{ setting('social.instagram') }}" class="rounded"><i
                                    data-feather="instagram" class="fea icon-sm fea-social"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="{{ setting('social.twitter') }}" class="rounded"><i
                                     data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="{{ setting('social.linkedin') }}" class="rounded"><i
                                    data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                    </ul>
                    <!--end icon-->
                </div>
                <!--end col-->

               
               
                <!--end col-->

                
                <!--end col-->

                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <h5 class="text-light footer-head" >خبرنامه </h5>
                    <p class="mt-4" style="color: #F5E6CC !important;">ثبت نام کنید و آخرین نکات را از طریق ایمیل دریافت کنید.</p>
                    <form method="POST" action="{{ route('save.newslatter') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="foot-subscribe mb-3">
                                    <label class="form-label">ایمیل خود را بنویسید <span
                                            class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                        <input type="email" name="email" id="emailsubscribe" 
                                        style=" color: #6F4E37 !important; border: 1px solid #6F4E37 !important;" 
                                            class="form-control ps-5 rounded"  placeholder="ایمیل شما: " required > 
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-grid" >
                                  <input type="submit" id="submitsubscribe " 
                                  style="background-color: #F5E6CC !important;"
       class="btn " 
       style="background-color: #F5E6CC !important; color: #6F4E37 !important; border: 1px solid #6F4E37 !important;" 
       value="خبرنامه">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </footer>
    <!--end footer-->
    <footer class="footer footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-start">
                       
                    </div>
                </div>
                <!--end col-->

                <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                  <span>
                    
                  
                        </span>    
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </footer>
    <!--end footer-->
    <!-- Footer End -->

    <div  class="footer-mobile-spacer">

    </div>



    <!-- Back to top -->
    <a href="#" onclick="topFunction()" id="back-to-top" style="background-color= #6F4E37 !important;" class="btn btn-icon btn-primary back-to-top"><i
            data-feather="arrow-up" class="icons"></i></a>
    <!-- Back to top -->



    <!-- javascript -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Icons -->
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Switcher -->
    <script src="{{ asset('assets/js/switcher.js') }}"></script>
    <!-- Main Js -->
    <script src="{{ asset('assets/js/plugins.init.js') }}"></script>
    <!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    

    <!-- اسکریپت (دقت کن اول jQuery باشه بعد Owl) -->


    <!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    @if (session()->has('newslatter'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'ثبت نام در خبرنامه',
                text: "{{ session('newslatter') }}",
                confirmButtonText: 'تایید',
            })
        </script>
    @endif

    @if (session()->has('productComment'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'ثبت نظر',
                text: "{{ session('productComment') }}",
                confirmButtonText: 'تایید',
            })
        </script>
    @endif

    @if (session()->has('buy_message_success'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'ثبت سفارش',
                text: "{{ session('buy_message_success') }}",
                confirmButtonText: 'تایید',
            })
        </script>
    @endif
    @yield('scripts')
</body>

</html>
