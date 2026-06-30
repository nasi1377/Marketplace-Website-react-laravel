import React, { useState, useEffect } from "react";
import axios from "axios";
import api from "../api";

const BarberSchedule = () => {

    const [services, setServices] = useState([]);

    const [formData, setFormData] = useState({
        service_id: "",
        available_date: "",
        start_time: "",
        end_time: "",
        slot_duration: 30
    });

    useEffect(() => {

        const token = localStorage.getItem("token");

        api.get(
            "barber/services",
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        )
        .then((res) => {

            console.log("Services:", res.data);

            setServices(res.data);

        })
        .catch((err) => {
            console.log("خطا در دریافت خدمات:");
            console.log(err.response?.data || err);
        });

    }, []);

    const handleChange = (e) => {

        const updatedData = {
            ...formData,
            [e.target.name]: e.target.value
        };

        console.log("FormData:", updatedData);

        setFormData(updatedData);
    };

    const handleSave = async () => {

        console.log("اطلاعات ارسالی:", formData);

        if (
            !formData.service_id ||
            !formData.available_date ||
            !formData.start_time ||
            !formData.end_time
        ) {
            alert("لطفا همه فیلدها را تکمیل کنید");
            return;
        }

        try {

            const token = localStorage.getItem("token");

            const response = await api.post(
                "/barber/service-schedules",
                formData,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json"
                    }
                }
            );

            console.log("پاسخ سرور:", response.data);

            alert("زمان رزرو با موفقیت ثبت شد");

            setFormData({
                service_id: "",
                available_date: "",
                start_time: "",
                end_time: "",
                slot_duration: 30
            });

        } catch (error) {

            console.log("خطای لاراول:");

            if (error.response) {
                console.log(error.response.data);
                alert(JSON.stringify(error.response.data));
            } else {
                console.log(error);
                alert("خطا در ارتباط با سرور");
            }
        }
    };

    return (
        <div className="bg-white p-6 rounded-xl shadow">

            <h2 className="text-xl font-bold mb-5">
                تعریف زمان‌های قابل رزرو
            </h2>

            <div className="space-y-4">

                <select
                    name="service_id"
                    value={formData.service_id}
                    onChange={handleChange}
                    className="w-full border rounded p-3"
                >
                    <option value="">
                        انتخاب خدمت
                    </option>

                    {services.map((service) => (
                        <option
                            key={service.id}
                            value={service.id}
                        >
                            {service.title}
                        </option>
                    ))}
                </select>

                <input
                    type="date"
                    name="available_date"
                    value={formData.available_date}
                    onChange={handleChange}
                    className="w-full border rounded p-3"
                />

                <input
                    type="time"
                    name="start_time"
                    value={formData.start_time}
                    onChange={handleChange}
                    className="w-full border rounded p-3"
                />

                <input
                    type="time"
                    name="end_time"
                    value={formData.end_time}
                    onChange={handleChange}
                    className="w-full border rounded p-3"
                />

                <select
                    name="slot_duration"
                    value={formData.slot_duration}
                    onChange={handleChange}
                    className="w-full border rounded p-3"
                >
                    <option value="30">
                        هر 30 دقیقه
                    </option>

                    <option value="60">
                        هر 60 دقیقه
                    </option>
                </select>

                <button
                    onClick={handleSave}
                    className="w-full bg-indigo-600 text-white py-3 rounded-lg"
                >
                    ذخیره زمان رزرو
                </button>

            </div>

        </div>
    );
};

export default BarberSchedule;