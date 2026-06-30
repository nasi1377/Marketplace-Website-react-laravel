import React from 'react';

const CourseApprovalTable = ({ courses, onStatusChange }) => {
    return (
        <table className="w-full text-right">
            <thead>
                <tr className="bg-gray-100">
                    <th className="p-3">تصویر</th>
                    <th className="p-3">عنوان</th>
                    <th className="p-3">توضیحات</th>
                    <th className="p-3">وضعیت</th>
                </tr>
            </thead>

            <tbody>
                {courses.map(course => (
                    <tr key={course.id} className="border-b">
                        <td className="p-3">
                            <img
                                src={`http://127.0.0.1:8000/storage/${course.image}`}
                                alt={course.title}
                                className="w-20 h-20 object-cover rounded"
                            />
                        </td>

                        <td className="p-3">
                            {course.title}
                        </td>

                        <td className="p-3">
                            {course.description}
                        </td>

                        <td className="p-3 flex gap-2">
                            <button
                                onClick={() =>
                                    onStatusChange(course.id, 'approve')
                                }
                                className="bg-green-600 text-white px-3 py-1 rounded"
                            >
                                تایید
                            </button>

                            <button
                                onClick={() =>
                                    onStatusChange(course.id, 'reject')
                                }
                                className="bg-red-600 text-white px-3 py-1 rounded"
                            >
                                رد
                            </button>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
};

export default CourseApprovalTable;