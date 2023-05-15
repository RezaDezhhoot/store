<div class="col-sm-12 col-md-3 col-lg-3" wire:ignore>

    <div class="dashboard_tab_button position-sticky" style="top: 4rem">
        <div class="col-12 px-0 py-2">
            <p>
                موجودی کیف پول : {{ number_format(auth()->user()->balance) }} تومان
            </p>
        </div>
        <ul role="tablist" class="nav flex-column dashboard-list">
            <li><a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">داشبورد</a></li>
            <li> <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs(['user.order','user.orders']) ? 'active' : '' }}">سفارشات</a></li>
            <li> <a href="{{ route('user.returns') }}" class="nav-link {{ request()->routeIs(['user.return','user.returns']) ? 'active' : '' }}">مرجوعی ها</a></li>
            <li> <a href="{{ route('user.notifications') }}" class="nav-link {{ request()->routeIs(['user.notifications']) ? 'active' : '' }}">اعلان ها</a></li>
            <li><a href="{{ route('user.addresses') }}"  class="nav-link {{ request()->routeIs(['user.address','user.addresses']) ? 'active' : '' }}">آدرس ها</a></li>
            <li><a href="{{ route('user.tickets') }}" class="nav-link {{ request()->routeIs(['user.tickets','user.ticket']) ? 'active' : '' }}">پشتیبانی</a></li>
            <li><a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">جزئیات حساب</a></li>
            <li><a href="{{ route('logout') }}" class="nav-link">خروج</a></li>
        </ul>
    </div>
</div>
