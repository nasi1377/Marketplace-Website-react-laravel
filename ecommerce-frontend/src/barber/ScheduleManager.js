const ScheduleManager = () => {
    const days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'];

    return (
        <div className="bg-white p-6 rounded shadow">
            <h3 className="text-lg font-bold mb-4 ml-4">تعیین ساعات کاری هفته</h3>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                {days.map(day => (
                    <div key={day} className="border p-4 rounded flex justify-between items-center bg-gray-50">
                        <span>{day}</span>
                        <div className="flex gap-2">
                            <input type="time" name={`${day}-start`} className="border p-1 rounded" />
                            <span>تا</span>
                            <input type="time" name={`${day}-end`} className="border p-1 rounded" />
                        </div>
                    </div>
                ))}
            </div>
            <button className="mt-6 bg-indigo-600 text-white px-6 py-2 rounded">ذخیره تقویم کاری</button>
        </div>
    );
};
