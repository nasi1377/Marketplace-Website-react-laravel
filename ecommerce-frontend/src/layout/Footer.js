import React, { useEffect, useState } from "react";
import api from "../api";

const Footer = () => {
    const [footer, setFooter] = useState(null);

    useEffect(() => {
        api
            .get("/footer-data")
            .then((res) => {
                setFooter(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    }, []);

    if (!footer) return null;

    return (
<footer className="bg-black text-white mt-10">
                <div className="container mx-auto px-6 py-16">

                <div className="grid md:grid-cols-3 gap-10">

                    {/* خبرنامه */}
                    <div>
                        <h3 className="text-3xl font-bold mb-8">
                            خبرنامه
                        </h3>

                        <input
                            type="email"
                            placeholder="ایمیل شما"
                            className="w-full p-4 rounded-lg text-black mb-4"
                        />

<button className="w-full bg-white text-black font-bold py-4 rounded-lg">
                                عضویت
                        </button>
                    </div>

                    {/* فاصله وسط */}
                    <div></div>

                    {/* اطلاعات سایت */}
                    <div className="text-right">

                        
                        <div
                            className="leading-10 text-lg"
                            dangerouslySetInnerHTML={{
                                __html: footer.description
                            }}
                        />

                        <div className="mt-6">
                            <p>
                                تلفن:
                                {" "}
                                {footer.phone}
                            </p>

                            <p>
                                پست الکترونیکی:
                                {" "}
                                {footer.email}
                            </p>

                            <p>
                                آدرس:
                                {" "}
                                {footer.address}
                            </p>
                        </div>

                        {footer.instagram && (
                            <a
                                href={footer.instagram}
                                target="_blank"
                                rel="noreferrer"
className="block mt-4 hover:text-gray-300"                            >
                                اینستاگرام
                            </a>
                        )}

                        {footer.enamad && (
                            <div className="mt-6 flex justify-end">
                                <img
                                    src={footer.enamad}
                                    alt="enamad"
                                    className="w-24 h-24 object-contain bg-white rounded-lg p-2"
                                />
                            </div>
                        )}
                    </div>
                </div>

                {/* خط جداکننده */}
<div className="border-t border-gray-700 mt-12 pt-8 text-center text-white">
                        © {new Date().getFullYear()} تمام حقوق برای بانوگل محفوظ است.
                </div>
            </div>
        </footer>
    );
};

export default Footer;