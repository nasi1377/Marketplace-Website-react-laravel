@extends('layouts.desktop')
@section('title', 'عضور گیری')
@section('body')
<div class="border-bottom">
    <div class="row">
        <div class="col-md-12">
            
            <div class="rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">معرفی زیرمجموعه ها</h2>
                    <hr style="background-color: silver">
                </div>
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-lg-12 col-md-4">
                        <div style="padding: 0 15px">
                            <div class="alert alert-info">
                                <strong>پیام سیستم:</strong><br>
                                <span>کدمعرفی بازو های چپ و راست خور را تعریف کنید</span><br>
                                <span>دقت داشته باشید کاربرانی که فقط زیرمجموعه کسی دیگر نیستند می تواند در بازوهای شما قرار بگیرند.</span>
                            </div>
                        
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
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-4 mt-4 pt-2">
                        <div class="text-center">
                            <img src="{{url('storage', auth()->user()->avatar)}}" class="avatar avatar-medium shadow-lg rounded-pill" alt="{{auth()->user()->name}}">
                            <div class="content mt-3">
                                <a href="javascript:void(0)" class="h5 text-dark">{{auth()->user()->name}}</a>
                                <div style="margin-top: 10px">
                                    <a href="javascript:void(0)" class="btn btn-warning">
                                        <i class="uil uil-atom"></i>
                                        <small> امتیاز :</small>
                                        {{auth()->user()->points}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <form class="row" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-lg-6 col-md-4 mt-4 pt-2">
                            <div class="text-center">
                                <div>
                                    <img src="{{url('storage/users/default.png')}}" class="avatar avatar-medium shadow-lg rounded-pill" alt="پیش فرض">
                                    <div class="content mt-3" style="align-items: center; justify-content:center; display: flex;">
                                        <div class="form-icon position-relative" style="width: 80%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            <input name="right_user_code" id="first" value="{{ auth()->user()->rightUser()? auth()->user()->rightUser()->getInviteCode() : null}}" type="text" class="form-control ps-5" placeholder="کدمعرفی بازوی راستی">
                                        </div>
                                    </div>
                                    @error('right_user_code')
                                    <small>
                                        <p style="color:red">{{ $errors->first('right_user_code') }}</p>
                                    </small>
                                    @enderror
                                </div>
                            </div>
                        </div><!--end col-->
                        
                        <div class="col-lg-6 col-md-4 mt-4 pt-2">
                            <div class="text-center">
                                <div>
                                    <img src="{{url('storage/users/default.png')}}" class="avatar avatar-medium shadow-lg rounded-pill" alt="پیش فرض">
                                    <div class="content mt-3" style="align-items: center; justify-content:center; display: flex;">
                                        <div class="form-icon position-relative" style="width: 80%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            <input name="left_user_code" id="first" value="{{ auth()->user()->leftUser()? auth()->user()->leftUser()->getInviteCode() : null}}" type="text" class="form-control ps-5" placeholder="کدمعرفی بازوی چپ">
                                        </div>
                                    </div>
                                    @error('left_user_code')
                                    <small>
                                        <p style="color:red">{{ $errors->first('left_user_code') }}</p>
                                    </small>
                                    @enderror
                                </div>
                            </div>
                        </div><!--end col-->
    
                        <div class="col-lg-12 text-center">
                            <hr style="background-color: silver">
                            <button class="btn btn-primary">ذخیره اطلاعات زیرمجموعه</button>
                        </div>
                    </form>
                  
                </div><!--end row-->
            </div>
        </div><!--end col-->   
    </div><!--end row-->
</div>
@endsection