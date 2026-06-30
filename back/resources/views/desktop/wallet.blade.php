@extends('layouts.desktop')
@section('title', 'کیف پول من')
@section('body')
    <div class="rounded shadow">
        <div class="text-center" style="background-color: #f1f1f1">
            <h4 style="padding-top: 10px; color: #555">کیف پول من</h4>
            <hr style="background-color: silver">
        </div>

        <div class="row p-4" style="padding-top: 0 !important">


            <hr>
            <div class="col-md-12 mb-4">
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

            </div>




            <h5>هدیه های جدید من:</h5>
            @forelse ($gifts as $gift)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card" style="background-color: #bbab68">
                        <div class="card-body">
                            <h4 class="card-title">{{ $gift->title }}</h4>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $gift->created_at->diffForHumans() }}</h6>
                            <p class="card-text">{{ $gift->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>شما هیچ امتیازی دریافت نکرده‌اید.</p>
            @endforelse



            <hr>




            <div class="col-md-12">
                <div>
                    <div>
                        <strong>موجودی ریالی : </strong>
                        <span style="font-size: 20px">{{ number_format($totalScore) }} <small
                                style="color:silver">(ریال)</small></span>
                        <br>
                        <strong>موجودی برنج : </strong>
                        <span style="font-size: 20px">{{ number_format($totalRice) }} <small
                                style="color:silver">(کیلوگرم)</small></span>
                        @if (auth()->user()->rice_credit)
                            <p
                                style="color: orange; margin-top: 10px; font-size: 12px; background-color: #ffeacb; padding: 5px 10px">
                                موجودی برنج شما در حال پردازش برای ارسال است.</p>
                        @endif
                        @foreach ($transactions as $transaction)
                            @if ($transaction->type == 2)
                                <div class="transaction-item">
                                    <p>مقدار برنج: {{ $transaction->rice_amount }} کیلوگرم</p>
                                    <p>نوع برنج: {{ $transaction->riceProduct->title ?? 'نامشخص' }}</p>
                                    <p>تاریخ: {{ jdate($transaction->created_at)->format('Y/m/d H:i') }}</p>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                    </div>


                    <form method="POST" action="{{ route('desktop.send.request') }}">
                        @csrf
                        <label for="">درخواست تسویه</label>
                        <div class="">
                            <div class="input-group">
                                <input name="credit" id="email" type="number" class="form-control"
                                    placeholder="مبلغ هدیه شما :" required="">
                                <div class="input-group-append">
                                    <button class="btn btn-primary submitBnt" type="submit" id="paypalmail">ارسال
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form><!--end form-->


                    


                  

                    <hr>
                    <form method="POST" action="{{ route('desktop.charge.credit') }}">
                        @csrf
                        <label for="">افزایش موجودی ریالی</label>
                        <div class="mt-4 mb-0">
                            <div class="input-group">
                                <input name="credit" id="email" type="number" class="form-control"
                                    placeholder="مبلغ هدیه شما :" required="">
                                <div class="input-group-append">
                                    <button class="btn btn-primary submitBnt" type="submit" id="paypalmail">پرداخت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form><!--end form-->



                </div>
            </div>





            <div class="col-md-12 ">
                <a href="javascript:void(0)">
                    <div class="card rounded shadow bg-warning border-0 text-center" style="margin-bottom: 10px">
                        <div class="card-body">

                            <div class="mt-4">
                                <h5 class="text-light" style="direction: ltr">{{ auth()->user()->balanced_scores() }}
                                    <small style="color: silver">(Score)</small>
                                </h5>
                                <div class="text-light">
                                    <p class="h6 mb-0" style="color: #f8f9fc">امتیاز به تعادل رسیده</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><!--end col-->


            <div class="col-md-4">

                <div class="card rounded shadow bg-dark border-0 text-center">
                    <div class="card-body">

                        <div>
                            <h5 class="text-light" style="direction: ltr">
                                {{ number_format(auth()->user()->righScoreReduced()) }} <small
                                    style="color: silver">(Score)</small></h5>
                            <div>
                                <p class="h6 text-muted mb-0">امتیاز شاخه راست</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--end col-->

            <div class="col-md-4">

                <div class="card rounded shadow bg-dark border-0 text-center">
                    <div class="card-body">

                        <div>
                            <h5 class="text-light" style="direction: ltr">
                                {{ number_format(auth()->user()->leftScoreReduced()) }} <small
                                    style="color: silver">(Score)</small></h5>
                            <div>
                                <p class="h6 text-muted mb-0">امتیاز شاخه چپ</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--end col-->

            <div class="col-md-4">

                <div class="card rounded shadow bg-dark border-0 text-center">
                    <div class="card-body">

                        <div>
                            <h5 class="text-light" style="direction: ltr">
                                {{ number_format(auth()->user()->totalScoreReduced()) }} <small
                                    style="color: silver">(Score)</small></h5>
                            <div>
                                <p class="h6 mb-0" style="color: #f8f9fc">کل امتیازات</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--end col-->





            <div class="col-md-12">
                <div class="card rounded shadow bg-light border-0">
                    <div class="p-4 row">
                        <div class="col-md-6">
                            <strong style="position: relative; top:10px">تبدیل امیتاز به موجودی ریالی</strong>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('desktop.score.to.credit') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary"
                                    style="margin-top: 23px;;float: left">تبدیل امتیاز به پاداش ریالی</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card rounded shadow bg-light border-0" style="margin-top: 10px">
                    <div class="p-4 row">

                        <div class="col-md-6">
                            <strong style="position: relative; top:10px">تبدیل امیتاز به برنج</strong>
                        </div>

                        <div class="col-md-6">
                            <form method="POST" action="{{ route('desktop.score.to.rice') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="rice_product">انتخاب نوع برنج:</label>
                                    <select name="rice_product" id="rice_product" class="form-control" required>
                                        @foreach ($riceProducts as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->title }} - قیمت هر کیلو : {{ $product->price }}
                                                (موجودی در انبار : {{ $product->stock }} کیلوگرم)
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mt-2">
                                    <strong>امتیاز قابل تبدیل:
                                        {{ number_format($currentTransaction->value ?? 0) }}</strong>
                                </div>
                                <button type="submit" class="btn btn-primary"
                                    style="margin-top: 23px; float: left">تبدیل موجودی ریالی به برنج</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-12 ">

                <table class="table table-bordered table-responsive ">
                    <thead>
                        <tr>
                            <th style="width: 60px" class="text-center">کد</th>
                            <th style="width: 250px">امتیاز تعادل</th>
                            <th class="text-center">امتیاز راست</th>
                            <th class="text-center">امتیاز چپ</th>
                            <th class="text-center">مقدار اعتبار به ریال</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="text-center"><code
                                        style="unicode-bidi: normal">{{ $transaction->id + 4786 }}</code></td>
                                <td class="text-center">{{ number_format($transaction->total_score) }} </td>
                                <td class="text-center">{{ number_format($transaction->right_score) }} </td>
                                <td class="text-center">{{ number_format($transaction->left_score) }} </td>
                                <td class="text-center">{{ number_format($transaction->value) }} <small
                                        style="color: silver">(ریال)</small></td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="col-md-12 rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">جعبه هدیه و پاداش ها</h2>
                        <hr style="background-color: silver">
                </div>
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-lg-12 col-md-4">
                        <div style="padding: 0 15px">
                            <div class="alert alert-info">
                                <strong>پیام سیستم:</strong><br>
                                <span>فعلا پاداشی به سیستم اضافه نشده است.</span><br>
                                <span>پاداش های مختلف را باید کارفرما تعریف کند.</span>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div>

        </div>
    </div>
@endsection
