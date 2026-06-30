import React, { useState, useEffect } from "react";
import axios from "axios";
import api from "../api";

const token = localStorage.getItem("token");

if (token) {
    axios.defaults.headers.common[
        "Authorization"
    ] = `Bearer ${token}`;
}
const UserDashboard = () => {
    const [activeTab, setActiveTab] = useState("orders");
    const [orders, setOrders] = useState([]);
    const [reservations, setReservations] = useState([]);
    const [courses, setCourses] = useState([]);
    const [profile, setProfile] = useState({
        name: "",
        mobile: "",
        password: ""
    });
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        fetchProfile();
        fetchOrders();
        fetchReservations();
        fetchCourses();
    }, []);

    const fetchOrders = async () => {
        try {
            const res = await api.get("/user/orders");
            setOrders(res.data);
        } catch (err) {
            console.error("خطا در دریافت سفارشات");
        }
    };

    const fetchReservations = async () => {
        try {
            const res = await api.get("/user/reservations");
            const data = Array.isArray(res.data) ? res.data : (res.data.data || []);
            setReservations(data);
        } catch (err) {
            console.error("خطا در دریافت رزروها");
        }
    };

   const fetchCourses = async () => {
    try {
        const res = await api.get("/user/courses");

        console.log("Courses Response:", res.data);

        setCourses(res.data);
    } catch (err) {
        console.log("Error:", err.response);
        console.log("Status:", err.response?.status);
        console.log("Data:", err.response?.data);
    }
};

    const fetchProfile = async () => {
        try {
            const res = await api.get("/user/profile");
            setProfile({
                ...res.data,
                password: ""
            });
        } catch (err) {
            console.error("خطا در دریافت پروفایل");
        }
    };

    const handleUpdateProfile = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            await api.post("/user/update-profile", profile);
            alert("اطلاعات با موفقیت بروزرسانی شد");
        } catch (err) {
            alert("خطا در بروزرسانی اطلاعات");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-7xl mx-auto mt-10 px-4 mb-10" dir="rtl">
            <h1 className="text-3xl font-bold mb-6">پنل کاربری</h1>
            <div className="grid grid-cols-12 gap-6">
                
                {/* Sidebar */}
                <div className="col-span-12 md:col-span-3">
                    <div className="bg-white shadow rounded-lg overflow-hidden border">
                        <button
                            onClick={() => setActiveTab("orders")}
                            className={`w-full text-right p-4 border-b ${activeTab === "orders" ? "bg-blue-50 text-blue-600 font-bold" : ""}`}
                        >
                            سفارشات من
                        </button>
                        <button
                            onClick={() => setActiveTab("reservations")}
                            className={`w-full text-right p-4 border-b ${activeTab === "reservations" ? "bg-blue-50 text-blue-600 font-bold" : ""}`}
                        >
                            رزروهای من
                        </button>
                        <button
                            onClick={() => setActiveTab("courses")}
                            className={`w-full text-right p-4 border-b ${activeTab === "courses" ? "bg-blue-50 text-blue-600 font-bold" : ""}`}
                        >
                            ثبت نام دوره‌ها
                        </button>
                        <button
                            onClick={() => setActiveTab("profile")}
                            className={`w-full text-right p-4 ${activeTab === "profile" ? "bg-blue-50 text-blue-600 font-bold" : ""}`}
                        >
                            اطلاعات کاربری
                        </button>
                    </div>
                </div>

                {/* Content */}
                <div className="col-span-12 md:col-span-9">
                    
                    {/* سفارشات */}
                    {activeTab === "orders" && (
                        <div className="bg-white shadow rounded-lg p-5 border">
                            <h3 className="text-xl font-bold mb-4 font-black">سفارشات من</h3>
                            {orders.length > 0 ? (
                                orders.map((order) => (
                                    <div key={order.id} className="border-b py-3 flex justify-between">
                                        <span>سفارش #{order.id}</span>
                                        <span>{order.total_price} تومان</span>
                                        <span className="text-blue-600">{order.status}</span>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 py-4">سفارشی ثبت نشده است.</p>
                            )}
                        </div>
                    )}

                    {/* رزروها (اصلاح شده) */}
                    {activeTab === "reservations" && (
                        <div className="bg-white shadow rounded-lg p-5 border">
                            <h3 className="text-xl font-bold mb-4 font-black">رزروهای من</h3>
                            {reservations && reservations.length > 0 ? (
                                reservations.map((reservation) => (
                                    <div key={reservation.id} className="border-b py-3 flex justify-between items-center text-sm md:text-base">
                                        <span className="font-medium text-gray-800">
                                            {reservation.service_name || "خدمات آرایشی"}
                                        </span>
                                        <span className="text-gray-600">{reservation.appointment_date}</span>
                                        <span className="text-gray-600">{reservation.appointment_time}</span>
                                        <span className={`px-3 py-1 rounded-full text-xs font-bold ${
                                            reservation.status == 0 || reservation.status === 'pending' ? "bg-yellow-100 text-yellow-700" :
                                            reservation.status == 1 || reservation.status === 'approved' ? "bg-green-100 text-green-700" :
                                            "bg-red-100 text-red-700"
                                        }`}>
                                            {reservation.status == 0 || reservation.status === 'pending' ? "در انتظار" : 
                                             reservation.status == 1 || reservation.status === 'approved' ? "تایید شده" : "رد شده"}
                                        </span>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 py-4 text-center">هیچ رزروی پیدا نشد.</p>
                            )}
                        </div>
                    )}

                    {/* دوره‌ها */}
                    {activeTab === "courses" && (
                        <div className="bg-white shadow rounded-lg p-5 border">
                            <h3 className="text-xl font-bold mb-4 font-black">دوره‌های ثبت نام شده</h3>
                            {courses.length > 0 ? (
                                courses.map((course) => (
                                    <div key={course.id} className="border-b py-3 flex justify-between">
                                        <span className="font-bold">{course.title}</span>
                                        <span>مدرس: {course.teacher}</span>
                                        <span className="text-green-600">{course.status}</span>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 py-4">هنوز در هیچ دوره‌ای ثبت نام نکرده‌اید.</p>
                            )}
                        </div>
                    )}

                    {/* پروفایل */}
                    {activeTab === "profile" && (
                        <div className="bg-white shadow rounded-lg p-6 border">
                            <h3 className="text-xl font-bold mb-4 font-black">اطلاعات کاربری</h3>
                            <form onSubmit={handleUpdateProfile}>
                                <label className="block mb-2 font-medium">نام و نام خانوادگی</label>
                                <input
                                    type="text"
                                    value={profile.name}
                                    onChange={(e) => setProfile({ ...profile, name: e.target.value })}
                                    className="w-full border p-3 rounded mb-4"
                                />
                                <label className="block mb-2 font-medium">شماره موبایل</label>
                                <input
                                    type="text"
                                    value={profile.mobile}
                                    onChange={(e) => setProfile({ ...profile, mobile: e.target.value })}
                                    className="w-full border p-3 rounded mb-4"
                                />
                                <label className="block mb-2 font-medium">رمز عبور جدید</label>
                                <input
                                    type="password"
                                    value={profile.password}
                                    placeholder="در صورت عدم تغییر خالی بگذارید"
                                    onChange={(e) => setProfile({ ...profile, password: e.target.value })}
                                    className="w-full border p-3 rounded mb-4"
                                />
                                <button
                                    type="submit"
                                    disabled={loading}
                                    className="bg-green-600 text-white px-5 py-3 rounded font-bold hover:bg-green-700 transition"
                                >
                                    {loading ? "در حال ذخیره..." : "ذخیره تغییرات"}
                                </button>
                            </form>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default UserDashboard;
