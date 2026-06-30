import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

const HomeSlider = () => {
    const slides = [
        {
            id: 1,
            image:
                "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9",
            title: "رزرو آنلاین آرایشگر",
            subtitle: "بهترین آرایشگران شهر را آنلاین رزرو کنید",
        },
        {
            id: 2,
            image:
                "https://images.unsplash.com/photo-1596462502278-27bfdc403348",
            title: "محصولات آرایشی",
            subtitle: "جدیدترین محصولات زیبایی با بهترین قیمت",
        },
        {
            id: 3,
            image:
                "https://images.unsplash.com/photo-1515377905703-c4788e51af15",
            title: "دوره‌های آموزشی",
            subtitle: "آموزش حرفه‌ای آرایشگری و زیبایی",
        },
    ];

    return (
        <Swiper
            modules={[Autoplay, Pagination, Navigation]}
            autoplay={{
                delay: 4000,
                disableOnInteraction: false,
            }}
            pagination={{ clickable: true }}
            navigation
            loop
            className="w-full h-[500px]"
        >
            {slides.map((slide) => (
                <SwiperSlide key={slide.id}>
                    <div className="relative h-[500px]">
                        <img
                            src={slide.image}
                            alt={slide.title}
                            className="w-full h-full object-cover"
                        />

                        <div className="absolute inset-0 bg-black/50 flex flex-col justify-center items-center text-white">
                            <h2 className="text-5xl font-bold mb-4">
                                {slide.title}
                            </h2>

                            <p className="text-xl">
                                {slide.subtitle}
                            </p>
                        </div>
                    </div>
                </SwiperSlide>
            ))}
        </Swiper>
    );
};

export default HomeSlider;