@extends('layouts.auth')
@section('title', 'تایید شماره تماس')
@section('content')

    <style>
        #ps1 {
            padding: 0.375rem 2.2rem !important;
        }

        .eye.off {
            display: none;
        }

        .eye {
            float: left;
            margin-top: -33px;
            cursor: pointer;
            margin-left: 5px;
            z-index: 999;
            position: absolute;
            left: 0;
        }

        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
    </style>

    <script>
        function see(id) {
            var x = document.getElementById(id);
            var off = document.querySelector(".off." + id);
            if (x.type === "password") {
                x.type = "text";
                off.style.display = "block";
            } else {
                x.type = "password";
                off.style.display = "none";
            }
        }

        function sendcode() {

            $.ajax({
                url: '/send-verify-mobile?mobile=' +
                    "{{ session('mobile') != null ? session('mobile') : request()->get('mobile') }}",
                type: 'POST',
                processData: false,
                contentType: false
            }).done(function(data) {
                alert("کد تایید ارسال شد");

                $("#send-ver-code-text").show();
                $("#send-ver-code-btn").hide();

                setTimeout(() => {

                    $("#send-ver-code-text").hide();
                    $("#send-ver-code-btn").show();


                }, 60000);
            });
        }
    </script>

    <section class="bg-home d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="me-lg-5">
                        <img src="{{ asset('assets/images/user/login.svg') }}" class="img-fluid d-block mx-auto"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="card login-page bg-white shadow rounded border-0">
                        <div class="card-body">
                            <h4 class="card-title text-center">تایید شماره </h4>
                            <form class="login-form mt-4" method="POST" action="{{ route('verify-mobile.action') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if (session()->has('auth_error'))
                                            <div class="alert alert-danger">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{!! session('auth_error') !!}</span>
                                            </div>
                                        @endif
                                        @if (session()->has('auth_success'))
                                            <div class="alert alert-success">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{!! session('auth_success') !!}</span>

                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label">شماره موبایل <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="phone" class="fea icon-sm icons"></i>
                                                <input disabled type="text" class="form-control ps-5"
                                                    placeholder="موبایل"
                                                    value="{{ session('mobile') != null ? session('mobile') : request()->get('mobile') }}">
                                                <input hidden type="text"
                                                    value="{{ session('mobile') != null ? session('mobile') : request()->get('mobile') }}"
                                                    name="mobile">
                                            </div>
                                            @error('mobile')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('mobile') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->


                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">رمز عبور <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input id="ps1" type="password" class="form-control ps-5"
                                                    placeholder="رمز عبور " value="{{session('password')}}" name="password" required="required">

                                                <i onclick="see('ps1')" class="eye ps1 on mdi mdi-18px mdi-eye"></i>
                                                <i onclick="see('ps1')" class="eye ps1 off mdi mdi-18px mdi-eye-off"></i>

                                            </div>
                                            @error('password')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('password') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">کد تایید <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input id="ps1" type="text" class="form-control ps-5"
                                                    placeholder="کد تایید " name="code" required="">

                                                <i onclick="see('ps1')" class="eye ps1 on mdi mdi-18px mdi-eye"></i>
                                                <i onclick="see('ps1')" class="eye ps1 off mdi mdi-18px mdi-eye-off"></i>

                                            </div>
                                            @error('code')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('code') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between">
                                            <div class="mb-3">

                                            </div>
                                            {{-- <p class="forgot-pass mb-0"><a href="auth-re-password.html" class="text-dark fw-bold">فراموشی رمز عبور؟ </a></p> --}}
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary">تایید </button>
                                        </div>
                                    </div>
                                    <!--end col-->

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


                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>

                            <div class="row">

                                <div class="col-12 text-center">
                                    <p class="mb-0 mt-3">
                                        <small id="send-ver-code-text" class="text-dark me-2"> کد تایید ارسال شده 2 دقیقه
                                            بعد مجددا امکان ارسال وجود دارد </small>
                                    </p>
                                    <button onclick="sendcode()" id="send-ver-code-btn" class="btn btn-danger">ارسال
                                        مجدد </button>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="mb-0 mt-3">
                                        <small class="text-dark me-2">حسابی ندارید؟ </small>
                                        <a href="{{ route('register') }}" class="text-dark fw-bold">ثبت نام کنید </a>
                                    </p>
                                    <a href="{{ route('login') }}" class="text-dark fw-bold">وارد شوید </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!--end section-->
    <!-- پایان آن -->

    <script>
        $("#send-ver-code-text").hide();
        $("#send-ver-code-btn").show();
    </script>

@endsection
