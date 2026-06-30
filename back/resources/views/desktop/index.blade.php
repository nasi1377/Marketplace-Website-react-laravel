@extends('layouts.desktop')
@section('title', 'دفتر کار کاربر')
@section('body')
<div class="border-bottom">
    <div class="row">
        <div class="col-md-12">

            <div class="rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">دفتر کار کاربری</h2>
                    <hr style="background-color: silver">
                </div>
                
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-lg-12 col-md-12">
                        <div style="padding: 0 15px">
                            <div class="alert alert-info">
                                <strong>خوش آمدید:</strong><br>
                                <span>به پنل کاربری خود خوش آمدید. در این قسمت می‌توانید وضعیت حساب خود را مشاهده کنید.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 mt-4 pt-2">
                        <div class="text-center">
                            @if(auth()->user()->avatar)
                                <img src="{{url('storage', auth()->user()->avatar)}}" class="avatar avatar-medium shadow-lg rounded-pill" alt="{{auth()->user()->name}}">
                            @else
                                <img src="{{url('storage/users/default.png')}}" class="avatar avatar-medium shadow-lg rounded-pill" alt="پیش فرض">
                            @endif
                            
                            <div class="content mt-3">
                                <h5 class="text-dark">{{auth()->user()->name}}</h5>
                                <p class="text-muted">خوش آمدید</p>
                                
                                <!-- دکمه امتیاز حذف شد چون متد آن در مدل وجود ندارد -->
                            </div>
                        </div>
                    </div><!--end col-->

                </div><!--end row-->
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div>
@endsection
