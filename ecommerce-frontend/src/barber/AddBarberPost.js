import React, { useState } from 'react';
import api from "../api";

const AddBarberPost = ({ userId }) => {
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [price, setPrice] = useState(''); // اضافه کردن استیت قیمت
    const [image, setImage] = useState(null);
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState('');

    const handleUpload = async () => {
        // چک کردن فیلد قیمت در اعتبارسنجی اولیه
        if (!title || !image || !price) {
            alert("لطفاً عنوان، قیمت و عکس رو انتخاب کن!");
            return;
        }

        setLoading(true);
        const token = localStorage.getItem('token'); // دریافت توکن برای رفع مشکل 401 احتمالی

        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('price', price); // اضافه شدن قیمت به ارسال
        formData.append('image', image);
        formData.append('user_id', userId);
        formData.append('status', 'pending');

        try {
            await api.post('/posts', formData, {
                headers: { 
                    'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}` // اضافه کردن توکن
                }
            });
            setMessage('✅ پست با موفقیت ثبت شد و پس از تأیید ادمین نمایش داده می‌شود.');
            setTitle('');
            setDescription('');
            setPrice(''); // خالی کردن فیلد قیمت بعد از موفقیت
            setImage(null);
        } catch (error) {
            console.error("خطا در ثبت پست:", error);
            // نمایش پیام دقیق خطای ولیدیشن اگر از سمت سرور بیاد
            if (error.response && error.response.data.errors) {
                setMessage('❌ خطا: ' + Object.values(error.response.data.errors)[0]);
            } else {
                setMessage('❌ خطایی رخ داد، دوباره تلاش کن.');
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="space-y-4">
            <h2 className="text-xl font-semibold">ثبت نمونه‌کار جدید</h2>
            
            {message && <div className={`p-3 rounded-lg ${message.includes('✅') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                {message}
            </div>}

            <div className="grid grid-cols-1 gap-4">
                <input 
                    type="text" 
                    placeholder="عنوان نمونه‌کار (مثلاً: سایه حرفه‌ای)" 
                    className="border p-2 rounded-lg outline-none focus:border-blue-500"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                />

                {/* فیلد جدید قیمت */}
                <input 
                    type="number" 
                    placeholder="قیمت خدمات (تومان)" 
                    className="border p-2 rounded-lg outline-none focus:border-blue-500"
                    value={price}
                    onChange={(e) => setPrice(e.target.value)}
                />

                <textarea 
                    placeholder="توضیحات کوتاه..." 
                    className="border p-2 rounded-lg h-32 outline-none focus:border-blue-500"
                    value={description}
                    onChange={(e) => setDescription(e.target.value)}
                ></textarea>
                
                <div className="flex flex-col gap-2">
                    <label className="text-sm text-gray-600">انتخاب عکس نمونه‌کار:</label>
                    <input 
                        type="file" 
                        accept="image/*"
                        className="border p-2 rounded-lg cursor-pointer"
                        onChange={(e) => setImage(e.target.files[0])}
                    />
                </div>

                <button 
                    onClick={handleUpload}
                    disabled={loading}
                    className={`bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition ${loading ? 'opacity-50' : ''}`}
                >
                    {loading ? 'در حال ارسال...' : 'ارسال جهت تأیید ادمین'}
                </button>
            </div>
        </div>
    );
};

export default AddBarberPost;
