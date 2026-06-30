@extends('layouts.desktop')
@section('title', 'مرجوعیت محصول')
@section('body')
<div class="border-bottom">
    <div class="row">
        <div class="col-md-12">
            
            <div class="rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">مرجوعیت محصول</h2>
                    <hr style="background-color: silver">
                </div>
                <div class="row" style="padding-bottom: 20px">
                   
                    
            <div class="rounded shadow mt-4">
                <div class="p-4 border-bottom">
                    <h5 class="mb-0 text-danger">مرجوعیت محصول :</h5>
                </div>





                <div class="p-4">


                    <div class="alert alert-info">
                        <strong>پیام سیستم:</strong><br>
                        <span>  فروشگاه نارنید محصولات خود  را تا 3  به دلیل مشکلات فیزیمی  را با کمال افتخار میپذیرد. </span>
                        <br>
                    </div>
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


                    <h6 class="mb-0">به هر دلیل سفار ش خود را میخواهید مرجوع کنید از فرم زیر اقدام کنید.</h6>
                    <div class="mt-4">
                        <form action="{{route('desktop.orders.referred')}}" method="POST">
                            @csrf
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">انتخاب سفارش </label>
                                    <div class="form-group position-relative">
                                        <select name="order" id="order" class="form-control">
                                            <option value="">انتخاب کنید</option>
                                            @foreach ($orders as $order)
                                                @if( $order->status == 'PROCESSED')
                                                    <option value="{{$order->id}}">  {!! $order->displayProduct() !!}  (کد:{{$order->id + 4786 }})  </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('order')
                                        <small>
                                            <p style="color:red">{{ $errors->first('order') }}</p>
                                        </small>
                                    @enderror
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">دلیل مرجوعیت </label>
                                    <div class="form-group position-relative">
                                        <textarea class="form form-control" name="message" style="height: 110px" name="" id="" cols="30" rows="10">{{old('message')}}</textarea>
                                    </div>
                                    @error('message')
                                        <small>
                                            <p style="color:red">{{ $errors->first('message') }}</p>
                                        </small>
                                    @enderror
                                </div> 
                            </div>
                            <button class="btn btn-danger">ثبت تقاضا</button>
                        </form>
                    </div><!--end col-->
                </div>
            </div>


                  
                </div><!--end row-->
            </div>
        </div><!--end col-->   
    </div><!--end row-->
</div>
@endsection