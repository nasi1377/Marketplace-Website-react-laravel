import React, { useState } from 'react';
import api from "../api";


const AddCourse = ({ userId }) => {
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [image, setImage] = useState(null);
    const [preview, setPreview] = useState(null);
    const [loading, setLoading] = useState(false);

    const handleImageChange = (e) => {
        const file = e.target.files[0];

        if (file) {
            setImage(file);
            setPreview(URL.createObjectURL(file));
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            setLoading(true);

            const token = localStorage.getItem('token');

            const formData = new FormData();

            formData.append('user_id', userId);
            formData.append('title', title);
            formData.append('description', description);

            if (image) {
                formData.append('image', image);
            }

            const response = await api.post(
                '/barber/courses',
                formData,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                }
            );

            console.log(response.data);

            alert('دوره با موفقیت ثبت و برای تایید ادمین ارسال شد');

            setTitle('');
            setDescription('');
            setImage(null);
            setPreview(null);

        } catch (error) {
            console.error(error);

            alert(
                error.response?.data?.message ||
                'خطا در ثبت دوره'
            );
        } finally {
            setLoading(false);
        }
    };
    

    return (
        <div className="max-w-3xl mx-auto">
            <h2 className="text-2xl font-bold mb-6 text-center">
                افزودن دوره آموزشی
            </h2>

            <form onSubmit={handleSubmit} className="space-y-5">

                <div>
                    <label className="block mb-2">
                        عنوان دوره
                    </label>

                    <input
                        type="text"
                        value={title}
                        onChange={(e) => setTitle(e.target.value)}
                        className="w-full border rounded-xl p-3"
                        required
                    />
                </div>

                <div>
                    <label className="block mb-2">
                        توضیحات دوره
                    </label>

                    <textarea
                        rows="5"
                        value={description}
                        onChange={(e) => setDescription(e.target.value)}
                        className="w-full border rounded-xl p-3"
                        required
                    />
                </div>

                <div>
                    <label className="block mb-2">
                        تصویر دوره
                    </label>

                    <input
                        type="file"
                        accept="image/*"
                        onChange={handleImageChange}
                    />
                </div>

                {preview && (
                    <img
                        src={preview}
                        alt="preview"
                        className="w-full max-h-80 object-cover rounded-lg"
                    />
                )}

                <button
                    type="submit"
                    disabled={loading}
                    className="w-full bg-green-600 text-white py-3 rounded-xl"
                >
                    {loading ? 'در حال ثبت...' : 'ثبت دوره'}
                </button>

            </form>
        </div>
    );
};

export default AddCourse;