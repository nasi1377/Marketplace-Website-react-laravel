@extends('layouts.desktop')
@section('title', 'رسید خرید')
@section('body')
    <div class="border-bottom">
        <div class="row">
            <div class="col-md-12">

                <div class="rounded shadow">
                    <div class="text-center" style="background-color: #f1f1f1">
                        <h4 style="padding-top: 10px; color: #555">رسید خرید</h2>
                            <hr style="background-color: silver">
                    </div>
                    <div class="row" style="padding-bottom: 20px">
                        <div class="col-lg-12 col-md-4">
                            <div style="padding: 0 15px">
                                <div class="row">
                                    <div class="col-6">
                                        {!! $order->displayType() !!}
                                    </div>
                                    <div class="col-6">
                                        {!! $order->displayStatus() !!}
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-6">
                                        محصول : {{ $product->title }}
                                    </div>
                                    <div class="col-6">
                                         رنگ محصول: {{ $order->color }}  
                                        <hr>
                                        سایز محصول: {{ $order->size }}  

                                        <hr>

                                        تعداد محصول: {{ $order->count }}  

                                        <hr>


                                        قیمت  هر عدد: {{ number_format($product->price) }} تومان

                                        <hr>
                                        هزینه محصول: {{ number_format( $order->count * $order->price) }}
                                        تومان

                                        <hr>

                                        @if ($order->type == 'SINGLE')
                                            هزینه ارسال: {{ number_format(  ($order->weight * $order->count * 3000)  + (int) setting('site.sendprice')) }} تومان
                                        @else
                                             هزینه ارسال: {{ number_format(  ( ($order->weight * $order->count * 3000 ) + (  (int) setting('site.sendprice'))) / 1) }} تومان
                                        @endif



                                        

                                        <hr>

                                        قابل پرداخت:
                                        {{ number_format(($order->weight * $order->count * $order->price) + (  ( ($order->weight * $order->count * 3000 )  + ( (int) setting('site.sendprice') ) ) / ($order->type == 'SINGLE' ? 1 : 1) ) ) }}
                                        تومان
                                    </div>
                                </div>

                                @if ($order->type == 'MAJOR')
                                    <hr>
                                    <div class="alert alert-info">
                                        <strong> نصف هزینه ی ارسال بر عهده ی شرکت میباشد</strong><br>
                                    </div>

                                    <div class="alert alert-danger">
                                        <strong> نکته : پاداش نقدی از این خرید پس از پرداخت مستقیم وارد کیف پول خریدار
                                            میگردد.
                                        </strong><br>
                                    </div>
                                @endif



                                <hr>

                                @if ($order->status == 'PENDING')
                                    <form method="POST"
                                        action="{{ route('desktop.GotoPayment', ['order_id' => $order->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf


                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="submit" id="submit" class="btn btn-primary">پرداخت
                                                </button>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->

                                    </form>
                                    <!--end form-->
                                @endif


                                @if ($order->status == 'REFERRED')
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <div class="alert alert-danger">
                                                <strong>پیام سیستم : </strong>
                                                <br>
                                                <span>

                                                    درخواست ارجاع محصول مدنظر با کد پیگیری"{{ $order->id + 1000 }}" تایید شد
                                                    شما میتوانید طی یک هفته آتی باقی مانده محصول را به ادرس استان
                                                    گیلان_شهرستان تالش _ شهر اسالم _شرکت شالی گسترعطرآگین با کد پستی
                                                    4389177167
                                                    شماره تماس
                                                    09114564260.
                                                    09226482686
                                                    پس از دریافت محصول تمام هزینه به حساب شما منظور میگردد. اعتبار ما اعتماد
                                                    شماست...


                                                </span>
                                            </div>

                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                @endif


                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <style>
        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }

        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        .badge-primary {
            color: #fff;
            background-color: #007bff;
        }
    </style>
@endsection
