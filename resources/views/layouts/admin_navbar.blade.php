
      <ul class="dashboard_menu user_profile">
      <li>
        <a href="{{ route('admin.dashboard') }}" 
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('admin.doctors.index') }}" 
           class="{{ request()->routeIs('admin.doctors.index') ? 'active' : '' }}">
            <i class="fas fa-user-md"></i> Doctors
        </a>
    </li>
    <li>
        <a href="{{ route('admin.patients.index') }}" 
           class="{{ request()->routeIs('admin.patients.index') ? 'active' : '' }}">
            <i class="fas fa-procedures"></i> Patients
        </a>
    </li>
    <li>
        <a href="{{ route('admin.appointments.index') }}" 
           class="{{ request()->routeIs('admin.appointments.index') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Appointments
        </a>
    </li>
    <li>
        <a href="{{ route('admin.appointments.pending') }}" 
           class="{{ request()->routeIs('admin.appointments.pending') ? 'active' : '' }}">
            <i class="fas fa-clock"></i> Pending Appointments
        </a>
    </li>
    <li>
        <a href="{{ route('logout') }}" 
        class="{{ request()->routeIs('logout') ? 'active' : '' }}">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        
    </li>
</ul>