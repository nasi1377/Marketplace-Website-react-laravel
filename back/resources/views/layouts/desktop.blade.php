@extends('layouts.basic')

@section('header-links')
    <div class="header-links row">

        <div class="col-lg-2  col-md-4 col-sm-4 col-4">

            <a href="{{ route('desktop.orders') }}" class=" star">

            </a>


        </div>

        <div class="col-lg-2  col-md-4 col-sm-4 col-4">
            <a href="{{ route('desktop.relationship') }}" class="star">

            </a>
        </div>

        <div class="col-lg-2  col-md-4 col-sm-4 col-4">

            <a href="{{ route('desktop.relationship') }}" class=" star">

            </a>
        </div>

        <div class="col-lg-2  col-md-4 col-sm-4 col-4">
            <a href="{{ route('desktop.wallet') }}" class="star ">

            </a>
        </div>

        <div class="col-lg-2  col-md-4 col-sm-4 col-4">

            <a href="{{ route('desktop.return') }}" class="star ">

            </a>
        </div>

        <div class="col-lg-2  col-md-4 col-sm-4 col-4">
            <a href="{{ route('desktop.profile') }}" class="star ">

            </a>
        </div>




    </div>

    <style>
        .header-links div:nth-child(1) .star {
            background-image: url("/assets/images/star-01-1.png") !important;
        }

        .header-links div:nth-child(2) .star {
            background-image: url("/assets/images/star-01-2.png") !important;
        }

        .header-links div:nth-child(3) .star {
            background-image: url("/assets/images/star-01-3.png") !important;
        }

        .header-links div:nth-child(4) .star {
            background-image: url("/assets/images/star-01-4.png") !important;
        }

        .header-links div:nth-child(5) .star {
            background-image: url("/assets/images/star-01-5.png") !important;
        }

        .header-links div:nth-child(6) .star {
            background-image: url("/assets/images/star-01-6.png") !important;
        }
    </style>
@endsection
@section('content')
    <!-- Hero Start -->
    <section class="bg-profile d-table w-100 bg-primary"
        style="background: url('{{ asset('assets/images/account/bg.png') }}') center center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card public-profile border-0 rounded shadow" style="z-index: 1;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-md-3 text-md-start text-center">
                                    <img src="{{ url('storage', auth()->user()->avatar) }}"
                                        class="avatar avatar-large rounded-circle shadow d-block mx-auto" alt="">
                                </div>
                                <!--end col-->

                                <div class="col-lg-10 col-md-9">
                                    <div class="row align-items-end">
                                        <div class="col-md-7 text-md-start text-center mt-4 mt-sm-0">
                                            <h3 class="title mb-0">{{ auth()->user()->name }}</h3>
                                            <small class="text-muted h6 me-2">
                                                <strong>سمت: </strong> {{ auth()->user()->levelDisplay(true) }}<br>
                                                <strong>وظیفه: </strong> <span>{{ auth()->user()->levelDisplay() }}</span>
                                            </small>

                                            <ul class="list-inline mb-0 mt-3">
                                            
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)" class="text-muted" title="کد ملی">
                                                        <small style="font-weight: bold; color:silver">کدملی :</small>
                                                        <code
                                                            style="unicode-bidi: normal">{{ auth()->user()->extra('nation_code') ?? 'ثبت نشده' }}</code>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--end col-->
                                        <div class="col text-md-end">
                                            <span
                                                style="background-color: #f1f1f1; color:666; border:1px solid silver !important; border-radius:5px; padding: 2px 5px;">{{ jdate(time())->format('Y/m/d ساعت h:i:s') }}</span>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--ed container-->
    </section>
    <!--end section-->
    <!-- Hero End -->

    <!-- Profile Start -->
    <section class="section">
        <div class="container mt-lg-3">
            <div class="row">
                <div class="col-lg-12 col-12 d-lg-block d-none">
                    <div class="sidebar sticky-bar p-4 rounded shadow">



                        </div>


                        <div class="widget mt-4 pt-2">
                            <h5 class="widget-title">دنبال کردن ما :</h5>
                            <ul class="list-unstyled social-icon mb-0 mt-4">
                                <li class="list-inline-item"><a href="{{ setting('social.facebook') }}" class="rounded"><i
                                            data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="{{ setting('social.instagram') }}"
                                        class="rounded"><i data-feather="instagram"
                                            class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a href="{{ setting('social.twitter') }}"
                                        class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a>
                                </li>
                                <li class="list-inline-item"><a href="{{ setting('social.linkedin') }}"
                                        class="rounded"><i data-feather="linkedin"
                                            class="fea icon-sm fea-social"></i></a></li>
                            </ul>
                            <!--end icon-->
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-lg-12 col-12">
                    @yield('body')
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!--end section-->
    <!-- تنظیمات پروفایل End -->

    <div id="showUserDetail" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-right">
                        <img style="float: right; margin-left:10px"
                            src="http://gilna.test/storage/users%2FJanuary2022%2FHgaFdWHGMNnYnAxR2d8Z.jpg"
                            class="avatar avatar-medium shadow-lg rounded-pill" alt="پوریا کرمی">
                        <br>
                        <h4>پوریا کرمی</h4>

                        <small>
                            <strong>وضعیت : </strong> <span style="color: rgb(17 189 17)">فعال</span>
                        </small>
                    </div>
                    <div style="width: 100%; margin-top:35px">
                        <hr>
                        <strong>آخرین پیام ها:</strong>
                        <div class="box-message">
                            <ul id="list">
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="">متن پیام</label>
                            <input id="msg_text" type="text" class="form-control" placeholder="متن پیام">
                        </div>

                        <div class="form-group" style="margin-top: 5px">
                            <button onclick="send_msg()" class="btn btn-primary">ارسال پیام</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <style>
        .tree-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .tree-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 100%;
            max-width: 500px;
        }

        .tree-title {
            text-align: center;
            color: #333;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
        }

        .tree-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, #4e73df, #4e73df);
        }

        .tree-structure {
            position: relative;
        }

        .tree-root {
            justify-content: center;
            margin-bottom: 40px;
        }

        .tree-node {
            /* background: #f8f9fc; */
            border-radius: 8px;
            padding: 15px 25px;
            text-align: center;
            /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); */
            /* border: 1px solid #e3e6f0; */
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .node-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 10px;
            border: 3px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .node-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4e73df;
            margin-bottom: 5px;
        }

        .tree-branches {
            position: relative;
        }

        .branch-line {
            width: 3px;
            height: 40px;
            background: linear-gradient(to bottom, #2d2d30, transparent);
            margin-bottom: 15px;
            top: -20px;
        }

        .right-branch .node-value {
            color: #4e73df;
        }

        .left-branch .node-value {
            color: #4e73df;
        }

        .node-label {
            color: #5a5c69;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .node-label i {
            margin: 0 5px;
        }

        .right-branch .node-label i {
            color: #4e73df;
        }

        .left-branch .node-label i {
            color: #4e73df;
        }

        /* تغییرات برای موبایل */
        @media (max-width: 768px) {
            .tree-branches {
                display: flex;
                flex-wrap: wrap;
            }

            .tree-branch {
                width: 50%;
                margin-bottom: 20px;
                padding: 0 10px;
            }

            .branch-line {
                height: 40px;
            }

            .node-avatar {
                width: 50px;
                height: 50px;
            }
        }




        .box-message {
            width: 100%;
            height: 350px;
            border-radius: 5px;
            background-color: #f1f1f1;
            border: 1px solid silver;
            margin: 10px auto
        }

        #showUserDetail {
            text-align: right;
            direction: rtl
        }

        .box-message ul {
            overflow-y: scroll;
            height: inherit;
            list-style-type: none;
        }

        .speech-bubble {
            position: relative;
            background: #d9d9d9;
            border-radius: .4em;
            padding: 15px;
            margin: 17px;
        }

        .speech-bubble.other {

            background: #96eea4;

        }

        .speech-bubble span {
            font-size: 12px;
            color: #9b9b9b;
        }



        .speech-bubble:after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 0;
            height: 0;
            border: 33px solid transparent;
            border-left-color: #d9d9d9;
            border-right: 0;
            border-bottom: 0;
            margin-top: -16.5px;
            margin-right: -33px;
        }


        .speech-bubble.other:after {
            border-left-color: #96eea4;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        var user_id = null;

        function openUserDetail(event) {
            var img = event.getAttribute('data-image'),
                name = event.getAttribute('data-name');
            user_id = event.getAttribute('data-id');

            $('#showUserDetail img').attr('src', img);
            $('#showUserDetail h4').html(name);
            $('#showUserDetail').modal('show');

            load_msg();
            read_msg();

            var cc = setInterval(function() {
                load_msg();
            }, 5000);

        }

        $('#showUserDetail .close').modal('close')



        function send_msg() {


            var msg = document.getElementById('msg_text').value;

            if (msg.length > 1) {
                $.ajax({
                        method: "POST",
                        url: "/desktop/sendMsg",
                        data: {
                            user_id: user_id,
                            msg: msg
                        }
                    })
                    .done(function(msg) {
                        document.getElementById('msg_text').value = "";

                        load_msg();
                    });
            }



        }

        function read_msg() {

            $.ajax({
                method: "POST",
                url: "/desktop/ReadMsgByUser",
                data: {
                    user_id: user_id,
                }
            });
        }

        function load_msg() {


            $.ajax({
                    method: "POST",
                    url: "/desktop/LoadMsgByUser",
                    data: {
                        user_id: user_id,
                    }
                })
                .done(function(data) {

                    $(".box-message #list").html("");

                    data.forEach(item => {
                        var p = "";
                        var h = "";
                        var m = "";
                        var s = "";

                        if (item.created_at != null) {

                            var d = new Date(item.created_at);
                            h = d.getHours();
                            m = d.getMinutes();
                            s = d.getSeconds();
                            p = d.toLocaleDateString('fa-IR');
                        }


                        $(".box-message #list").append("<li><div class='speech-bubble " + ((item.author_id !=
                                user_id) ? "me" : "other") + "'><p>" + item.message +
                            "</p><span>" + h + ":" + m + ":" + s + " " + p + "</span></div></li>");
                    });


                    setTimeout(function() {

                        let scroll_to_bottom = document.getElementById('list');
                        scroll_to_bottom.scrollTop = scroll_to_bottom.scrollHeight;

                    }, 500);



                });
        }
    </script>
@endsection
