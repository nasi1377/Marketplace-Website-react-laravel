@extends('layouts.main')
@section('title', 'لیست کتاب های ارسال شده')
@section('content')
<section class="bg-half bg-light d-table w-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <h4 class="title"> کتاب ها </h4>
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">صفحه اصلی </a></li>
                                <li class="breadcrumb-item active" aria-current="page">کتاب ها</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section>
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row">
            @foreach ($books as $book)
                <div class="col-lg-4 col-md-6 mb-4 pb-2">
                    <div class="card blog rounded border-0 shadow overflow-hidden">
                        <div class="position-relative">
                            <img src="{{url('storage', $book->image)}}" class="card-img-top" alt="{{$book->title}}">
                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                            <h5><a href="{{url('books', $book->slug)}}" class="card-title title text-dark">{{$book->title}}</a></h5>
                            <div class="post-meta d-flex justify-content-between mt-3">
                                <ul class="list-unstyled mb-0">
                                    {{-- <li class="list-inline-item me-2 mb-0"><a href="url(" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li> --}}
                                </ul>
                                <a href="{{url('books', $book->slug)}}" class="text-muted readmore">ادامه مطلب  <i class="uil uil-angle-left-b align-middle"></i></a>
                            </div>
                        </div>
                        <div class="author">
                            <small class="text-light user d-block"><i class="uil uil-user"></i> مدیریت </small>
                            <small class="text-light date"><i class="uil uil-calendar-alt"></i> {{jdate($book->created_at)->format('F Y')}}</small>
                        </div>
                    </div>
                </div><!--end col-->
            @endforeach
        

            <!-- PAGINATION START -->
            <div class="col-12">
                {!! $books->links() !!}
            </div><!--end col-->
            <!-- PAGINATION END -->
        </div><!--end row-->
    </div><!--end container-->
</section>
@endsection