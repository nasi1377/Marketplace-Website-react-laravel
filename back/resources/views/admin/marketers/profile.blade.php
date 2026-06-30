<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل بازاریاب‌ها</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/city.js') }}"></script>

    <!-- فونت زیبای فارسی -->
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- لینک FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f9f9f9;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 20px 20px 0 0;
        }

        .list-group-item {
            padding: 15px;
        }

        .icon {
            margin-left: 10px;
        }
    </style>
</head>

<body>




    <div class="container-fluid">
        <div class="row">
            <!-- سایدبار -->
            <div class="col-md-3">
                @include('admin.partials.sidebar')
            </div>

            <!-- محتوای اصلی -->
            <div class="col-md-9">
                <div class="container mt-4">
                    <div class="card p-4">
                        <h1 class="mb-4 text-center">پنل بازاریاب‌ها</h1>
                        <hr>
                        <div class="container">
                            <h2 class="text-center mb-4">پروفایل بازاریاب</h2>
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white text-center">
                                    <p><strong>نام و نام خانوادگی:</strong> {{ $marketer->name }}</p>
                                    <p><i class="fas fa-user-tag fa-lg icon"></i><strong>نقش:</strong> {{ $marketer->getUserRoleById($marketer->id) }}</p>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-center mb-4 text-info">اطلاعات تکمیلی</h5>

                                    <div class="text-center">

                                        <div class="content mt-3">

                                            <div style="margin-top: 10px">
                                                <p class="btn btn-success">
                                                    <i class="fas fa-atom fa-lg icon"></i>
                                                    <small> امتیاز :</small>
                                                    {{ number_format($marketer->totalScore()) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <img id="avatar-pic" src="{{ url('storage', $marketer->avatar) }}" height="50px" width="50px"
                                                class="avatar float-md-left avatar-medium rounded-circle shadow me-md-4" alt="">
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-envelope fa-lg icon text-info"></i> <strong>ایمیل:</strong> {{ $marketer->email }}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-mobile-alt fa-lg icon text-success"></i> <strong>موبایل:</strong> {{ $marketer->mobile }}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-phone fa-lg icon text-success"></i> <strong>تلفن ثابت:</strong> {{ $marketer->extra('phone') }}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-map-marker-alt fa-lg icon text-danger"></i> <strong>استان:</strong> {{ $provinces[$marketer->prov_id] ?? 'نامشخص' }}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-map-marker-alt fa-lg icon text-danger"></i> <strong>شهر:</strong> {{ $cityName }}
                                        </li>
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-map-marker-alt fa-lg text-danger me-2"></i> <strong>آدرس دقیق:</strong> {{ $marketer->address }}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-calendar-alt fa-lg icon text-primary"></i> <strong>تاریخ عضویت:</strong> {{ $marketer->created_at->format('d-m-Y') }}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-key fa-lg icon text-warning"></i> <strong>کد معرف:</strong> {{ $marketer->getInviteCode() }}
                                        </li>
                                    </ul>
                                    <br>
                                    <h5 class="text-info">اطلاعات بازاریابی :</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="fas fa-id-card fa-lg icon text-secondary"></i> <strong>کد ملی:</strong> {{ $marketer->extra('nation_code')}}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-credit-card fa-lg icon text-secondary"></i> <strong>شماره کارت:</strong> {{ $marketer->extra('cart')}}
                                        </li>
                                        <li class="list-group-item">
                                            <i class="fas fa-money-check fa-lg icon text-secondary"></i> <strong>شبا:</strong> {{ $marketer->extra('sheba')}}
                                        </li>
                                    </ul>
                                </div>





                                <div class="widget">
                                    <div class="p-3 bg-secondary text-dark rounded shadow-sm">
                                        <h6 class="text-center mb-3 fw-bold">🔗 زیر مجموعه‌ها</h6>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div class="p-3 bg-white shadow-sm rounded">
                                                    <h5 class="mb-1 text-success fw-bold">{{ number_format($marketer->rightUsersCount()) }}</h5>
                                                    <p class="text-muted mb-0">📌 شاخه سمت راست</p>
                                                </div>
                                            </div>

                                            <div class="col-6 text-center">
                                                <div class="p-3 bg-white shadow-sm rounded">
                                                    <h5 class="mb-1 text-success fw-bold">{{ number_format($marketer->leftUsersCount()) }}</h5>
                                                    <p class="text-muted mb-0">📌 شاخه سمت چپ</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h5 class="text-info">ساختار زیرمجموعه ها:</h5>
                                        {!! $structure !!}
                                    </div>

                                </div>




                                <div class="card-footer text-center">
                                    <a href="{{ route('admin.marketers.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left fa-lg icon"></i> بازگشت به لیست بازاریاب‌ها
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- اسکریپت‌های جاوا اسکریپت -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>