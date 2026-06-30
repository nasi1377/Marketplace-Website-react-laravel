@extends('layouts.main')
@section('title', $product->title)

@section("meta")
<meta name="product_id" content="{{ $product->id }}">
<meta name="product_name" content="{{ $product->title }}">
<meta name="product_price" content="{{intval($product->price)}}">
<meta name="product_old_price" content="{{intval($product->old_price)}}">
<meta name="availability" content="{{ ($product->stock == 0) ? 'outofstock' : 'instock' }}">

<meta property="og:image" content="{{ url('storage', $product->image) }}">
<meta name="description" content="{{ $product->meta_description }}">
<meta name="keywords" content="{{ $product->meta_keywords }}">
<meta property="og:title" content="{{$product->title }}">
{{-- <meta property="og:title" content="{{ $product->seo_title ?? $product->title }}"> --}}
<meta property="og:description" content="{{ $product->meta_description }}">
<meta property="og:type" content="product">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

<style>
.btn-mochalight{
        background-color: #D5C4B4  !important;

}
.btn-mocha {
    background-color: #D5C4B4  !important;
    border: 2px solid #6F4E37 !important;
    color: #ffffff !important;
    border-radius: 5px !important;
    padding: 10px 20px; /* اضافه کردن پدینگ برای زیبایی بیشتر */
    transition: all 0.3s ease; /* افکت نرم هنگام کلیک یا هاور */
}
/* افکت هاور (زمانی که موس میره روی دکمه) */
.btn-mocha:hover {
    background-color: #D5C4B4  !important;
    border-color: #5c412d !important;
    cursor: pointer;
}
 /* این استایل برای سایز و رنگ */
    .sizes li div, .colors li div {
        padding: 8px 15px; /* کمی پدینگ بیشتر برای زیبایی */
        border: 2px solid #6F4E37; /* رنگ اصلی موکایی */
        border-radius: 8px;
        cursor: pointer;
        color: #6F4E37;
        transition: all 0.3s ease;
    }

    .sizes li div.active, .colors li div.active {
        background-color: #D5C4B4 !important; /* موکایی روشن انتخابی */
        color: white !important;
        border-color: #6F4E37 !important;
    }

    /* این بخش برای هاور باکس توضیحات */
    #pills-tab .nav-link:hover {
        background-color: #D5C4B4 !important;
        color: white !important;
        transition: 0.3s;
    }
    
    #pills-tab .nav-link.active {
        background-color: #6F4E37 !important; /* وقتی فعاله رنگ اصلی باشه */
        color: white !important;
    }

    .sizes, .colors { list-style: none; padding: 0; }
    .sizes li, .colors li { display: inline-block; margin: 5px; }
</style>


@section('content')
<section class="section pb-0">
    <div class="container" style="color: #6F4E37 !important;">
        <div class="row align-items-center mt-5">
            <div class="col-md-5">
                <div class="tiny-single-item">
                    <div class="tiny-slide"><img src="{{url('storage', $product->image)}}" class="img-fluid rounded" alt="{{ $product->title }}"></div>
                    @if($product->gallery)
                        @foreach (json_decode($product->gallery) as $image)
                            <div class="tiny-slide"><img src="{{ asset('storage/' . str_replace('\\', '/', $product->image)) }}" class="img-fluid rounded" alt="{{ $product->title }}"></div>

                        @endforeach
                    @endif
                </div>
                
            </div><!--end col-->

            <div class="col-md-7 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="section-title ms-md-4">
                    {{-- @if($discount > 0)
                        <div class="discount-section">
                            <span style="color: #6F4E37 !important;">تخفیف ({{ $discountTitle }}):</span>
                            <span style="color: #6F4E37 !important;">{{ number_format($discount) }} تومان</span>
                        </div>
                    @endif --}}

                    <h1 class="title" style="color: #6F4E37 !important;">{{ $product->title }}</h1>
                    <h5 class="text-muted" style="color: #6F4E37 !important;">
                        {{ number_format(intval($product->price)) }} تومان
                        @if($product->old_price)
                            <del class="text-danger ms-2" style="color: #6F4E37 !important;">{{ number_format(intval($product->old_price)) }} تومان</del>
                        @endif
                    </h5>
                    <ul class="list-unstyled text-warning h5 mb-0">
                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                    </ul>

                    <h5 class="mt-4 py-2" style="color: #6F4E37 !important;">بررسی:</h5>
                    <p class="text-muted">
                        {!! $product->excerpt !!}
                    </p>


                    <div class="row mt-4 pt-2">
                       

<form action="{{ route('add.product.card', ['SLUG' => $product->slug]) }}"  method="post">
                            @csrf

                  
   <input type="hidden" name="size" id="inputSize" value="{{ $product->variations->first()->size }}">
<input type="hidden" name="color" id="inputColor" value="{{ $product->variations->first()->color }}">
@if($product->variations->sum('stock') > 0)



                            <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                                <div class="d-flex shop-list align-items-center">

                              
<!-- سایز -->
<!-- سایز -->
<label>سایز:</label>
<ul class="sizes" style="color: #6F4E37 !important;">
    @foreach($product->variations->unique('size') as $variation)
        <li>
           <div onclick="
                document.querySelectorAll('.sizes li div').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                selectVariation('size', '{{ $variation->size }}');
            " class="{{ $loop->first ? 'active' : '' }}">
                {{ $variation->size }}
            </div>
        </li>
    @endforeach
</ul>

<!-- رنگ -->
<label>رنگ:</label>
<ul class="colors" style="color: #6F4E37 !important;">
    @foreach($product->variations->unique('color') as $variation)
        <li>
            <div onclick="
                document.querySelectorAll('.colors li div').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                selectVariation('color', '{{ $variation->color }}');
            " class="{{ $loop->first ? 'active' : '' }}">
                {{ $variation->color }}
            </div>
        </li>
    @endforeach
</ul>

  </div>
                                <br>
                              
                            </div>







                            <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                                <div class="d-flex shop-list align-items-center">


                                    <h6 class="mb-0" style="color: #6F4E37 !important;">تعداد: </h6>
                                    <div class="qty-icons ms-3">
    <!-- حذف کردیم چون تابع خودش از اینپوت میخونه -->
<a onclick="document.querySelector('input[name=count]').stepDown(); checkAndResetStock()" class="btn  btn-icon btn-mocha minus">-</a>
    
    <input min="1" name="count" value="1" type="number" class="btn  btn-mochalight btn-soft-primary qty-btn quantity">
    
<a onclick="document.querySelector('input[name=count]').stepUp(); checkAndResetStock()" class="btn btn-icon btn-mocha plus">+</a>
</div>


                                    
                                </div>
                                
                            

                                <br>
                                <br>
                         @php
    $inCart = false;
    $cart = json_decode(request()->cookie('cart'), true) ?? [];
    foreach($cart as $item) {
        // چک کردن ترکیبِ دقیقِ محصول + سایز + رنگ
        if($item['product_id'] == $product->id && 
           $item['size'] == $product->variations->first()->size && 
           $item['color'] == $product->variations->first()->color) {
            $inCart = true;
            break;
        }
    }
@endphp

                              @if($inCart)
    <div id="cartStatusContainer">
        <!-- دکمه خرید (در حالت عادی مخفی چون در سبد هست) -->
        <button type="submit" id="addToCartBtn" class="btn btn-mocha ms-2" style="display: none;">افزودن به سبد خرید</button>
        
        <!-- پیغام خطا (موجودی) -->
        <p id="errorToCart" style="display: none; color: #dc3545; font-weight: bold; margin-top: 10px;">
            ⚠️ موجودی انبار کافی نیست
        </p>
        
        <!-- پیغام موجود در سبد خرید -->
        <div id="inCartAlert" class="alert alert-warning mt-3">
            این محصول با این رنگ و سایز هم‌اکنون در سبد خرید شما موجود است.
            <a href="{{ route('add.shop.cart') }}" class="fw-bold">مشاهده سبد خرید</a>
        </div>
    </div>
@else
    <div id="cartStatusContainer">
        <!-- دکمه خرید اصلی -->
        <button type="submit" id="addToCartBtn" class="btn btn-mocha ms-2">افزودن به سبد خرید</button>
        
        <!-- پیغام خطا (موجودی) -->
        <p id="errorToCart" style="display: none; color: #dc3545; font-weight: bold; margin-top: 10px;">
            ⚠️ موجودی انبار کافی نیست
        </p>
        
        <!-- پیغام موجود در سبد خرید (در حالت عادی مخفی) -->
        <div id="inCartAlert" class="alert alert-warning mt-3" style="display: none;">
            این محصول با این رنگ و سایز هم‌اکنون در سبد خرید شما موجود است.
            <a href="{{ route('add.shop.cart') }}" class="fw-bold">مشاهده سبد خرید</a>
        </div>
    </div>

<!-- اون span اضافی بعد از endif رو حذف کن چون بالا داخل دوتا بلاک گذاشتیمش -->



@endif
<span id="errorToCart" style="display: none; color: red;" >موجودی انبار کافی نیست</span>
                            </div><!--end col-->


                            @else
                                <button class="btn btn-warning" disabled style="color: #6F4E37 !important;">موجودی انبار خالی است</button>
                            @endif
@if(session('buy_message_error'))
    <div class="alert alert-danger">
        {{ session('buy_message_error') }}
    </div>
@endif
                            
                        </form>
                        {{-- <form class="login-form mt-4" method="POST" action="{{ route('register.action.direct', ['SLUG' => $product->slug]) }}" >
                            @csrf
                            <div class="col-lg-6">

                                <div class="mb-3">
                                    <label for="name" class="form-label" style="color: #6F4E37 !important;" style="color: #6F4E37 !important;">نام</label>
                                    <input type="text" class="form-control" name="name" placeholder="نام خود را وارد کنید" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label" style="color: #6F4E37 !important;" style="color: #6F4E37 !important;">نام خانوادگی</label>
                                    <input type="text" class="form-control" name="family" placeholder="نام خود را وارد کنید" required>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label" style="color: #6F4E37 !important;" style="color: #6F4E37 !important;">شماره موبایل</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder=" شماره موبایل خودرا وارد کنید" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label" style="color: #6F4E37 !important;" style="color: #6F4E37 !important;">آدرس دقیق</label>
                                    <textarea name="address" id="address" cols="30" rows="10" class="form-control" placeholder="آدرس دقیق و کد پستی و ..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label"style="color: #6F4E37 !important;" style="color: #6F4E37 !important;">کد معرفی</label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="اگر کد معرف دارید وارد کنید">
                                </div>
                                <button type="submit" class="btn btn-primary" style="color: #6F4E37 !important;" style="color: #ffff !important;">ثبت مشخصات</button>
                            </div>
                        </form> --}}
                    </div><!--end row-->

                    <div class="mt-4 pt-2">

                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class="container mt-100 mt-60">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills shadow flex-column flex-sm-row d-md-inline-flex mb-0 p-1 bg-white rounded position-relative overflow-hidden" id="pills-tab" role="tablist">
                    <li class="nav-item m-1">
                        <a class="nav-link py-2 px-5 active rounded" id="description-data" data-bs-toggle="pill" href="#description" role="tab" aria-controls="description" aria-selected="false">
                            <div class="text-center">
                                <h6 class="mb-0" style="color: #D5C4B4  !important;">توضیحات </h6>
                            </div>
                        </a><!--end nav link-->
                    </li><!--end nav item-->

                    <li class="nav-item m-1">
                        <a class="nav-link py-2 px-5 rounded" id="additional-info" data-bs-toggle="pill" href="#additional" role="tab" aria-controls="additional" aria-selected="false">
                            <div class="text-center">
                                <h6 class="mb-0" style="color: #D5C4B4  !important;">اطلاعات تکمیلی</h6>
                            </div>
                        </a><!--end nav link-->
                    </li><!--end nav item-->

                    <li class="nav-item m-1">
                        <a class="nav-link py-2 px-5 rounded" id="review-comments" data-bs-toggle="pill" href="#review" role="tab" aria-controls="review" aria-selected="false">
                            <div class="text-center">
                                <h6 class="mb-0" style="color: #D5C4B4  !important;">نظرات </h6>
                            </div>
                        </a><!--end nav link-->
                    </li><!--end nav item-->
                </ul>

                <div class="tab-content mt-5" id="pills-tabContent" style="margin-bottom: 50px">
                    <div class="card border-0 tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-data">
                        {!! $product->body !!}



                        
                    </div>

                    <div class="card border-0 tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-info">
                        <table class="table">
                            <tbody>
                                @foreach ($properties as $property)
                                    @php $property = explode(':', $property); @endphp
                                    @if(isset($property[0]) && isset($property[1]))
                                    <tr>
                                        <td style="width: 220px;" style="color: #6F4E37 !important;">{{ $property[0] }} </td>
                                        <td class="text-muted" style="color: #6F4E37 !important;">{{ $property[1] }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card border-0 tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-comments">
                        <div class="row">
                            <div class="col-lg-6" style="color: #6F4E37 !important;">
                                @if(!count($comments))
                                    <div class="alert alert-info btn-mochalight" >
                                        <span style="color: #6F4E37 !important;">نظری برای این محصول ثبت نشده است!</span>
                                    </div>
                                @endif
                                <ul class="media-list list-unstyled mb-0">
                                    @foreach ($comments as $comment)
                                    <li>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <a class="pe-3" href="#">
                                                    <img src="{{asset('assets/images/client/default.jpg')}}" class="img-fluid avatar avatar-md-sm rounded-circle shadow" alt="img">
                                                </a>
                                                <div class="flex-1 commentor-detail">
                                                    <h6 class="mb-0"><a href="javascript:void(0)" class="text-dark media-heading">{{ $comment->name }}</a></h6>
                                                    <small class="text-muted">{{ jdate($comment->created_at)->format('j F Y') }}</small>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            </ul>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-muted fst-italic p-3 bg-light rounded" style="color: #6F4E37 !important;">{{ $comment->text }}</p>
                                        </div>
                                    </li>
                                    @endforeach

                                </ul>
                            </div><!--end col-->

                            <div class="col-lg-6">
                                <form class="ms-lg-4" method="POST" action="{{ route('save.product.comment', ['SLUG' => $product->slug]) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 style="color: #6F4E37 !important;">اضافه کردن نظر:</h5>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="color: #6F4E37 !important;">نظر شما:</label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="message-circle" class="fea icon-sm icons"></i>
                                                    <textarea id="message" placeholder="کامنت شما" rows="5" name="text" class="form-control ps-5" required=""></textarea>
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" style="color: #6F4E37 !important;">نام  <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input id="name" name="name" type="text" placeholder="نام" class="form-control ps-5" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" style="color: #6F4E37 !important;">ایمیل شما <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                                    <input id="email" type="email" placeholder="ایمیل" name="email" class="form-control ps-5" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="send d-grid">
                                                <button type="submit" class="btn btn-mochalight" style="color: #6F4E37 !important;">ارسال </button>
                                            </div>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form><!--end form-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </div><!--end container-->

    {{-- <div class="container mt-100 mt-60">
        <div class="row">
            <div class="col-12">
                <h5 class="mb-0" style="color: #6F4E37 !important;">محصولات اخیر</h5>
            </div><!--end col-->

            <div class="col-12 mt-4">
                <div class="tiny-four-item">
                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <ul class="label list-unstyled mb-0">
                                <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-danger">داغ </a></li>
                            </ul>
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s1.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-1.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">تی شرت بردان  </a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">16000 تومان<del class="text-danger ms-2">21000 تومان</del> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s2.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-2.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">کیسه خرید </a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">21000 تومان <del class="text-danger ms-2">25000 تومان</del> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <ul class="label list-unstyled mb-0">
                                <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-warning">ویژه </a></li>
                            </ul>
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s3.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-3.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">ساعت الگنت </a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">50000 تومان <span class="text-success ms-1">30% تخفیف</span> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s4.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-4.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">کفش های گاه به گاه </a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">18000 تومان <del class="text-danger ms-2">22000 تومان</del> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <ul class="label list-unstyled mb-0">
                                <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-warning">ویژه </a></li>
                            </ul>
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s5.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-5.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">هدفون </a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">30000 تومان</h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s6.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-6.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">لیوان زیبا</a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">4500 تومان <del class="text-danger ms-2">6500 تومان</del> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s7.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-7.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">هدفون سونی</a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">9000 تومان <span class="text-success ms-2">20% تخفیف</span> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide">
                        <div class="card shop-list border-0 position-relative m-2">
                            <ul class="label list-unstyled mb-0">
                                <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-success">ویژه ها </a></li>
                            </ul>
                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                <a href="shop-product-detail.html"><img src="images/shop/product/s8.jpg" class="img-fluid" alt=""></a>
                                <a href="shop-product-detail.html" class="overlay-work">
                                    <img src="images/shop/product/s-8.jpg" class="img-fluid" alt="">
                                </a>
                                <ul class="list-unstyled shop-icons">
                                    <li><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-danger"><i data-feather="heart" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-product-detail.html" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a></li>
                                    <li class="mt-2"><a href="shop-cart.html" class="btn btn-icon btn-pills btn-soft-warning"><i data-feather="shopping-cart" class="icons"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body content pt-4 p-2">
                                <a href="shop-product-detail.html" class="text-dark product-name h6">چهارپایه چوبی</a>
                                <div class="d-flex justify-content-between mt-1">
                                    <h6 class="text-muted small fst-italic mb-0 mt-1">22000 تومان <del class="text-danger ms-2">25000 تومان</del> </h6>
                                    <ul class="list-unstyled text-warning mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container--> --}}


</section><!--end section-->
<script>
    const allVariations = @json($product->variations);
    const cartItems = @json(json_decode(request()->cookie('cart'), true) ?? []);
    
    let selectedSize = "{{ $product->variations->first()->size ?? '' }}";
    let selectedColor = "{{ $product->variations->first()->color ?? '' }}";

    function selectVariation(type, value) {
        if(type === 'size') {
            selectedSize = value;
            document.getElementById('inputSize').value = value;
        }
        if(type === 'color') {
            selectedColor = value;
            document.getElementById('inputColor').value = value;
        }
        checkAndResetStock();
    }

    function checkAndResetStock() {
        const countInput = document.querySelector('input[name=count]');
        const count = parseInt(countInput.value) || 1;
        
        const currentVar = allVariations.find(v => v.size == selectedSize && v.color == selectedColor);
        
        const alreadyInCart = cartItems.some(item => 
            parseInt(item.product_id) === {{ $product->id }} && 
            String(item.size) === String(selectedSize) && 
            String(item.color) === String(selectedColor)
        );

        const btn = document.getElementById("addToCartBtn");
        const error = document.getElementById("errorToCart");
        const inCartMsg = document.getElementById("inCartAlert");

        // اول همه رو مخفی می‌کنیم
        if(btn) btn.style.display = "none";
        if(error) error.style.display = "none";
        if(inCartMsg) inCartMsg.style.display = "none";

        if (alreadyInCart) {
            // اگر در سبد بود، فقط پیام سبد خرید
            if(inCartMsg) inCartMsg.style.display = "block";
        } else if (!currentVar || count > parseInt(currentVar.stock)) {
            // اگر موجودی انبار کم بود، نمایش ارور موجودی
            if(error) {
                error.style.display = "block";
                error.innerText = !currentVar ? "⚠️ این ترکیب موجود نیست" : "⚠️ موجودی انبار کافی نیست )";
            }
        } else {
            // اگر همه چیز درست بود، دکمه خرید
            if(btn) btn.style.display = "inline-block";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        checkAndResetStock();
    });


    
</script>


<style>
    .weights{
        list-style: none;
    }
    .weights li{
        display:inline-block;
        margin:5px;
    }

    .weights li div{
        padding: 5px;
        border: 1px solid;
        border-radius: 20px;
        cursor: pointer;
    }


    .weights li div.active {
        background-color: #aebd48;
        color: white;
    }

    .weights li span{font-size: 11px;}


     .sizes{
        list-style: none;
    }
    .sizes li{
        display:inline-block;
        margin:5px;
    }

    .sizes li div{
        padding: 5px;
        border: 1px solid;
        border-radius: 20px;
        cursor: pointer;
    }


    .sizes li div.active {
        background-color: #aebd48;
        color: white;
    }

    .sizes li span{font-size: 11px;}



























     .colors{
        list-style: none;
    }
    .colors li{
        display:inline-block;
        margin:5px;
    }

    .colors li div{
        padding: 5px;
        border: 1px solid;
        border-radius: 20px;
        cursor: pointer;
    }


    .colors li div.active {
        background-color: #aebd48;
        color: white;
    }

    .colors li span{font-size: 11px;}
    
</style>

@endsection
