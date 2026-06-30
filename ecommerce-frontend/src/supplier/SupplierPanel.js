import React, { useEffect, useState } from 'react';
import SupplierSidebar from './SupplierSidebar';
import AddProductForm from './AddProductForm';
import MyProducts from './MyProducts';
import SupplierOrders from './SupplierOrders';

const SupplierPanel = () => {
    const [activeTab, setActiveTab] = useState('my-products');
    const [userId, setUserId] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const roleId = localStorage.getItem('role_id');
        const storedUserId = localStorage.getItem('user_id');

        if (roleId !== "3") {
            alert("دسترسی غیرمجاز! شما تامین‌کننده نیستید.");
            window.location.href = '/login';
            return;
        }

        if (storedUserId) {
            setUserId(storedUserId);
        }

        setLoading(false);
    }, []);

    if (loading) {
        return (
            <div className="text-center p-10">
                در حال بررسی دسترسی...
            </div>
        );
    }

    if (!userId) {
        return (
            <div className="text-center p-10">
                اطلاعات کاربر یافت نشد
            </div>
        );
    }

    return (
        <div className="flex flex-row-reverse bg-gray-50 min-h-screen">

            <SupplierSidebar
                activeTab={activeTab}
                setActiveTab={setActiveTab}
            />

            <main className="flex-1 p-8">

                {activeTab === 'add-product' && (
                    <AddProductForm userId={userId} />
                )}

                {activeTab === 'my-products' && (
                    <MyProducts userId={userId} />
                )}

                {activeTab === 'my-orders' && (
                    <SupplierOrders userId={userId} />
                )}

            </main>

        </div>
    );
};

export default SupplierPanel;