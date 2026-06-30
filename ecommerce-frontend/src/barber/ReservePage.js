import React, { useEffect, useState } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import api from "../api";


const ReservePage = () => {

    const { id } = useParams();
    const navigate = useNavigate();

    const [slots, setSlots] = useState([]);

    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8000/api/services/${id}/slots`)
            .then((res) => {
                setSlots(res.data.data);
            })
            .catch((err) => {
                console.error(err);
            });
    }, [id]);

    const handleReserve = async (slot) => {

    const token = localStorage.getItem("token");
    const roleId = localStorage.getItem("role_id");

    if (!token) {
        navigate("/login");
        return;
    }

    if (roleId !== "2") {
        alert("فقط کاربران عادی می‌توانند رزرو ثبت کنند");
        return;
    }

    try {

        await api.post(
            "/reservations",
            {
                service_id: id,
                schedule_id: slot.id
            },
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        );

        alert("رزرو با موفقیت ثبت شد");
        navigate("/desktop/reservations");

    } catch (error) {
        console.log(error.response?.data);
        alert("خطا در ثبت رزرو");
    }
};
    return (
        <div className="container mx-auto p-8">

            <h2 className="text-2xl font-bold mb-5">
                انتخاب زمان رزرو
            </h2>

            {slots.map((slot) => (

                <div
                    key={slot.id}
                    className="border rounded p-4 mb-3"
                >
                    <p>
                        تاریخ: {slot.available_date}
                    </p>

                    <p>
                        از: {slot.start_time}
                    </p>

                    <p>
                        تا: {slot.end_time}
                    </p>

                    <button
                        onClick={() => handleReserve(slot)}
                        className="bg-pink-600 text-white px-4 py-2 rounded mt-3"
                    >
                        انتخاب این زمان
                    </button>

                </div>

            ))}

        </div>
    );
};

export default ReservePage;