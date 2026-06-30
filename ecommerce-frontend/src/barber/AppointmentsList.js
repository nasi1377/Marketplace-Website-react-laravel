const AppointmentsList = ({ userId }) => {
    const [appointments, setAppointments] = useState([]);

    // اینجا با useEffect و axios دیتا رو از `api/barber/appointments/${userId}` بگیر

    return (
        <table className="w-full bg-white shadow rounded">
            <thead>
                <tr className="bg-indigo-100">
                    <th className="p-3 text-right">مشتری</th>
                    <th className="p-3 text-right">تاریخ و ساعت</th>
                    <th className="p-3 text-right">نوع خدمت</th>
                    <th className="p-3 text-right">وضعیت</th>
                </tr>
            </thead>
            <tbody>
                {appointments.map(app => (
                    <tr>
                        <td className="p-3 border">{app.customer_name}</td>
                        <td className="p-3 border">{app.date} / {app.time}</td>
                        <td className="p-3 border">{app.service_name}</td>
                        <td className="p-3 border">
                            <span className="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold">تایید شده</span>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
};
