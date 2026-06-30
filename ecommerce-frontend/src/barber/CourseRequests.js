import React, { useEffect, useState } from "react";
import axios from "axios";
import api from "../api";


const CourseRequests = () => {
    const [requests, setRequests] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        loadRequests();
    }, []);

    const loadRequests = async () => {
        try {
            const token = localStorage.getItem("token");

            const res = await api.get(
                "barber/course-requests",
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }
            );

            setRequests(res.data); 
        } catch (err) {
            console.error("Error loading requests:", err);
        } finally {
            setLoading(false);
        }
    };

    const updateStatus = async (id, status) => {
        try {
            const token = localStorage.getItem("token");

            await axios.put(
                `http://127.0.0.1:8000/api/barber/course-requests/${id}`,
                { status },
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }
            );

            loadRequests(); // refresh list
        } catch (err) {
            console.error("Error updating status:", err);
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
            <h2 className="text-xl font-bold mb-4">
                درخواست‌های ثبت نام دوره
            </h2>

            {requests.length === 0 ? (
                <p className="text-gray-500">
                    هیچ درخواستی وجود ندارد
                </p>
            ) : (
                requests.map((item) => (
                    <div
                        key={item.id}
                        className="border rounded-lg p-4 mb-3"
                    >
                        <h3 className="font-bold">
                            {item.course_title}
                        </h3>

                        <p>
                            هنرجو: {item.student_name}
                        </p>

                        <p>
                            وضعیت:{" "}
                            <span
                                className={
                                    item.status === "pending"
                                        ? "text-yellow-600"
                                        : item.status === "approved"
                                        ? "text-green-600"
                                        : "text-red-600"
                                }
                            >
                                {item.status}
                            </span>
                        </p>

                        {item.status === "pending" && (
                            <div className="flex gap-2 mt-3">
                                <button
                                    onClick={() =>
                                        updateStatus(item.id, "approved")
                                    }
                                    className="bg-green-600 text-white px-4 py-2 rounded"
                                >
                                    تایید
                                </button>

                                <button
                                    onClick={() =>
                                        updateStatus(item.id, "rejected")
                                    }
                                    className="bg-red-600 text-white px-4 py-2 rounded"
                                >
                                    رد
                                </button>
                            </div>
                        )}
                    </div>
                ))
            )}
        </div>
    );
};

export default CourseRequests;