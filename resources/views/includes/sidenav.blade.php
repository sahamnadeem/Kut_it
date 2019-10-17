<div class="card card-sidebar-mobile">
    <ul class="nav nav-sidebar" data-nav-type="accordion">

        <!-- Main -->
        <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{Request::is('home') ? 'active' : ''}}">
                <i class="icon-home4"></i>
                <span>
					Dashboard
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{Request::is(['users','users/*']) ? 'active' : ''}}">
                <i class="icon-user"></i>
                <span>
					User Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('roles.index') }}" class="nav-link {{Request::is(['roles','roles/*']) ? 'active' : ''}}">
                <i class="icon-user-lock"></i>
                <span>
					Role Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('status.index') }}" class="nav-link {{Request::is(['status','status/*']) ? 'active' : ''}}">
                <i class="icon-shield2"></i>
                <span>
					Status Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('services.index') }}" class="nav-link {{Request::is(['services','services/*']) ? 'active' : ''}}">
                <i class="icon-store2"></i>
                <span>
					Service Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('barbers.index') }}" class="nav-link {{Request::is(['barbers','barbers/*']) ? 'active' : ''}}">
                <i class="icon-scissors"></i>
                <span>
					Barber Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bookings.index') }}" class="nav-link {{Request::is(['bookings','bookings/*']) ? 'active' : ''}}">
                <i class="icon-notebook"></i>
                <span>
					Booking Management
                </span>
            </a>
        </li>
    </ul>
</div>
