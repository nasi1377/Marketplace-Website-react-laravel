import React, { useEffect, useState } from 'react';
import axios from 'axios';
import api from "../api";

const SupplierOrders = ({ userId }) => {
  const [orders, setOrders] = useState([]);

  useEffect(() => {
    // گرفتن سفارشات مخصوص این تامین‌کننده
    api.get(`/supplier/orders/${userId}`)
      .then(res => setOrders(res.data))
      .catch(err => console.log("خطا در دریافت سفارشات", err));
  }, [userId]);

  return (
    <div className="overflow-x-auto">
      <table className="w-full text-right border-collapse bg-white">
        <thead>
          <tr className="bg-slate-100 text-gray-700">
            <th className="p-3 border">شماره سفارش</th>
            <th className="p-3 border">مشتری</th>
            <th className="p-3 border">محصول</th>
            <th className="p-3 border">مبلغ پرداختی</th>
            <th className="p-3 border">وضعیت ارسال</th>
          </tr>
        </thead>
        <tbody>
          {orders.length > 0 ? orders.map(order => (
            <tr key={order.id} className="hover:bg-gray-50">
              <td className="p-3 border">#{order.id}</td>
              <td className="p-3 border">{order.user?.name} {order.user?.last_name}</td>
              <td className="p-3 border">{order.product?.title}</td>
              <td className="p-3 border">{order.price} تومان</td>
              <td className="p-3 border">
                <span className="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                  در حال پردازش
                </span>
              </td>
            </tr>
          )) : (
            <tr>
              <td colSpan="5" className="p-5 text-center text-gray-500">سفارشی یافت نشد.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default SupplierOrders;
