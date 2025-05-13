@include('layouts.header')
<style>

.patient-avatar {
    object-fit: cover;
    border: 2px solid #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    width: 50px !important;
    height:50px !important;
}

.patient-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

    .stat-card {
    border-radius: 8px;
    border-left: 4px solid;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.stat-card.total { border-left-color: #3498db; }
.stat-card.pending { border-left-color: #f39c12; }
.stat-card.active { border-left-color: #2ecc71; }
.stat-card.expired { border-left-color: #e74c3c; }
    </style>
<body>
    <section class="dashboard mt_100 xs_mt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                    @include('layouts.admin_navbar')
                </div>
            
                <div class="col-xl-9 col-lg-8 user_profile">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Patients</h1>
                    </div>
                    
                    <div class="card appointment-table mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Patient List</h5>
                            <span class="badge bg-primary">
                                Total: {{ $patients->total() }}
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Image & Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Joined At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($patients as $patient)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $patient->image ? asset('storage/public/images/' . $patient->image) : asset('assets/images/default-avatar.jpg') }}" 
                                                        class="rounded-circle me-2 patient-avatar"
                                                        alt="{{ $patient->name }}">
                                                    <span>{{ $patient->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $patient->mobile }}</td>
                                            <td>{{ $patient->email }}</td>
                                            <td>{{ $patient->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info view-stats" 
                                                    data-patient-id="{{ $patient->id }}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#statsModal">
                                                    <i class="fas fa-chart-bar"></i> View Stats
                                                </button>
                                            </td>
                                            <!-- Patient Delete Button 
                                            <td>
                                            <form action="{{ route('admin.patients.delete', $patient->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this Patient?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        </td>
                                       End of Patient Delete Button -->
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">No patients found</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($patients->hasPages())
                        <div class="card-footer bg-white">
                            {{ $patients->links() }}
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

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Stats viewer
            document.querySelectorAll('.view-stats').forEach(btn => {
                btn.addEventListener('click', function() {
                    const patientId = this.getAttribute('data-patient-id');
                    const content = document.getElementById('statsContent');
                    
                    fetch(`/admin/patients/${patientId}/stats`)
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
        });
    </script>
</body>
</html>