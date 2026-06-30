import React from 'react';
import {
    LayoutDashboard,
    CalendarDays,
    ClipboardList,
    LogOut,
    Scissors,
    GraduationCap
} from 'lucide-react';
const BarberSidebar = ({ activeTab, setActiveTab }) => {
    
    // لیست منوها برای این که کد تمیزتر باشه
   const menuItems = [
{
    id: 'add-post',
    label: 'ثبت نمونه‌کار',
    icon: <Scissors size={20} />
},
{
    id: 'schedule',
    label: 'مدیریت ساعات',
    icon: <CalendarDays size={20} />
},
{
    id: 'appointments',
    label: 'لیست رزروها',
    icon: <ClipboardList size={20} />
},
{
    id: 'add-course',
    label: 'افزودن دوره آموزشی',
    icon: <GraduationCap size={20} />
},
{
    id: 'course-requests',
    label: 'درخواست‌های دوره‌ها',
    icon: <GraduationCap size={20} />
}
];
    

    return (
        <div className="fixed right-0 top-0 h-screen w-64 bg-white border-l border-gray-200 shadow-sm flex flex-col">
            {/* بخش لوگو یا عنوان بالای سایدبار */}
            <div className="p-6 border-bottom flex items-center justify-center gap-2">
                <div className="bg-black text-white p-2 rounded-lg">
                    <LayoutDashboard size={24} />
                </div>
                <span className="font-bold text-xl text-gray-800">پنل آرایشگر</span>
            </div>

            {/* بخش آیتم‌های منو */}
            <nav className="flex-1 px-4 mt-4 space-y-2">
                {menuItems.map((item) => (
                    <button
                        key={item.id}
                        onClick={() => setActiveTab(item.id)}
                        className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 ${
                            activeTab === item.id
                                ? 'bg-black text-white shadow-md'
                                : 'text-gray-600 hover:bg-gray-100'
                        }`}
                    >
                        {item.icon}
                        <span className="font-medium">{item.label}</span>
                    </button>
                ))}
            </nav>

            {/* بخش خروج یا پروفایل در پایین */}
            <div className="p-4 border-t border-gray-100">
                <button 
                    onClick={() => {
                        localStorage.clear();
                        window.location.href = '/login';
                    }}
                    className="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all"
                >
                    <LogOut size={20} />
                    <span className="font-medium">خروج از حساب</span>
                </button>


            </div>
        </div>
    );
};

export default BarberSidebar;
