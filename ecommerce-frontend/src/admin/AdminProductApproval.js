import React, { useState, useEffect } from 'react';
import axios from 'axios';
import api from "../api";

const AdminProductApproval = () => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const API_BASE_URL = 'http://127.0.0.1:8000';

    // تابع کمکی برای دریافت توکن و تنظیم هدرها
    const getAuthHeaders = () => {
        const token = localStorage.getItem('token');
        console.log("در حال تلاش برای بازیابی توکن از localStorage:", token);

        if (!token) {
            console.warn("توکنی در localStorage پیدا نشد!");
            return null;
        }
        
        return {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
    };

    // 1. تابع دریافت محصولات در انتظار تایید
    const fetchPendingProducts = async () => {
        const headers = getAuthHeaders();
        if (!headers) {
            setLoading(false);
            return;
        }

        try {
            setLoading(true);
            const res = await api.get(`${API_BASE_URL}/api/admin/products/pending`, { headers });
            
            console.log("دیتای دریافتی از سرور:", res.data);
            setProducts(res.data);
        } catch (err) {
            console.error("خطا در دریافت لیست محصولات:", err.response?.data || err.message);
            if (err.response && (err.response.status === 401 || err.response.status === 403)) {
                alert("توکن نامعتبر است یا دسترسی ندارید. لطفاً مجدداً وارد شوید.");
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchPendingProducts();
    }, []);

    // 2. تابع تغییر وضعیت (تایید یا رد)
    const handleStatusUpdate = async (id, newStatus) => {
        const actionText = newStatus === 'approved' ? "تایید" : "رد";
        if (window.confirm(`آیا از ${actionText} این محصول مطمئن هستید؟`)) {
            const headers = getAuthHeaders();
            if (!headers) return;

            try {
                await api.post(`${API_BASE_URL}/api/admin/products/${id}/status`, 
                    { status: newStatus }, 
                    { headers }
                );
                
                setProducts(products.filter(p => p.id !== id));
                alert(`محصول با موفقیت ${actionText} شد.`);
            } catch (err) {
                console.error("خطا در آپدیت وضعیت:", err);
                if (err.response?.status === 401) {
                    alert("نشست شما منقضی شده است. لطفا دوباره وارد شوید.");
                    window.location.href = '/login';
                }
            }
        }
    };

    if (loading) return <div className="p-10 text-center text-gray-500">در حال بارگذاری محصولات...</div>;

    return (
        <div className="p-4">
            {products.length === 0 ? (
                <div className="text-center py-20 text-gray-400 border-2 border-dashed rounded-xl">
                    <p>هیچ محصولی در انتظار تایید وجود ندارد.</p>
                </div>
            ) : (
                <div className="overflow-x-auto">
                    <table className="w-full text-right border-collapse">
                        <thead>
                            <tr className="bg-gray-50 text-gray-700">
                                <th className="p-4 border-b">تصویر</th>
                                <th className="p-4 border-b">نام محصول</th>
                                <th className="p-4 border-b">قیمت</th>
                                <th className="p-4 border-b">تامین‌کننده</th>
                                <th className="p-4 border-b">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            {products.map(product => (
                                <tr key={product.id} className="border-b hover:bg-gray-50 transition-colors">
                                    <td className="p-4">
                                        <img src={`${API_BASE_URL}/storage/${product.image}`} alt={product.name} className="w-14 h-14 object-cover rounded-lg shadow-sm border" />
                                    </td>
                                    <td className="p-4 font-bold text-gray-800">{product.name}</td>
                                    <td className="p-4 text-indigo-600 font-medium">{Number(product.price).toLocaleString()} تومان</td>
                                    <td className="p-4 text-sm text-gray-600">{product.supplier?.name || "نامشخص"}</td>
                                    <td className="p-4">
                                        <div className="flex gap-2">
                                            <button onClick={() => handleStatusUpdate(product.id, 'approved')} className="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-xs transition-colors">✅ تایید</button>
                                            <button onClick={() => handleStatusUpdate(product.id, 'rejected')} className="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-1.5 rounded-lg text-xs transition-colors">❌ رد</button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
        </div>
    );
};

export default AdminProductApproval;
