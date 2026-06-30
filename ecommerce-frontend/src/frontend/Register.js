import React, { useState } from 'react';
import api from "../api";

const Register = () => {
    const [formData, setFormData] = useState({
        name: '',
        family: '',
        mobile: '',
        password: '',
        role_id: 2, 
        check_law: false,
        document: null
    });

    const [errors, setErrors] = useState({});
    const [showPassword, setShowPassword] = useState(false);
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState({ type: '', text: '' });

    // مدیریت تغییرات ورودی‌های متنی و چک‌باکس
    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        let finalValue = value;

        if (type === 'checkbox') finalValue = checked;
        if (name === 'role_id') finalValue = parseInt(value);

        setFormData({
            ...formData,
            [name]: finalValue
        });

        // پاک کردن خطای مربوط به فیلد در حال تایپ
        if (errors[name]) {
            setErrors({ ...errors, [name]: null });
        }
    };

    // مدیریت انتخاب فایل
    const handleFileChange = (e) => {
        setFormData({
            ...formData,
            document: e.target.files[0]
        });
        if (errors.document) setErrors({ ...errors, document: null });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setErrors({});
        setMessage({ type: '', text: '' });

        const data = new FormData();
        data.append('name', formData.name);
        data.append('family', formData.family);
        data.append('mobile', formData.mobile);
        data.append('password', formData.password);
        data.append('role_id', formData.role_id);
        
        if (formData.role_id !== 2 && formData.document) {
            data.append('document', formData.document);
        }

        try {
            const response = await api.post('/register', data, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            setMessage({ type: 'success', text: 'ثبت‌نام با موفقیت انجام شد! در حال انتقال...' });
            
            // اینجا می‌تونی کاربر رو ریدایرکت کنی
            // setTimeout(() => window.location.href = '/login', 2000);

        } catch (err) {
            if (err.response && err.response.status === 422) {
                setErrors(err.response.data.errors);
            } else {
                setMessage({ type: 'error', text: 'خطایی در سیستم رخ داده است. مجدداً تلاش کنید.' });
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <section className="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
            <div className="max-w-4xl w-full space-y-8 flex flex-col md:flex-row items-center">
                
                {/* بخش تصویر */}
                <div className="md:w-1/2 p-4 hidden md:block">
                    <img src="/assets/images/user/signup.svg" alt="Signup" className="w-full h-auto" />
                </div>

                {/* بخش فرم */}
                <div className="md:w-1/2 w-full bg-white p-8 rounded-lg shadow-lg border border-gray-100 text-right" dir="rtl">
                    <h4 className="text-center text-2xl font-bold mb-6" style={{ color: '#6F4E37' }}>ثبت نام در سامانه</h4>

                    {message.text && (
                        <div className={`p-3 rounded mb-4 text-sm ${message.type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>
                            {message.text}
                        </div>
                    )}

                    <form onSubmit={handleSubmit} className="space-y-4">
                        
                        {/* انتخاب نقش */}
                        <div className="bg-gray-50 p-3 rounded-md border border-gray-200">
                            <label className="block text-sm font-bold mb-3" style={{ color: '#6F4E37' }}>نقش کاربری:</label>
                            <div className="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                {[
                                    { id: 2, label: 'کاربر عادی' },
                                    { id: 3, label: 'تأمین کننده' },
                                    { id: 4, label: 'آرایشگر' }
                                ].map((role) => (
                                    <label key={role.id} className="flex items-center cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="role_id" 
                                            value={role.id} 
                                            checked={formData.role_id === role.id} 
                                            onChange={handleChange} 
                                            className="ml-2 accent-[#6F4E37]" 
                                        />
                                        <span className="text-sm">{role.label}</span>
                                    </label>
                                ))}
                            </div>
                        </div>

                        {/* فیلد آپلود فایل */}
                        {formData.role_id !== 2 && (
                            <div className="bg-orange-50 p-3 rounded-md border border-orange-200">
                                <label className="block text-sm font-bold mb-1 text-orange-800">آپلود مدرک یا جواز کسب <span className="text-red-500">*</span></label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={handleFileChange}
                                    className="block w-full text-sm text-gray-500 file:ml-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                                    required
                                />
                                {errors.document && <p className="text-red-500 text-[11px] mt-1">{errors.document[0]}</p>}
                            </div>
                        )}

                        {/* فیلد نام و فامیلی */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">نام</label>
                                <input type="text" name="name" onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-mocha outline-none" required />
                                {errors.name && <p className="text-red-500 text-[11px] mt-1">{errors.name[0]}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700">نام خانوادگی</label>
                                <input type="text" name="family" onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-mocha outline-none" required />
                                {errors.family && <p className="text-red-500 text-[11px] mt-1">{errors.family[0]}</p>}
                            </div>
                        </div>

                        {/* موبایل */}
                        <div>
                            <label className="block text-sm font-medium text-gray-700">شماره موبایل</label>
                            <input 
                                type="text" 
                                name="mobile" 
                                placeholder="09123456789"
                                onChange={handleChange} 
                                className="mt-1 block w-full border border-gray-300 rounded-md p-2 text-left dir-ltr focus:ring-mocha outline-none" 
                                required 
                            />
                            {errors.mobile && <p className="text-red-500 text-[11px] mt-1">{errors.mobile[0]}</p>}
                        </div>

                        {/* رمز عبور */}
                        <div className="relative">
                            <label className="block text-sm font-medium text-gray-700">رمز عبور</label>
                            <div className="relative">
                                <input 
                                    type={showPassword ? "text" : "password"} 
                                    name="password" 
                                    onChange={handleChange} 
                                    className="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-mocha outline-none" 
                                    required 
                                />
                                <button 
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    className="absolute inset-y-0 left-0 pl-3 flex items-center text-sm text-gray-500"
                                >
                                    {showPassword ? "پنهان" : "نمایش"}
                                </button>
                            </div>
                            {errors.password && <p className="text-red-500 text-[11px] mt-1">{errors.password[0]}</p>}
                        </div>

                        {/* دکمه ثبت نام */}
                        <button 
                            type="submit" 
                            disabled={loading}
                            className={`w-full py-3 px-4 rounded-md shadow-sm text-white font-bold transition-all ${loading ? 'bg-gray-400' : 'hover:bg-opacity-90'}`}
                            style={{ backgroundColor: '#967969' }}
                        >
                            {loading ? 'در حال ارسال اطلاعات...' : 'تکمیل ثبت‌نام و ارسال'}
                        </button>
                    </form>
                </div>
            </div>
        </section>
    );
};

export default Register;
