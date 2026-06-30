@extends('layouts.main')

@section('title', 'فروشگاه نارنید')

@section('content')
<style>
    /* ظرف اصلی اسلایدر */
   .simple-slider-container {
    direction: ltr !important; 
    overflow: hidden;
    position: relative;
    width: 100vw; /* عرض کامل صفحه */
    margin-left: calc(-50vw + 50%); /* این خط جادویی، اسلایدر رو از محدودیت پدرش خارج می‌کنه */
    margin-right: calc(-50vw + 50%);
    border-radius: 0; /* برای حالت تمام‌عرض، گوشه‌های گرد معمولا قشنگ نمیشه */
    background-color: #f8f9fa;
    margin-top: 0; /* فاصله از بالا رو صفر کن تا بچسبه به منو */
    min-height: 200px;
}

    .slider-wrapper {
        display: flex;
        transition: transform 0.5s ease-in-out;
        width: 100%;
    }

    .slider-slide {
        min-width: 100%;
        box-sizing: border-box;
    }

    .slider-slide img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        max-height: 550px;
    }

    /* دکمه‌های ناوبری */
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 10;
        border-radius: 5px;
    }
    .slider-prev { left: 10px; }
    .slider-next { right: 10px; }

    /* نقطه‌های پایین */
    .slider-dots {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }
    .dot {
        width: 12px;
        height: 12px;
        background: rgba(255,255,255,0.5);
        border-radius: 50%;
        cursor: pointer;
    }
    .dot.active { background: #fff; }
    <style>
/* تراز کردن دکمه‌های ناوبری OWL Carousel */
.owl-carousel .owl-nav {
    position: absolute;
    top: 35%; /* ارتفاع عمودی فلش‌ها */
    width: 100%;
    display: flex;
    justify-content: space-between;
    pointer-events: none; /* این باعث میشه کلیک روی بقیه عکس‌ها مسدود نشه */
}


/* تنظیم کانتینر برای موقعیت‌دهی مطلق فلش‌ها */
.owl-carousel {
    position: relative !important;
}

/* تنظیم جایگاه باکس فلش‌ها */
.owl-carousel .owl-nav {
    position: absolute;
    top: 40%; /* این مقدار رو تنظیم کن تا فلش دقیقاً وسط ارتفاع عکس قرار بگیره */
    width: 100%;
    display: flex;
    justify-content: space-between;
    pointer-events: none; /* جلوگیری از مزاحمت باکس فلش برای کلیک روی عکس */
}

/* استایل دکمه‌های دایره‌ای */
.owl-carousel .owl-nav button {
    pointer-events: auto; /* فعال کردن امکان کلیک */
    width: 40px;
    height: 40px;
    background: #ffffff !important; /* رنگ سفید */
    color: #6F4E37 !important; /* رنگ آیکون به رنگ موکایی */
    border-radius: 50% !important; /* دایره‌ای شدن */
    font-size: 20px !important;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important; /* سایه ملایم برای زیبایی */
    margin: 0 10px !important; /* فاصله از لبه‌های چپ و راست */
    transition: all 0.3s ease;
    display: flex !important;
    align-items: center;
    justify-content: center;
}

/* افکت هاور برای دکمه‌ها */
.owl-carousel .owl-nav button:hover {
    background: #6F4E37 !important;
    color: #ffffff !important;
}
</style>


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="simple-slider-container">
                <div class="slider-wrapper" id="mainSliderWrapper">
                    <!-- اسلاید اول -->
                    <div class="slider-slide">
                        <img src="{{ asset('storage/settings/12345678.png') }}" alt="نارنید 1">
                    </div>
                    <!-- اسلاید دوم -->
                    <div class="slider-slide">
                        <img src="{{ asset('storage/settings/March2022/1234.jpg') }}" alt="نارنید 2">
                    </div>
                </div>

                <!-- دکمه‌ها -->
                <button class="slider-btn slider-prev" id="btnPrevSlider">&#10094;</button>
                <button class="slider-btn slider-next" id="btnNextSlider">&#10095;</button>

                <!-- نقطه‌ها -->
                <div class="slider-dots" id="dotsContainer">
                    <span class="dot active" data-idx="0"></span>
                    <span class="dot" data-idx="1"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const swrapper = document.getElementById('mainSliderWrapper');
    const sdots = document.querySelectorAll('.dot');
    const snext = document.getElementById('btnNextSlider');
    const sprev = document.getElementById('btnPrevSlider');
    
    let sIndex = 0;
    const sTotal = document.querySelectorAll('.slider-slide').length;

    function sUpdate() {
        if (swrapper) {
            swrapper.style.transform = `translateX(-${sIndex * 100}%)`;
            sdots.forEach((d, i) => d.classList.toggle('active', i === sIndex));
        }
    }

    if (snext) {
        snext.addEventListener('click', function() {
            sIndex = (sIndex + 1) % sTotal;
            sUpdate();
        });
    }

    if (sprev) {
        sprev.addEventListener('click', function() {
            sIndex = (sIndex - 1 + sTotal) % sTotal;
            sUpdate();
        });
    }

    sdots.forEach(dot => {
        dot.addEventListener('click', function() {
            sIndex = parseInt(this.getAttribute('data-idx'));
            sUpdate();
        });
    });

    // حرکت خودکار
    setInterval(() => {
        sIndex = (sIndex + 1) % sTotal;
        sUpdate();
    }, 5000);
});
</script>




   <!-- Profile Start -->
<section style="margin-top: 0; padding-top: 0;" class="section pb-0">
    <div class="my-slide" style="min-width: 100%; height: fit-content; background: #fff; padding: 20px;">
        <div class="widget">
          <!-- اضافه کردن d-flex flex-wrap justify-content-center برای وسط‌چین کردن -->
            <ul class="list-unstyled sidebar-nav mb-0 d-flex flex-wrap justify-content-center">
                @foreach (\App\Models\Pcategory::all() as $category)
                <li class="navbar-item account-menu px-2" style="margin-bottom: 10px;">
                    <a href="{{ route('category.products', $category->slug) }}" 
                       class="navbar-link d-flex rounded align-items-center justify-content-center py-2 px-4" 
                       style="border: 2px solid #6F4E37 !important; background-color: #F5E6CC !important; color: #6F4E37 !important; transition: all 0.3s; text-align: center; min-width: 150px;">
                        <h6 class="mb-0 p-2" style="color: #6F4E37 !important;">{{ $category->name }}</h6>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

                                {{-- <li class="navbar-item account-menu px-0 mt-2">
                                    <a href="#shopping-bag" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                                        <h6 class="mb-0 ms-1 p-2">   سبد خرید</h6>
                                    </a>
                                </li>
                                
                                
                                <li class="navbar-item account-menu px-0 mt-2">
                                    <a href="#contact-us" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                                        <h6 class="mb-0 ms-2 p-2">تماس با ما</h6>
                                    </a>
                                </li>
                                
                                <li class="navbar-item account-menu px-0 mt-2">
                                    <a href="#about-us" class="navbar-link d-flex rounded shadow align-items-center py-2 px-4">
                                        <h6 class="mb-0 ms-2 p-2">درباره ی ما</h6>
                                    </a>
                                </li> 
                            </ul>
                        </div> 

                        <div class="widget mt-4 pt-2">
                            <h5 class="widget-title">دنبال کردن ما :</h5>
                            <ul class="list-unstyled social-icon mb-0 mt-4">
                                <li class="list-inline-item"><a href="{{ setting('social.facebook') }}" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="{{ setting('social.instagram') }}" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="{{ setting('social.twitter') }}" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="{{ setting('social.linkedin') }}" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                            </ul><!--end icon-->
                        </div>
                    </div> --}}
                </div><!--end col-->






<!-- ۱. مطمئن شو تمام تگ‌های بازِ قبلی رو با این کار می‌بندی -->
</div> 
</div> 
</div> 










<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">جدیدترین‌ها</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
            @foreach ($vip_products as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>



<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">شومیز</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
                        @foreach ($shomiz as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>



<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">کت</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
                        @foreach ($coats as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">ست</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
                            @foreach ($sets as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>




<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">شلوار</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
                            @foreach ($shalvar as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">ساحلی</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
                      @foreach ($saheli as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">اکسسوری</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
  @foreach ($acssesory as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


 
<section class="section">
    <div class="container">
        <!-- بخش تیتر -->
        <div class="row align-items-center mb-4">
            <div class="col-8">
                <h4 class="mb-0" style="color: #6F4E37 !important;">پالتو و بارانی</h4>
            </div>
        </div>

        <!-- اسلایدر محصولات -->
        <div class="owl-carousel new-products-slider">
                            @foreach ($paltos as $product)
                <div class="item">
                    <a href="{{ url('product', $product->slug) }}" class="text-decoration-none">
                        <div class="card border-0">
                            <!-- تصویر محصول -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded shadow-sm img-fluid" style="height: 300px; object-fit: cover;">
                            
                            <!-- جزئیات محصول -->
                            <div class="card-body px-0 pt-3">
                                <h6 class="text-dark">{{ $product->title }}</h6>
                                <p class="text-warning fw-bold mb-0">
                                    {{ number_format($product->price) }} 
                                    <small>تومان</small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section style="margin-top: 30px; margin-bottom: 10px;" class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <!-- عنوان با رنگ موکایی -->
                    <h4 class="title mb-4" style="color: #6F4E37 !important; font-weight: bold;">اخبار</h4>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($posts as $post)
            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                <!-- تغییر رنگ کارت به یه تم روشن‌تر از موکایی -->
                <div class="card blog rounded border-0 shadow" style="background-color: #fcf9f7; border: 1px solid #e8e0db !important;">
                    <div class="position-relative">
                        <img src="{{url('storage/', $post->image)}}" class="card-img-top rounded-top" alt="{{$post->title}}">
                    </div>
                    <div class="card-body content">
                        <h5>
                            <a href="{{url('posts', $post->slug)}}" class="card-title title" style="color: #6F4E37 !important;">{{$post->title}}</a>
                        </h5>
                        <div class="post-meta d-flex justify-content-between mt-3">
                            <a href="{{url('posts', $post->slug)}}" class="readmore" style="color: #6F4E37 !important; font-weight: bold;">ادامه مطلب <i class="uil uil-angle-left-b align-middle"></i></a>
                        </div>
                    </div>
                    <!-- نوار پایین کارت با رنگ موکایی اصلی -->
                    <div class="author" style="background-color: #6F4E37 !important; padding: 10px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                        <small class="text-white user d-block"><i class="uil uil-user"></i> ادمین </small>
                        <small class="text-white date"><i class="uil uil-calendar-alt"></i> {{jdate($post->created_at)->format('j F')}}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
// استفاده از جاوااسکریپت خالص برای اطمینان از اجرا، حتی اگر جی‌کوئری دیر لود شود
function initSliders() {
    if (typeof $ !== 'undefined' && $.fn.owlCarousel) {
        // اسلایدر شومیز، کت و غیره
        $('.best-sell-slider').owlCarousel({
            rtl: true, // برای نمایش درست در فارسی
            loop: true,
            margin: 10,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: { items: 2 },
                768: { items: 3 },
                1000: { items: 4 }
            }
        });

        // اسلایدر جدیدترین‌ها
        $('.new-products-slider').owlCarousel({
            rtl: true,
            loop: true,
            margin: 15,
            dots: false,
            responsive: {
                0: { items: 2 },
                768: { items: 3 },
                1000: { items: 5 }
            }
        });
    } else {
        // اگر جی‌کوئری هنوز لود نشده، نیم ثانیه دیگه دوباره امتحان کن
        setTimeout(initSliders, 500);
    }
}

document.addEventListener('DOMContentLoaded', initSliders);
</script>

@endsection


