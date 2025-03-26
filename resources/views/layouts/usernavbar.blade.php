
                    <div class="user_profile">
                        <div class="user_profile_img">
                        @if($patient->image)
                            <img src="{{ asset('storage/public/images/' . $patient->image) }}" alt="Patient Image" class="img-fluid w-100" >
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Default Image" class="img-fluid w-100" >
                        @endif
                    </div>
                        <h4>{{$patient->name}}</h4>
                    </div>
                    <ul class="dashboard_menu">
    <li>
        <a href="{{ route('patient.dashboard') }}" 
           class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
            My Profile
        </a>
    </li>
    <li>
        <a href="{{ route('patient.appointment') }}" 
           class="{{ request()->routeIs('patient.appointment') ? 'active' : '' }}">
            Appointment
        </a>
    </li>
    <li>
        <a href="{{ route('patient.book_appointment') }}" 
           class="{{ request()->routeIs('patient.book_appointment') ? 'active' : '' }}">
            Schedule Appointment
        </a>
    </li>
    <li>
        <a href="{{ route('logout') }}" 
           class="{{ request()->routeIs('logout') ? 'active' : '' }}">
            Logout
        </a>
    </li>
</ul>