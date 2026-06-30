import React, { useState } from 'react';
import api from "../api";
const AddProductForm = ({ userId }) => {
  const [loading, setLoading] = useState(false);
  const [formData, setFormData] = useState({
    name: '', price: '', stock: '', excerpt: '', body: '', image: null
  });
  console.log("User ID prop:", userId); 

 const handleSubmit = async (e) => {
  e.preventDefault();
  setLoading(true);
  
  const token = localStorage.getItem('token');
  if (!token) {
      alert("لطفاً ابتدا وارد حساب کاربری خود شوید.");
      window.location.href = '/login'; 
      setLoading(false);
      return;
  }
  // userId احتمالا از props میاد، پس باید چک بشه
  if (!userId) {
      alert("شناسه کاربری یافت نشد. لطفاً دوباره وارد شوید.");
      window.location.href = '/login'; 
      setLoading(false);
      return;
  }

  const data = new FormData();
  Object.keys(formData).forEach(key => {
    if (formData[key] !== null && formData[key] !== '') {
      data.append(key, formData[key]);
    }
  });
  // user_id که به بک‌اند ارسال میشه (مهم!)
  // اگر auth()->id() در بک‌اند استفاده میشه، این data.append('user_id', userId) شاید اضافه باشه
  // ولی چون در بک‌اند supplier_id استفاده شده، شاید نیاز نباشه اینو بفرستی
  // یا اگر هم فرستادی، توی بک‌اند اون supplier_id رو از auth()->id() بگیره نه از request
  
  // فعلا مطابق کد قبلی میفرستیم:
  data.append('user_id', userId); 

  try {
    // استفاده از URL کامل یا base URL تنظیم شده
    const response = await api.post('/supplier/products/store', data, {
      headers: { 
        'Authorization': `Bearer ${token}`, 
      }
    });

    console.log("Server Response:", response.data); 

    // *** کلید status رو چک کن ***
    if (response.data.status === 'success') {
      alert('محصول با موفقیت ثبت شد');
      setFormData({ name: '', price: '', stock: '', excerpt: '', body: '', image: null });
    } else if (response.data.status === 'error') {
       // اگر بک‌اند status error برگردوند
       alert('خطا در ثبت محصول: ' + (response.data.message || 'خطای ناشناخته'));
    }
     else {
      // اگر response.data.status وجود نداشت یا مقدار دیگری داشت
      alert('ثبت محصول با مشکلی مواجه شد. وضعیت نامشخص.');
    }

  } catch (error) {
    console.error("Catch Error details:", error.response?.data || error.message);
    let errorMessage = 'خطای ارتباطی یا سرور';
    if (error.response?.data?.message) {
        errorMessage = error.response.data.message;
    } else if (error.response?.data?.errors) {
        errorMessage = Object.values(error.response.data.errors).flat().join(' ');
    } else if (error.message) {
        errorMessage = error.message;
    }
    // اگه خطا از سمت کاربر بود، ممکنه بخوایم message خاصی نمایش بدیم
    alert('خطا در ثبت محصول: ' + errorMessage);
  } finally {
    setLoading(false);
  }
};

  // ... (بقیه کد فرم مثل قبل)
  return (
    <form onSubmit={handleSubmit} className="w-full max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md space-y-4">
      <h2 className="text-xl font-bold text-center text-gray-700 mb-4">ثبت محصول جدید</h2>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label htmlFor="name" className="block text-sm font-medium text-gray-700">نام محصول</label>
          <input 
            type="text" 
            id="name"
            placeholder="نام محصول" 
            className="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value={formData.name} 
            onChange={(e) => setFormData({...formData, name: e.target.value})} 
            required 
          />
        </div>
        <div>
          <label htmlFor="price" className="block text-sm font-medium text-gray-700">قیمت (تومان)</label>
          <input 
            type="number" 
            id="price"
            placeholder="قیمت" 
            className="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value={formData.price} 
            onChange={(e) => setFormData({...formData, price: e.target.value})} 
            required 
          />
        </div>
      </div>
      <div>
         <label htmlFor="stock" className="block text-sm font-medium text-gray-700">موجودی انبار</label>
         <input 
           type="number" 
           id="stock"
           placeholder="موجودی" 
           className="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
           value={formData.stock} 
           onChange={(e) => setFormData({...formData, stock: e.target.value})} 
         />
      </div>
      <div>
        <label htmlFor="excerpt" className="block text-sm font-medium text-gray-700">توضیحات کوتاه</label>
        <textarea 
          id="excerpt"
          placeholder="توضیحات کوتاه" 
          className="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          value={formData.excerpt} 
          onChange={(e) => setFormData({...formData, excerpt: e.target.value})} 
        />
      </div>
      <div>
        <label htmlFor="image" className="block text-sm font-medium text-gray-700">تصویر محصول</label>
        <input 
          type="file" 
          id="image"
          onChange={(e) => setFormData({...formData, image: e.target.files[0]})} 
          className="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" 
          required 
        />
        {formData.image && <p className="text-sm text-gray-500 mt-1">فایل انتخاب شده: {formData.image.name}</p>}
      </div>
      <button 
        type="submit" 
        disabled={loading} 
        className={`w-full py-2 px-4 rounded-md font-semibold text-white transition duration-200 
          ${loading ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'}`}
      >
        {loading ? 'در حال ارسال...' : 'ثبت محصول'}
      </button>
    </form>
  );
};

export default AddProductForm;
