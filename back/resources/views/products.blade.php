@extends('layouts.main')
@section('title', 'لیست محصولات')
@section('content')

        <!-- Hero Start -->
        <section class="bg-half bg-light d-table w-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                            <h4 class="title"> تمام محصولات  </h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!-- Hero End -->

        <!-- Start Products -->
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="card border-0 sidebar sticky-bar">
                            <div class="card-body p-0">
                                <!-- SEARCH -->
                                <div class="widget">
                                    <!-- SEARCH -->
                                    <div class="widget">
                                        <form role="search" method="get">
                                            <div class="input-group mb-3 border rounded">
                                                <input type="text" id="s" name="s" class="form-control border-0" placeholder="جستجوی کلمه کلیدی...">
                                                <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- SEARCH -->
                                </div>
                                <!-- SEARCH -->

                                <!-- Categories -->
                                {{-- <div class="widget mt-4 pt-2">
                                    <h5 class="widget-title">دسته بندیها </h5>
                                    <ul class="list-unstyled mt-4 mb-0 blog-categories">
                                        <li><a href="jvascript:void(0)">برنج های هاشمی</a></li>
                                        <li><a href="jvascript:void(0)">برنج های طلایی  </a></li>
                                        <li><a href="jvascript:void(0)">برنج های خوش بو </a></li>
                                    </ul>
                                </div> --}}
                                <!-- Categories -->  
                                
                                <!-- Top Products -->
                                <div class="widget mt-4 pt-2">
                                    <h5 class="widget-title">محصولات ویژه </h5>
                                    <ul class="list-unstyled mt-4 mb-0">
                                        @foreach ($vip_products as $product)
                                            <li class="d-flex align-items-center">
                                                <a href="{{ url('product',$product->slug) }}">
                                                    <img src="{{url('storage', $product->image)}}" class="img-fluid avatar avatar-small rounded shadow" style="height:auto;" alt="{{$product->title}}">
                                                </a>
                                                <div class="flex-1 content ms-3">
                                                    <a href="{{ url('product',$product->slug) }}" class="text-dark h6">{{$product->title}}</a>
                                                    <h6 class="text-muted small fst-italic mb-0 mt-1">
                                                        {{ number_format(intval($product->price)) }} تومان 
                                                        @if(intval($product->old_price))
                                                            <del class="text-danger ms-2">{{ number_format(intval($product->old_price)) }} تومان</del>
                                                        @endif 
                                                    </h6>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-9 col-md-8 col-12 mt-5 pt-2 mt-sm-0 pt-sm-0">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-7">
                                <div class="section-title">
                                    <h5 class="mb-0">نمایش محصولات</h5>
                                </div>
                            </div><!--end col-->
        
                            {{-- <div class="col-lg-4 col-md-5 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                <div class="d-flex justify-content-md-between align-items-center">
                                    <div class="form custom-form">
                                        <div class="mb-0">
                                            <select class="form-select form-control" aria-label="Default select example" id="Sortbylist-job">
                                                <option selected>مرتب سازی بر اساس آخرین</option>
                                                <option>مرتب سازی بر اساس محبوبیت</option>
                                                <option>مرتب سازی بر اساس رتبه بندی</option>
                                                <option>مرتب سازی بر اساس قیمت: کم به زیاد</option>
                                                <option>مرتب سازی بر اساس قیمت: زیاد به کم</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col--> --}}
                        </div><!--end row-->

                        <div class="row">
                            
                            @foreach ($products as $product)
                            <div class="col-12 mt-4 pt-2">
                                <div class="card shop-list border-0 shadow position-relative">
                                    <ul class="label list-unstyled mb-0">
                                        {{-- <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-primary">جدید </a></li>
                                        <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-success">ویژه ها </a></li> --}}
                                        @if($product->vip)
                                        <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-warning">ویژه </a></li>
                                        @endif
                                    </ul>
                                    <div class="row align-items-center g-0">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="shop-image position-relative overflow-hidden">
                                                <a href="{{ url('product',$product->slug) }}"><img src="{{url('storage', $product->image)}}" class="img-fluid" alt="{{$product->title}}"></a>
                                            </div>
                                        </div><!--end col-->
        
                                        <div class="col-lg-8 col-md-6">
                                            <div class="card-body content p-4">
                                                <a href="{{ url('product',$product->slug) }}" class="text-dark product-name h6">{{$product->title}} </a>
                                                <div class="d-lg-flex align-items-center mt-2 mb-3">
                                                    <h6 class="text-muted small fst-italic mb-0 me-3">
                                                        {{ number_format(intval($product->price)) }} تومان 
                                                        @if($product->old_price)
                                                            <del class="text-danger ms-2">{{ number_format(intval($product->old_price)) }} تومان</del>
                                                        @endif     
                                                    </h6>
                                                    <ul class="list-unstyled text-warning mb-0">
                                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                                        <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                                    </ul>
                                                </div>
                                                <p class="para-desc text-muted mb-1">{{mb_strimwidth($product->excerpt, 0, 180, "...")}}</p>
                                                <ul class="list-unstyled mb-0">
                                                    {{-- <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="heart" class="icons"></i></a></li> --}}
                                                    <li class="mt-2 list-inline-item">
                                                        <a  href="{{ url('product',$product->slug) }}"  id="addToCart" class="btn btn-soft-primary ms-2">افزودن به سبد خرید</a>
                                                        
                                                        {{-- <a href="{{ url('product',$product->slug) }}" data-bs-toggle="modal" data-bs-target="#productview" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="eye" class="icons"></i></a>
                                                    
                                                     --}}
                                                    </li>
                                                    
                                                    
                                                    {{-- <li class="mt-2 list-inline-item"><a href="{{ url('product',$product->slug . '/add-to-card') }}" class="btn btn-icon btn-pills btn-soft-primary"><i data-feather="shopping-cart" class="icons"></i></a></li> --}}
                                                </ul>
                                            </div>
                                        </div><!--end col-->
                                    </div> <!--end row-->
                                </div><!--end blog post-->
                            </div><!--end col-->
                            @endforeach
                            

                         
                            <!-- PAGINATION END -->
                        </div><!--end row-->
                           <!-- PAGINATION START -->
                        <div class="mt-4">
                            {{$products->links()}}
                        </div><!--end col-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End Products -->

@endsection