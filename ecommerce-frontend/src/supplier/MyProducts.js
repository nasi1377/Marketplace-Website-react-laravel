import React, { useState, useEffect } from 'react';
import api from "../api";

const MyProducts = () => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchProducts = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await api.get('/supplier/my-products', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                
                setProducts(response.data);
                setLoading(false);
            } catch (error) {
                console.error("خطا در دریافت محصولات:", error);
                setLoading(false);
            }
        };

        fetchProducts();
    }, []);

    if (loading) return <div>در حال بارگذاری محصولات...</div>;

    return (
        <div className="p-4">
            <h2 className="text-xl font-bold mb-4">محصولات من</h2>
            <div className="grid grid-cols-3 gap-4">
                {products.length > 0 ? (
                    products.map((product) => (
                        <div key={product.id} className="border p-2 rounded shadow">
                            <img 
                                src={`http://localhost:8000/storage/${product.image}`} 
                                alt={product.name} 
                                className="w-full h-32 object-cover" 
                            />
                            <h3 className="font-bold mt-2">{product.name}</h3>
                            <p>قیمت: {product.price} تومان</p>

                            {/* --- اینجا اضافه شد --- */}
                            <span className={`text-sm ${product.status === 'approved' ? 'text-green-500' : 'text-orange-500'}`}>
                                وضعیت: {product.status === 'approved' ? 'تایید شده' : 'در انتظار تایید'}
                            </span>
                            {/* ---------------------- */}

                        </div>
                    ))
                ) : (
                    <p>هنوز هیچ محصولی ثبت نکردی.</p>
                )}
            </div>
        </div>
    );
};

export default MyProducts;
