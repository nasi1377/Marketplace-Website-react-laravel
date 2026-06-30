import React, { useState, useEffect } from 'react';
// استفاده از نمونه تنظیم‌شده axios که توکن رو خودکار اضافه می‌کنه
import api from '../api'; 

const PostApprovalList = () => {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);

    // 1. گرفتن لیست پست‌های در انتظار (Pending)
    const fetchPendingPosts = async () => {
        try {
            // استفاده از api به جای axios معمولی
            const res = await api.get('/admin/posts/pending');
            setPosts(res.data);
        } catch (err) {
            console.error("خطا در دریافت پست‌ها", err);
            // اینجا می‌تونی چک کنی اگه ارور 401 بود، کاربر رو هدایت کنی به صفحه لاگین
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchPendingPosts();
    }, []);

    // 2. تابع تایید یا رد کردن
    const handleAction = async (id, newStatus) => {
        try {
            // استفاده از api به جای axios معمولی
            await api.post(`/admin/posts/${id}/status`, {
                status: newStatus 
            });
            
            setPosts(posts.filter(post => post.id !== id));
            alert(newStatus === 'approved' ? "پست تایید و منتشر شد" : "پست رد شد");
        } catch (err) {
            console.error("خطا در تغییر وضعیت", err);
            alert("خطایی رخ داد، بررسی کن شاید دسترسی نداری!");
        }
    };

    if (loading) return <div className="p-5 text-center">در حال بارگذاری...</div>;

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            {posts.length === 0 ? (
                <p className="text-gray-500">هیچ پستی در صف انتظار نیست.</p>
            ) : (
                posts.map(post => (
                    <div key={post.id} className="bg-white border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                        <img 
                            src={`http://127.0.0.1:8000/storage/${post.image}`} 
                            className="w-full h-40 object-cover" 
                            alt="post"
                        />
                        
                        <div className="p-4">
                            <h3 className="font-bold text-lg text-gray-800">{post.title}</h3>
                            <p className="text-gray-600 text-sm mt-1 line-clamp-2">{post.content}</p>
                            
                            <div className="mt-4 flex items-center justify-between">
                                <span className="text-xs text-gray-400">
                                    فرستنده: <span className="text-blue-500 font-medium">{post.supplier?.name}</span>
                                </span>
                                <span className="px-2 py-1 bg-yellow-100 text-yellow-700 text-[10px] rounded-full">در انتظار تایید</span>
                            </div>

                            <div className="flex gap-2 mt-5">
                                <button 
                                    onClick={() => handleAction(post.id, 'approved')}
                                    className="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm font-bold transition"
                                >
                                    ✅ تایید و انتشار
                                </button>
                                <button 
                                    onClick={() => handleAction(post.id, 'rejected')}
                                    className="flex-1 bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-lg text-sm font-bold transition"
                                >
                                    ❌ رد کردن
                                </button>
                            </div>
                        </div>
                    </div>
                ))
            )}
        </div>
    );
};

export default PostApprovalList;
