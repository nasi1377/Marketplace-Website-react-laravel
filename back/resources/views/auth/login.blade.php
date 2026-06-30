@extends('layouts.auth')
@section('title', 'ورود به حساب کاربری')
@section('content')


<style>
/* استایل برای آیکون موکایی */
.btn-icon.btn-mocha-soft {
    background-color: #f0e6e0; /* رنگ زمینه خیلی ملایم نزدیک به موکایی */
    color: #967969;           /* رنگ خود آیکون (موکایی) */
    border: none;
}

.btn-icon.btn-mocha-soft:hover {
    background-color: #967969; /* رنگ زمینه وقتی موس میره روش */
    color: #ffffff;           /* سفید شدن آیکون هنگام هاور */
}


    #ps1{
        padding: 0.375rem 2.2rem !important;
    }
    .eye.off{
        display: none;
    }
    .eye{
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
  var off = document.querySelector(".off."+id);
  if (x.type === "password") {
    x.type = "text";
    off.style.display = "block";
  } else {
    x.type = "password";
    off.style.display = "none";
  }
}

</script>

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
                        <h4 class="card-title text-center" style="color: #6F4E37 !important;">وارد شدن </h4>
                        <form class="login-form mt-4" method="POST" action="{{route('login.action')}}">
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
                                            <strong style="color: #6F4E37 !important;">پیام سیستم : </strong>
                                            <br>
                                            <span>{{session('auth_success')}}</span>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #6F4E37 !important;">شماره موبایل <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="phone" class="fea icon-sm icons"></i>
                                            <input type="text" class="form-control ps-5" placeholder="موبایل" value="{{old('mobile')}}" name="mobile" id="mobile" >
                                        </div>
                                        @error('mobile')
                                        <small>
                                            <p style="color:red">{{ $errors->first('mobile') }}</p>
                                        </small>
                                        @enderror
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #6F4E37 !important;">رمز عبور  <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                            <input id="ps1" type="password" class="form-control ps-5" placeholder="رمز عبور " name="password" required="">
                                            
                                            <i onclick="see('ps1')" class="eye ps1 on mdi mdi-18px mdi-eye"></i>
                                            <i onclick="see('ps1')" class="eye ps1 off mdi mdi-18px mdi-eye-off"></i>
                                       
                                        </div>
                                        @error('password')
                                        <small>
                                            <p style="color:red">{{ $errors->first('password') }}</p>
                                        </small>
                                        @enderror
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault" style="color: #6F4E37 !important;">مرا به خاطر بسپار </label>
                                            </div>
                                        </div>
                                        {{-- <p class="forgot-pass mb-0"><a href="auth-re-password.html" class="text-dark fw-bold">فراموشی رمز عبور؟ </a></p> --}}
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-12 mb-0">
                                    <div class="d-grid">
                                        <button class="btn-icon.btn-mocha-soft" style="color: #ffff !important;">ورود </button>
                                    </div>
                                </div><!--end col-->

                                {{-- <div class="col-lg-12 mt-4 text-center">
                                    <h6 style="color: #6F4E37 !important;">یا با آن وارد شوید</h6>
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
                                    <p class="mb-0 mt-3">
                                        <small class="text-dark me-2" style="color: #6F4E37 !important;">حسابی ندارید؟ </small>
                                        <a href="{{route('register')}}" class="text-dark fw-bold" style="color: #6F4E37 !important;">ثبت نام کنید </a>
                                    </p>
                                    <a href="{{route('forgot-password')}}" class="text-dark fw-bold" style="color: #6F4E37 !important;">کلمه عبور را فراموش کردم! </a>
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
