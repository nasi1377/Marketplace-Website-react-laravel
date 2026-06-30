@extends('layouts.desktop')
@section('title', 'خرید عمده')
@section('body')
<div class="border-bottom">
    <div class="row">
        <div class="col-md-12">
            
            <div class="rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">خرید عمده</h2>
                    <hr style="background-color: silver">
                </div>
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-lg-12 col-md-4">
                        <div style="padding: 0 15px">
                            <div class="alert alert-warning">
                                <strong>پیام سیستم:</strong><br>
                                <span>از تکمیل بودن پروفایل خود اطمینان حاصل کنید.</span><br>
                            </div>
                            <div class="alert alert-success">
                                <span>  خرید عمده برای خرید های بالا 150 کیلوگرم است و قالبا برای بازاریابان مستقیم میباشد تمامی پاداش خرید عمده برای شخص بازاریاب (خریدار) میباشد 
                                </span><br>
                            </div>

                          
                            <form method="POST" action="{{route('desktop.buy.major.save')}}" enctype="multipart/form-data">
                                @csrf
                    
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        @if(session()->has('message_error'))
                                            <div class="alert alert-danger">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{{session('message_error')}}</span>
                                            </div>
                                        @endif
                                        @if(session()->has('message_success'))
                                            <div class="alert alert-success">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{{session('message_success')}}</span>
                                            </div>
                                        @endif
                                        <hr>
                                        <h6 style="color: #888">اطلاعات سفارش</h6>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">انتخاب محصول </label>
                                                    <div class="form-group position-relative">
                                                        <select name="product" id="product" class="form-control" onChange="CalPrice(this)" value="{{old("product",null)}}">
                                                            <option value="">انتخاب کنید</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{$product->id}}" data-one-price="{{$product->one_price}}">{{ $product->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('product')
                                                        <small>
                                                            <p style="color:red">{{ $errors->first('product') }}</p>
                                                        </small>
                                                    @enderror
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">وزن سفارش (kg)</label>
                                                    <div class="form-group position-relative">
                                                        <input class="form-control" type="number" name="weight" value="{{old("weight",150)}}" min="150" placeholder="وزن سفارش">
                                                        @error('weight')
                                                        <small>
                                                            <p style="color:red">{{ $errors->first('weight') }}</p>
                                                        </small>
                                                    @enderror
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <h6 style="color: #888">اطلاعات تماس</h6>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">تلفن همراه </label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="phone-call" class="fea icon-sm icons"></i>
                                                <input name="mobile" id="email" value="{{old("mobile",auth()->user()->mobile)}}" type="text" class="form-control ps-5" placeholder="تلفن همراه :">
                                                @error('mobile')
                                                    <small>
                                                        <p style="color:red">{{ $errors->first('mobile') }}</p>
                                                    </small>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">تلفن ثابت </label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="phone" class="fea icon-sm icons"></i>
                                                <input name="phone" id="email" value="{{old("phone",auth()->user()->extra('phone'))}}" type="text" class="form-control ps-5" placeholder="تلفن ثابت :">
                                                @error('phone')
                                                    <small>
                                                        <p style="color:red">{{ $errors->first('phone') }}</p>
                                                    </small>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">کدپستی </label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="bookmark" class="fea icon-sm icons"></i>
                                                <input name="zipcode" id="occupation" value="{{old("zipcode",auth()->user()->extra('zipcode'))}}" type="text" class="form-control ps-5" placeholder="کدپستی :">
                                                @error('zipcode')
                                                    <small>
                                                        <p style="color:red">{{ $errors->first('zipcode') }}</p>
                                                    </small>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">آدرس دقیق </label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                                <textarea name="address" id="comments" rows="4" class="form-control ps-5" placeholder="آدرس :">{{old("address",auth()->user()->extra('address'))}}</textarea>
                                                @error('address')
                                                    <small>
                                                        <p style="color:red">{{ $errors->first('address') }}</p>
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end row-->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="submit" class="btn btn-primary">ثبت سفارش</button>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form><!--end form-->
                        </div>
                    </div>
                </div><!--end row-->
            </div>
        </div><!--end col-->   
    </div><!--end row-->
</div>
<script>
    function CalPrice(event) {
        console.log(event.value);
    }
</script>
@endsection