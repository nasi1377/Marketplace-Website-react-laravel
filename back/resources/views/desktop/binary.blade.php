<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>نمایش ریز زیر مجموعه ها</title>
</head>
<style>
    .container {
        display: flex;
        justify-content: center;
    }
    .tree ul {
        padding-top: 20px; position: relative;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li::before, .tree li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 1px solid #ccc;
        width: 50%; height: 20px;
    }
    .tree li::after{
        right: auto; left: 50%;
        border-left: 1px solid #ccc;
    }

    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }

    .tree li:only-child{ padding-top: 0;}

    .tree li:first-child::before, .tree li:last-child::after{
        border: 0 none;
    }
    .tree li:last-child::before{
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }
    .tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 1px solid #ccc;
        width: 0; height: 20px;
    }
    .tree li div{
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }
    .tree li div:hover, .tree li div:hover+ul li div {
        background: #c8e4f8; color: #6F4E37 ; border: 1px solid #94a0b4;
    }
    .tree li div:hover+ul li::after,
    .tree li div:hover+ul li::before,
    .tree li div:hover+ul::before,
    .tree li div:hover+ul ul::before{
        border-color:  #94a0b4;
    }
</style>
<body>
    <div class="container">
        <h3>لیست تمام زیر مجموعه ها</h3>
    </div>
    <div class="container">
        <button onclick="history.go(-1);"
            style="text-decoration: none; cursor: pointer; padding: 5px 10px; border: 1px solid silver; background-color: #f1f1f1; float: left; height: 30px;display: flex; justify-content: center; align-items: center"
            >برگشت</button>
        <div class="tree">
            <ul>
                <li>
                    @php
                        $main_user_id = $user_id;
                        $main_user = \App\Models\User::whereId($main_user_id)->firstOrFail();
                        @endphp
                    <div>
                        <img src="{{url('storage', $main_user->avatar)}}" style="width: 110px; height: 110px" alt="{{$main_user->name}}">
                        <hr>
                        <b><a href="{{route('desktop.binary.show', ['USER_ID' => $main_user->id])}}">{{$main_user->name}}</a> </b><small>(0 امتیاز)</small>
                    </div>
                    <ul>
                        <li>
                            @if($main_user->left_user_id)
                                @php
                                    $sub_user_1 = \App\Models\User::whereId($main_user->left_user_id)->first();
                                @endphp
                                <div>
                                    <img src="{{url('storage', $sub_user_1->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_1->name}}">
                                    <hr>
                                    <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_1->id])}}">{{$sub_user_1->name}} </a></b><small>({{$sub_user_1->getPoint()}} امتیاز)</small>
                                </div>
                            <ul>
                                <li>
                                    @if($sub_user_1->left_user_id)
                                        @php
                                            $sub_user_2 = \App\Models\User::whereId($sub_user_1->left_user_id)->first();
                                        @endphp
                                        <div>
                                            <img src="{{url('storage', $sub_user_2->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_2->name}}">
                                            <hr>
                                            <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_2->id])}}">{{$sub_user_2->name}} </a></b><small>({{$sub_user_2->getPoint()}} امتیاز)</small>
                                        </div>
                                    <ul>
                                        <li>
                                            @if($sub_user_2->left_user_id)
                                                @php
                                                    $sub_user_3 = \App\Models\User::whereId($sub_user_2->left_user_id)->first();
                                                @endphp
                                                <div>
                                                    <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                    <hr>
                                                    <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_3->id])}}">{{$sub_user_3->name}}</a> </b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                </div>
                                            @endif

                                        </li>
                                        <li>
                                            @if($sub_user_2->right_user_id)
                                                @php
                                                    $sub_user_3 = \App\Models\User::whereId($sub_user_2->right_user_id)->first();
                                                @endphp
                                                <div>
                                                    <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                    <hr>
                                                    <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_3->id])}}">{{$sub_user_3->name}} </a></b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                    @endif
                                </li>
                                <li>
                                    @if($sub_user_1->left_user_id)
                                        @php
                                            $sub_user_2 = \App\Models\User::whereId($sub_user_1->left_user_id)->first();
                                        @endphp
                                        <div>
                                            <img src="{{url('storage', $sub_user_2->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_2->name}}">
                                            <hr>
                                            <b>{{$sub_user_2->name}} </b><small>({{$sub_user_2->getPoint()}} امتیاز)</small>
                                        </div>
                                        <ul>
                                            <li>
                                                @if($sub_user_2->left_user_id)
                                                    @php
                                                        $sub_user_3 = \App\Models\User::whereId($sub_user_2->left_user_id)->first();
                                                    @endphp
                                                    <div>
                                                        <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                        <hr>
                                                        <b>{{$sub_user_3->name}} </b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                    </div>
                                                @endif

                                            </li>
                                            <li>
                                                @if($sub_user_2->right_user_id)
                                                    @php
                                                        $sub_user_3 = \App\Models\User::whereId($sub_user_2->right_user_id)->first();
                                                    @endphp
                                                    <div>
                                                        <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                        <hr>
                                                        <b>{{$sub_user_3->name}} </b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            </ul>
                            @endif
                        </li>
                        <li>
                            @if($main_user->right_user_id)
                                @php
                                    $sub_user_1 = \App\Models\User::whereId($main_user->right_user_id)->first();
                                @endphp
                            <div>
                                <img src="{{url('storage', $sub_user_1->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_1->name}}">
                                <hr>
                                <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_1->id])}}">{{$sub_user_1->name}}</a> </b><small>({{$sub_user_1->getPoint()}} امتیاز)</small>
                            </div>
                            <ul>
                                <li>
                                    @if($sub_user_1->left_user_id)
                                        @php
                                            $sub_user_2 = \App\Models\User::whereId($sub_user_1->left_user_id)->first();
                                        @endphp
                                        <div>
                                            <img src="{{url('storage', $sub_user_2->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_2->name}}">
                                            <hr>
                                            <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_2->id])}}">{{$sub_user_2->name}} </a></b><small>({{$sub_user_2->getPoint()}} امتیاز)</small>
                                        </div>
                                        <ul>
                                            <li>
                                                @if($sub_user_2->left_user_id)
                                                    @php
                                                        $sub_user_3 = \App\Models\User::whereId($sub_user_2->left_user_id)->first();
                                                    @endphp
                                                <div>
                                                    <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                    <hr>
                                                    <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_3->id])}}">{{$sub_user_3->name}}</a> </b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                </div>
                                                @endif
                                            </li>
                                            <li>
                                                @if($sub_user_2->right_user_id)
                                                    @php
                                                        $sub_user_3 = \App\Models\User::whereId($sub_user_2->right_user_id)->first();
                                                    @endphp
                                                    <div>
                                                        <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                        <hr>
                                                        <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_3->id])}}">{{$sub_user_3->name}} </a></b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                                <li>
                                    @if($sub_user_1->right_user_id)
                                        @php
                                            $sub_user_2 = \App\Models\User::whereId($sub_user_1->right_user_id)->first();
                                        @endphp
                                        <div>
                                            <img src="{{url('storage', $sub_user_2->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_2->name}}">
                                            <hr>
                                            <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_2->id])}}">{{$sub_user_2->name}} </a></b><small>({{$sub_user_2->getPoint()}} امتیاز)</small>
                                        </div>
                                        <ul>
                                            <li>
                                                @if($sub_user_2->left_user_id)
                                                    @php
                                                        $sub_user_3 = \App\Models\User::whereId($sub_user_2->left_user_id)->first();
                                                    @endphp
                                                    <div>
                                                        <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                        <hr>
                                                        <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_3->id])}}">{{$sub_user_3->name}} </a></b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                    </div>
                                                @endif
                                            </li>
                                            <li>
                                                @if($sub_user_2->right_user_id)
                                                    @php
                                                        $sub_user_3 = \App\Models\User::whereId($sub_user_2->right_user_id)->first();
                                                    @endphp
                                                    <div>
                                                        <img src="{{url('storage', $sub_user_3->avatar)}}" style="width: 110px; height: 110px" alt="{{$sub_user_3->name}}">
                                                        <hr>
                                                        <b><a href="{{route('desktop.binary.show', ['USER_ID' => $sub_user_3->id])}}">{{$sub_user_3->name}} </a></b><small>({{$sub_user_3->getPoint()}} امتیاز)</small>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            </ul>
                            @endif
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</body>
</html>
