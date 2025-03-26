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
                        <h1>sign in</h1>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li>Sign In</li>
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
    SIGN IN START
==============================-->
<section class="sign_up pt_100 xs_pt_70 pb_100 xs_pb_70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-md-9 col-lg-6 wow fadeInUp" data-wow-duration="1s">
                <div class="sign_up_form">
                    <form id="loginForm">
                        @csrf <!-- CSRF Token -->
                        <input type="text" id="email" name="email" placeholder="Email">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <button class="common_btn w-100">
                            <span id="spinner" class="d-none text-white">Loading...</span>
                            <span id="buttonText" class="text-white">Login</span>
                        </button>
                        <!-- Alert container to show error or success messages -->
                        <div id="alertContainer" class="mt-3"></div>
                        <p class="tf_new_account">Don’t Have An Appointment? <a href="{{route('appointment')}}">Sign Up</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    SIGN IN END
==============================-->
@include('layouts.footer')

    <script>
document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Prevent default form submission

    const form = this;
    const email = form.querySelector('input[name="email"]').value.trim();
    const password = form.querySelector('input[name="password"]').value.trim();
    const alertContainer = document.getElementById('alertContainer');

    // Clear previous alert messages
    alertContainer.innerHTML = '';

    // Basic validation
    if (!email || !password) {
        alertContainer.innerHTML = `<div class="alert alert-danger">Please fill in all fields.</div>`;
        return;
    }

    const formData = new FormData(form);
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('buttonText');

    // Show spinner and disable button
    spinner.classList.remove('d-none');
    buttonText.classList.add('d-none');

    // Submit form data via fetch
    fetch("{{ route('login.auth') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        spinner.classList.add('d-none');  // Hide spinner
        buttonText.classList.remove('d-none');  // Show button text

        if (data.success) {
            // Show success message
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;

            // Redirect to dashboard or appropriate page
            setTimeout(() => {
                window.location.href = data.redirect; // Redirect to dashboard or provided URL
            }, 2000);
        } else {
            // Show error message
            alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        spinner.classList.add('d-none');  // Hide spinner on error
        buttonText.classList.remove('d-none');  // Show button text
        console.error(error);  // Log the error to the console for debugging
        alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again later.</div>`;
    });
});
</script>
</body>
</html>