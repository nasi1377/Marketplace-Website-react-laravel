@extends('layouts.auth')
@section('title', 'بازیابی کلمه عبور')
@section('content')
    <section class="bg-home d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="me-lg-5">
                        <img src="{{asset('assets/images/user/login.svg')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="card login-page bg-white shadow rounded border-0">
                        <div class="card-body">
                            <h4 class="card-title text-center" style="color: #6F4E37 !important;">بازیابی کلمه عبور </h4>
                            <form class="login-form mt-4" method="POST" action="{{route('forgot-password.action')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if(session()->has('auth_error'))
                                            <div class="alert alert-danger">
                                                <strong style="color: #6F4E37 !important;">پیام سیستم : </strong>
                                                <br>
                                                <span>{{session('auth_error')}}</span>
                                            </div>
                                        @endif
                                        @if(session()->has('auth_success'))
                                            <div class="alert alert-success">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{{session('auth_success')}}</span>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label" style="color: #6F4E37 !important;">شماره موبایل <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="phone" class="fea icon-sm icons"></i>
                                                <input id="mobile" type="text" class="form-control ps-5" style="color: #6F4E37 !important;" placeholder="موبایل" value="{{old('mobile')}}" name="mobile">
                                            </div>
                                            @error('mobile')
                                            <small>
                                                <p style="color:red">{{ $errors->first('mobile') }}</p>
                                            </small>
                                            @enderror
                                        </div>
                                    </div><!--end col-->




                                    <div class="col-lg-12 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary">ارسال کلمه عبور جدید </button>
                                        </div>
                                    </div><!--end col-->

                                    {{-- <div class="col-lg-12 mt-4 text-center">
                                        <h6>یا با آن وارد شوید</h6>
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="javascript:void(0)" class="btn btn-light"><i class="mdi mdi-facebook text-primary"></i> فیس بوک </a>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="javascript:void(0)" class="btn btn-light"><i class="mdi mdi-google text-danger"></i> گوگل </a>
                                                </div>
                                            </div><!--end col-->
                                        </div>
                                    </div><!--end col--> --}}

                                    <div class="col-12 text-center">
                                        <p class="mb-0 mt-3"><small class="text-dark me-2">قبلاً حساب دارید؟</small> <a href="{{route('login')}}" class="text-dark fw-bold">وارد شوید </a></p>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                        </div>
                    </div><!---->
                </div> <!--end col-->
            </div><!--end row-->
        </div> <!--end container-->
    </section><!--end section-->
    <!-- پایان آن -->

@endsection
