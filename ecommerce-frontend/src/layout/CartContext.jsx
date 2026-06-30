import { createContext, useState, useEffect } from "react";

export const CartContext = createContext();

export const CartProvider = ({ children }) => {

    const [cart, setCart] = useState(() => {
        try {
            return JSON.parse(localStorage.getItem("cart")) || [];
        } catch {
            return [];
        }
    });

    useEffect(() => {
        console.log("Cart Changed:", cart);
    }, [cart]);

    const saveCart = (newCart) => {
        console.log("Saving Cart:", newCart);

        setCart(newCart);

        localStorage.setItem(
            "cart",
            JSON.stringify(newCart)
        );
    };

    const addToCart = (product) => {

    const existingItem = cart.find(
        (item) => item.id === product.id
    );

    if (existingItem) {

        const stock = Number(product.stock || 0);

        if (existingItem.quantity >= stock) {
            alert("موجودی محصول کافی نیست");
            return;
        }

        const updatedCart = cart.map((item) =>
            item.id === product.id
                ? {
                      ...item,
                      quantity: item.quantity + 1,
                  }
                : item
        );

        saveCart(updatedCart);

    } else {

        const updatedCart = [
            ...cart,
            {
                ...product,
                quantity: 1,
            },
        ];

        saveCart(updatedCart);
    }
};

   const increaseQuantity = (id) => {

    const updatedCart = cart.map((item) => {

        if (item.id === id) {

            const stock = Number(item.stock || 0);

            if (item.quantity >= stock) {
                alert("موجودی محصول کافی نیست");
                return item;
            }

            return {
                ...item,
                quantity: item.quantity + 1,
            };
        }

        return item;
    });

    saveCart(updatedCart);
};

    const decreaseQuantity = (id) => {

    const updatedCart = cart
        .map((item) => {

            if (item.id === id) {

                if (item.quantity <= 1) {
                    return null;
                }

                return {
                    ...item,
                    quantity: item.quantity - 1,
                };
            }

            return item;
        })
        .filter(Boolean);

    saveCart(updatedCart);
};
const removeFromCart = (id) => {

    const updatedCart = cart.filter(
        (item) => item.id !== id
    );

    saveCart(updatedCart);
};
    return (
        <CartContext.Provider
            value={{
                cart,
                addToCart,
                increaseQuantity,
                decreaseQuantity,
                removeFromCart,
            }}
        >
            {children}
        </CartContext.Provider>
    );
};