import React, { useEffect, useState, useContext } from "react";
import { useParams } from "react-router-dom";
import { CartContext } from "./layout/CartContext";
import { useNavigate } from "react-router-dom";
import api from "./api";


const ProductDetail = () => {
    const navigate = useNavigate();
    const { id } = useParams();

    const [product, setProduct] = useState(null);
    const [activeTab, setActiveTab] = useState("description");

    const { addToCart } = useContext(CartContext);

    useEffect(() => {
    api.get(`/product/${id}`)   // یا /products/${id} مطابق api.php
        .then((res) => {
            setProduct(res.data);
        })
        .catch((err) => {
            console.error(err);
        });
}, [id]);

    if (!product) {
        return (
            <div className="text-center py-20">
                در حال بارگذاری...
            </div>
        );
    }




    const handleAddToCart = async () => {

    const token = localStorage.getItem("token");

    if (!token) {
        navigate("/login");
        return;
    }

    try {

        await api.post(
            "/cart/add",
            {
                product_id: product.id
            },
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json"
                }
            }
        );

        // اضافه شدن به Context
        addToCart(product);

        alert("محصول به سبد خرید اضافه شد");

    } catch (error) {

        console.error(error);
        alert("خطا در افزودن به سبد خرید");
    }
};

    return (
<div className="container mx-auto px-4 py-10 text-right" dir="rtl">
            {/* بالا */}
            <div className="grid md:grid-cols-2 gap-10">

                {/* تصاویر */}
                <div>

                    <img
                        src={`/storage/${product.image}`}
                        alt={product.name}
                        className="w-full h-[550px] object-cover rounded-xl shadow"
                    />

                </div>

                {/* اطلاعات */}
                <div className="text-right">

                    <h1 className="text-4xl font-bold text-[#8B5E3C]">
                        {product.name}
                    </h1>

                    <div className="mt-6">
                        <span className="text-3xl font-bold text-[#8B5E3C]">
                            {Number(product.price).toLocaleString()}
                            تومان
                        </span>
                    </div>

                    <hr className="my-8" />

                    <div>
                        <h3 className="font-bold mb-3">
                            بررسی کوتاه:
                        </h3>

                        <p className="text-gray-600 leading-8">
                            {product.short_description ||
                                product.description?.substring(0, 120)}
                        </p>
                    </div>

                    <button
    onClick={handleAddToCart}
                        className="
                            mt-10
                            w-full
                            bg-[#8B5E3C]
                            text-white
                            py-4
                            rounded-lg
                            font-bold
                            hover:opacity-90
                        "
                    >
                        افزودن به سبد خرید
                    </button>

                </div>

            </div>

            {/* تب ها */}
            <div className="mt-20">

                <div className="flex justify-end gap-2 border-b pb-3">

                    <button
                        onClick={() =>
                            setActiveTab("description")
                        }
                        className={`px-6 py-3 rounded-lg ${
                            activeTab === "description"
                                ? "bg-[#8B5E3C] text-white"
                                : "bg-gray-100"
                        }`}
                    >
                        توضیحات
                    </button>

                    <button
                        onClick={() =>
                            setActiveTab("details")
                        }
                        className={`px-6 py-3 rounded-lg ${
                            activeTab === "details"
                                ? "bg-[#8B5E3C] text-white"
                                : "bg-gray-100"
                        }`}
                    >
                        اطلاعات تکمیلی
                    </button>

                    <button
                        onClick={() =>
                            setActiveTab("comments")
                        }
                        className={`px-6 py-3 rounded-lg ${
                            activeTab === "comments"
                                ? "bg-[#8B5E3C] text-white"
                                : "bg-gray-100"
                        }`}
                    >
                        نظرات
                    </button>

                </div>

                <div className="bg-[#F8F3F0] rounded-xl p-8 mt-6 text-right min-h-[200px]">

                    {activeTab === "description" && (
                        <div className="leading-9 text-gray-700">
                            {product.description}
                        </div>
                    )}

                    {activeTab === "details" && (
                        <div className="space-y-4">

                            <div>
                                <strong>نام محصول:</strong>
                                {" "}
                                {product.name}
                            </div>

                            <div>
                                <strong>قیمت:</strong>
                                {" "}
                                {Number(product.price).toLocaleString()}
                                تومان
                            </div>

                        </div>
                    )}

                    {activeTab === "comments" && (
                        <div className="text-gray-500">
                            هنوز نظری ثبت نشده است.
                        </div>
                    )}

                </div>

            </div>

        </div>
    );
};

export default ProductDetail;