import { useParams, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import api from "../api";


function CourseDetail() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [course, setCourse] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8000/api/courses/${id}`)
            .then(res => {
                setCourse(res.data);
            })
            .catch(err => {
                console.log(err);
            });
    }, [id]);

    const handleRegister = async () => {
        if (!course) return;
        
        try {
            setLoading(true);
            const response = await api.post(`/user/courses-register`, {
                course_id: id
            });
            
            alert("ثبت نام با موفقیت انجام شد!");
            navigate("/desktop");
            
        } catch (err) {
            console.error(err);
            alert("خطا در ثبت نام. لطفاً دوباره تلاش کنید.");
        } finally {
            setLoading(false);
        }
    };

    if (!course) {
        return <div className="text-center mt-10">در حال بارگذاری...</div>;
    }

    return (
        <div className="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-10">
            
            {course.image ? (
                <img
                    src={`http://127.0.0.1:8000/storage/${course.image}`}
                    alt={course.title}
                    className="w-full h-96 object-cover rounded-xl mb-6"
                />
            ) : (
                <div className="w-full h-96 bg-gray-200 rounded-xl flex items-center justify-center mb-6">
                    تصویر ندارد
                </div>
            )}

            <h1 className="text-3xl font-bold mb-4 text-gray-800">
                {course.title}
            </h1>

            <div className="prose max-w-none text-gray-600 mb-8">
                <p>{course.description}</p>
            </div>

            <div className="mt-auto">
                <button
                    onClick={handleRegister}
                    disabled={loading}
                    className={`w-full py-4 px-6 rounded-lg text-lg font-bold transition-all duration-300 flex items-center justify-center gap-2
                        ${loading 
                            ? "bg-gray-400 cursor-not-allowed text-white" 
                            : "bg-green-600 hover:bg-green-700 hover:shadow-lg text-white transform hover:-translate-y-1"
                        }`}
                >
                    {loading ? (
                        <>
                            <span className="animate-spin">⏳</span>
                            در حال پردازش...
                        </>
                    ) : (
                        <>
                            ثبت نام در دوره
                            <span>➔</span>
                        </>
                    )}
                </button>
            </div>

        </div>
    );
}

export default CourseDetail;