<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پنل مدیریت بازاریابان - هدیه‌ها</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #343a40;
            color: white;
            font-weight: 500;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
            font-weight: 500;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .status-badge {
            min-width: 80px;
            display: inline-block;
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
            <div class="col-md-9 py-4">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-white border-bottom-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">مدیریت هدیه‌های بازاریابان</h4>
                            
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">بازاریاب</th>
                                            <th width="20%">عنوان هدیه</th>
                                            <th width="15%">مقدار</th>
                                            <th width="15%">تاریخ ارسال</th>
                                            <th width="10%">وضعیت</th>
                                            <th width="15%">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($gifts as $gift)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $gift->user->name ?? 'نامشخص' }}</td>
                                            <td>{{ $gift->title }}</td>
                                            <td>{{ number_format($gift->value) }} تومان</td>
                                            <td>{{ jdate($gift->created_at)->format('Y/m/d H:i') }}</td>
                                            <td>
                                                @if($gift->status == 1)
                                                    <span class="badge bg-success status-badge">فعال</span>
                                                @else
                                                    <span class="badge bg-warning text-dark status-badge">غیرفعال</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                  
                                                    <form action="{{ route('admin.marketers.gifts.delete', $gift->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('آیا از حذف این هدیه مطمئن هستید؟')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">هیچ هدیه‌ای ثبت نشده است</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($gifts->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $gifts->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // نمایش پیام‌های حذف با SweetAlert
            $('form[method="DELETE"]').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: "این عمل قابل بازگشت نیست!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'انصراف'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>