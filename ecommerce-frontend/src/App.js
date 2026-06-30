import React, { useEffect, useState } from 'react';
import { BrowserRouter, Routes, Route, Navigate, useParams,Link  } from 'react-router-dom';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'font-awesome/css/font-awesome.min.css';
import BarberPanel from './barber/BarberPanel';
import Home from './frontend/Home';
import Login from './frontend/Login';
import Register from './frontend/Register';
import Header from './layout/Header';
import Footer from './layout/Footer';
import AdminDashboard from './admin/AdminDashboard';
import SupplierPanel from './supplier/SupplierPanel';
import UserDashboard from './user/UserDashboard';
import ProductDetail from './ProductDetail';
import Cart from './layout/Cart';
import ReservePage from "./barber/ReservePage";
import CourseDetail from "./barber/CourseDetail";
import ChatPage  from "./chat/ChatPage";
import api from './api';




axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

const CategoryPage = () => {
    const { slug } = useParams();

    const [products, setProducts] = useState([]);
    const [category, setCategory] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        setLoading(true);

                api.get(`/api/category/${slug}`)

        .then((res) => {
                setCategory(res.data.category);
                setProducts(res.data.products.data);
                setLoading(false);
            })
            .catch((err) => {
                console.error(err);
                setLoading(false);
            });
    }, [slug]);

    if (loading) {
        return <div className="text-center p-5">در حال بارگذاری...</div>;
    }

    if (!category) {
        return <div className="text-center p-5">دسته‌بندی پیدا نشد.</div>;
    }

    return (
        <div className="container mt-4">
            <h1 className="mb-4">{category.title}</h1>

            <hr />

            <div className="row">
                {products.length > 0 ? (
                    products.map((product) => (
                        <div key={product.id} className="col-md-3 mb-3">
                            <div className="card h-100 p-3 shadow-sm">
                                <h4>{product.name}</h4>

                                <p className="text-primary">
                                    {product.price?.toLocaleString()} تومان
                                </p>

                                <button className="btn btn-sm btn-outline-primary">
                                    مشاهده محصول
                                </button>
                            </div>
                        </div>
                    ))
                ) : (
                    <p className="p-3">
                        هیچ محصولی در این دسته پیدا نشد.
                    </p>
                )}
            </div>
        </div>
    );
};

function App() {
    return (
        <BrowserRouter>
            <Header />

            <Routes>

                {/* صفحه اصلی */}
                <Route path="/" element={<Home />} />

                {/* دسته‌بندی */}
                <Route
                    path="/category/:slug"
                    element={<CategoryPage />}
                />

                {/* ورود و ثبت نام */}
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />

                {/* جزئیات محصول */}
                <Route
                    path="/product/:id"
                    element={<ProductDetail />}
                />

                {/* سبد خرید */}
                <Route
                    path="/cart"
                    element={<Cart />}
                />

                {/* پنل آرایشگر */}
                <Route
                    path="/barber/*"
                    element={
                        localStorage.getItem('role_id') === '4'
                            ? <BarberPanel />
                            : <Navigate to="/login" />
                    }
                />

                {/* پنل ادمین */}
                <Route
                    path="/admin/*"
                    element={
                        localStorage.getItem('role_id') === '1'
                            ? <AdminDashboard />
                            : <Navigate to="/login" />
                    }
                />

                {/* پنل تامین‌کننده */}
                <Route
                    path="/supplier/*"
                    element={
                        localStorage.getItem('role_id') === '3'
                            ? <SupplierPanel />
                            : <Navigate to="/login" />
                    }
                />

                {/* پنل کاربر */}
                <Route
                    path="/desktop/*"
                    element={
                        localStorage.getItem('role_id') === '2'
                            ? <UserDashboard />
                            : <Navigate to="/login" />
                    }
                />
                <Route
    path="/reserve/:id"
    element={<ReservePage />}
/>
        <Route path="/chat" element={<ChatPage />} />

<Route
    path="/course/:id"
    element={<CourseDetail />}
/>
                {/* 404 */}

                <Route
                    path="*"
                    element={
                        <div className="text-center p-5">
                            <h1>404</h1>
                            <p>صفحه مورد نظر یافت نشد.</p>
                        </div>
                    }
                />

            </Routes>
 {/* 💬 دکمه چت ثابت */}
           <Link
  to="/chat"
  style={{
    position: "fixed",
    bottom: 20,
    right: 20,
    padding: "12px 20px",
    borderRadius: 30,
    background: "black",
    color: "white",
    textDecoration: "none",
    zIndex: 9999,
  }}
>
  💬 چت با ما
</Link>

            <Footer />
        </BrowserRouter>
    );
}

export default App;