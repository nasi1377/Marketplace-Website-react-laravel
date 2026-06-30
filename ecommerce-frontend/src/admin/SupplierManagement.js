import React, { useState, useEffect } from 'react';

const SupplierManagement = () => {
  // این دیتارو معمولاً از API یا ریداکس می‌گیری
  const [suppliers, setSuppliers] = useState([
    { id: 1, name: "پخش مرکزی لوازم آرایشی", status: "pending", type: "عمده فروش" },
    { id: 2, name: "بازرگانی نوین", status: "approved", type: "واردکننده" },
  ]);

  const handleApprove = (id) => {
    // اینجا کد تایید رو می‌زنی (Dispatch به ریداکس یا Axios به بک‌انند)
    alert(`تأمین‌کننده با کد ${id} تایید شد!`);
    // در واقعیت باید وضعیت رو توی استیت آپدیت کنی
  };

  return (
    <div className="container-fluid p-4">
      <h3 className="mb-4">مدیریت تأمین‌کنندگان</h3>
      <div className="card shadow border-0">
        <div className="table-responsive">
          <table className="table align-items-center table-flush">
            <thead className="thead-light">
              <tr>
                <th>نام تأمین‌کننده</th>
                <th>نوع فعالیت</th>
                <th>وضعیت</th>
                <th>عملیات</th>
              </tr>
            </thead>
            <tbody>
              {suppliers.map((s) => (
                <tr key={s.id}>
                  <td>{s.name}</td>
                  <td>{s.type}</td>
                  <td>
                    {s.status === 'pending' ? 
                      <span className="badge bg-warning text-dark">منتظر تایید</span> : 
                      <span className="badge bg-success text-white">تایید شده</span>
                    }
                  </td>
                  <td>
                    {s.status === 'pending' && (
                      <button 
                        onClick={() => handleApprove(s.id)}
                        className="btn btn-sm btn-success"
                      >
                        تایید حساب
                      </button>
                    )}
                    <button className="btn btn-sm btn-outline-primary ms-2">مشاهده جزئیات</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default SupplierManagement;
