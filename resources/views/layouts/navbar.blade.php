<style>
    .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000; /* Ensure it's above other content */
}

/* Add padding to the top of the body or banner to prevent overlap */
body {
    padding-top: 70px; /* Adjust this value based on the height of your navbar */
}
    </style>
   
   <!--============================
    MAIN MENU START
==============================-->
<nav class="navbar navbar-expand-lg main_menu">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="../assets/images/Logo_1.png" alt="logo" class="img-fluid w-100">
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars bar_icon"></i>
            <i class="far fa-times close_icon"></i>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Push items to the right using ms-auto -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-dark" class="" href="{{route('login')}}" >Login</a>
            </li>
            </ul>

            <!-- Appointment Button -->
            <ul class="menu_btn d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{route('appointment')}}" class="common_btn">Appointment</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--============================
    MAIN MENU END
==============================-->