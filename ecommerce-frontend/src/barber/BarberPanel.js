import React, { useState, useEffect } from 'react';
import BarberSidebar from './BarberSidebar';
import BarberAppointments from './BarberAppointments';
import AddBarberPost from './AddBarberPost';
import BarberSchedule from './BarberSchedule';
import AddCourse from './AddCourse';
import CourseRequests from './CourseRequests';

const BarberPanel = () => {
    const [activeTab, setActiveTab] = useState('add-post');
    const [isAuthorized, setIsAuthorized] = useState(false); // وضعیت احراز هویت
    const [loadingAuth, setLoadingAuth] = useState(true); // وضعیت بارگذاری احراز هویت

    // کد محافظت از پنل
    useEffect(() => {
        const roleId = localStorage.getItem('role_id');
        
        // چک می‌کنیم اگر رل ایدی 4 نبود، نذاره وارد بشه
        if (roleId === "4") {
            setIsAuthorized(true); // دسترسی مجاز هست
        } else {
            alert("شما اجازه ورود به پنل آرایشگران را ندارید!");
            window.location.href = '/login'; // ریدایرکت به صفحه لاگین
            // setIsAuthorized(false); // این خط لازم نیست چون ریدایرکت میشه
        }
        setLoadingAuth(false); // اتمام بارگذاری احراز هویت
    }, []); // باک کامپوننت خالی، فقط یک بار در زمان mount اجرا میشه

    // اگر هنوز در حال چک کردن احراز هویت هستیم، هیچی نشون نده
    if (loadingAuth) {
        return null; 
    }

    // حالا اگر کاربر مجاز نیست (یعنی roleId درست نبوده و ریدایرکت نشده)، باز هم هیچی نشون بده
    // این قسمت بیشتر جنبه اطمینان داره چون با کد بالا ریدایرکت میشه.
    // if (!isAuthorized) {
    //     return null;
    // }

    // استخراج userId فقط در صورتی که دسترسی مجاز است
    const userId = isAuthorized ? localStorage.getItem('user_id') || 1 : null;

    return (
        <div className="flex flex-row-reverse bg-gray-50 min-h-screen">
            <BarberSidebar activeTab={activeTab} setActiveTab={setActiveTab} />
            
            <div className="flex-1 mr-64 p-8">
                <div className="max-w-5xl mx-auto">
                    <h1 className="text-2xl font-bold mb-6 border-b pb-4">
                        {activeTab === 'add-post' && '✨ ثبت نمونه‌کار جدید'}
                        {activeTab === 'schedule' && '📅 مدیریت ساعات حضور'}
                        {activeTab === 'appointments' && '👥 لیست رزروهای مشتریان'}
                        {activeTab === 'add-course' && '🎓 افزودن دوره آموزشی'}
{activeTab === 'course-requests' && '📚 درخواست‌های ثبت‌نام دوره‌ها'}
                        
                    </h1>

                    <div className="bg-white rounded-2xl shadow-sm p-6">
                        {activeTab === 'add-post' && <AddBarberPost userId={userId} />}
                        {activeTab === 'schedule' && <BarberSchedule userId={userId} />}
                        {activeTab === 'appointments' && <BarberAppointments userId={userId} />}
                        {activeTab === 'add-course' && <AddCourse userId={userId} />}
                        {activeTab === 'course-requests' && (
    <CourseRequests userId={userId} />
)}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default BarberPanel;
