<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title >پنل مدیریت بازاریابان</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

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

                        <div class="row mb-4 action-buttons">
                            <div class="col-md-3">
                                <button id="selectAllBtn" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-check-square"></i> انتخاب همه
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button id="deselectAllBtn" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times-circle"></i> لغو انتخاب
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button id="sendBulkSmsBtn" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#smsModal">
                                    <i class="fas fa-sms"></i> ارسال پیام
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button id="sendGiftBtn" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#giftModal">
                                    <i class="fas fa-truck"></i> ارسال رایگان
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button id="sendDiscountBtn" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#discountModal">
                                    <i class="fas fa-percentage"></i> کد تخفیف
                                </button>
                            </div>
                        </div>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50px">انتخاب</th>
                                        <th>نام</th>
                                        <th>چپ</th>
                                        <th>راست</th>
                                        <th>نقش</th>
                                        <th>وظیفه</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($marketers as $marketer)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="marketer-checkbox form-check-input" value="{{ $marketer->id }}">
                                            </td>
                                            <td>{{ $marketer->name }}</td>
                                            <td>{{ $marketer->left_users_count }}</td>
                                            <td>{{ $marketer->right_users_count }}</td>
                                            <td>{{ $marketer->level_name }}</td>
                                            <td>{{ $marketer->level_order }}</td>
                                            <td>
                                                <a href="{{ route('admin.marketers.profile', ['id' => $marketer->id]) }}" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-eye"></i> جزئیات
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ارسال پیامک -->
    <div class="modal fade" id="smsModal" tabindex="-1" aria-labelledby="smsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smsModalLabel">
                        <i class="fas fa-sms text-primary"></i> ارسال پیامک گروهی
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bulkSmsForm">
                        @csrf
                        <div class="mb-3">
                            <label for="messageText" class="form-label">متن پیامک</label>
                            <textarea class="form-control" id="messageText" rows="5" maxlength="500" required></textarea>
                            <div class="form-text">حداکثر 500 کاراکتر</div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirmSend">
                                <label class="form-check-label" for="confirmSend">
                                    تایید ارسال پیامک به <span id="selectedSmsCount" class="counter">0</span> بازاریاب
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> انصراف
                    </button>
                    <button type="button" id="confirmSendBtn" class="btn btn-primary" disabled>
                        <i class="fas fa-paper-plane"></i> ارسال پیامک
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ارسال رایگان -->
    <div class="modal fade" id="giftModal" tabindex="-1" aria-labelledby="giftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="giftModalLabel">
                        <i class="fas fa-truck text-success"></i> ارسال هدیه رایگان
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> با ارسال هدیه رایگان، بازاریابان انتخاب شده می‌توانند از ارسال رایگان برای خرید بعدی خود استفاده کنند.
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmGift">
                            <label class="form-check-label" for="confirmGift">
                                تایید ارسال هدیه به <span id="selectedGiftCount" class="counter">0</span> بازاریاب
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> انصراف
                    </button>
                    <button type="button" id="confirmGiftBtn" class="btn btn-success" disabled>
                        <i class="fas fa-gift"></i> ارسال هدیه
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    
    <div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="discountModalLabel">
                        <i class="fas fa-percentage text-warning"></i> ارسال کد تخفیف
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="discountForm">
                        @csrf
                        <div class="mb-3">
                            <label for="discountAmount" class="form-label">مبلغ تخفیف (تومان)</label>
                            <input type="number" class="form-control" id="discountAmount" required min="1" placeholder="به تومان وارد کنید">
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> هر کاربر می‌تواند چندین کد تخفیف دریافت کند.
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirmDiscount">
                                <label class="form-check-label" for="confirmDiscount">
                                    تایید ارسال تخفیف به <span id="selectedDiscountCount" class="counter">0</span> بازاریاب
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> انصراف
                    </button>
                    <button type="button" id="confirmDiscountBtn" class="btn btn-warning" disabled>
                        <i class="fas fa-percentage"></i> ارسال تخفیف
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal نمایش نتیجه -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel">
                        <i class="fas fa-clipboard-check text-primary"></i> نتیجه عملیات
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultModalBody">
                    <!-- محتوای نتیجه اینجا نمایش داده می‌شود -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        <i class="fas fa-check"></i> تایید
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{ $marketers->links() }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // انتخاب همه
            $('#selectAllBtn').click(function() {
                $('.marketer-checkbox').prop('checked', true);
                updateAllCounters();
            });

            // لغو انتخاب همه
            $('#deselectAllBtn').click(function() {
                $('.marketer-checkbox').prop('checked', false);
                updateAllCounters();
            });

            // به‌روزرسانی تمام شمارنده‌ها
            function updateAllCounters() {
                const count = $('.marketer-checkbox:checked').length;
                $('#selectedSmsCount, #selectedGiftCount, #selectedDiscountCount').text(count);
                updateButtonStates();
            }

            // رویداد تغییر چک‌باکس‌ها
            $(document).on('change', '.marketer-checkbox', function() {
                updateAllCounters();
            });

            // رویدادهای تغییر تایید
            $('#confirmSend, #confirmGift, #confirmDiscount').change(function() {
                updateButtonStates();
            });

            // به‌روزرسانی وضعیت دکمه‌ها
            function updateButtonStates() {
                const selectedCount = $('.marketer-checkbox:checked').length;
                $('#confirmSendBtn').prop('disabled', selectedCount === 0 || !$('#confirmSend').is(':checked'));
                $('#confirmGiftBtn').prop('disabled', selectedCount === 0 || !$('#confirmGift').is(':checked'));
                $('#confirmDiscountBtn').prop('disabled', selectedCount === 0 || !$('#confirmDiscount').is(':checked') || !$('#discountAmount').val());
            }

            // ارسال پیامک
            $('#confirmSendBtn').click(function() {
                const selectedMarketers = getSelectedMarketers();
                const message = $('#messageText').val();

                if (selectedMarketers.length === 0 || !message) {
                    showResult('خطا', 'لطفاً حداقل یک بازاریاب و متن پیام را انتخاب کنید.', 'danger');
                    return;
                }

                sendRequest({
                    btn: $(this),
                    url: '{{ route("admin.marketers.sendBulkSms") }}',
                    data: {
                        selected_marketers: selectedMarketers,
                        message: message
                    },
                    success: function(response) {
                        let message = `<div class="alert alert-success">
                            <i class="fas fa-check-circle result-icon"></i>
                            پیامک به ${response.success_count} نفر ارسال شد.
                        </div>`;

                        if (response.failed_numbers) {
                            message += `<div class="alert alert-danger mt-2">
                                <i class="fas fa-exclamation-triangle result-icon"></i>
                                خطا در ارسال به: ${response.failed_numbers.join(', ')}
                            </div>`;
                        }

                        showResult('نتیجه ارسال پیامک', message, 'success');
                        $('#smsModal').modal('hide');
                    }
                });
            });

            // ارسال هدیه رایگان
            $('#confirmGiftBtn').click(function() {
                const selectedMarketers = getSelectedMarketers();

                if (selectedMarketers.length === 0) {
                    showResult('خطا', 'لطفاً حداقل یک بازاریاب را انتخاب کنید.', 'danger');
                    return;
                }

                sendRequest({
                    btn: $(this),
                    url: '{{ route("admin.marketers.sendGift") }}',
                    data: {
                        selected_marketers: selectedMarketers
                    },
                    success: function(response) {
                        let message = `<div class="alert alert-success">
                            <i class="fas fa-check-circle result-icon"></i>
                            هدیه به ${response.new_gifts_count || response.new_gifts.length} نفر ارسال شد.
                        </div>`;

                        if (response.already_gifted) {
                            message += `<div class="alert alert-warning mt-2">
                                <i class="fas fa-exclamation-triangle result-icon"></i>
                                ${response.message}: ${response.already_gifted_count || response.already_gifted.length} نفر
                            </div>`;
                        }

                        showResult('نتیجه ارسال هدیه', message, 'success');
                        $('#giftModal').modal('hide');
                    }
                });
            });

            // ارسال تخفیف
            $('#confirmDiscountBtn').click(function() {
                const selectedMarketers = getSelectedMarketers();
                const discountAmount = $('#discountAmount').val();

                if (selectedMarketers.length === 0 || !discountAmount) {
                    showResult('خطا', 'لطفاً حداقل یک بازاریاب را انتخاب کنید و مبلغ تخفیف را وارد نمایید.', 'danger');
                    return;
                }

                sendRequest({
                    btn: $(this),
                    url: '{{ route("admin.marketers.sendDiscount") }}',
                    data: {
                        selected_marketers: selectedMarketers,
                        discount: discountAmount
                    },
                    success: function(response) {
                        let message = `<div class="alert alert-success">
                            <i class="fas fa-check-circle result-icon"></i>
                            تخفیف به ${response.new_discounts.length} نفر ارسال شد.
                        </div>`;

                        showResult('نتیجه ارسال تخفیف', message, 'success');
                        $('#discountModal').modal('hide');
                    }
                });
            });


            // رویداد تغییر مبلغ تخفیف
            $('#discountAmount').on('input', function() {
                updateButtonStates();
            });

            // دریافت لیست بازاریابان انتخاب شده
            function getSelectedMarketers() {
                const selected = [];
                $('.marketer-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });
                return selected;
            }

            // نمایش نتیجه
            function showResult(title, content, type) {
                const icon = type === 'success' ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-danger';
                $('#resultModalLabel').html(`<i class="fas ${icon}"></i> ${title}`);
                $('#resultModalBody').html(content);
                $('#resultModal').modal('show');
            }

            // ارسال درخواست AJAX
            function sendRequest(options) {
                const btn = options.btn;
                const originalHtml = btn.html();
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> در حال ارسال...');
                btn.prop('disabled', true);

                $.ajax({
                    url: options.url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ...options.data
                    },
                    success: function(response) {
                        if (options.success) options.success(response);
                    },
                    error: function(xhr) {
                        let errorMessage = 'خطا در انجام عملیات';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showResult('خطا', errorMessage, 'danger');
                    },
                    complete: function() {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                    }
                });
            }
        });
    </script>
</body>
</html>