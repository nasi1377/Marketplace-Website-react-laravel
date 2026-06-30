@extends('layouts.basic') 

<style>
.main-mocha-border {
    border: 2px solid #6F4E37 !important;
    border-radius: 15px !important;
    background-color: #fdfbf7;
    padding: 20px !important; 
    padding-bottom: 50px !important; /* به جای margin از padding استفاده کن */
    margin-bottom: 0; /* از اینجا مارجین را بردار */
}

/* عکس رو از 150 به 220 افزایش دادیم */
.product-image-container {
    width: 100%;
    height: 220px; 
    overflow: hidden;
    border-radius: 10px;
}
.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* فاصله کادر اصلی از هدر */
.container-margin { margin-top: 150px; }

/* استایل صفحه‌بندی */
.page-link { color: #6F4E37 !important; border-color: #6F4E37 !important; }
.page-item.active .page-link { background-color: #6F4E37 !important; color: white !important; }
</style>

@section('content')
<div class="container container-margin"> 
    <div class="row">
        <div class="col-12">
            <div class="rounded shadow p-4 main-mocha-border">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-6 col-12 mt-4">
                            <div class="card border-0 product-mocha-card">
                                <div class="card-body p-2">
                                    <a href="{{ url('product', $product->slug) }}" class="product-image-container d-block">
                                        <img src="{{ url('storage', $product->image) }}" alt="{{ $product->title }}">
                                    </a>
                                    <div class="pt-2">
                                        <a href="{{ url('product', $product->slug) }}" style="text-decoration: none;">
                                            <h6 style="color: #6F4E37 !important; font-weight: bold;">{{ $product->title }}</h6>
                                        </a>
                                        <h6 class="text-muted mb-0"><strong>قیمت:</strong> {{ number_format(intval($product->price)) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- نمایش صفحه‌بندی که خود لاراول به صورت خودکار "1 از X" رو مدیریت می‌کنه -->
                <div class="row mt-5">
                    <div class="col-12 d-flex justify-content-center">
<!-- برای محصولات اصلی -->
<div class="d-flex justify-content-center">
    {{ $products->appends(['v_page' => request('v_page')])->links('pagination::bootstrap-4') }}
</div>

<!-- برای محصولات VIP -->
</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12 text-center">
        <!-- نمایش شماره صفحات -->
        <p style="color: #6F4E37;">
            صفحه {{ $products->currentPage() }} از {{ $products->lastPage() }}
        </p>

        <!-- نمایش دکمه‌های صفحه‌بندی فقط در صورت نیاز -->
        @if ($products->hasPages())
            {{ $products->links() }}
        @endif
    </div>
</div>
@endsection
