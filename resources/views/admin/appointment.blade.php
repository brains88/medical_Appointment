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
                        <h1 class="h2">Patients Appointment(s)</h1>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" id="refreshBtn">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                    
                    <div class="card appointment-table mb-4 user_profile">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Appointments</h5>
                            <span class="badge bg-primary">
                                Total: {{ $appointments->total() }}
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Department</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($appointments as $appointment)
                                        <tr>
                                            <td>#{{ $appointment->id }}</td>
                                            <td>{{ $appointment->patient->name }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td>{{ $appointment->doctor->department }}</td>
                                            <td>
                                                <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                                                <div class="text-muted small">{{ $appointment->appointment_time }}</div>
                                            </td>
                                            <td>
                                                @include('components.status-badge', ['status' => $appointment->computed_status])
                                            </td>
                                            <td>
                                                @if($appointment->message)
                                                <button class="btn btn-sm btn-outline-info view-message" 
                                                    data-id="{{ $appointment->id }}"
                                                    title="View message">
                                                    <i class="fas fa-envelope-open-text"></i>
                                                </button>
                                                @else
                                                <span class="text-muted small">None</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <i class="far fa-calendar-times fa-2x mb-2"></i>
                                                <p>No appointments found</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($appointments->hasPages())
                        <div class="card-footer bg-white">
                            {{ $appointments->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-envelope me-2"></i>Patient Message
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="messageContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
<!-- Required Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Make sure jQuery isn't conflicting (remove if not needed) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Refresh button
            document.getElementById('refreshBtn').addEventListener('click', function() {
                window.location.reload();
            });

            // Message viewer
            document.querySelectorAll('.view-message').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modalElement = document.getElementById('messageModal');
                    const modal = new bootstrap.Modal(modalElement); // Pass element, not string
                    const content = document.getElementById('messageContent');
                    const id = this.dataset.id;
                    
                    content.innerHTML = `
                        <div class="text-center py-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>`;
                    
                    modal.show();
                    
                    fetch(`/admin/appointments/${id}/message`) // Matches your route
                        .then(r => {
                            if (!r.ok) throw new Error('Network response was not ok');
                            return r.json();
                        })
                        .then(data => {
                            content.innerHTML = `
                                <div class="message-container bg-light p-3 rounded">
                                    <p class="mb-0">${data.message}</p>
                                </div>`;
                        })
                        .catch(() => {
                            content.innerHTML = `
                                <div class="alert alert-danger">
                                    Failed to load message
                                </div>`;
                        });
                });
            });
        });
    </script>
</body>
</html>