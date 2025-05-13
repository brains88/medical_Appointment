@include('layouts.header')

<body>
    <section class="dashboard mt_100 xs_mt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                    @include('layouts.admin_navbar')
                </div>
            
                <div class="col-xl-9 col-lg-8">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Doctors</h1>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                            <i class="fas fa-plus me-1"></i> Add Doctor
                        </button>
                    </div>
                    
                    <div class="card appointment-table mb-4 user_profile">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Doctor List</h5>
                            <span class="badge bg-primary">
                                Total: {{ $doctors->total() }}
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Joined At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($doctors as $doctor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $doctor->name }}</td>
                                            <td>{{ $doctor->department }}</td>
                                            <td>{{ $doctor->mobile }}</td>
                                            <td>{{ $doctor->email }}</td>
                                            <td>{{ $doctor->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info view-stats" 
                                                    data-doctor-id="{{ $doctor->id }}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#statsModal">
                                                    <i class="fas fa-chart-bar"></i> Stats
                                                </button>
                                            </td>
                                            <td>
                                            <form action="{{ route('admin.doctors.delete', $doctor->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this Doctor?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-user-md fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">No doctors found</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($doctors->hasPages())
                    <div class="card-footer bg-white py-2">
                        <div class="d-flex justify-content-end">
                            {{ $doctors->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Modal -->
    <div class="modal fade" id="statsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-chart-pie me-2"></i>Appointment Statistics
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="statsContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Doctor Modal -->
    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-md me-2"></i>Add New Doctor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDoctorForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department" name="department" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Stats viewer
            document.querySelectorAll('.view-stats').forEach(btn => {
                btn.addEventListener('click', function() {
                    const doctorId = this.getAttribute('data-doctor-id');
                    const content = document.getElementById('statsContent');
                    
                    fetch(`/admin/doctors/${doctorId}/stats`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            content.innerHTML = `
                                <div class="row text-center">
                                    <div class="col-md-6 mb-3">
                                        <div class="card stat-card total">
                                            <div class="card-body">
                                                <h6 class="text-muted">Total Appointments</h6>
                                                <h3>${data.total}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card stat-card pending">
                                            <div class="card-body">
                                                <h6 class="text-muted">Pending</h6>
                                                <h3>${data.pending}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card stat-card active">
                                            <div class="card-body">
                                                <h6 class="text-muted">Active</h6>
                                                <h3>${data.active}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card stat-card expired">
                                            <div class="card-body">
                                                <h6 class="text-muted">Expired</h6>
                                                <h3>${data.expired}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        })
                        .catch(error => {
                            content.innerHTML = `
                                <div class="alert alert-danger">
                                    Failed to load statistics: ${error.message}
                                </div>`;
                        });
                });
            });

            // Add doctor form
            document.getElementById('addDoctorForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                
                fetch('/admin/doctors', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to add doctor'));
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Add Doctor';
                });
            });
        });
    </script>
</body>
</html>