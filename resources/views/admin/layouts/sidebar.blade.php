<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> <a href="{{ route('admin.index') }}" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span
                    class="nav_logo-name">TRENDEMY</span> </a>
            <div class="nav_list">
                <a href="{{ route('admin.index') }}"
                    class="{{ request()->is('admin') ? 'nav_link active' : 'nav_link' }}">
                    <i class='bx bx-grid-alt nav_icon'></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a @class(['nav_link', 'active' => request()->is('admin/users*')]) href="{{ route('admin.users.index') }}">
                    <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">Users</span>
                </a>
                <a @class(['nav_link', 'active' => request()->is('admin/coupons*')]) href="{{ route('admin.coupons.index') }}">
                    <i class='bx bxs-coupon nav_icon'></i>
                    <span class="nav_name">Coupons</span>
                </a>
                <a href="{{ route('admin.configs.index') }}" @class(['nav_link', 'active' => request()->is('admin/configs*')])>
                    <i class='bx bxs-cog nav_icon'></i>
                    <span class="nav_name">Configs</span>
                </a>
                <a @class(['nav_link', 'active' => request()->is('admin/courses*')]) href="{{ route('admin.courses.index') }}">
                    <i class='bx bxs-book-reader nav_icon'></i>
                    <span class="nav_name">Courses</span>
                </a>
                <a @class(['nav_link', 'active' => request()->is('admin/orders*')]) href="{{ route('admin.orders.index') }}">
                    <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
                    <span class="nav_name">Orders</span>
                </a>
                <a href="javascript:void(0)" class="nav_link">
                    <i class='bx bx-credit-card nav_icon'></i>
                    <span class="nav_name">Transactions</span>
                </a>
            </div>
        </div>
        <a href="{{ route('home') }}" class="nav_link">
            <i class='bx bx-log-out nav_icon'></i>
            <span class="nav_name">Home Page</span>
        </a>
    </nav>
</div>
