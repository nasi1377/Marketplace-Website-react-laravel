import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import HomeSlider from "../frontend/HomeSlider";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation } from "swiper/modules";
import api from "../api";

const ProductCard = ({ product }) => {
    return (
        <div className="bg-white rounded-xl overflow-hidden shadow">

            <img
                src={`/storage/${product.image}`}
                alt={product.title}
                className="w-full h-60 object-cover"
            />

            <div className="p-4 text-right">

                <h4 className="font-bold line-clamp-1">
                    {product.title}
                </h4>

                <p className="mt-2 text-[#000000] font-bold">
                    {Number(product.price).toLocaleString()}
                    {" "}
                    تومان
                </p>

                <Link
                    to={`/product/${product.id}`}
                    className="block mt-3 text-center bg-[#000000] text-white py-2 rounded"
                >
                    مشاهده
                </Link>

            </div>

        </div>
    );
};

const Home = () => {
    const [data, setData] = useState({
        products: [],
        stylistPosts: [],
        categories: [],
        courses: [],
    });
    
const [cityId, setCityId] = useState("");
const [productSearch, setProductSearch] = useState("");
const [minPrice, setMinPrice] = useState("");
const [maxPrice, setMaxPrice] = useState("");
const [stylistSearch, setStylistSearch] = useState("");
const [courseSearch, setCourseSearch] = useState("");
const [loading, setLoading] = useState(true);
const [stylistMinPrice, setStylistMinPrice] = useState("");
const [stylistMaxPrice, setStylistMaxPrice] = useState("");
const [courseMinPrice, setCourseMinPrice] = useState("");
const [courseMaxPrice, setCourseMaxPrice] = useState("");
const [provinces, setProvinces] = useState([]);
const [cities, setCities] = useState([]);

const [provinceId, setProvinceId] = useState(null);
   useEffect(() => {
    const fetchHomeData = async () => {
        try {
            const response = await api.get(
                "/home-data"
            );

            setData({
                products: response.data.data.products || [],
                stylistPosts: response.data.data.stylistPosts || [],
                categories: response.data.data.categories || [],
                courses: response.data.data.courses || [],
            });
        } catch (error) {
            console.error("خطا در دریافت اطلاعات:", error);
        } finally {
            setLoading(false);
        }
    };

    fetchHomeData();
}, []);


// دریافت استان‌ها
useEffect(() => {
    api
        .get("/provinces")
        .then((res) => {
            setProvinces(res.data);
        })
        .catch(console.error);
}, []);


// دریافت شهرهای استان انتخاب شده
useEffect(() => {
    if (!provinceId) {
        setCities([]);
        return;
    }

    console.log("Province ID:", provinceId);

   api
    .get(`/provinces/${provinceId}/cities`)
    .then((res) => {
        console.log("FULL RESPONSE", res);
        console.log("DATA", res.data);
        console.log("TYPE", typeof res.data);

        setCities(res.data);
    })
    .catch((err) => {
        console.error(err);
    });
}, [provinceId]);
useEffect(() => {
    console.log("cities state =", cities);
}, [cities]);

    if (loading) {
        return (
            <div className="text-center py-20 text-xl font-semibold">
                در حال بارگذاری اطلاعات...
            </div>
        );
    }
    const filteredProducts = data.products.filter((product) => {
    const searchMatch =
        !productSearch ||
        product.title
            ?.toLowerCase()
            .includes(productSearch.toLowerCase());

    const minMatch =
        !minPrice ||
        Number(product.price) >= Number(minPrice);

    const maxMatch =
        !maxPrice ||
        Number(product.price) <= Number(maxPrice);

    return searchMatch && minMatch && maxMatch;
});
const filteredStylists = data.stylistPosts.filter((post) => {
    const searchMatch =
        !stylistSearch ||
        (post.title || "")
            .toLowerCase()
            .includes(stylistSearch.toLowerCase());

    const minPriceMatch =
        !stylistMinPrice ||
        Number(post.price) >= Number(stylistMinPrice);

    const maxPriceMatch =
        !stylistMaxPrice ||
        Number(post.price) <= Number(stylistMaxPrice);

   const provinceMatch =
  !provinceId || String(post.province_id) === String(provinceId);

const cityMatch =
  !cityId || String(post.city_id) === String(cityId);

    return (
        searchMatch &&
        minPriceMatch &&
        maxPriceMatch &&
        provinceMatch &&
        cityMatch
    );
});


const filteredCourses = data.courses.filter((course) => {

    const searchMatch =
        !courseSearch ||
        course.title
            ?.toLowerCase()
            .includes(courseSearch.toLowerCase());

    const minPriceMatch =
        !courseMinPrice ||
        Number(course.price) >= Number(courseMinPrice);

    const maxPriceMatch =
        !courseMaxPrice ||
        Number(course.price) <= Number(courseMaxPrice);

const provinceMatch =
  !provinceId || String(course.province_id) === String(provinceId);

const cityMatch =
  !cityId || String(course.city_id) === String(cityId);

    return (
        searchMatch &&
        minPriceMatch &&
        maxPriceMatch &&
        provinceMatch &&
        cityMatch
    );
});
const productsByCategory = data.categories.map((category) => ({
    ...category,
    products: filteredProducts.filter(
        (product) =>
            product.product_category_id === category.id
    ),
}));
    return (
    <div className="bg-gray-50 min-h-screen">
           {/* Header Banner */}
<HomeSlider />
{/* Category Icons */}
<section className="bg-[#00000] py-12">
    <div className="container mx-auto px-4">

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">

            {data.categories.map((category) => (
                <Link
                    key={category.id}
                    to={`/category/${category.id}`}
                    className="flex flex-col items-center group"
                >
                    <div
                        className="
                            w-28 h-28
                            rounded-full
                            border-2
                            border-[#000000]
                            bg-[#F5E8CF]
                            flex items-center justify-center
                            transition
                            group-hover:scale-105
                        "
                    >
                        <img
                            //src={`http://127.0.0.1:8000/storage/${category.icon}`}
                            alt={category.name}
                            className="w-12 h-12 object-contain"
                        />
                    </div>

                    
                   
                </Link>
            ))}
        </div>

    </div>
</section>
            {/* Main Layout */}
            <div className="container mx-auto px-4 py-8">
                <div className="flex flex-col lg:flex-row gap-6">

                    {/* Sidebar */}

                    {/* Main Content */}
                    <main className="flex-1">

                    {/* Products */}
<section id="products" className="mb-16">

    <h2
        className="text-3xl font-bold text-right mb-8"
        style={{ color: "#000000" }}
    >
        محصولات
    </h2>

    {/* فیلتر محصولات */}
    <div className="bg-white p-4 rounded-xl shadow mb-10">

        <h3 className="font-bold text-right mb-4">
            فیلتر محصولات
        </h3>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-3">

            <input
                type="text"
                placeholder="نام محصول"
                value={productSearch}
                onChange={(e) =>
                    setProductSearch(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

            <input
                type="number"
                placeholder="حداقل قیمت"
                value={minPrice}
                onChange={(e) =>
                    setMinPrice(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

            <input
                type="number"
                placeholder="حداکثر قیمت"
                value={maxPrice}
                onChange={(e) =>
                    setMaxPrice(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

        </div>

        <div className="text-right text-gray-500 mt-3">
            تعداد محصولات: {filteredProducts.length}
        </div>

    </div>

    {/* جدیدترین محصولات */}
    <div className="mb-20">

        <div className="flex justify-between items-center mb-6">

            <Link
                to="/products"
                className="text-sm text-[#000000] font-bold"
            >
                مشاهده همه
            </Link>

            <h3
                className="text-2xl font-bold"
                style={{ color: "#000000" }}
            >
                جدیدترین محصولات
            </h3>

        </div>

        <Swiper
            modules={[Navigation]}
            navigation
            spaceBetween={20}
            breakpoints={{
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                },
            }}
        >
            {filteredProducts.slice(0, 12).map((product) => (
                <SwiperSlide key={product.id}>
                    <ProductCard product={product} />
                </SwiperSlide>
            ))}
        </Swiper>

    </div>

    {/* دسته بندی ها */}
    {productsByCategory.map((category) => (

        <div
            key={category.id}
            className="mb-20"
        >

            <div className="flex justify-between items-center mb-6">

                <Link
                    to={`/category/${category.id}`}
                    className="text-sm text-[#000000] font-bold"
                >
                    مشاهده همه
                </Link>

                <h3
                    className="text-2xl font-bold"
                    style={{ color: "#000000" }}
                >
                    {category.name}
                </h3>

            </div>

            {category.products.length > 0 ? (

                <Swiper
                    modules={[Navigation]}
                    navigation
                    spaceBetween={20}
                    breakpoints={{
                        320: {
                            slidesPerView: 1,
                        },
                        640: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 4,
                        },
                    }}
                >
                    {category.products.map((product) => (
                        <SwiperSlide key={product.id}>
                            <ProductCard product={product} />
                        </SwiperSlide>
                    ))}
                </Swiper>

            ) : (

                <div className="bg-white rounded-xl p-8 text-center text-gray-400">
                    محصولی در این دسته‌بندی وجود ندارد
                </div>

            )}

        </div>

    ))}

</section>
  {/* Stylists */}
<section
    id="stylists"
    className="mb-16"
>

    <h2
        className="text-3xl font-bold text-right mb-8"
        style={{ color: "#000000" }}
    >
        رزرو آنلاین نوبت آرایشگر
    </h2>

    {/* فیلتر آرایشگر */}
    <div className="bg-white p-4 rounded-xl shadow mb-8">

        <h3 className="font-bold text-right mb-4">
            فیلتر آرایشگرها
        </h3>

        <div className="grid grid-cols-1 md:grid-cols-5 gap-3">

            <input
                type="text"
                placeholder="نام آرایشگر"
                value={stylistSearch}
                onChange={(e) =>
                    setStylistSearch(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

           <select
    value={provinceId}
onChange={(e) => {
  setProvinceId(e.target.value);
  setCityId("");
}}
    
    className="border p-2 rounded w-full"
>
    <option value="">
        انتخاب استان
    </option>

    {provinces.map((province) => (
        <option
            key={province.id}
            value={province.id}
        >
            {province.name}
        </option>
    ))}
</select>

<select
 value={cityId}
onChange={(e) => setCityId(e.target.value)}
    className="border p-2 rounded w-full"
>
    <option value="">
        انتخاب شهر
    </option>

    {cities.map((city) => (
        <option
            key={city.id}
            value={city.id}
        >
            {city.name}
        </option>
    ))}
</select>
            <input
                type="number"
                placeholder="حداقل قیمت"
                value={stylistMinPrice}
                onChange={(e) =>
                    setStylistMinPrice(
                        e.target.value
                    )
                }
                className="border rounded-lg p-2 text-right"
            />

            <input
                type="number"
                placeholder="حداکثر قیمت"
                value={stylistMaxPrice}
                onChange={(e) =>
                    setStylistMaxPrice(
                        e.target.value
                    )
                }
                className="border rounded-lg p-2 text-right"
            />

        </div>

        <div className="text-right text-gray-500 mt-3">
            تعداد آرایشگرها:
            {" "}
            {filteredStylists.length}
        </div>

    </div>

    {filteredStylists.length > 0 ? (

        <Swiper
            modules={[Navigation]}
            navigation
            spaceBetween={20}
            slidesPerView={4}
            breakpoints={{
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                },
            }}
        >

            {filteredStylists.map((post) => (

                <SwiperSlide key={post.id}>

                    <div className="bg-white rounded-xl overflow-hidden shadow">

                        <img
                            src={`http://127.0.0.1:8000/storage/${post.image}`}
                            alt={post.title}
                            className="w-full h-48 object-cover"
                        />

                        <div className="p-3 text-right">

                            <div className="flex justify-between items-center mb-2">

                                <span className="text-sm text-gray-500">
                                    {post.user?.name ||
                                        "آرایشگر"}
                                </span>

                                <span className="text-pink-600 font-bold text-sm">
                                    {Number(
                                        post.price
                                    ).toLocaleString()}
                                    {" "}
                                    تومان
                                </span>

                            </div>

                            <h3 className="font-bold text-sm line-clamp-1 mb-3">
                                {post.title}
                            </h3>

                            <Link
                                to={`/reserve/${post.id}`}
                                className="block text-center bg-black text-white py-2 rounded-lg text-sm"
                            >
                                رزرو نوبت
                            </Link>

                        </div>

                    </div>

                </SwiperSlide>

            ))}

        </Swiper>

    ) : (

        <div className="text-center py-10 text-gray-400">
            آرایشگری یافت نشد.
        </div>

    )}

</section>

                       <section id="courses" className="mb-16">

    <h2
        className="text-3xl font-bold text-right mb-8"
        style={{ color: "#000000" }}
    >
        دوره‌های آموزشی
    </h2>

    {/* فیلتر دوره */}
    <div className="bg-white p-4 rounded-xl shadow mb-8">

        <h3 className="font-bold text-right mb-4">
            فیلتر دوره‌ها
        </h3>

        <div className="grid grid-cols-1 md:grid-cols-5 gap-3">

            <input
                type="text"
                placeholder="نام دوره"
                value={courseSearch}
                onChange={(e) =>
                    setCourseSearch(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

            <select
              value={provinceId}
onChange={(e) => {
  setProvinceId(e.target.value);
  setCityId("");
}}
                className="border rounded-lg p-2 text-right"
            >
                <option value="">
                    همه استان‌ها
                </option>

              {provinces.map((item) => (
    <option
        key={item.id}
        value={item.id}
    >
        {item.name}
    </option>
))}
            </select>

            <select
               value={cityId}
onChange={(e) => setCityId(e.target.value)}
                
                className="border rounded-lg p-2 text-right"
            >
                <option value="">
                    همه شهرها
                </option>

               {cities.map((item) => (
    <option
        key={item.id}
        value={item.id}
    >
        {item.name}
    </option>
))}
            </select>

            <input
                type="number"
                placeholder="حداقل قیمت"
                value={courseMinPrice}
                onChange={(e) =>
                    setCourseMinPrice(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

            <input
                type="number"
                placeholder="حداکثر قیمت"
                value={courseMaxPrice}
                onChange={(e) =>
                    setCourseMaxPrice(e.target.value)
                }
                className="border rounded-lg p-2 text-right"
            />

        </div>

        <div className="text-right text-gray-500 mt-3">
            تعداد دوره‌ها:
            {" "}
            {filteredCourses.length}
        </div>

    </div>

    {filteredCourses.length > 0 ? (

        <Swiper
            modules={[Navigation]}
            navigation
            spaceBetween={20}
            slidesPerView={4}
            breakpoints={{
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                },
            }}
        >

            {filteredCourses.map((course) => (

                <SwiperSlide key={course.id}>

                    <div className="bg-white rounded-xl overflow-hidden shadow">

                        <img
                            src={`http://127.0.0.1:8000/storage/${course.image}`}
                            alt={course.title}
                            className="w-full h-48 object-cover"
                        />

                        <div className="p-3 text-right">

                            <h3 className="font-bold text-sm line-clamp-1 mb-2">
                                {course.title}
                            </h3>

                            <p className="text-xs text-gray-500 line-clamp-2 mb-3">
                                {course.description}
                            </p>

                            <div className="flex justify-between items-center">

                                <span className="text-blue-600 font-bold text-sm">
                                    {Number(
                                        course.price || 0
                                    ).toLocaleString()}
                                    {" "}
                                    تومان
                                </span>

                                <Link
                                    to={`/course/${course.id}`}
                                    className="bg-black text-white px-3 py-2 rounded-lg text-sm"
                                >
                                    مشاهده
                                </Link>

                            </div>

                        </div>

                    </div>

                </SwiperSlide>

            ))}

        </Swiper>

    ) : (

        <div className="text-center py-10 text-gray-400">
            دوره‌ای یافت نشد.
        </div>

    )}

</section>

                    </main>
                </div>
            </div>
        </div>
    );
};

export default Home;