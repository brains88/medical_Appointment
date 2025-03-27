<style>
    .initials-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 24px;
    margin: 0 auto;
}
    </style>

                <div class="user_profile">
                    <div class="user_profile_initials">
                        @php
                            // Get the first two letters of the doctor's name
                            $initials = strtoupper(substr($doctor->name, 0, 2));
                            // Generate a random background color (or use a fixed one)
                            $bgColor = '#' . substr(md5($doctor->name), 0, 6); // Creates a unique color based on name
                        @endphp
                        <div class="initials-circle" style="background-color: {{ $bgColor }};">
                            {{ $initials }}
                        </div>
                    </div>
                        <h4>{{$doctor->name}}</h4>
                    </div>
                    <ul class="dashboard_menu">
                    <li>
                        <a href="{{ route('doctor.dashboard') }}" 
                        class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.appointment') }}" 
                        class="{{ request()->routeIs('doctor.appointment') ? 'active' : '' }}">
                            Appointment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" 
                        class="{{ request()->routeIs('logout') ? 'active' : '' }}">
                            Logout
                        </a>
                    </li>
                </ul>