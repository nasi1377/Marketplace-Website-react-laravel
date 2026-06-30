import React, { useState } from "react";
import axios from "axios";
import api from "../api";



const Login = () => {
    const [formData, setFormData] = useState({
        mobile: "",
        password: "",
    });

    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();

        setLoading(true);

        try {
            const response = await api.post(
                "/login",
                formData
            );

            if (response.data.status === "success") {
                const { token, user } =
                    response.data;

                // ذخیره توکن
                localStorage.setItem(
                    "token",
                    token
                );

                // ذخیره کل اطلاعات کاربر
                localStorage.setItem(
                    "user",
                    JSON.stringify(user)
                );

                // ذخیره جداگانه برای دسترسی سریع
                localStorage.setItem(
                    "user_id",
                    user.id
                );

                localStorage.setItem(
                    "role_id",
                    user.role_id
                );

                // تنظیم هدر Authorization
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${token}`;

                // انتقال به پنل مربوطه
                handleRedirect(user.role_id);
            }

            else if (
                response.data.status ===
                "verify_required"
            ) {
                window.location.href =
                    `/verify?mobile=${formData.mobile}`;
            }

        } catch (error) {
            console.error(error);

            if (
                error.response?.status === 419
            ) {
                alert(
                    "خطای امنیتی رخ داده است. لطفاً مجدداً تلاش کنید."
                );
            }

            else if (
                error.response?.data?.message
            ) {
                alert(
                    error.response.data.message
                );
            }

            else {
                alert(
                    "شماره موبایل یا رمز عبور اشتباه است."
                );
            }
        } finally {
            setLoading(false);
        }
    };

    const handleRedirect = (roleId) => {

        switch (roleId) {

            case 1:
                window.location.href =
                    "/admin";
                break;

            case 2:
                window.location.href =
                    "/desktop";
                break;

            case 3:
                window.location.href =
                    "/supplier";
                break;

            case 4:
                window.location.href =
                    "/barber";
                break;

            default:
                window.location.href = "/";
        }
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">

            <form
                onSubmit={handleSubmit}
                className="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md"
            >
                <h2 className="text-2xl font-bold text-center mb-6">
                    ورود به حساب کاربری
                </h2>

                <input
                    type="text"
                    placeholder="شماره موبایل"
                    value={formData.mobile}
                    onChange={(e) =>
                        setFormData({
                            ...formData,
                            mobile:
                                e.target.value,
                        })
                    }
                    className="w-full border p-3 rounded-lg mb-4"
                    required
                />

                <input
                    type="password"
                    placeholder="رمز عبور"
                    value={formData.password}
                    onChange={(e) =>
                        setFormData({
                            ...formData,
                            password:
                                e.target.value,
                        })
                    }
                    className="w-full border p-3 rounded-lg mb-6"
                    required
                />

                <button
                    type="submit"
                    disabled={loading}
                    className="w-full bg-[#8B5E3C] text-white py-3 rounded-lg"
                >
                    {loading
                        ? "در حال ورود..."
                        : "ورود"}
                </button>
            </form>

        </div>
    );
};

export default Login;