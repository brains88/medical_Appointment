  @include('layouts.header')

<body>
  <!--============================
        DASHBOARD START
    ==============================-->
    <section class="dashboard mt_100 xs_mt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                @include('layouts.usernavbar')
                </div>

                <div class="col-xl-9 col-lg-8 mb-5">
                    <div class="dashboard_content">
                        <h5>overview</h5>

                        <div class="row">
                            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                <div class="dashboard_overview">
                                    <div class="icon"><i class="fal fa-handshake"></i></div>
                                    <div class="text">
                                        <p>Total Appointments</p>
                                        <h3>{{ $appointmentStats['total'] }}</h3>
                                        <p>{{ $appointmentStats['today'] }} Today</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                <div class="dashboard_overview">
                                    <div class="icon"><i class="far fa-check-circle"></i></div>
                                    <div class="text">
                                        <p>Active Appointments</p>
                                        <h3>{{ $appointmentStats['active'] }}</h3>
                                        <p>Upcoming</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                <div class="dashboard_overview">
                                    <div class="icon"><i class="far fa-calendar-times"></i></div>
                                    <div class="text">
                                        <p>Expired/Cancelled</p>
                                        <h3>{{ $appointmentStats['expired'] }}</h3>
                                        <p>Past appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dashboard_profile mt-5">
                            <h5>Profile information</h5>
                            <!-- Edit Profile Button 
                            <a href="dashboard_profile_edit.html">edit</a>
                            -->
                            <ul class="list-unstyled">
                            <li><span>Name:</span> {{ $patient->name }}</li>
                            <li><span>Phone:</span> {{ $patient->mobile }}</li>
                            <li><span>Email:</span> {{ $user->email }}</li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        DASHBOARD END
    ==============================-->
    
@include('layouts.footer')
</body>

</html>