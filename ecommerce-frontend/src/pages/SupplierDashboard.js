import React, { useEffect, useState } from 'react';
import api from "../api";

const SupplierDashboard = () => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // آدرس API لاراولت رو چک کن
    api.get('/my-products')
            .then(res => {
                setProducts(res.data);
                setLoading(false);
            })
            .catch(err => {
                console.error("خطا در دریافت اطلاعات:", err);
                setLoading(false);
            });
    }, []);

    if (loading) return <div className="text-center p-10">در حال بارگذاری...</div>;

    return (
        <div className="p-8 bg-gray-100 min-h-screen">
            <div className="max-w-6xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                <div className="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h1 className="text-2xl font-bold text-gray-800">پنل مدیریت محصولات (Supplier)</h1>
                    <button className="bg-blue-600 text-white px-4 py-2 rounded shadow">افزودن محصول جدید</button>
                </div>
                
                <table className="w-full text-right" dir="rtl">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-gray-600">ID</th>
                            <th className="px-6 py-3 text-gray-600">نام محصول</th>
                            <th className="px-6 py-3 text-gray-600">وضعیت تایید</th>
                            <th className="px-6 py-3 text-gray-600">عملیات</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-200">
                        {products.length > 0 ? products.map(p => (
                            <tr key={p.id} className="hover:bg-gray-50">
                                <td className="px-6 py-4">{p.id}</td>
                                <td className="px-6 py-4 font-medium">{p.name}</td>
                                <td className="px-6 py-4">
                                    <span className={`px-3 py-1 rounded-full text-sm ${
                                        p.status === 'approved' ? 'bg-green-100 text-green-700' : 
                                        p.status === 'rejected' ? 'bg-red-100 text-red-700' : 
                                        'bg-yellow-100 text-yellow-700'
                                    }`}>
                                        {p.status === 'approved' ? 'تایید شده' : 
                                         p.status === 'rejected' ? 'رد شده' : 'در انتظار تایید'}
                                    </span>
                                </td>
                                <td className="px-6 py-4">
                                    <button className="text-blue-500 hover:underline">ویرایش</button>
                                </td>
                            </tr>
                        )) : (
                            <tr>
                                <td colSpan="4" className="text-center py-10 text-gray-500">هیچ محصولی یافت نشد.</td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default SupplierDashboard;
