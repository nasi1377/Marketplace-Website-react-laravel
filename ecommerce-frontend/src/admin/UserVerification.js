import React, { useState, useEffect } from 'react';
// فرض می‌کنیم primaryColor رو جایی تعریف کردید
// import { primaryColor } from './config'; // مثال

function UserVerification() {
    const [pendingUsers, setPendingUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // تابع دریافت کاربران از بک‌اند
    const fetchPendingUsers = async () => {
        setLoading(true);
        setError(null);
        try {
            // فرض می‌کنیم این تابع درخواست GET به /api/pending-users رو انجام میده
            const response = await fetchData('/api/admin/pending-users');
            setPendingUsers(response.data);
        } catch (err) {
            setError('Failed to fetch users');
            console.error("Error fetching users:", err);
        } finally {
            setLoading(false);
        }
    };

    // تابع تایید کاربر
    const handleApprove = async (userId) => {
        try {
            // فرض می‌کنیم این تابع درخواست POST به /api/approve-user/{userId} رو انجام میده
            await fetchData(`/api/approve-user/${userId}`, { method: 'POST' });
            // بعد از تایید، کاربر رو از لیست حذف می‌کنیم یا وضعیتش رو عوض می‌کنیم
            alert('User approved!');
            fetchPendingUsers(); // دوباره لیست رو آپدیت می‌کنیم
        } catch (err) {
            setError('Failed to approve user');
            console.error("Error approving user:", err);
        }
    };

    // تابع رد کاربر
    const handleReject = async (userId) => {
        try {
            // فرض می‌کنیم این تابع درخواست POST به /api/reject-user/{userId} رو انجام میده
            await fetchData(`/api/admin/reject-user/${userId}`, { method: 'POST' });
            alert('User rejected!');
            fetchPendingUsers(); // دوباره لیست رو آپدیت می‌کنیم
        } catch (err) {
            setError('Failed to reject user');
            console.error("Error rejecting user:", err);
        }
    };

    useEffect(() => {
        fetchPendingUsers();
    }, []); // فقط یک بار موقع بارگذاری اولیه اجرا میشه

    if (loading) return (
        <div className="p-4">
            Loading pending users...
        </div>
    );

    if (error) return (
        <div className="p-4 text-red-500">
            {error}
        </div>
    );

    return (
        <div className="p-4">
            <h2 className="text-lg font-semibold mb-4">Pending User Verifications</h2>

            {pendingUsers.length === 0 ? (
                <p>No users are currently pending verification.</p>
            ) : (
                <div className="space-y-4">
                    {pendingUsers.map((user) => (
                        <div key={user.id} className="border p-4 rounded-lg shadow-sm">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                                <p><strong>ID:</strong> {user.id}</p>
                                <p><strong>Name:</strong> {user.name}</p>
                                <p><strong>Email:</strong> {user.email}</p>
                                {/* بقیه مشخصاتی که می‌خواید رو اینجا اضافه کنید */}
                                {user.phone && <p><strong>Phone:</strong> {user.phone}</p>}
                                {user.address && <p><strong>Address:</strong> {user.address}</p>}
                                {/* ... */}
                            </div>
                            <div className="mt-4 flex justify-end space-x-2">
                                <button
                                    onClick={() => handleApprove(user.id)}
                                    className="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded font-medium transition"
                                    style={{ backgroundColor: primaryColor }} // مثال استفاده از رنگ اصلی
                                >
                                    Approve
                                </button>
                                <button
                                    onClick={() => handleReject(user.id)}
                                    className="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded font-medium transition"
                                >
                                    Reject
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}

// تابع کمکی fetchData (این رو باید خودت پیاده‌سازی کنی یا از axios استفاده کنی)
async function fetchData(url, options = {}) {
    // فرض می‌کنیم همه‌ی درخواست‌ها به API نیاز به توکن احراز هویت دارند
    const token = localStorage.getItem('authToken'); // یا از context/store دیگه

    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token && { 'Authorization': `Bearer ${token}` }),
        },
    };

    const mergedOptions = { ...defaultOptions, ...options };

    if (mergedOptions.method !== 'GET' && mergedOptions.body === undefined) {
        // برای متدهای POST, PUT, DELETE و ... که payload دارند
        if (options.body) {
             mergedOptions.body = JSON.stringify(options.body);
        }
    }

    try {
        const response = await fetch(url, mergedOptions); // از /api/* باید در URL استفاده کنی

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        // برای متدهایی که response body ندارند (مثل 204 No Content) JSON parse نکن
        if (response.status === 204) {
            return null; // یا response برگردون
        }

        return await response.json();

    } catch (error) {
        console.error('API Request Error:', error);
        throw error; // خطا رو دوباره پرتاب کن تا در component ها catch بشه
    }
}


export default UserVerification;
