@extends('layouts.desktop')
@section('title', 'اعضا کم فعالیت')
@section('body')
<div class="border-bottom">
    <div class="row">
        <div class="col-md-12">
            
            <div class="rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">اعضا کم فعالیت</h2>
                    <hr style="background-color: silver">
                </div>
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-lg-12 col-md-4">
                        <div style="padding: 0 15px">
                            <div class="alert alert-info">
                                <strong>پیام سیستم:</strong><br>
                                <span>لیست اعضای که هیچ یا یک زیرمجموعه ای برای خود تعریف نکرده اند.</span><br>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
                <div class="row" style="padding-bottom: 40px">
                    @foreach ($users as $user)
                        <div class="col-lg-3 col-md-4 mt-4 pt-2">
                            <div class="text-center">
                                <img src="{{url('storage', $user->avatar)}}" class="avatar avatar-medium shadow-lg rounded-pill" alt="{{$user->name}}">
                                <div class="content mt-3">
                                    <a href="javascript:void(0)" class="h5 text-dark">{{$user->name}}</a>
                                    <div style="margin-top: 10px">
                                        <a href="javascript:void(0)" class="btn btn-success">
                                            <i class="uil uil-atom"></i>
                                            <small> امتیاز :</small>
                                            {{$user->totalScore()}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div><!--end row-->
            </div>
        </div><!--end col-->   
    </div><!--end row-->
</div>
@endsection