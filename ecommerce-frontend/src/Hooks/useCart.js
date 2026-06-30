import { useState, useEffect } from 'react';

export const useCart = () => {
    const [cart, setCart] = useState([]);
    const [totals, setTotals] = useState({
        subTotal: 0,
        totalPrice: 0,
        sendPrice: 0,
        discount: 0
    });

    // بارگذاری سبد خرید از LocalStorage
    useEffect(() => {
        const savedCart = JSON.parse(localStorage.getItem('cart')) || [];
        setCart(savedCart);
    }, []);

    // محاسبه مبالغ (دقیقاً مشابه منطق کنترلر لاراول)
    const calculateTotals = (products, gifts, settingSendPrice) => {
        let sub = 0;
        let weight = 0;

        cart.forEach(item => {
            const product = products.find(p => p.id === item.product_id);
            if (product) {
                sub += item.count * product.price;
                weight += item.count; // طبق منطق کد خودت
            }
        });

        // منطق تخفیف
        let discountAmt = 0;
        const discountGift = gifts.find(g => g.title === 'کد تخفیف' && g.status === 1);
        if (discountGift && sub > discountGift.value) {
            discountAmt = parseInt(discountGift.value);
        }

        // منطق ارسال رایگان
        const freeShipping = gifts.some(g => g.title === 'ارسال رایگان' && g.status === 1);
        const sendPrice = freeShipping ? 0 : parseInt(settingSendPrice) + (weight * 3000);

        setTotals({
            subTotal: sub,
            discount: discountAmt,
            sendPrice: sendPrice,
            totalPrice: (sub - discountAmt) + sendPrice
        });
    };

    return { cart, totals, calculateTotals };
};
