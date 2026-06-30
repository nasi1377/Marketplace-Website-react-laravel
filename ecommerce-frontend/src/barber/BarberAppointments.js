import React, { useEffect, useState } from "react";
import api from "../api";

const BarberAppointments = () => {
const [appointments, setAppointments] = useState([]);
const [loading, setLoading] = useState(true);

const token = localStorage.getItem("token");

const fetchAppointments = async () => {
    try {
        const res = await api.get(
            "barber/appointments",
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );

        setAppointments(res.data.data || []);
    } catch (error) {
        console.error("خطا در دریافت رزروها", error);
    } finally {
        setLoading(false);
    }
};

useEffect(() => {
    fetchAppointments();
}, []);

const approveAppointment = async (id) => {
    try {
        await api.post(
            `/barber/appointments/${id}/approve`,
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );

        alert("رزرو تایید شد");
        fetchAppointments();

    } catch (error) {
        console.error(error);
        alert("خطا در تایید رزرو");
    }
};

if (loading) {
    return (
        <div className="text-center py-10">
            در حال بارگذاری...
        </div>
    );
}

return (
    <div>
        <h2 className="text-xl font-bold mb-6">
            لیست رزروهای مشتریان
        </h2>

        {appointments.length === 0 ? (
            <div className="text-center text-gray-500">
                رزروی ثبت نشده است
            </div>
        ) : (
            <div className="overflow-x-auto">
                <table className="w-full border border-gray-200">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="p-3 border">مشتری</th>
                            <th className="p-3 border">خدمت</th>
                            <th className="p-3 border">تاریخ</th>
                            <th className="p-3 border">ساعت</th>
                            <th className="p-3 border">وضعیت</th>
                            <th className="p-3 border">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        {appointments.map((item) => (
                            <tr key={item.id}>
                                <td className="p-3 border">
                                    {item.customer_name}
                                </td>

                                <td className="p-3 border">
                                    {item.service_title}
                                </td>

                                <td className="p-3 border">
                                    {item.appointment_date}
                                </td>

                                <td className="p-3 border">
                                    {item.appointment_time}
                                </td>

                                <td className="p-3 border">
                                    {item.status === "pending" ? (
                                        <span className="text-yellow-600 font-bold">
                                            در انتظار تایید
                                        </span>
                                    ) : (
                                        <span className="text-green-600 font-bold">
                                            تایید شده
                                        </span>
                                    )}
                                </td>

                                <td className="p-3 border">
                                    {item.status === "pending" && (
                                        <button
                                            onClick={() =>
                                                approveAppointment(item.id)
                                            }
                                            className="bg-green-600 text-white px-3 py-1 rounded"
                                        >
                                            تایید رزرو
                                        </button>
                                    )}
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

export default BarberAppointments;
