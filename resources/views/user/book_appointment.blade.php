@include('layouts.header')

<style>
    /* Modern Form Styling */
    .appointment-form {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }
    
    .form-header {
        margin-bottom: 30px;
        text-align: center;
    }
    
    .form-header h5 {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    .form-header p {
        color: #7f8c8d;
        font-size: 14px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #34495e;
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
        background-color: #f9f9f9;
    }
    
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        background-color: #fff;
    }
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 15px;
    }
    
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    
    .submit-btn {
        background: #3498db;
        color: white;
        border: none;
        padding: 14px 25px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .submit-btn:hover {
        background: #2980b9;
        transform: translateY(-2px);
    }
    
    .submit-btn:active {
        transform: translateY(0);
    }
    
    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .doctor-card {
        display: none;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        border-left: 4px solid #3498db;
    }
    
    .doctor-card.active {
        display: block;
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .availability-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        margin-left: 10px;
    }
    
    .available {
        background: #2ecc71;
        color: white;
    }
    
    .unavailable {
        background: #e74c3c;
        color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .appointment-form {
            padding: 20px;
        }
    }
</style>

<body>
<section class="dashboard mt_100 xs_mt_70 pb_100 xs_pb_70">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                @include('layouts.usernavbar')
            </div>

            <div class="col-xl-9 col-lg-8 wow fadeInRight" data-wow-duration="1s">
                <div class="appointment-form">
                    <div class="form-header">
                        <h5>Book New Appointment</h5>
                        <p>Fill out the form below to schedule your appointment</p>
                    </div>
                    
                    <form id="appointmentForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Doctor Selection -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                <label class="form-label" for="doctor">Select Doctor</label>
                                    <select name="doctor" id="doctorSelect" class="form-control" required>
                                        <option value="">-- Select a Doctor --</option>
                                        @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->department }}</option>
                                            @endforeach
                                    </select>
                                    <div id="availabilityStatus" class="mt-2 text-info"></div>
                                </div>
                                
                             <!-- Doctor Info Card (shown when doctor is selected) -->
                            <div id="doctorInfoCard" class="doctor-card bg-light p-3 rounded mb-3" style="display: none;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1" id="doctorName"></h5>
                                        <p class="mb-1"><strong>Specialty:</strong> <span id="doctorSpecialty" class="text-muted"></span></p>
                                    </div>
                                    <span id="availabilityBadge" class="badge"></span>
                                </div>
                                <p class="mb-0"><small id="availabilityMessage" class="text-muted"></small></p>
                            </div>
                            
                            <!-- Date Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="appointmentDate">Appointment Date</label>
                                    <input type="date" 
                                           name="date" 
                                           id="appointmentDate" 
                                           class="form-control" 
                                           min="{{ date('Y-m-d') }}" 
                                           max="{{ date('Y-m-d', strtotime('+30 days')) }}" 
                                           required>
                                </div>
                            </div>
                            
                            <!-- Time Slot Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="timeSlot">Time Slot</label>
                                    <select name="time" id="timeSlot" class="form-control" required>
                                        <option value="">-- Select a Time Slot --</option>
                                        <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                        <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                        <option value="02:00 PM - 03:00 PM">02:00 PM - 03:00 PM</option>
                                        <option value="03:00 PM - 04:00 PM">03:00 PM - 04:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Symptoms/Message -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="patientMessage">Describe Your Symptoms</label>
                                    <textarea name="message" 
                                              id="patientMessage" 
                                              class="form-control" 
                                              rows="5" 
                                              placeholder="Please describe your symptoms or reason for the appointment..."></textarea>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <button type="submit" class="submit-btn">
                                    <span id="buttonText" class="text-white">Book Appointment</span>
                                    <div id="loadingSpinner" class="loading-spinner"></div>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Alert Container -->
                        <div id="alertContainer" class="mt-4"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Doctor selection handler
    document.getElementById('doctorSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const doctorCard = document.getElementById('doctorInfoCard');
    const availabilityBadge = document.getElementById('availabilityBadge');
    const availabilityMessage = document.getElementById('availabilityMessage');
    
    if (this.value) {
        // Update doctor info
        document.getElementById('doctorName').textContent = selectedOption.text;
        document.getElementById('doctorSpecialty').textContent = selectedOption.dataset.specialty || 'General Practitioner';
        
        // Set availability display
        const availability = selectedOption.dataset.availability || 'available';
        
        // Update badge styling based on availability
        availabilityBadge.className = 'badge ' + 
            (availability === 'available' ? 'bg-success' : 
             availability === 'on_leave' ? 'bg-warning' : 'bg-secondary');
             
        availabilityBadge.textContent = 
            availability === 'available' ? 'Available' :
            availability === 'on_leave' ? 'On Leave' : 'Unavailable';
        
        // Set appropriate message
        availabilityMessage.textContent = 
            availability === 'available' ? 'Accepting new appointments' :
            availability === 'on_leave' ? 'Temporarily unavailable - on leave' : 
            'Currently not accepting appointments';
        
        // Show the card
        doctorCard.style.display = 'block';
    } else {
        doctorCard.style.display = 'none';
    }
});

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
    // Form submission handler
            document.getElementById('appointmentForm').addEventListener('submit', function (event) {
            event.preventDefault();  // Prevent default form submission

            const form = this;
            const formData = new FormData(form);
            const alertContainer = document.getElementById('alertContainer');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const buttonText = document.getElementById('buttonText');

            // Clear previous alert messages
            alertContainer.innerHTML = '';

            // Show spinner and disable button
            loadingSpinner.style.display = 'block';
            buttonText.textContent = 'Processing...';
            form.querySelector('button[type="submit"]').disabled = true;

            // Submit form data via fetch
            fetch("{{ route('patient.book_appointment.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Accept": "application/json"
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
                loadingSpinner.style.display = 'none';
                buttonText.textContent = 'Book Appointment';
                form.querySelector('button[type="submit"]').disabled = false;

                if (data.success) {
                    // Show success message
                    alertContainer.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show">
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;

                    // Optionally, reset the form
                    form.reset();
                    document.getElementById('doctorInfoCard').style.display = 'none';

                    // Redirect to a confirmation page or dashboard
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 2000);
                    }
                } else {
                    // Show error message
                    alertContainer.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                }
            })
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
            
    // Initialize date picker with disabled past dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointmentDate').min = today;
</script>
</body>
</html>