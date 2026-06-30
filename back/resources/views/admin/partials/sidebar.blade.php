
<!-- در بخش body -->
<button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i> منو
</button>

<div class="sidebar" id="sidebar">
    <button class="close-btn d-md-none" onclick="toggleSidebar()">×</button>
    <h3 class="sidebar-title">
     بازاریابان</h3>
    <a href="{{ route('home') }}" class="{{ request()->is('home') ? 'active' : '' }}">
        <i class="fas fa-home"></i> صفحه اصلی
    </a>
    <a href="{{ route('admin.marketers.index') }}" class="{{ request()->routeIs('admin.marketers.index') ? 'active' : '' }}">
        <i class="fas fa-users"></i> بازاریاب‌ها
    </a>
    <!-- در بخش سایدبار، قبل از لینک خروج این کد را اضافه کنید -->
    <a href="{{ route('admin.marketers.gifts') }}" class="{{ request()->routeIs('admin.marketers.gifts') ? 'active' : '' }}">
        <i class="fas fa-gift"></i> هدیه های بازاریابان
    </a>
    <a href="#">
        <i class="fas fa-sign-out-alt"></i> خروج
    </a>
</div>

<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        
        // غیرفعال کردن اسکرول صفحه وقتی سایدبار باز است
        document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
    }
    
    // بستن سایدبار وقتی صفحه بزرگ می‌شود
    function handleResize() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    // افزودن event listener برای تغییر سایز صفحه
    window.addEventListener('resize', handleResize);
    
    // بستن سایدبار با کلیک روی overlay
    document.querySelector('.sidebar-overlay').addEventListener('click', function() {
        toggleSidebar();
    });
</script>