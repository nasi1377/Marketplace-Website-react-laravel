import {
    useContext,
    useState,
    useEffect
} from "react";
import api from "../api";
import { CartContext } from "../layout/CartContext";

const Cart = () => {

    const {
        cart,
        increaseQuantity,
        decreaseQuantity,
        removeFromCart,
    } = useContext(CartContext);

    const [firstName, setFirstName] =
        useState("");

    const [lastName, setLastName] =
        useState("");

    const [address, setAddress] =
        useState("");

    const [loading, setLoading] =
        useState(false);

    useEffect(() => {

        const token =
            localStorage.getItem("token");

        if (!token) return;

api
            .get(
    "/user/profile",
                {
                    headers: {
                        Authorization:
                            `Bearer ${token}`,
                    },
                }
            )
            .then((res) => {

                setFirstName(
                    res.data.name || ""
                );

                setLastName(
                    res.data.family || ""
                );

                setAddress(
                    res.data.address || ""
                );
            })
            .catch((err) => {
                console.log(err);
            });

    }, []);

    const updateProfile = async () => {

        const token =
            localStorage.getItem("token");

        try {

            setLoading(true);

            await api.post(
    "/user/update-profile",
                {
                    name: firstName,
                    family: lastName,
                    address: address,
                },
                {
                    headers: {
                        Authorization:
                            `Bearer ${token}`,
                    },
                }
            );

            alert(
                "اطلاعات با موفقیت بروزرسانی شد"
            );

        } catch (error) {

            console.log(error);

            alert(
                "خطا در بروزرسانی اطلاعات"
            );

        } finally {
            setLoading(false);
        }
    };

    const total = cart.reduce(
        (sum, item) =>
            sum +
            Number(item.price || 0) *
                item.quantity,
        0
    );

    return (
        <div
            className="container mx-auto px-4 py-10"
            dir="rtl"
        >

            <h1 className="text-3xl font-bold mb-8">
                سبد خرید
            </h1>

            <div className="bg-white rounded-xl shadow overflow-hidden mb-10">

                <table className="w-full text-center">

                    <thead className="bg-gray-50">

                        <tr>
                            <th className="p-4">
                                محصول
                            </th>

                            <th className="p-4">
                                قیمت
                            </th>

                            <th className="p-4">
                                تعداد
                            </th>

                            <th className="p-4">
                                مجموع
                            </th>

                            <th className="p-4">
                                حذف
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        {cart.map((item) => (

                            <tr
                                key={item.id}
                                className="border-t"
                            >

                                <td className="p-4">

                                    <div className="flex items-center justify-end gap-4">

                                        <span>
                                            {item.name}
                                        </span>

                                        <img
                                            src={`http://127.0.0.1:8000/storage/${item.image}`}
                                            alt=""
                                            className="w-16 h-16 rounded object-cover"
                                        />

                                    </div>

                                </td>

                                <td>

                                    {Number(
                                        item.price
                                    ).toLocaleString()}

                                    تومان

                                </td>

                                <td>

                                    <div className="flex justify-center items-center gap-2">

                                        <button
                                            onClick={() =>
                                                decreaseQuantity(
                                                    item.id
                                                )
                                            }
                                            className="bg-[#8B5E3C] text-white px-3 py-1 rounded"
                                        >
                                            -
                                        </button>

                                        <span>
                                            {
                                                item.quantity
                                            }
                                        </span>

                                        <button
                                            onClick={() =>
                                                increaseQuantity(
                                                    item.id
                                                )
                                            }
                                            className="bg-[#8B5E3C] text-white px-3 py-1 rounded"
                                        >
                                            +
                                        </button>

                                    </div>

                                </td>

                                <td>

                                    {(
                                        Number(
                                            item.price
                                        ) *
                                        item.quantity
                                    ).toLocaleString()}

                                    تومان

                                </td>

                                <td>

                                    <button
                                        onClick={() =>
                                            removeFromCart(
                                                item.id
                                            )
                                        }
                                        className="text-red-500 text-xl"
                                    >
                                        ×
                                    </button>

                                </td>

                            </tr>

                        ))}

                    </tbody>

                </table>

            </div>

            <div className="grid lg:grid-cols-3 gap-8">

                <div className="lg:col-span-2">

                    <h3 className="font-bold mb-4">
                        اطلاعات مشتری
                    </h3>

                    <div className="grid md:grid-cols-2 gap-4">

                        <input
                            type="text"
                            placeholder="نام"
                            value={firstName}
                            onChange={(e) =>
                                setFirstName(
                                    e.target.value
                                )
                            }
                            className="border rounded-lg p-3"
                        />

                        <input
                            type="text"
                            placeholder="نام خانوادگی"
                            value={lastName}
                            onChange={(e) =>
                                setLastName(
                                    e.target.value
                                )
                            }
                            className="border rounded-lg p-3"
                        />

                    </div>

                    <textarea
                        placeholder="آدرس"
                        value={address}
                        onChange={(e) =>
                            setAddress(
                                e.target.value
                            )
                        }
                        rows={5}
                        className="border rounded-lg p-3 w-full mt-4"
                    />

                    <button
                        onClick={updateProfile}
                        disabled={loading}
                        className="
                            mt-4
                            bg-green-600
                            text-white
                            px-6
                            py-3
                            rounded-lg
                        "
                    >
                        {loading
                            ? "در حال ذخیره..."
                            : "بروزرسانی اطلاعات"}
                    </button>

                </div>

                <div>

                    <div className="bg-white rounded-xl shadow p-6">

                        <h3 className="font-bold text-xl mb-6">
                            مجموع سفارش
                        </h3>

                        <div className="flex justify-between mb-4">

                            <span>
                                جمع کل
                            </span>

                            <span>

                                {total.toLocaleString()}

                                تومان

                            </span>

                        </div>

                        <button
                            className="
                            w-full
                            mt-4
                            bg-[#8B5E3C]
                            text-white
                            py-3
                            rounded-lg
                            font-bold
                        "
                        >
                            اقدام به پرداخت
                        </button>

                    </div>

                </div>

            </div>

        </div>
    );
};

export default Cart;