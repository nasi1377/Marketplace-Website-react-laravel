<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Barber\HairstylistServiceController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Barber\BarberController;
use App\Http\Controllers\Barber\AppointmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Chat\ChatController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- 1. مسیرهای عمومی (Public - بدون نیاز به لاگین) ---
Route::post('/login', [AuthController::class, 'loginAction']);
Route::post('/register', [AuthController::class, 'registerAction']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::get('/home-data', [HomeController::class, 'index']);
Route::get('/hairstylist/services/approved', [HairstylistServiceController::class, 'getApproved']);


// --- 2. مسیرهای تامین‌کننده (Supplier) ---
Route::middleware(['auth:sanctum', 'IsSupplier'])->group(function () {
    Route::post('/supplier/products/store', [ProductController::class, 'store']);
    Route::get('/supplier/my-products', [ProductController::class, 'index']);
    Route::get(
    '/supplier/orders/{userId}',
    [ProductController::class, 'supplierOrders']
);
});


// --- 3. مسیرهای ادمین (اصلاح شده) ---
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // کاربران فعال
    Route::get('/admin/inactive-users', [AdminController::class, 'getUsersgheifal']);
Route::get('/admin/all-users', [AdminController::class, 'getAllUsers']);
    Route::post('/admin/verify-user/{id}', [AdminController::class, 'verifyUser']);
    Route::get('/admin/orders', [AdminController::class, 'getOrders']);
    Route::get('/admin/products/pending', [AdminController::class, 'getPendingProducts']);
    Route::post('/admin/products/{id}/status', [AdminController::class, 'verifyProducts']);
    Route::get('/admin/posts/pending', [AdminController::class, 'getPendingPosts']);
    Route::post('/admin/posts/{id}/status', [AdminController::class, 'updateStatus']);
    Route::get('/admin/pending-users', [AdminController::class, 'getUsersgheifal']);
    // روت برای گرفتن لیست خدمات آرایشگرها
    Route::get('/admin/pending-services', [AdminController::class, 'pendingServices']);
    // روت برای آپدیت وضعیت خدمات آرایشگر
    Route::post('/admin/posts/{id}/update', [AdminController::class, 'updateStatusHair']);
    Route::get('admin/pending-users', [UserController::class, 'getPendingUsers']);
    // اصلاح سمی‌کالن در این خط
    Route::post('/admin/users/approve/{userId}', [AdminController::class, 'approve']); 
    Route::post('admin/reject-user/{user}', [UserController::class, 'rejectUser']);

    Route::get(
    '/admin/courses/pending',
    [CourseController::class, 'pendingCourses']
);

Route::post(
    '/admin/courses/{id}/approve',
    [CourseController::class, 'approveCourse']
);

Route::post(
    '/admin/courses/{id}/reject',
    [CourseController::class, 'rejectCourse']
);

  Route::get('/admin/barber-posts',
        [AdminController::class,'allBarberPosts']);

    Route::get('/admin/published-products',
        [AdminController::class,'publishedProducts']);

    Route::get('/admin/published-courses',
        [AdminController::class,'publishedCourses']);

});


// --- 4. مسیرهای کاربر عادی (User) ---
Route::middleware(['auth:sanctum', 'is_user'])->group(function () {
    Route::get('/user/orders', [UserController::class, 'getOrders']);
    Route::get('/user/profile', [UserController::class, 'getProfile']);
    Route::post('/user/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/reservations', [AppointmentController::class,'store']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/user/reservations', [UserController::class, 'getUserReservations']); 
 Route::post('/user/courses-register', [UserController::class, 'enrollCourse']);
Route::delete('/courses/unenroll', [UserController::class, 'unenrollCourse']);
Route::get('user/courses', [UserController::class, 'userCourses']);

});




// --- 5. مسیرهای آرایشگر (Barber) ---
Route::middleware(['auth:sanctum', \App\Http\Middleware\CheckBarberRole::class])->group(function () {
    Route::post('/posts', [HairstylistServiceController::class, 'store']);
    Route::get('/hairstylist/my-services', [HairstylistServiceController::class, 'index']);
     Route::get('/barber/services',[BarberController::class, 'myServices'] );
    Route::post('/barber/service-schedules',[BarberController::class, 'storeSchedule']);
    Route::post('/barber/courses', [CourseController::class, 'store']);
   
    Route::put(
        '/barber/course-requests/{id}',
        [CourseController::class, 'updateRequestStatus']
    );

    Route::get(
        '/barber/appointments',
        [AppointmentController::class, 'barberAppointments']
    );

    Route::put(
        '/appointments/{id}/approve',
        [AppointmentController::class, 'approve']
    );

    Route::get('/barber/course-requests', [CourseController::class, 'barberCourseRequests']);
    Route::put('/barber/course-requests/{id}', [CourseController::class, 'updateCourseRequest']);

});

// روت نمایش عمومی برای همه کاربران
Route::get('/services/approved', [HairstylistServiceController::class, 'getApproved']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/services/{service}/slots', [AppointmentController::class, 'getAvailableSlots']);
Route::middleware('auth:sanctum')->post('/user/update-profile', function (Request $request) {
    $user = $request->user();
    $user->update([
        'name' => $request->name,
        'family' => $request->family,
        'address' => $request->address,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'اطلاعات بروزرسانی شد'
    ]);
});
Route::middleware('auth:sanctum')->get('/user/profile', function (Request $request) {
    return response()->json($request->user());
});
Route::middleware('auth:sanctum')->post(
    '/course-request',
    [CourseController::class, 'reserveCourse']
);
Route::get(
    '/courses/{id}',
    [CourseController::class, 'show']
);
Route::get('/menus', [HomeController::class, 'menus']);
Route::get('/footer-data', [HomeController::class, 'footerData']);
Route::get('/provinces', [LocationController::class, 'provinces']);
Route::get(
    '/provinces/{provinceId}/cities',
    [LocationController::class, 'cities']
);


Route::post('/chat', [ChatController::class, 'chat']);