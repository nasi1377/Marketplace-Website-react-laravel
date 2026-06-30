@extends('layouts.desktop')
@section('title', 'سفارشات من')
@section('body')
    <div class="border-bottom">
        <div class="row">
            <div class="col-md-12">

                <div class="rounded shadow">
                    <div class="text-center" style="background-color: #f1f1f1">
                        <h4 style="padding-top: 10px; color: #555">سفارشات من</h2>
                            <hr style="background-color: silver">
''                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <div style="padding:15px 15px 0 15px">
                                <div class="alert alert-info">
                                    <strong>پیام سیستم:</strong><br>
                                    <span>سفارش ها فعالی و در حال اجرا را میتوانید ببنید.</span><br>
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
                            </div>
                        </div>
                    </div>

                    <!--end row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 10%" class="text-center">ردیف</th>
                                            <th style="width: 50%" class="text-center">محصول</th>
                                            <th style="width: 15%" class="text-center">مبلغ سفارش</th>
                                            <th style="width: 10%" class="text-center">وضعیت</th>
                                            <th style="width: 15%" class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td style="width: 10%" class="text-center">{{ $loop->iteration }}</td>
                                                <td style="width: 50%" class="text-center">{!! $order->displayProduct() !!}</td>
                                                <td style="width: 15%" class="text-center">
                                                    {{ number_format($order->price * $order->weight * $order->count) }} 
                                                    <small class="text-muted">تومان</small>
                                                </td>
                                                <td style="width: 10%" class="text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {!! $order->displayStatus() !!}
                                                </td>
                                                <td style="width: 15%" class="text-center">
                                                    <a class="btn btn-sm btn-success" href="/desktop/invoice/{{ $order->id }}">
                                                        <i class="fas fa-receipt"></i> رسید
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if (!count($orders))
                                    <div class="alert alert-warning text-center">
                                        <strong>سفارشی در سیستم ثبت نشده است.</strong>
                                    </div>
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
