@extends('layouts.main')
@section('title', 'درباره ما')
@section('content')
<!-- شوع آن -->
<section class="bg-half bg-light d-table w-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <h4 class="title" style="color: #6F4E37 !important;"> تاریخچه فروشگاه  ما </h4>
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color: #6F4E37 !important;">صفحه اصلی </a></li>
                                <li class="breadcrumb-item active" aria-current="page" style="color: #6F4E37 !important;">درباره ما</li>
                            </ul>
                        </nav>
                    </div>
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
<!-- پایان آن -->

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="main-icon rounded-pill text-primary text-center mt-4 pt-2">
                    <i data-feather="star" class="fea icon-md-sm"></i>
                </div>
                <div class="timeline-page pt-2 position-relative">
                    <div class="timeline-item mt-4">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="duration date-label-left border rounded p-2 px-4 position-relative shadow">1400</div>
                            </div><!--end col-->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card event event-description-right rounded shadow border-0 overflow-hidden float-start">
                                    <img src="{{url('assets/images/blog/01.jpg')}}" class="img-fluid" alt="">
                                    <div class="card-body">
                                        <h5 class="mb-0 text-capitalize"  style="color: #6F4E37 !important;">تاسیس </h5>
                                        <p class="mt-3 mb-0 text-muted"> فروشگاه نارنید در سال 1404 با هدف فراهم کردن لباس مرغوب برای زنان کشور عزیزمان ایجاد شد</p>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end timeline item-->
    
                    <div class="timeline-item mt-4">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 order-sm-1 order-2">
                                <div class="card event event-description-left rounded shadow border-0 overflow-hidden float-start">
                                    <img src="{{url('assets/images/blog/02.jpg')}}" class="img-fluid" alt="">
                                    <div class="card-body">
                                        <h5 class="mb-0 text-capitalize" style="color: #6F4E37 !important;">شعارما</h5>
                                        <p class="mt-3 mb-0 text-muted">عذت نفس بالا= شیک پوشی</p>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-6 col-md-6 col-sm-6 order-sm-2 order-1">
                                <div class="duration duration-right rounded border p-2 px-4 position-relative shadow text-start">1404</div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end timeline item-->

                   
                </div><!--end timeline page-->
                <!-- TIMELINE END -->
            </div><!--end col-->
        </div><!--end row-->
    </div>
</section>
@endsection