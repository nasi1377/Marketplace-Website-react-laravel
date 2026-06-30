import React from 'react';

const SupplierSidebar = ({ activeTab, setActiveTab }) => {
  const menuItems = [
    { id: 'add-product', label: 'افزودن محصول', icon: '➕' },
    { id: 'my-products', label: 'محصولات من', icon: '📦' },
    { id: 'my-orders', label: 'سفارشات فروش', icon: '💰' },
  ];

  return (
    <div className="w-64 bg-slate-800 h-screen text-white p-5 sticky  right-0 shadow-xl">
      <div className="text-center mb-10">
        <h2 className="text-xl font-bold text-orange-400">پنل تامین‌کننده</h2>
        <p className="text-xs text-slate-400 mt-1">مدیریت محصولات نارنید</p>
      </div>
      
      <nav>
        {menuItems.map(item => (
          <button
            key={item.id}
            onClick={() => setActiveTab(item.id)}
            // در اینجا از button استفاده کردیم تا ارور anchor-is-valid ایجاد نشه
            className={`w-full text-right p-3 mb-3 rounded-lg flex items-center gap-3 transition-all duration-300 ${
              activeTab === item.id 
              ? 'bg-orange-500 shadow-lg shadow-orange-900/20' 
              : 'hover:bg-slate-700 text-slate-300 hover:text-white'
            }`}
          >
            <span className="text-lg">{item.icon}</span>
            <span className="font-medium">{item.label}</span>
          </button>
        ))}
      </nav>
      
      <div className="absolute bottom-5 right-5 left-5">
        <button className="w-full bg-slate-700 p-2 rounded text-sm hover:bg-red-600 transition">
          خروج از پنل
        </button>
      </div>
    </div>
  );
};

// این خط خیلی مهمه و باعث حل ارور export 'default' می‌شه:
export default SupplierSidebar;
