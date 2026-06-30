import React from 'react';
import { useSelector } from 'react-redux'; // هوک برای گرفتن دیتا از ریداکس
import api from "../api";

const UserDashboard = () => {
  // گرفتن دیتای یوزر از استور ریداکس
  const user = useSelector((state) => state.auth.user);

  const STORAGE_URL = "https://your-api-domain.com/storage/";

  return (
    <div className="rounded shadow bg-white">
      <div className="text-center" style={{ backgroundColor: '#f1f1f1' }}>
        <h4 style={{ paddingTop: '10px', color: '#555' }}>دفتر کار کاربری</h4>
        <hr style={{ backgroundColor: 'silver' }} />
      </div>

      <div className="row" style={{ paddingBottom: '20px' }}>
        <div className="col-12 mt-4 pt-2">
          <div className="text-center">
            {/* چک کردن وجود یوزر و آواتار */}
            <img
              src={user?.avatar ? `${STORAGE_URL}${user.avatar}` : `${STORAGE_URL}users/default.png`}
              className="avatar avatar-medium shadow-lg rounded-pill"
              alt="پروفایل"
              style={{ width: '100px', height: '100px', objectFit: 'cover' }}
            />

            <div className="content mt-3">
              <h5 className="text-dark">{user?.name || 'کاربر مهمان'}</h5>
              <p className="text-muted">به پنل کاربری خوش آمدید</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default UserDashboard;
