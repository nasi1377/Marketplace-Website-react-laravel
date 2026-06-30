import React, { useState, useEffect } from 'react';
import AdminProductApproval from './AdminProductApproval';
import PostApprovalList from './PostApprovalList';
import PostTable from './PostTable';
import CourseApprovalTable from './CourseApprovalTable';
import api from "../api";



const AdminDashboard = () => {
    const [activeTab, setActiveTab] = useState('verifications');
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(false);
    
    const primaryColor = '#6F4E37'; // رنگ اصلی برند نارنید

    // ۱. چک کردن دسترسی کاربر (ادمین) و وجود توکن موقع بارگذاری صفحه
    useEffect(() => {
        const role = localStorage.getItem('role_id'); 
        const token = localStorage.getItem('token');
        
        // اگر کاربر ادمین نبود (role_id برابر 1 نباشه) یا توکن نداشت، بفرستش صفحه لاگین
        if (String(role) !== '1' || !token) {
            window.location.href = '/login';
        }
    }, []);

    // ۲. تابع برای fetching اطلاعات تب‌های مختلف (با ارسال توکن)
    const fetchData = async (tab) => {
    // اگر تب پست‌ها (تامین‌کننده) یا محصولات هست، از اینجا خارج شو (چون خودشون کامپوننت دارن)
    if (tab === 'posts' || tab === 'products') return;

    setLoading(true);
    let endpoint = '';


    if (tab === 'courses')
    endpoint = '/api/admin/courses/pending';
    
    // ۱. اصلاح روت تایید کاربران (مطابق با api.php که فرستادی)
if (tab === 'verifications')
    endpoint = '/api/admin/inactive-users';

if (tab === 'users')
    endpoint = '/api/admin/all-users';
    if (tab === 'orders') endpoint = '/api/admin/orders';

    // ۲. اضافه کردن مسیر برای آرایشگرها (بر اساس روت جدیدت)
    if (tab === 'barber_posts') endpoint = '/api/admin/pending-services'; 
    if (tab === 'all_barber_posts')
    endpoint = '/api/admin/barber-posts';

if (tab === 'all_products')
    endpoint = '/api/admin/published-products';

if (tab === 'all_courses')
    endpoint = '/api/admin/published-courses';

    try {
        // اگر هیچ کدوم از تب‌های بالا نبود، یعنی endpoint خالیه و نباید درخواست بزنیم
        if (!endpoint) {
            setLoading(false);
            return;
        }

        const token = localStorage.getItem('token');
        const res = await api.get(`${endpoint}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        setData(res.data); 
    } catch (err) {
        console.error("خطا در دریافت اطلاعات ادمین", err);
        if (err.response && (err.response.status === 401 || err.response.status === 403)) {
            localStorage.removeItem('token');
            localStorage.removeItem('role_id');
            window.location.href = '/login';
        }
    }
    setLoading(false);
};


    // ۳. اجرای fetchData هر بار که تب فعال عوض می‌شه
    useEffect(() => { 
        fetchData(activeTab); 
    }, [activeTab]);
const handleProductStatus = async (id, status) => {
    try {
        const token = localStorage.getItem('token');
        const response = await api.post(`admin/posts/${id}/update`, 
            { status: status }, 
            { headers: { 'Authorization': `Bearer ${token}` } }
        );

        // ۱. نمایش پیام موفقیت (که از بک‌اِند میاد)
        alert(response.data.message || 'عملیات با موفقیت انجام شد');

        // ۲. بروزرسانی آنی لیست در ظاهر برنامه (UI)
        // این خط باعث می‌شه پستی که تایید یا رد شده، بلافاصله از لیست غیب بشه
        setData(prevData => prevData.filter(post => post.id !== id));

        // ۳. اختیاری: فراخوانی مجدد از دیتابیس برای اطمینان
        // fetchData('barber_posts'); 

    } catch (err) {
        console.error(err);
        alert('خطا در انجام عملیات: ' + (err.response?.data?.message || 'خطای ناشناخته'));
    }
};


const handleCourseStatus = async (id, action) => {
    try {
        const token = localStorage.getItem('token');

        await api.post(
            `/admin/courses/${id}/${action}`,
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        );

        setData(prev =>
            prev.filter(item => item.id !== id)
        );

    } catch (error) {
        console.error(error);
        alert('خطا در انجام عملیات');
    }
};

const handleVerify = async (userId) => {
    // گرفتن توکن از لوکال استوریج (چون روت شما نیاز به auth:sanctum دارد)
    const token = localStorage.getItem('token'); 

    try {
      const response = await fetch(`http://localhost:8000/api/admin/users/approve/${userId}`, { // آدرس کامل بک‌ند
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
    }
});


        const result = await response.json();

        if (response.ok) {
            // نمایش پیام موفقیت
            alert(result.message);
            // حذف کاربر از لیست فعلی (چون دیگه وضعیتش از 0 تغییر کرده)
            setData(prevData => prevData.filter(item => item.id !== userId));
        } else {
            alert(result.message || "خطایی رخ داد");
        }
    } catch (error) {
        console.error("خطای شبکه:", error);
        alert("ارتباط با سرور برقرار نشد.");
    }
};

    return (
<div className="flex min-h-screen bg-gray-100 font-sans" dir="rtl">            {/* --- سایدبار --- */}
            <aside className="w-64 bg-white shadow-xl flex flex-col border-l border-gray-200">
                <div className="p-6 text-center border-b border-gray-100">
                    <h2 className="text-2xl font-bold" style={{ color: primaryColor }}>پنل ادمین نارنید</h2>
                </div>
                
                <nav className="flex-1 mt-6 px-4 space-y-2">
                    {/* دکمه‌های سایدبار برای انتخاب تب‌ها */}
                    <button 
                        onClick={() => setActiveTab('verifications')} 
                        className={`w-full flex items-center p-3 rounded-lg transition duration-150 ease-in-out ${activeTab === 'verifications' ? 'text-white' : 'text-gray-600 hover:bg-gray-50'}`} 
                        style={activeTab === 'verifications' ? { backgroundColor: primaryColor } : {}}>
                        📋 تایید کاربر جدید
                    </button>
                    <button 
                        onClick={() => setActiveTab('users')} 
                        className={`w-full flex items-center p-3 rounded-lg transition duration-150 ease-in-out ${activeTab === 'users' ? 'text-white' : 'text-gray-600 hover:bg-gray-50'}`} 
                        style={activeTab === 'users' ? { backgroundColor: primaryColor } : {}}>
                        👥 مدیریت کاربران
                    </button>
                    <button 
                        onClick={() => setActiveTab('posts')} 
                        className={`w-full flex items-center p-3 rounded-lg transition duration-150 ease-in-out ${activeTab === 'posts' ? 'text-white' : 'text-gray-600 hover:bg-gray-50'}`} 
                        style={activeTab === 'posts' ? { backgroundColor: primaryColor } : {}}>
                        💬  تامین کنندگام نظارت بر پست‌ها
                    </button>
                  


                    <button 
    onClick={() => setActiveTab('barber_posts')} 
    className={`w-full flex items-center p-3 rounded-lg transition duration-150 ease-in-out ${activeTab === 'barber_posts' ? 'text-white' : 'text-gray-600 hover:bg-gray-50'}`} 
    style={activeTab === 'barber_posts' ? { backgroundColor: primaryColor } : {}}>
    📝 مدیریت پست‌های آرایشگران
</button>
<button
    onClick={() => setActiveTab('courses')}
    className={`w-full flex items-center p-3 rounded-lg transition duration-150 ease-in-out ${
        activeTab === 'courses'
            ? 'text-white'
            : 'text-gray-600 hover:bg-gray-50'
    }`}
    style={
        activeTab === 'courses'
            ? { backgroundColor: primaryColor }
            : {}
    }
>
    🎓 تایید دوره‌های آموزشی
</button>
<button
    onClick={() => setActiveTab('all_barber_posts')}
    className={`w-full flex items-center p-3 rounded-lg ${
        activeTab === 'all_barber_posts'
            ? 'text-white'
            : 'text-gray-600 hover:bg-gray-50'
    }`}
    style={activeTab === 'all_barber_posts'
        ? { backgroundColor: primaryColor }
        : {}}
>
    📄 همه پست‌های آرایشگران
</button>

<button
    onClick={() => setActiveTab('all_products')}
    className={`w-full flex items-center p-3 rounded-lg ${
        activeTab === 'all_products'
            ? 'text-white'
            : 'text-gray-600 hover:bg-gray-50'
    }`}
    style={activeTab === 'all_products'
        ? { backgroundColor: primaryColor }
        : {}}
>
    🛍 همه محصولات منتشر شده
</button>

<button
    onClick={() => setActiveTab('all_courses')}
    className={`w-full flex items-center p-3 rounded-lg ${
        activeTab === 'all_courses'
            ? 'text-white'
            : 'text-gray-600 hover:bg-gray-50'
    }`}
    style={activeTab === 'all_courses'
        ? { backgroundColor: primaryColor }
        : {}}
>
    🎓 همه دوره‌های منتشر شده
</button>
                    <button 
                        onClick={() => setActiveTab('orders')} 
                        className={`w-full flex items-center p-3 rounded-lg transition duration-150 ease-in-out ${activeTab === 'orders' ? 'text-white' : 'text-gray-600 hover:bg-gray-50'}`} 
                        style={activeTab === 'orders' ? { backgroundColor: primaryColor } : {}}>
                        🛒 سفارشات
                    </button>
                </nav>
            </aside>

            {/* --- محتوای اصلی --- */}
            <main className="flex-1 overflow-y-auto p-8">
                <header className="flex justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    {/* تیتر صفحه بر اساس تب فعال */}
                    <h1 className="text-xl font-bold text-gray-800">
                        {activeTab === 'verifications' && "کاربران در انتظار تایید"}
                        {activeTab === 'users' && "مدیریت کل کاربران"}
                        {activeTab === 'posts' && "نظارت بر انتشار پست‌ها"}
                        {activeTab === 'products' && "تایید محصولات جدید"}
                        {activeTab === 'orders' && "مدیریت سفارشات"}
                        
                        {activeTab === 'barber_posts' && "تایید محصولات جدید آرایشگران"}
                        {activeTab === 'all_barber_posts' && "همه پست‌های آرایشگران"}
{activeTab === 'all_products' && "همه محصولات منتشر شده"}
{activeTab === 'all_courses' && "همه دوره‌های منتشر شده"}


{activeTab === 'courses' && <CourseApprovalTable courses={data} onStatusChange={handleCourseStatus}/>
}
                    </h1>
                    {/* دکمه خروج برای بستن پنل */}
                    <button 
                        onClick={() => {
                            localStorage.removeItem('token'); // حذف توکن
                            localStorage.removeItem('role_id'); // حذف نقش
                            window.location.href = '/login'; // رفتن به صفحه لاگین
                        }} 
                        className="text-red-500 text-sm font-bold hover:text-red-700 transition duration-150 ease-in-out">
                        خروج از پنل
                    </button>
                </header>

                {/* محتوای تب‌ها */}
                <div className="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    
                    {/* نمایش کامپوننت مدیریت پست */}
                    {activeTab === 'posts' && <PostApprovalList />}

                    {/* نمایش کامپوننت مدیریت محصول */}
                    {activeTab === 'products' && <AdminProductApproval />}
                    {/* نمایش کامپوننت جدید بدون تغییر در قبلی‌ها */}
{activeTab === 'barber_posts' && (
    <PostTable 
        posts={data} 
        onStatusChange={handleProductStatus} // این تابع رو باید تعریف کنی (پایین‌تر نوشتم)
    />
)}



                    {/* نمایش جدول برای تب‌های دیگر */}
                    {(activeTab !== 'posts' && activeTab !== 'products') && (
                        loading ? (
                            // نمایش پیام در حین بارگذاری
                            <div className="p-20 text-center text-gray-400">در حال دریافت اطلاعات...</div>
                        ) : (
                            <table className="w-full text-right text-gray-600">
                                <thead className="bg-gray-50 border-b border-gray-100">
                                    {/* سرستون‌ها بر اساس تب فعال */}
                                    <tr>
                                        {activeTab === 'verifications' && <>
                                            <th className="p-4">نام</th>
                                            <th className="p-4">نقش</th>
                                            <th className="p-4">شماره تماس</th>
                                            <th className="p-4">عملیات</th>
                                        </>}
                                        {activeTab === 'users' && <>
                                            <th className="p-4">نام</th>
                                            <th className="p-4">موبایل</th>
                                            <th className="p-4">نقش</th>
                                            <th className="p-4">وضعیت</th>
                                        </>}
                                        {activeTab === 'orders' && <>
                                            <th className="p-4">کد سفارش</th>
                                            <th className="p-4">مبلغ</th>
                                            <th className="p-4">وضعیت</th>
                                        </>}
                                        {activeTab === 'all_barber_posts' && <>
    <th className="p-4">عنوان</th>
    <th className="p-4">آرایشگر</th>
    <th className="p-4">موبایل</th>
    <th className="p-4">تاریخ</th>
</>}
{activeTab === 'all_products' && <>
    <th className="p-4">محصول</th>
    <th className="p-4">تأمین‌کننده</th>
    <th className="p-4">موبایل</th>
    <th className="p-4">قیمت</th>
</>}
{activeTab === 'all_courses' && <>
    <th className="p-4">دوره</th>
    <th className="p-4">آرایشگر</th>
    <th className="p-4">موبایل</th>
    <th className="p-4">قیمت</th>
</>}
                                    </tr>
                                </thead>
                                <tbody>
                                    {/* اگر هیچ داده‌ای نبود، پیام نمایش داده شود */}
                                    {data.length === 0 ? (
                                        <tr><td colSpan="4" className="p-10 text-center text-gray-400">موردی برای نمایش وجود ندارد.</td></tr>
                                    ) : (
                                        // پیمایش روی داده‌ها برای نمایش ردیف‌ها
                                        data.map((item) => (
                                            <tr key={item.id} className="border-b hover:bg-gray-50 transition duration-150 ease-in-out">
                                                {/* نمایش ردیف بر اساس تب فعال */}
                                            {activeTab === 'verifications' && (
    <>
        <td className="p-4 font-bold">{item.name}</td>
        <td className="p-4">{item.role_id === 3 ? 'تامین‌کننده' : 'آرایشگر'}</td>
        <td className="p-4 text-sm">{item.phone_number || 'ثبت نشده'}</td>
        <td className="p-4">
            <button 
                onClick={() => handleVerify(item.id)} // اتصال به تابع بالا
                className="bg-green-600 text-white px-4 py-1 rounded-lg text-xs hover:bg-green-700 focus:outline-none"
            >
                تایید نهایی
            </button>
        </td>
    </>
)}
                                               
                                                {activeTab === 'users' && (
                                                    <>
                                                        <td className="p-4 font-bold">{item.name}</td>
                                                        <td className="p-4">{item.phone_number}</td>
                                                        <td className="p-4 text-xs">
                                                            {/* نمایش نقش کاربر */}
                                                            {item.role_id === 1 ? 'ادمین' : (item.role_id === 3 ? 'تامین‌کننده' : 'آرایشگر')}
                                                        </td>
                                                        <td className="p-4">
                                                            {/* نمایش وضعیت کاربر (فعال/غیرفعال) */}
                                                            <span className={`px-2 py-1 rounded-full text-xs ${item.status === 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>
                                                                {item.status === 1 ? 'فعال' : 'غیرفعال'}
                                                            </span>
                                                        </td>
                                                    </>
                                                )}
                                                {activeTab === 'all_barber_posts' && (
    <>
        <td className="p-4">{item.title}</td>
        <td className="p-4">{item.user?.name}</td>
        <td className="p-4">{item.user?.phone_number}</td>
        <td className="p-4">
            {new Date(item.created_at).toLocaleDateString('fa-IR')}
        </td>
    </>
)}
{activeTab === 'all_products' && (
    <>
        <td className="p-4">{item.name}</td>
        <td className="p-4">{item.user?.name}</td>
        <td className="p-4">{item.user?.phone_number}</td>
        <td className="p-4">{item.price} تومان</td>
    </>
)}
{activeTab === 'all_courses' && (
    <>
        <td className="p-4">{item.title}</td>
        <td className="p-4">{item.user?.name}</td>
        <td className="p-4">{item.user?.phone_number}</td>
        <td className="p-4">{item.price} تومان</td>
    </>
)}

                                                {activeTab === 'orders' && (
                                                    <>
                                                        <td className="p-4 font-mono">#{item.id}</td>
                                                        <td className="p-4 font-bold text-green-700">{item.total_price || (item.price && `${item.price} تومان`)}</td> {/* نمایش قیمت یا مبلغ کل */}
                                                        <td className="p-4 text-xs">{item.status}</td> {/* نمایش وضعیت سفارش */}
                                                    </>
                                                )}

                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        )
                    )}
                </div>
            </main>
        </div>
    );
};

export default AdminDashboard;
