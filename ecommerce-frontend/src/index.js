import React from 'react';
import ReactDOM from 'react-dom/client'; // این درسته
import './index.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'font-awesome/css/font-awesome.min.css';
import { Provider } from 'react-redux'; // این رو اضافه کن
import { store } from './redux/store';
import App from './App';
 import { CartProvider } from "./layout/CartContext";

// تنظیمات پایه برای ارتباط با لاراول

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(

<CartProvider>
    <App />
</CartProvider>
);



