@extends('layouts.auth')
@section('title', 'ایجاد حساب کاربری جدید')
@section('content')

    <style>
    .btn-mocha {
    background-color: #967969; /* کد رنگ موکایی */
    border-color: #967969;
    color: white;
}

.btn-mocha:hover {
    background-color: #7d6558; /* کمی تیره‌تر برای وقتی که موس میره روش */
    border-color: #7d6558;
}

        #ps1,
        #ps2 {
            padding: 0.375rem 2.2rem !important;
            color: #6F4E37 !important;
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

        // Modal Script
        function openModal() {
            $('#modalLaw').modal('show');
        }
    </script>

    <section class="bg-auth-home d-table w-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="me-lg-5">
                        <img src="{{ asset('assets/images/user/signup.svg') }}" class="img-fluid d-block mx-auto"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h4 class="card-title text-center" style="color: #6F4E37 !important;">ثبت نام </h4>
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>پیام سیستم : </strong>
                                    <br>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif
                            
                            <form class="login-form mt-4" method="POST" action="{{ route('register.action') }}">
                                @csrf
                                <div class="row">
                                    @if (session()->has('auth_error'))
                                        <div class="alert alert-danger">
                                            <strong>پیام سیستم : </strong>
                                            <br>
                                            <span>{{ session('auth_error') }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-6">

                                        <div class="mb-3">
                                            <label class="form-label" style="color: #6F4E37 !important;">نام <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input type="text" class="form-control ps-5" placeholder="نام "
                                                    value="{{ old('name') }}" name="name" required="">
                                            </div>
                                            @error('name')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('name') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: #6F4E37 !important;">نام خانوادگی <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user-check" class="fea icon-sm icons"></i>
                                                <input type="text" class="form-control ps-5" placeholder="نام خانوادگی"
                                                    value="{{ old('family') }}" name="family" required="">
                                            </div>
                                            @error('family')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('family') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div><!--end col-->

                                    <!-- <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">ایمیل شما </label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                                    <input type="email" class="form-control ps-5" placeholder="ایمیل" value="{{ old('email') }}" name="email">
                                                </div>
                                                @error('email')
        <small>
                                                            <p style="color:red">{{ $errors->first('email') }}</p>
                                                        </small>
    @enderror
                                            </div>
                                        </div> -->
                                    <!--end col-->

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: #6F4E37 !important;">شماره موبایل <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="phone" class="fea icon-sm icons"></i>
                                                <input type="text" style="direction: ltr; text-align: right"
                                                    class="form-control ps-5" value="{{ old('mobile') }}"
                                                    placeholder="موبایل" name="mobile" id="mobile" required="required">
                                            </div>

                                            @error('mobile')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('mobile') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: #6F4E37 !important;">رمز عبور <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input id="ps1" type="password" class="form-control ps-5"
                                                    placeholder="یک رمز عبور دلخواه برای خود انتخاب کنید" name="password"
                                                    required="">

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

                                    {{-- <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #6F4E37 !important;">تکرار رمز عبور  <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                            <input  id="ps2" type="password" class="form-control ps-5" placeholder="تکرار رمز عبور " name="password_confirmation" required="">
                                            
                                            <i onclick="see('ps2')" class="eye ps2 on  mdi mdi-18px mdi-eye"></i>
                                            <i onclick="see('ps2')" class="eye ps2 off mdi mdi-18px mdi-eye-off"></i>
                                        </div>
                                        @error('password_confirmation')
                                        <small>
                                            <p style="color:red">{{ $errors->first('password_confirmation') }}</p>
                                        </small>
                                        @enderror
                                    </div>
                                </div> --}}
                                    <!--end col-->


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: #6F4E37 !important;">کدمعرفی </label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="code" class="fea icon-sm icons"></i>
                                                <input type="text" style="direction: ltr; text-align: right"
                                                    class="form-control ps-5"
                                                    value="{{ request()->has('inv') ? request()->get('inv') : old('code') }}"
                                                    placeholder="کدمعرفی" name="code">
                                            </div>

                                            @error('code')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('code') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div><!--end col-->




                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="check_law"
                                                    id="flexCheckDefault" onclick="openModal()">
                                                <label class="form-check-label" for="flexCheckDefault">تایید میکنم <a
                                                        href="#" style="color: #6F4E37 !important;">قوانین سایت را و تیکت را فعال
                                                        میکنم</a></label>
                                            </div>
                                            @error('check_law')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('check_law') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-md-12">
                                        <div class="d-grid">
                                            <button class="btn btn-mocha" >ثبت نام </button>
                                        </div>
                                    </div><!--end col-->
                                    {{--
                                <div class="col-lg-12 mt-4 text-center">
                                    <h6 >یا با آن ثبت نام کنید</h6>
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

                                    <div class="mx-auto">
                                        <p class="mb-0 mt-3"><small class="text-dark me-2">قبلاً حساب دارید؟</small> <a
                                                href="{{ route('login') }}" class="text-dark fw-bold" style="color: #6F4E37 !important;">وارد شوید </a></p>
                                    </div>
                                </div><!--end row-->
                            </form>
                        </div>
                    </div>
                </div> <!--end col-->
            </div><!--end row-->
        </div> <!--end container-->
    </section><!--end section-->



    <!-- Modal for Terms and Conditions -->
    <div class="modal fade" id="modalLaw" tabindex="-1" aria-labelledby="modalLawLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLawLabel">قوانین سایت</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #6F4E37 !important;">
                    <p>
                    <h3 >قوانین فروشگاه نارنید
                </h3>
                    <p> بزرگ ترین مجموعه اینترنتی خرید لباس  مستقیما
                        ارسال به سراسر کشور .قبل از ثبت نام این برگه را به طور کامل مطالعه کنید.</p>

                    <h3>قوانین</h3>

                    <h4><b>بند اول:</b></h4>
                    <p>فروشگاه نارنید تا 10 روز پس از ثبت سفارش محصولات را ارسال می کند و شماره پیگیری برای شما ارسال می گردد.</p>
                    <p>روز کاری به معنی روز شنبه تا پنج شنبه به استثنای روز های تعطیل عمومی در کشور ایران است و کلیه سفارشات
                        ثبت شده در طول روز های کاری و اولین روز پس از تعطیلات پردازش میگردد.</p>

                    <h4><b>بند دوم:</b></h4>
                    <p>در صورتی که محصول ارائه شده توسط فروشگاه دارای هر گونه مغایرت با اطلاعات درج شده در سایت یا هرگونه
                        نارضایتی بخاطر وجود مشکل در محصول و بسته بندی باشد مشتری میتواند از طریق افزونه مرجوعیت و ارتباط با
                        پشتیبانی تا 3 روز پس از تحویل مرجوع کرده و وجه خود را دریافت نماید.</p>
                    <p>برای ارتقاء کیفیت خدمات در موارد غیر ضروری و وجود هر گونه مشکل هرچند کوچک با ارتباط با کارشناسان
                        پشتیبانی مشکلات را مطرح و پیگیری فرمایید.</p>

                    <h4><b>بند سوم:</b></h4>
                    <p>پس از ثبت سفارش مشتری از طریق وبسایت یک تا چهار روز بسته به موقعیت مکانی شخص زمان نیاز است تا مرسوله
                        نزد مشتری تحویل گردد در این مدت با استفاده از کد ارسال مرسوله مکان و زمان محصول قابل پیگیری خواهد
                        بود و همچنین موقعیت سفارش توسط شرکت رساننده مرسوله با پیامک به مشتری اطلاع رسانی خواهد شد.</p>

                    <h4><b>بند چهارم:</b></h4>
                    <p>برای فعالیت به عنوان بازاریاب شرکت خرید  معرفی به حداقل دو نفر الزامی
                        میباشد.</p>

                

                    <h4><b>بند هفتم:</b></h4>
                    <p>مقدار پاداش ها و میزان موفقیت شما در این بستر کاملا بستگی به مقدار فعالیت شما و مجموعه دارد و شرکت
                        تنها تضمین کننده پرداخت پاداش ها مطابق الگوریتم تعیین شده سایت است و مقدار این پاداش ها کاملا بستگی
                        به فعالیت بازارساز و مجموعه آن و امتیاز های کسب شده توسط آن‌ها دارد.</p>
                    <p>پس قبل از اقدام برای فعالیت در این بستر از طریق منو کسب درآمد و مقالات مرتبط با بازارسازی با این نوع
                        کسب درآمد کاملا آشنا شده و آن را یاد بگیرید.</p>

                    <h4><b>بند هشتم:</b></h4>
                    <p>بستر پیام رسان شرکت صرفا برای ارتباط کاری با مجموعه تعبیه گردیده و در صورت هر گونه مزاحمت و نزاع و
                        کلمات مخالف شعونات اسلامی بلافاصله صفحه شما بسته خواهد شد.</p>

                    <h4><b>بند نهم:</b></h4>
                    <p>پس از ثبت نام تکمیل پروفایل شخصی الزامی میباشد و تمام اطلاعات پروفایل باید متعلق به کاربر ایجاد کننده
                        حساب باشد و مسئولیت اطلاعات شخصی (نام و نام خانوادگی، شماره کارت و …) بر عهده کاربر خواهد بود.</p>

                    <h4><b>بند دهم:</b></h4>
                    <p>افزودن کالا به سبد خرید به معنی رزرو آن کالا نمیباشد.</p>

                    <h4><b>بند یازدهم:</b></h4>
                    <p>تمام محصولات شرکت قابلیت مرجوعیت دارند و در صورت هرگونه نارضایتی تا یک هفته بعد از دریافت  از
                        محصول باقی مانده باشد می‌توانند مرجوع کرده و وجه خود را دریافت کنند. ارسال محصول جهت مرجوعیت محصول
                        بر عهده مشتری میباشد.</p>


                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

@endsection
