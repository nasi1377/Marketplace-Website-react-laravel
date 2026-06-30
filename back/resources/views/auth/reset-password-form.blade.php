@extends('layouts.auth')
@section('title', 'تغییر کلمه عبور')
@section('content')
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
                            <h4 class="card-title text-center">تغییر کلمه عبور</h4>
                            <form class="login-form mt-4" method="POST" action="{{ route('reset-password-action') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if (session()->has('auth_error'))
                                            <div class="alert alert-danger">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{{ session('auth_error') }}</span>
                                            </div>
                                        @endif
                                        @if (session()->has('auth_success'))
                                            <div class="alert alert-success">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>{{ session('auth_success') }}</span>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label">شماره موبایل <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <input id="mobile" type="text" class="form-control ps-5"
                                                    placeholder="موبایل" value="{{ old('mobile', session('mobile')) }}"
                                                    name="mobile" readonly>
                                            </div>
                                        </div>
                                        {{-- اضافه کردن فیلد کد تایید --}}
                                        <div class="mb-3">
                                            <label class="form-label">کد تایید <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <input type="text" class="form-control" name="code"
                                                    placeholder="کد تایید" required>
                                            </div>
                                            @error('code')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('code') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                        {{-- پایان فیلد کد تایید --}}
                                        <div class="mb-3">
                                            <label class="form-label">پسورد جدید <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="پسورد جدید">
                                            </div>
                                            @error('password')
                                                <small>
                                                    <p style="color:red">{{ $errors->first('password') }}</p>
                                                </small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">تکرار پسورد جدید <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                    placeholder="تکرار پسورد جدید">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary">تغییر کلمه عبور</button>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="mb-0 mt-3"><small class="text-dark me-2">قبلاً حساب دارید؟</small> <a
                                                href="{{ route('login') }}" class="text-dark fw-bold">وارد شوید </a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
