@extends('layouts.desktop')
@section('title', 'پروفایل کاربری')
@section('body')

<style>
.sidebar-nav .navbar-link {
    /* دایره‌ای‌تر شدن و اندازه */
    border-radius: 50px !important; /* بیشترش کردم که دایره‌ای‌تر بشه */
    padding: 15px 40px !important; 
    min-width: 200px !important; /* بزرگ‌تر شد */
    margin: 10px; /* فاصله از هم */
    text-decoration: none;
    transition: all 0.4s ease !important;
}

/* افکت هاور */
.sidebar-nav .navbar-link:hover {
    background-color: #6F4E37 !important; /* رنگ زمینه موقع هاور */
    color: #F5E6CC !important; /* رنگ متن موقع هاور */
    transform: scale(1.05); /* یکم بزرگ شدن موقع هاور */
}

/* اصلاح رنگ متن داخل هاور */
.sidebar-nav .navbar-link:hover h6 {
    color: #F5E6CC !important;
}
</style>
<section style="margin-top: 0; padding-top: 0;" class="section pb-0">
    <div class="my-slide" style="min-width: 100%; height: fit-content; background: #fff; padding: 20px;">
        <div class="widget">
            <!-- حذف max-width و d-inline-block برای گرفتن کل عرض -->
            <ul class="list-unstyled" style="margin: 0; padding: 0;">
                <li style="width: 100%; margin-bottom: 15px;">
                    <a href="{{ url('desktop/orders') }}" class="d-block rounded py-3 text-center" style="border: 2px solid #6F4E37 !important; background-color: #F5E6CC !important; color: #6F4E37 !important; text-decoration: none; width: 100%;">
                        <h6 class="mb-0">سفارشات</h6>
                    </a>
                </li>
                <li style="width: 100%; margin-bottom: 15px;">
                    <a href="{{ url('desktop/return') }}" class="d-block rounded py-3 text-center" style="border: 2px solid #6F4E37 !important; background-color: #F5E6CC !important; color: #6F4E37 !important; text-decoration: none; width: 100%;">
                        <h6 class="mb-0">مرجوعی</h6>
                    </a>
                </li>
                <li style="width: 100%;">
                    <a href="{{ url('desktop/gift-box') }}" class="d-block rounded py-3 text-center" style="border: 2px solid #6F4E37 !important; background-color: #F5E6CC !important; color: #6F4E37 !important; text-decoration: none; width: 100%;">
                        <h6 class="mb-0">هدیه ها</h6>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>



    <script src="{{ asset('assets/js/city.js') }}"></script>
    <div class="card border-0 rounded shadow">
        <div class="card-body">
            <h5 class="text-md-start text-center">جزئیات شخصی :</h5>

            @if (session()->has('message_error'))
                <div class="alert alert-danger">
                    <strong>پیام سیستم : </strong>
                    <br>
                    <span>{{ session('message_error') }}</span>
                </div>
            @endif
            @if (session()->has('message_success'))
                <div class="alert alert-success">
                    <strong>پیام سیستم : </strong>
                    <br>
                    <span>{{ session('message_success') }}</span>
                </div>
            @endif

            <div class="mt-3 text-md-start text-center d-sm-flex">
                <img id="avatar-pic" src="{{ url('storage', auth()->user()->avatar) }}"
                    class="avatar float-md-left avatar-medium rounded-circle shadow me-md-4" alt="">
                <form enctype="multipart/form-data" id="form-avatar">

                    <input name="file" style="display: none" type="file" id="file-avatar" accept="image/*"
                        onchange="showPreview(event);">
                </form>
                <div class="mt-md-4 mt-3 mt-sm-0">
                    <a id="btn-upload" href="javascript:void(0)" onclick="new_avatar()" style="cursor: pointer"
                        class="btn btn-primary mt-2">
                        <span style="display: none" id="btn-upload-loading" class="spinner-border spinner-border-sm"
                            role="status" aria-hidden="true"></span>
                        تغییر تصویر</a>

                    <a href="javascript:void(0)" onclick="reset_avatar()" style="cursor: pointer"
                        class="btn btn-outline-primary mt-2 ms-2">حذف </a>
                </div>
            </div>
            <hr style="background-color: silver">
            <form method="POST" action="{{ route('desktop.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input id="image-avatar" type="hidden" name="avatar" value="{{ auth()->user()->avatar }}">
                <div class="row mt-4">
                    <h5>اطلاعات اولیه </h5>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">نام اصلی <span style="color: red;">*</span></label>
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
                            <label class="form-label">نام خانوادگی <span style="color: red;">*</span></label>
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
                   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">تلفن همراه <span style="color: red;">*</span></label>
                            <div class="form-icon position-relative">
                                <i data-feather="phone-call" class="fea icon-sm icons"></i>
                                <input name="mobile" id="email" value="{{ old('mobile', auth()->user()->mobile) }}"
                                    type="text" class="form-control ps-5" placeholder="تلفن همراه :">
                                @error('mobile')
                                    <small>
                                        <p style="color:red">{{ $errors->first('mobile') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!--end col-->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">تلفن ثابت </label>
                            <div class="form-icon position-relative">
                                <i data-feather="phone" class="fea icon-sm icons"></i>
                                <input name="phone" id="email"
                                    value="{{ old('phone',auth()->user()->extra('phone')) }}" type="text"
                                    class="form-control ps-5" placeholder="تلفن ثابت :">
                                @error('phone')
                                    <small>
                                        <p style="color:red">{{ $errors->first('phone') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                   

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">استان</label>
                            <div class="form-icon position-relative">
                                <i data-feather="home" class="fea icon-sm icons"></i>
                                <select id="state" name="prov_id" onChange="iranwebsv(this.value);"
                                    class="form-control ps-5">
                                    <option value="0">لطفا استان را انتخاب نمایید</option>
                                    <option value="1">تهران</option>
                                    <option value="2">گیلان</option>
                                    <option value="3">آذربایجان شرقی</option>
                                    <option value="4">خوزستان</option>
                                    <option value="5">فارس</option>
                                    <option value="6">اصفهان</option>
                                    <option value="7">خراسان رضوی</option>
                                    <option value="8">قزوین</option>
                                    <option value="9">سمنان</option>
                                    <option value="10">قم</option>
                                    <option value="11">مرکزی</option>
                                    <option value="12">زنجان</option>
                                    <option value="13">مازندران</option>
                                    <option value="14">گلستان</option>
                                    <option value="15">اردبیل</option>
                                    <option value="16">آذربایجان غربی</option>
                                    <option value="17">همدان</option>
                                    <option value="18">کردستان</option>
                                    <option value="19">کرمانشاه</option>
                                    <option value="20">لرستان</option>
                                    <option value="21">بوشهر</option>
                                    <option value="22">کرمان</option>
                                    <option value="23">هرمزگان</option>
                                    <option value="24">چهارمحال و بختیاری</option>
                                    <option value="25">یزد</option>
                                    <option value="26">سیستان و بلوچستان</option>
                                    <option value="27">ایلام</option>
                                    <option value="28">کهگلویه و بویراحمد</option>
                                    <option value="29">خراسان شمالی</option>
                                    <option value="30">خراسان جنوبی</option>
                                    <option value="31">البرز</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <!--end col-->

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">شهر</label>
                            <div class="form-icon position-relative">
                                <i data-feather="home" class="fea icon-sm icons"></i>
                                <select onChange="sscity(this);" name="city_id" id="city"
                                    class="form-control ps-5">
                                    <option value="0">لطفا استان را انتخاب نمایید</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <!--end col-->



                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">کدپستی </label>
                            <div class="form-icon position-relative">
                                <i data-feather="bookmark" class="fea icon-sm icons"></i>
                                <input name="zipcode" id="occupation"
                                    value="{{ old('zipcode',auth()->user()->extra('zipcode')) }}" type="text"
                                    class="form-control ps-5" placeholder="کدپستی :">
                                @error('zipcode')
                                    <small>
                                        <p style="color:red">{{ $errors->first('zipcode') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">آدرس دقیق </label>
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
                            <button type="submit" id="submit" name="send" class="btn btn-primary">بروز رسانی
                                اطلاعات</button>
                        </div>
                        <!--end col-->
                    </div>

                 
                    <hr class="mb-4">
                 

                    <h5>پروفایل بازاریابان </h5>
                    <p>(این قسمت تنها برای افرادی است که تمایل به بازاریابی محصولات ما دارند)</p>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ایمیل شما </label>
                            <div class="form-icon position-relative">
                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                <input name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                                    type="email" class="form-control ps-5" placeholder="ایمیل شما :">
                                @error('email')
                                    <small>
                                        <p style="color:red">{{ $errors->first('email') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">کدملی </label>
                            <div class="form-icon position-relative">
                                <i data-feather="codepen" class="fea icon-sm icons"></i>
                                <input name="nation_code" id="email"
                                    value="{{ old('nation_code',auth()->user()->extra('nation_code')) }}" type="text"
                                    class="form-control ps-5" placeholder="کدملی :">
                                @error('nation_code')
                                    <small>
                                        <p style="color:red">{{ $errors->first('nation_code') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">شماره کارت </label>
                            <div class="form-icon position-relative">
                                <i data-feather="code" class="fea icon-sm icons"></i>
                                <input name="cart" id="occupation"
                                    value="{{ old('cart',auth()->user()->extra('cart')) }}"
                                    style="text-align: left; direction: ltr" type="text" class="form-control ps-5"
                                    placeholder="50222910...">
                                @error('cart')
                                    <small>
                                        <p style="color:red">{{ $errors->first('cart') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">شبا </label>
                            <div class="form-icon position-relative">
                                <i data-feather="code" class="fea icon-sm icons"></i>
                                <input name="sheba" id="occupation"
                                    value="{{ old('sheba',auth()->user()->extra('sheba')) }}"
                                    style="text-align: left; direction: ltr" type="text" class="form-control ps-5"
                                    placeholder="IR1254...">
                                @error('sheba')
                                    <small>
                                        <p style="color:red">{{ $errors->first('sheba') }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end col-->

                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            <strong>توضیحات مورد نیاز</strong>
                            <p>در این قسمت میتوانید اجازه دسترسی نمایش اطلاعات خود را مدیریت کنید!</p>
                        </div>
                        <div class="mb-3" style="padding: 10px; border-radius: 4px; background-color: #fff1d6">
                            <label class="form-label">اختیارات برنامه </label>
                            <div class="form-icon position-relative">
                                <i data-feather="codepen" class="fea icon-sm icons"></i>
                                <select name="access" class="form-control ps-5">
                                    <option value="0" @if (auth()->user()->extra('access') == '0') selected @endif>دسترسی نداشته
                                        باشند</option>
                                    <option value="1" @if (auth()->user()->extra('access') == '1') selected @endif>اجازه دسترسی
                                        داده شود</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->

                <input type="hidden" name="full_address" id="full_address" value="">

                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" id="submit" name="send" class="btn btn-primary">بروز رسانی
                            اطلاعات</button>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </form>
            <!--end form-->


         
        </div>
    </div>


    <script>
        var defualt_avatar = "users/default.png";

        function during_loading() {
            $("#btn-upload").attr("disabled");
            $("#btn-upload-loading").show();
        }

        function finished_loading() {
            $("#btn-upload-loading").hide();
            $("#btn-upload").removeAttr("disabled");

        }

        function reset_avatar() {
            $("#image-avatar").val(defualt_avatar);

            $("#avatar-pic").attr("src", "https://narnid.com/storage/" + defualt_avatar);

        }

        function new_avatar() {
            $("#file-avatar").click();
        }

        function showPreview(event) {
            if (event.target.files.length > 0) {

                during_loading();

                $.ajax({
                    url: '/desktop/avatar_upload',
                    type: 'POST',
                    data: new FormData(document.getElementById("form-avatar")), // The form with the file inputs.
                    processData: false,
                    contentType: false // Using FormData, no need to process data.
                }).done(function(data) {
                    console.log(data);

                    finished_loading();
                    var src = URL.createObjectURL(event.target.files[0]);
                    $("#avatar-pic").attr("src", src);
                    $("#image-avatar").val(data.url);
                }).fail(function(error) {
                    console.log(error);

                    finished_loading();
                });

            }
        }


        iranwebsv("{{ old('prov_id', auth()->user()->prov_id) }}");

      
        setTimeout(() => {
           

            document.getElementById('city').value = parseInt("{{ old('city_id', auth()->user()->city_id) }}");
           
            setTimeout(() => {

                var sel = document.getElementById('city');
                var sels = document.getElementById('state');

            

                 document.getElementById('full_address').value = sel.options[sel.selectedIndex].text+ "  ";

                 document.getElementById('full_address').value += sels.options[sels.selectedIndex].text;

      
            }, 500);

        }, 1000);
    </script>



@endsection
