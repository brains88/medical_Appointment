@include('layouts.header')

<body>
@include('layouts.navbar')
<style>
/* Banner Layout */
.banner {
    overflow: hidden;
}

.banner_left {
    padding: 100px 0;
}

.banner_right {
    position: relative;
    height: 100%;
    min-height: 600px;
}

/* Doctor Image */
.doctor_img {
    position: absolute;
    bottom: 0;
    right: 0;
    max-width: 80%;
}

</style>
<!--============================
    BANNER START
==============================-->
<section class="banner">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Left Side: Text Content -->
            <div class="col-lg-6 d-flex align-items-center banner_left" style="background: linear-gradient(135deg, rgba(10, 80, 150, 0.9), rgba(0, 120, 200, 0.9));">
                <div class="banner_text p-5 wow fadeInLeft" data-wow-duration="1s">
                    <h5 class="text-white">Welcome to MadiFax</h5>
                    <h1 class="text-white mb-4">Your Health, Our Commitment</h1>
                    <p class="text-white mb-4">At MadiFax, we combine cutting-edge technology with compassionate care to provide you with the best healthcare experience. Your well-being is our top priority.</p>
                    
                    <!-- Call-to-Action Buttons -->
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{route('appointment')}}" class="common_btn" style="background-color:white; color:#00a6fb;">Schedule An Appointment</a>
                    </div>

                    <!-- Stats Counter -->
                    <ul class="banner_counter d-flex flex-wrap mt-5">
                        <li class="text-center">
                            <h3 class="text-white"><span class="counter">355</span>k+</h3>
                            <p class="text-white">Happy Patients</p>
                        </li>
                        <li class="text-center">
                            <h3 class="text-white"><span class="counter">98</span>%</h3>
                            <p class="text-white">Satisfaction Rate</p>
                        </li>
                        <li class="text-center">
                            <h3 class="text-white"><span class="counter">120</span>+</h3>
                            <p class="text-white">Expert Doctors</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Image and Interactive Elements -->
            <div class="col-lg-6 banner_right" style="background: url(assets/images/banner.jpg); background-size: cover; background-position: center;">
                <div class="banner_interactive wow fadeInRight" data-wow-duration="1s">
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    BANNER END
==============================-->

    <!--============================
        ABOUT START
    ==============================-->
    <section class="about pt_100 xs_pt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-sm-9  col-lg-5 col-md-7 wow fadeInLeft" data-wow-duration="1s">
                    <div class="about_img">
                        <div class="about_img_1">
                            <img src="assets/images/about.jpg" alt="about img" class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12 col-lg-7  wow fadeInRight" data-wow-duration="1s">
                <div class="common_heading">
                    <h5>About Us</h5>
                    <h2>The Great Place of Medical Hospital Center</h2>
                    <p>At our Medical Hospital Center, we are dedicated to providing exceptional healthcare services with compassion and expertise. Our state-of-the-art facilities and highly skilled medical professionals ensure that you receive the best possible care. Whether it's routine check-ups, advanced treatments, or emergency services, we are here to support your health and well-being every step of the way.</p>
                </div>

                    <ul class="about_iteam d-flex flex-wrap">
                        <li>Ambulance Services</li>
                        <li>Oxygens on Wheel</li>
                        <li>Pharmacy on Clinic</li>
                        <li>On duty Doctors</li>
                        <li>24/7 Medical Emergency</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        ABOUT END
    ==============================-->


    <!--============================
        SERVICE START
    ==============================-->
    <section class="service" style="background: url(assets/images/service_bg.jpg);">
    <div class="service_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="common_heading center_heading mb_15">
                        <h5>Our Services</h5>
                        <h2>Comprehensive Medical Care</h2>
                    </div>
                </div>
            </div>
            <div class="row service_slider">
                <!-- Service 1: Online Monitoring -->
                <div class="col-xxl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_service">
                        <div class="service_img">
                            <span class="tf_service_icon"><i class="fas fa-eye"></i></span>
                            <img src="https://www.shutterstock.com/image-photo/african-female-doctor-holding-phone-600nw-1763113577.jpg" alt="Online Monitoring" class="img-fluid w-100">
                        </div>
                        <div class="service_text">
                            <a  class="service_heading">Online Monitoring</a>
                            <p>Stay connected with our 24/7 online monitoring services. Track your health remotely with expert guidance from our medical team.</p>
                           
                        </div>
                    </div>
                </div>

                <!-- Service 2: Heart Surgery -->
                <div class="col-xxl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_service">
                        <div class="service_img">
                            <span class="tf_service_icon tf_service_icon2"><i class="fas fa-heartbeat"></i></span>
                            <img src="assets/images/Heart_Surgery.jpeg" alt="Heart Surgery" class="img-fluid w-100">
                        </div>
                        <div class="service_text">
                            <a  class="service_heading">Heart Surgery</a>
                            <p>Advanced heart surgery procedures performed by our skilled cardiologists to ensure your heart health is in the best hands.</p>
                           
                        </div>
                    </div>
                </div>

                <!-- Service 3: Diagnosis & Research -->
                <div class="col-xxl-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_service">
                        <div class="service_img">
                            <span class="tf_service_icon tf_service_icon3"><i class="fad fa-capsules"></i></span>
                            <img src="https://www.shutterstock.com/shutterstock/videos/1107477125/thumb/1.jpg?ip=x480" alt="Diagnosis & Research" class="img-fluid w-100">
                        </div>
                        <div class="service_text">
                            <a  class="service_heading">Diagnosis & Research</a>
                            <p>Cutting-edge diagnostic tools and research-driven approaches to provide accurate and timely medical solutions.</p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!--============================
        SERVICE END
    ==============================-->





<!--============================
    PROCESS START
==============================-->
<section class="process pt_100 xs_pt_70 pb_95 xs_pb_65" style="background: url(assets/images/work_bg.jpg);">
    <div class="container process_shape">
        <div class="row">
            <div class="col-xl-12">
                <div class="common_heading center_heading mb_25">
                    <h5>How We Work</h5>
                    <h2>Our Working Process</h2>
                </div>
            </div>
        </div>
        <div class="work_process_area">
            <div class="row">
                <!-- Step 1: Fill the Form -->
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_process">
                        <span class="process_number num1">01</span>
                        <h4>Fill the Form</h4>
                        <p>Start by filling out our simple online form with your basic details and medical history. This helps us understand your needs better.</p>
                    </div>
                </div>

                <!-- Step 2: Book an Appointment -->
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_process">
                        <span class="process_number num2">02</span>
                        <h4>Book an Appointment</h4>
                        <p>Choose a convenient date and time for your appointment. Our team will confirm your booking and provide all necessary details.</p>
                    </div>
                </div>

                <!-- Step 3: Check-Ups -->
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_process">
                        <span class="process_number num3">03</span>
                        <h4>Check-Ups</h4>
                        <p>Visit our facility for a thorough check-up. Our experienced doctors will assess your health and recommend the best course of action.</p>
                    </div>
                </div>

                <!-- Step 4: Get Reports -->
                <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="single_process">
                        <span class="process_number num4">04</span>
                        <h4>Get Reports</h4>
                        <p>Receive detailed reports and personalized treatment plans. Our team will guide you through the next steps for your health journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    PROCESS END
==============================-->


    <!--============================
        APPOINMENT START
    ==============================-->
    <section class="appoinment pt_185 xs_pt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="appoinment_bg" style="background: url(assets/images/appointment_bg.jpg);">
                <div class="appoinment_overlay">
                    <div class="row">
                        <div class="col-xl-7 col-lg-7 wow fadeInLeft" data-wow-duration="1s">
                            <div class="appoinment_form">
                                <div class="common_heading mb_30">
                                    <h5>Appointment</h5>
                                    <h2>Apply For Free Now</h2>
                                </div>
                         <form id="appointmentForm">
                            @csrf <!-- Add the CSRF token -->
                            <div class="row">
                                <!-- Patient Name -->
                                <div class="col-md-6">
                                    <div class="appoinment_page_input">
                                        <input type="text" name="patient_name" placeholder="Patient Name*" required>
                                    </div>
                                </div>
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="appoinment_page_input">
                                        <input type="text" name="phone" placeholder="Phone*" required>
                                    </div>
                                </div>
                                <!-- Date -->
                                <div class="col-md-6">
                                    <div class="appoinment_page_input">
                                        <input type="date" name="date" required>
                                    </div>
                                </div>
                                <!-- Time -->
                                <div class="col-md-6">
                                    <div class="appoinment_page_input">
                                        <select name="time" class="reservation_input select_2" required>
                                            <option value="">Select Time</option>
                                            <option value="10.00 am to 11.00 am">10.00 am to 11.00 am</option>
                                            <option value="11.00 am to 12.00 pm">11.00 am to 12.00 pm</option>
                                            <option value="3.00 pm to 4.00 pm">3.00 pm to 4.00 pm</option>
                                            <option value="4.00 pm to 5.00 pm">4.00 pm to 5.00 pm</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="appoinment_page_input">
                                        <input type="email" name="email" placeholder="Email*" required>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="appoinment_page_input">
                                        <input type="password" name="password" placeholder="Password*" required>
                                    </div>
                                </div>
                                <!-- Profile image -->
                                <div class="col-lg-12">
                                    <div class="appoinment_page_input">
                                        <input type="file" name="image" placeholder="image" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="appoinment_page_input">
                                        <select name="doctor" class="select_2" required>
                                            <option value="">Select Doctor & Department</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->department }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Message -->
                                <div class="col-lg-12">
                                    <div class="appoinment_page_input">
                                        <textarea name="message" rows="5" placeholder="Tell Us how you feel."></textarea>
                                        <button type="submit" class="common_btn">
                                            <span id="spinner" class="d-none text-white">Booking Appointment...</span>
                                            <span id="buttonText" class="text-white">Book Appointment</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                           <!-- Alert container to show error or success messages -->
                            <div id="alertContainer" class="mt-3"></div>
                        </form>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="appoinment_img">
                                <img src="https://img.freepik.com/free-photo/medium-shot-smiley-doctor-with-coat_23-2148814212.jpg" alt="appointment" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        APPOINMENT END
    ==============================-->

    @include('layouts.footer')
    <script>
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Prevent default form submission

    const form = this;
    const formData = new FormData(form);
    const alertContainer = document.getElementById('alertContainer');
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('buttonText');

    // Clear previous alert messages
    alertContainer.innerHTML = '';

    // Show spinner and disable button
    spinner.classList.remove('d-none');
    buttonText.classList.add('d-none');

    // Submit form data via fetch
    fetch("{{ route('appointment.store') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw err;
            });
        }
        return response.json();
    })
    .then(data => {
        spinner.classList.add('d-none');  // Hide spinner
        buttonText.classList.remove('d-none');  // Show button text

        if (data.success) {
            // Show success message
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;

            // Optionally, reset the form
            form.reset();

            // Redirect to a confirmation page or dashboard
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 2000);
        } else {
            // Show error message
            alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        spinner.classList.add('d-none');  // Hide spinner on error
        buttonText.classList.remove('d-none');  // Show button text

        if (error.errors) {
            // Display all validation errors in a single list
            let errorList = '<div class="alert alert-danger"><ul>';
            for (const [field, messages] of Object.entries(error.errors)) {
                messages.forEach(message => {
                    errorList += `<li>${message}</li>`;
                });
            }
            errorList += '</ul></div>';
            alertContainer.innerHTML = errorList;
        } else {
            // Show generic error message
            alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again later.</div>`;
        }
    });
});
    </script>
</body>

</html>