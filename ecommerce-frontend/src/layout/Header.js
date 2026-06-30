import React, { useContext, useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "../api";
import { CartContext } from "./CartContext";

const CartIcon = () => (
    <svg
        xmlns="http://www.w3.org/2000/svg"
        className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth={2}
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 4h12M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"
        />
    </svg>
);

const Header = () => {
    const { cart } = useContext(CartContext);

    const [menus, setMenus] = useState([]);

    useEffect(() => {
        api
            .get("/menus")
            .then((res) => {
                setMenus(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    }, []);

    const totalItems = cart.reduce(
        (sum, item) => sum + item.quantity,
        0
    );

    const user = JSON.parse(
        localStorage.getItem("user")
    );

    const logout = () => {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        localStorage.removeItem("user_id");
        localStorage.removeItem("role_id");

        window.location.href = "/";
    };

    const getProfileLink = () => {
        const roleId = Number(
            localStorage.getItem("role_id")
        );

        switch (roleId) {
            case 1:
                return "/admin";

            case 2:
                return "/desktop";

            case 3:
                return "/supplier";

            case 4:
                return "/barber";

            default:
                return "/profile";
        }
    };

    return (
<header className=" shadow-md sticky top-0 z-50">
                <div className="container mx-auto px-4 py-3 flex items-center justify-between">

                {/* راست */}
                <div className="flex items-center gap-4">

                    <Link
                        to="/cart"
                        className="relative text-gray-700 hover:text-yellow-800"
                    >
                        <CartIcon />

                        <span className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {totalItems}
                        </span>
                    </Link>

                    {user ? (
                        <div className="flex items-center gap-3 border-r pr-4 mr-2">

                            <Link
                                to={getProfileLink()}
                                className="font-bold text-[#8B5E3C]"
                            >
                                {user.name}
                                {user.family
                                    ? ` ${user.family}`
                                    : ""}
                            </Link>

                            <button
                                onClick={logout}
                                className="text-sm text-red-500"
                            >
                                خروج
                            </button>

                        </div>
                    ) : (
                        <div className="hidden sm:flex items-center gap-2 border-r pr-4 mr-2">

                            <Link
                                to="/login"
                                className="text-gray-600 hover:text-gray-900 font-medium"
                            >
                                ورود
                            </Link>

                            <span className="text-gray-300">
                                |
                            </span>

                            <Link
                                to="/register"
                                className="text-black px-4 py-1.5 rounded-lg hover:bg-black-900"
                            >
                                ثبت نام
                            </Link>

                        </div>
                    )}
                </div>

                {/* منوها از دیتابیس */}
             <nav className="hidden md:flex items-center gap-8 text-gray-700 font-medium">

    {menus.map((item) => (
        <a
            key={item.id}
            href={item.url}
            target={item.target || "_self"}
            className="text-black no-underline"
        >
            {item.title}
        </a>
    ))}

</nav>

                {/* لوگو */}
                <div className="flex items-center">
                        <Link to="/">
    <img
  src="https://banogol.com/storage/settings/logo-dark.png"
        alt=""
        className="w-20 h-20 object-contain"
    />
</Link>
                </div>

            </div>
        </header>
    );
};

export default Header;