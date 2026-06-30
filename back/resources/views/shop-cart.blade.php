@extends('layouts.main')
@section('title', 'سبد خرید')
@section('content')
<style>
.mocha-text {
    color: #6F4E37 !important;
    font-weight: bold !important; /* برای خوانایی بهتر */
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
</style>
<section class="bg-half bg-light d-table w-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <h4 class="title" > سبد خرید </h4>
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">صفحه اصلی </a></li>
                                <li class="breadcrumb-item active" aria-current="page">سبد خرید </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive bg-white shadow">
                    <table class="table table-center table-padding mb-0">
                          <thead>
        <tr>
            <th class="border-bottom py-3" style="min-width:20px "></th>
            <th class="border-bottom py-3 mocha-text" style="min-width: 300px;">محصول</th>
            <th class="border-bottom text-center py-3 mocha-text" style="min-width: 160px;">قیمت</th>
            <th class="border-bottom text-center py-3 mocha-text" style="min-width: 160px;">سایز</th>
            <th class="border-bottom text-center py-3 mocha-text" style="min-width: 160px;">رنگ</th>
            <th class="border-bottom text-center py-3 mocha-text" style="min-width: 160px;">تعداد</th>
            <th class="border-bottom text-center py-3 mocha-text" style="min-width: 160px;">مجموع</th>
        </tr>
    </thead>
                        <tbody>
                            @php $totalPrice = 0;  $totalWeight =0; @endphp
                            @php
@endphp

                            @foreach ($cart as $key => $item)
                                @php
                                    $product = new App\Models\Product();
        $product = \App\Models\Product::find($item['product_id']);
                        
                                @endphp
                                @if($product)
                                <tr class="shop-list">
                                    <td class="h6"><a href="{{url('shop-cart', $key) . '/remove'}}" class="text-danger">X</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('product', $product->slug)}}"><img src="{{url('storage', $product->image)}}" class="img-fluid avatar avatar-small rounded shadow" style="height:auto;" alt=""></a>
                                            <a href="{{url('product', $product->slug)}}"><h6 class="mb-0 ms-3">{{$product->title}} </h6></a>
                                        </div> 
                                    </td>
                                    <td class="text-center">{{number_format(intval($product->price))}} تومان</td>
<td class="text-center">
    <div style="font-size: 12px; margin-bottom: 5px;">
        {{ $item['size'] }}
    </div>
</td>
<td class="text-center">
    <div style="font-size: 12px; margin-bottom: 5px;">
        {{ $item['color'] }}
    </div>
</td>

 @php
    // پیدا کردن موجودی دقیق بر اساس سایز و رنگ انتخابی در سشن
    $variation = $product->variations()->where('size', $item['size'])
                                       ->where('color', $item['color'])
                                       ->first();
    $maxStock = $variation ? $variation->stock : 0;
@endphp


  
                                   <td class="text-center qty-icons">
    <div class="d-flex justify-content-center">
      
<button class="btn btn-sm btn-mocha" 
        onclick="changeQty(this, -1, {{ $product->price }}, {{ $maxStock }}, '{{ $key }}', '{{ $item['size'] }}', '{{ $item['color'] }}')">-</button>

<input type="number" name="quantity" value="{{ $item['count'] }}" 
       data-max="{{ $maxStock }}" class="mx-2 text-center" style="width: 50px;" readonly>

<!-- دکمه مثبت -->
<button class="btn btn-sm btn-mocha" 
        onclick="changeQty(this, 1, {{ $product->price }}, {{ $maxStock }}, '{{ $key }}', '{{ $item['size'] }}', '{{ $item['color'] }}')">+</button>
    </div>
</td>
<td class="text-center fw-bold price-row">{{ number_format($item['count'] * $product->price) }} تومان</td>
                                {{-- انتقال محاسبات به تگ درست --}}
                                @php
                                    $totalPrice += (($item['count']) * intval($product->price));
                                    $totalWeight += ($item['weight'] * $item['count']);
                                @endphp


                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--end col-->
        </div><!--end row-->




        <hr>
        <h6 class="text-center" style="color: #6F4E37 !important;">* اگر اطلاعات شما درست است تایید کنید در غیر اینصورت مشخصات خودرا بروز کنید *</h6>
        <p class="mt-2" style="color: #6F4E37 !important;">تلفن همراه شما : {{ auth()->user()->mobile }}</ class="mt-2">

        <form method="POST" action="{{ route('profile.update') }}">
            <div class="row">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" style="color: #6F4E37 !important;">نام اصلی <span style="color: red;">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="user" class="fea icon-sm icons"></i>
                            <input name="name" id="first" value="{{ old('name',auth()->user()->extra('name')) }}"
                                type="text" class="form-control ps-5" placeholder="نام اول :">
                            @error('name')
                                <small>
                                    <p style="color:red">{{ $errors->first('name') }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <!--end col-->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" style="color: #6F4E37 !important;">نام خانوادگی <span style="color: red;">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="user-check" class="fea icon-sm icons"></i>
                            <input name="family" id="last"
                                value="{{ old('family',auth()->user()->extra('family')) }}" type="text"
                                class="form-control ps-5" placeholder="نام خانوادگی :">
                            @error('family')
                                <small>
                                    <p style="color:red">{{ $errors->first('family') }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!--end col-->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" style="color: #6F4E37 !important;">آدرس دقیق </label>
                        <div class="form-icon position-relative">
                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                            <textarea name="address" id="comments" rows="4" class="form-control ps-5" placeholder="آدرس :">{{ old('address',auth()->user()->extra('address')) }}</textarea>
                            @error('address')
                                <small>
                                    <p style="color:red">{{ $errors->first('address') }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-12">
                        <button type="submit" id="submit" name="send" class="btn btn-mocha" style="color: #ffff !important;">بروز رسانی
                            اطلاعات</button>
                    </div>
                    <!--end col-->
                </div>
            </div>
        </form>

        
        <hr>
        
        
        
        <div class="row">
            <div class="col-lg-8 col-md-6 mt-4 pt-2">
                <a href="{{url('/')}}" class="btn btn-mocha" style="color: #fff !important;">خرید بیشتر</a>
            </div>
            <div class="col-lg-4 col-md-6 ms-auto mt-4 pt-2">
                <div class="table-responsive bg-white rounded shadow">
                    <table class="table table-center table-padding mb-0">
                        <tbody>
                            
                            <!-- قیمت اصلی -->
                            <tr class="bg-light">
                                <td class="h6" style="color: #6F4E37 !important;">قیمت محصولات</td>
                                <td class="text-center fw-bold">{{ number_format($subTotal) }} تومان</td>
                            </tr>

                            @if($discountAmount > 0)
                            <!-- تخفیف -->
                            <tr class="bg-light">
                                <td class="h6" style="color: #6F4E37 !important;">تخفیف</td>
                                <td class="text-center fw-bold text-danger">- {{ number_format($discountAmount) }} تومان</td>
                            </tr>


                            @endif
        
                            <!-- هزینه ارسال -->
                            <tr class="bg-light">
                                <td class="h6" style="color: #6F4E37 !important;">هزینه ارسال</td>
                                <td class="text-center fw-bold">
                                    @if($freeShipping)
                                        رایگان
                                    @else
                                        {{ number_format($send_price) }} تومان
                                    @endif
                                </td>
                            </tr>

                            @if($discountAmount > 0)
                                <!-- مجموع کل (قیمت نهایی + هزینه ارسال) -->
                                <tr class="bg-light">
                                    <td class="h6" style="color: #6F4E37 !important;">قیمت بدون تخفیف</td>
                                    <td class="text-center fw-bold text-decoration-line-through text-muted">
                                        {{ number_format($totalPrice + $send_price) }} تومان
                                    </td>
                                </tr>
                            @endif

        
                            <!-- مجموع کل (قیمت نهایی + هزینه ارسال) -->
                            <tr class="bg-light">
                                <td class="h6" style="color: #6F4E37 !important;">مجموع قابل پرداخت</td>
                                <td class="text-center fw-bold">{{ number_format(($totalPrice + $send_price)- $discountAmount) }} تومان</td>
                            </tr>

                         

                        </tbody>
                    </table>
                </div>
                <div class="mt-4 pt-2 text-end">
                    <a href="{{ route('cart.payment') }}" class="btn btn-mocha">پرداخت نهایی فاکتور</a>
                </div>
            </div>
        </div>


    </div>
</section>




<script>
function changeQty(btn, delta, unitPrice, maxStock, id, size, color) {
    let input = btn.parentElement.querySelector('input');
    let currentVal = parseInt(input.value);
    let newVal = currentVal + delta;

    if (newVal < 1) return;
 if (newVal > maxStock) {
        alert('متأسفانه موجودی این محصول برای ترکیب انتخاب شده، کافی نیست. : ');
        return;
    };

    input.value = newVal;

    // آپدیت ایجکسی
    updateCartBackend(id, newVal, size, color);
}



   

function updateCartBackend(key, count, size, color) {
    console.log("URL is:", "/cart/update"); // یا هر آدرسی که داری استفاده می‌کنی

    fetch("{{ route('cart.update') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // این رو اضافه کن
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ key: key, count: count })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // اینو توی کنسول ببین چی میگه
        window.location.reload(); 
    })
    .catch(error => console.error('Error:', error));
}



</script>

@endsection
