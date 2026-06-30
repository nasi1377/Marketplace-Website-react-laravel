import { createSlice } from '@reduxjs/toolkit';

const authSlice = createSlice({
  name: 'auth',
  initialState: {
    user: {
      name: "رضا محمدی", // این دیتا معمولاً بعد از لاگین از API میاد
      avatar: "users/avatar.png",
    },
    isLoggedIn: true,
  },
  reducers: {
    setUser: (state, action) => {
      state.user = action.payload;
    },
    logout: (state) => {
      state.user = null;
      state.isLoggedIn = false;
    }
  },
});

export const { setUser, logout } = authSlice.actions;
export default authSlice.reducer;
