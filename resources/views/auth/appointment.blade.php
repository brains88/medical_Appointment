@include('layouts.header')

<body>
@include('layouts.navbar')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section class="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_text">
                        <h1>Appointment</h1>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li>Appointment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        APPOINTMENT PAGE START
    ==============================-->
    <section class="appointment_page pt_100 xs_pt_65 pb_100 xs_pb_70">
        <div class="container">
            <div class="appointment_content">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                        <div class="appointment_page_img">
                            <img src="https://media.istockphoto.com/id/1073728878/photo/focused-on-saving-a-life.jpg?s=612x612&w=0&k=20&c=MGUPBEHFr9sFWO4VsKy0VnsVcskdNT51u1bpaHi8oSs=" alt="appointment" class="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 wow fadeInRight" data-wow-duration="1s">
                        <div class="appointment_page_text">
                        <form id="appointmentForm">
                            @csrf <!-- Add the CSRF token -->
                            <h2>Book Appointment</h2>
                            <p>Schedule your visit with ease! Our online booking system allows you to choose a convenient date and time for your appointment. Whether it's a routine check-up or a specialized consultation, we’re here to provide you with the best care at your convenience.</p>
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
                                    <div id="availabilityStatus" class="mt-2 text-info"></div>
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
                </div>
            </div>
        </div>
    </section>
    <!--============================
        APPOINTMENT PAGE END
    ==============================-->

@include('layouts.footer')

<script>
//Check Doctor Availability
document.addEventListener('DOMContentLoaded', function () {
    const doctorSelect = document.querySelector('select[name="doctor"]');
    const dateInput = document.querySelector('input[name="date"]');
    const timeSelect = document.querySelector('select[name="time"]');
    const statusDiv = document.getElementById('availabilityStatus');

    function checkAvailability() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;
        const time = timeSelect.value;

        if (doctorId && date && time) {
            statusDiv.innerHTML = '<span>Checking availability...</span>';

            fetch(`/check-doctor-availability?doctor_id=${doctorId}&date=${date}&time=${encodeURIComponent(time)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        statusDiv.innerHTML = '<span class="text-success">Doctor is available ✅</span>';
                    } else {
                        statusDiv.innerHTML = '<span class="text-danger">Doctor is not available ❌</span>';
                    }
                })
                .catch(error => {
                    console.error('Error checking availability:', error);
                    statusDiv.innerHTML = '<span class="text-danger">Error checking availability.</span>';
                });
        } else {
            statusDiv.innerHTML = '';
        }
    }

    if (doctorSelect && dateInput && timeSelect) {
        doctorSelect.addEventListener('change', checkAvailability);
        dateInput.addEventListener('change', checkAvailability);
        timeSelect.addEventListener('change', checkAvailability);
    } else {
        console.error("One or more form fields not found in DOM");
    }
});

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
    spinner.classList.add('d-none');
    buttonText.classList.remove('d-none');

    // Custom error from server
    if (error.message) {
        alertContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
    }
    // Validation errors
    else if (error.errors) {
        let errorList = '<div class="alert alert-danger"><ul>';
        for (const [field, messages] of Object.entries(error.errors)) {
            messages.forEach(message => {
                errorList += `<li>${message}</li>`;
            });
        }
        errorList += '</ul></div>';
        alertContainer.innerHTML = errorList;
    } else {
        alertContainer.innerHTML = `<div class="alert alert-danger">An unexpected error occurred. Please try again later.</div>`;
    }
});
});
    </script>
</body>

</html>