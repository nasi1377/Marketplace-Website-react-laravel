@extends('layouts.desktop')
@section('title', 'عضوگیری')
@section('body')
    <div class="border-bottom">
        <div class="row">
            <div class="col-md-12">

                <div class="rounded shadow">

                    <div class="row" style="padding-bottom: 20px">
                        <div class="col-lg-12 col-md-4 mt-4 pt-2">
                            <hr style="background-color: silver">
                        </div>
                        <div class="col-lg-12 col-md-4 mt-4 pt-2">
                            <h5 class="text-center" style="color: #555;">عضوگیری </h5>
                        </div>



                        <div class="col-lg-12 col-md-4 mt-4 pt-2">

                            <div class="alert alert-info">
                                <strong>پیام سیستم:</strong><br>
                                <span> شما با استفاده از کد معرف و لینک های زیر میتوانید ما را به دوستان خود معرفی کنید از
                                    فروش ایجاد شده پاداش دریافت کنید برای آموزش های بیشتر به قسمت آموزش و رهبری مراجعه
                                    فرمایید </span>
                                <br>
                                <span> لینک ثبت نام با کد معرف شما
                                    "https://narnid.com/register?inv={{ auth()->user()->getInviteCode() }}" </span>
                            </div>


                            <div class="text-center" style="background-color: #f1f1f1">
                                <h4 style="padding-top: 10px; color: #555">ارتباط با سرگروه ها</h2>

                                    @foreach ($parents as $up)
                                        <div class="text-center">
                                            <img src="{{ url('storage', $up->avatar) }}"
                                                class="avatar avatar-medium shadow-lg rounded-pill"
                                                alt="{{ $up->name }}">
                                            <div class="content mt-3">



                                                <a href="javascript:void(0)" class="h5 text-dark">{{ $up->name }}</a>

                                                <div style="margin-top: 10px">
                                                    <a href="javascript:void(0)" onclick="openUserDetail(this)"
                                                        data-name="{{ $up->name }}" data-id="{{ $up->id }}"
                                                        data-image="{{ url('storage', $up->avatar) }}" class="btn btn-info">
                                                        <span
                                                            class="badge badge-danger">{{ $message->notify_msg($up->id) }}</span>
                                                        <i class="uil uil-chat"></i>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>

                            <hr>

                            <div class="text-center">
                                <img src="{{ url('storage', $user->avatar) }}"
                                    class="avatar avatar-medium shadow-lg rounded-pill" alt="{{ $user->name }}">
                                <div class="content mt-3">
                                    <a href="javascript:void(0)" class="h5 text-dark">{{ $user->name }}</a>
                                    <div style="margin-top: 10px">
                                        <a href="javascript:void(0)" class="btn btn-info">
                                            <i class="uil uil-atom"></i>
                                            <small> امتیاز :</small>
                                            {{ number_format($user->totalScore()) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->



                    </div>
                    <!--end row-->




                    <div class="text-center" style="background-color: #f1f1f1">
                        <h4 style="padding-top: 10px; color: #555">ارتباط با زیرمجموعه</h2>
                            @if ($back)
                                <span><a href="/desktop/relationship">برگشت به شاخه اصلی</a></span>
                            @endif
                            <hr style="background-color: silver">
                    </div>




                    <div id="canvas">
                        <ul class="tree" dir="ltr">

                            {!! $stracture !!}

                        </ul>

                    </div>

                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>

    <style>
        #canvas {
            width: 100%;
            height: auto;
            overflow-x: scroll;
            overflow-y: auto;
            cursor: grab;
        }

        .tree {
            transform: scale(-1, 1);
        }

        .tree,
        .tree ul,
        .tree li {
            list-style: none;
            margin: 0;
            padding: 7px;
            position: relative;
        }

        .tree {
            margin: 0 0 1em;
            text-align: center;
        }

        .tree,
        .tree ul {
            display: table;
        }

        .tree ul {
            display: inline-table;
            width: 100%;
        }

        .tree li {
            display: table-cell;
            padding: .5em 0;
            vertical-align: top;
        }

        /* _________ */
        .tree li:before {
            outline: solid 1px #666;
            content: "";
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
        }

        .tree li:first-child:before {
            left: 50%;
        }

        .tree li:last-child:before {
            right: 50%;
        }

        .tree code,
        .tree span {
            border: solid .1em #666;
            border-radius: .2em;
            display: inline-block;
            margin: 0 .2em .5em;
            padding: .2em .5em;
            position: relative;
        }

        /* If the tree represents DOM structure */
        .tree code {
            font-family: monaco, Consolas, 'Lucida Console', monospace;

            transform: scale(-1, 1);
        }

        /* | */
        .tree ul:before,
        .tree code:before,
        .tree span:before {
            outline: solid 1px #666;
            content: "";
            height: .5em;
            left: 50%;
            position: absolute;
        }

        .tree ul:before {
            top: -.5em;
        }

        .tree code:before,
        .tree span:before {
            top: -.55em;
        }

        /* The root node doesn't connect upwards */
        .tree>li {
            margin-top: 0;
        }

        .tree>li:before,
        .tree>li:after,
        .tree>li>code:before,
        .tree>li>span:before {
            outline: none;
        }

        code.blink {
            animation: blinkAnm 1s normal infinite ease-in-out;
        }

        @keyframes blinkAnm {
            0% {
                border-color: #330000;
            }

            50% {
                border-color: #7a0101;
            }

            100% {
                border-color: #f60000;
            }
        }
    </style>

    <script>
        const slider = document.getElementById('canvas');

        var zoom = 100;

        let mouseDown = false;
        let startX, scrollLeft;

        let startDragging = function(e) {
            mouseDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        };
        let stopDragging = function(event) {
            mouseDown = false;
        };

        slider.addEventListener('mousemove', (e) => {
            e.preventDefault();
            if (!mouseDown) {
                return;
            }
            const x = e.pageX - slider.offsetLeft;
            const scroll = x - startX;
            slider.scrollLeft = scrollLeft - scroll;
        });

        slider.addEventListener('wheel', (e) => {
            e.preventDefault();

            var sen = e.wheelDelta / 60;

            if (zoom + sen > 100) {
                return;
            }
            if (zoom + sen < 10) {
                return;
            }

            zoom = zoom + sen;

            slider.style.zoom = zoom + '%';

        });

        // slider.addEventListener('gestureend', function(e) {

        //     e.preventDefault();

        //     var sen = 0;

        //     if (e.scale < 1.0) {
        //         // User moved fingers closer together
        //         sen +=  e.scale ;
        //     } else if (e.scale > 1.0) {
        //         // User moved fingers further apart
        //         sen -=  e.scale;
        //     }

        //     zoom = zoom + sen;

        //     slider.style.zoom = zoom + '%';

        // }, false);

        // Add the event listeners
        slider.addEventListener('mousedown', startDragging, false);
        slider.addEventListener('mouseup', stopDragging, false);
        slider.addEventListener('mouseleave', stopDragging, false);
    </script>
    @if ($back)
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $('html, body').animate({
                scrollTop: $("#canvas").offset().top
            }, 1000);
        </script>
    @endif
@endsection
