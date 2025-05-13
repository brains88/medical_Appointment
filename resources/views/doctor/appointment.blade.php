@include('layouts.header')

<style>
    /* Improved message modal styling */
    .message-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
        overflow: auto;
    }

    

    .message-modal-content {
        background: white;
        margin: 5% auto;
        padding: 25px;
        border-radius: 10px;
        width: 60%;
        max-width: 700px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .close-message {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }
    
    .close-message:hover {
        color: #333;
    }
    .voice_call_btn,
    .video_call_btn,
    .email_btn {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        margin: 0 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .voice_call_btn:hover,
    .video_call_btn:hover,
    .email_btn:hover {
        background: #fff;
        color: #0056b3;
        border: 1px solid #0056b3;
    }

    .voice_call_btn i,
    .video_call_btn i,
    .email_btn i {
        font-size: 16px;
    }

    .text-danger {
        color: #dc3545;
        font-weight: bold;
    }

    /* Video Call Modal Styles */
    #videoCallModal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
    }

    .video-call-container {
        background: white;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 900px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        cursor: pointer;
    }

    #localVideo {
        width: 200px;
        position: absolute;
        bottom: 20px;
        right: 20px;
        border: 2px solid white;
        border-radius: 5px;
        z-index: 100;
    }

    #remoteVideo {
        width: 100%;
        height: 500px;
        background: #333;
        border-radius: 5px;
    }

    .call-controls {
        margin-top: 15px;
        text-align: center;
    }

    .control-btn {
        background: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin: 0 10px;
        cursor: pointer;
        font-size: 18px;
    }

    .end-call-btn {
        background: #dc3545;
    }

    .call-status {
        text-align: center;
        margin: 10px 0;
        font-weight: bold;
    }
</style>

<body>
<!--============================
    APPOINTMENT START
==============================-->
<section class="dashboard mt_100 xs_mt_70 pb_100 xs_pb_70">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                @include('layouts.doctor_navbar')
            </div>

            <div class="col-xl-9 col-lg-8 wow fadeInRight" data-wow-duration="1s">
            <div class="dashboard_content">
                    <h5>Appointment Details</h5>
                    <div class="appointment_history">
                        <div class="table-responsive">
                        <table class="table">
                            <tbody class="tf_dashboard__listing_body">
                                <tr>
                                    <th class="um_sn"><p>SL</p></th>
                                    <th class="um_name"><p>Doctor</p></th>
                                    <th class="um_name"><p>Department</p></th>
                                    <th class="um_date"><p>Date</p></th>
                                    <th class="um_duration"><p>Time</p></th>
                                    <th class="um_action"><p>Action</p></th>
                                </tr>
                            </thead>
                            <tbody class="tf_dashboard__listing_body">
                                @foreach($doctor->appointments as $index => $appointment)
                                <tr class="tabile_row">
                                    <td class="um_sn">{{ $index + 1 }}</td>
                                    <td class="um_name">
                                        {{ $appointment->patient->name }}
                                    </td>
                                    <td class="um_date">
                                        {{ $appointment->appointment_date->format('M d, Y') }}
                                    </td>
                                    <td class="um_duration">
                                        {{ $appointment->appointment_time }}
                                    </td>
                                    <td>
                                       @include('components.status-badge', ['status' => $appointment->status])
                                            </td>
                                            @if($appointment->status=='pending' || $appointment->status=='rejected' )
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $appointment->id }}">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $appointment->id }}">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </div>
                                            </td>
                                            @endif
                                    <td class="um_action">
                                        <!-- View Message Button -->
                                        <button class="action-btn view_message_btn" 
                                                onclick="showMessage('{{ addslashes($appointment->message) }}')">
                                            <i class="fas fa-envelope"></i> Message
                                        </button>
                                        
                                        @if($appointment->status === 'confirmed' && $appointment->appointment_date >= now()->toDateString())
                                            <!-- Action buttons for upcoming confirmed appointments -->
                                            <button class="action-btn voice_call_btn" 
                                                    onclick="initiateVoiceCall('{{ $appointment->patient->mobile }}')">
                                                <i class="fas fa-phone"></i> Call
                                            </button>
                                            <button class="action-btn video_call_btn" 
                                                    onclick="initiateVideoCall('{{ $appointment->id }}', '{{ $doctor->id }}')">
                                                <i class="fas fa-video"></i> Video
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    APPOINTMENT END
==============================-->

<!-- Message Modal -->
<div id="messageModal" class="message-modal">
    <div class="message-modal-content">
        <span class="close-message" onclick="closeMessageModal()">&times;</span>
        <h4><i class="fas fa-envelope-open-text me-2"></i>Patient Message</h4>
        <div id="messageContent" class="mt-3 p-3 bg-light rounded">
            <!-- Message content will be inserted here -->
        </div>
        <div class="mt-3 text-end">
            <button class="btn btn-secondary" onclick="closeMessageModal()">Close</button>
        </div>
    </div>
</div>

<!-- Video Call Modal -->
<div id="videoCallModal">
    <div class="video-call-container">
        <span class="close-btn" onclick="endCall()">&times;</span>
        <div class="call-status" id="callStatus">Waiting for connection...</div>
        <video id="remoteVideo" autoplay playsinline></video>
        <video id="localVideo" autoplay playsinline muted></video>
        <div class="call-controls">
            <button class="control-btn" onclick="toggleMute()">
                <i class="fas fa-microphone"></i>
            </button>
            <button class="control-btn" onclick="toggleVideo()">
                <i class="fas fa-video"></i>
            </button>
            <button class="control-btn end-call-btn" onclick="endCall()">
                <i class="fas fa-phone-slash"></i>
            </button>
        </div>
    </div>
</div>

@include('layouts.footer')

<!-- PeerJS for video calls -->
<script src="https://unpkg.com/peerjs@1.4.7/dist/peerjs.min.js"></script>

<!-- In your doctor dashboard, update the JavaScript section: -->
<script>


document.querySelectorAll('.approve-btn, .reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-id');
            const action = this.classList.contains('approve-btn') ? 'confirmed' : 'cancelled';
            const button = this;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            // Disable button during processing
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing';

            fetch(`/doctor/appointments/${appointmentId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: action
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Find the row and update status
                    const row = button.closest('tr');
                    row.querySelector('.badge').outerHTML = data.status_badge;
                    
                    // Remove action buttons
                    row.querySelector('td:last-child').innerHTML = 
                        `<span class="text-muted">Processed</span>`;
                    
                    // Show success message
                    showToast('success', data.message);
                }
            })
            .catch(error => {
                button.disabled = false;
                button.innerHTML = action === 'confirmed' 
                    ? '<i class="fas fa-check"></i> Approve' 
                    : '<i class="fas fa-times"></i> Reject';
                
                const message = error.message || 'An error occurred';
                showToast('error', message);
            });
        });
    });

    // PeerJS variables
    let peer;
    let currentCall;
    let localStream;
    let isMuted = false;
    let isVideoOff = false;
    
    // Initialize PeerJS when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializePeerConnection();
    });

    function initializePeerConnection() {
        try {
            console.log('Initializing PeerJS for doctor-{{ $doctor->id }}');
            
            // CORRECTED STUN SERVER CONFIGURATION
            peer = new Peer(`doctor-{{ $doctor->id }}`, {
                debug: 3,
                config: {
                    iceServers: [
                        // Valid STUN servers
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' },
                        { urls: 'stun:stun2.l.google.com:19302' }
                        
                        // For production, add your TURN server here:
                        // {
                        //   urls: 'turn:your.turn.server:3478',
                        //   username: 'your_username',
                        //   credential: 'your_password'
                        // }
                    ]
                }
            });
            
            peer.on('open', (id) => {
                console.log('Doctor PeerJS connection open with ID:', id);
            });
            
            // Handle incoming calls - UPDATED WITH BETTER ERROR HANDLING
            peer.on('call', async (call) => {
                console.log('Incoming call from:', call.peer);
                
                try {
                    // Show the video call modal
                    document.getElementById('videoCallModal').style.display = 'block';
                    document.getElementById('callStatus').textContent = 'Incoming call...';
                    
                    // Get user media
                    const stream = await navigator.mediaDevices.getUserMedia({ 
                        video: true, 
                        audio: true 
                    });
                    
                    console.log('Doctor obtained local media stream');
                    
                    // Show local video
                    document.getElementById('localVideo').srcObject = stream;
                    localStream = stream;
                    
                    // Answer the call with our stream
                    call.answer(stream);
                    currentCall = call;
                    console.log('Doctor answered the call');
                    
                    // Handle the stream from the caller
                    call.on('stream', (remoteStream) => {
                        console.log('Received remote stream from patient');
                        document.getElementById('remoteVideo').srcObject = remoteStream;
                        document.getElementById('callStatus').textContent = 'Call connected';
                    });
                    
                    // Handle call ending
                    call.on('close', endCall);
                    call.on('error', (err) => {
                        console.error('Call error:', err);
                        document.getElementById('callStatus').textContent = 'Call error: ' + err.message;
                        setTimeout(endCall, 2000);
                    });
                    
                } catch (err) {
                    console.error('Call handling error:', err);
                    document.getElementById('callStatus').textContent = 
                        'Error: ' + (err.message || 'Failed to handle call');
                    endCall();
                }
            });
            
            // Handle errors
            peer.on('error', (err) => {
                console.error('PeerJS error:', err);
                alert('Connection error: ' + err.message);
            });
            
        } catch (err) {
            console.error('PeerJS initialization failed:', err);
            alert('Failed to initialize video call system. Please refresh the page.');
        }
    }

    // Properly defined endCall function
    function endCall() {
        try {
            console.log('Ending call...');
            
            if (currentCall) {
                currentCall.close();
                currentCall = null;
            }
            
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
                localStream = null;
            }
            
            document.getElementById('videoCallModal').style.display = 'none';
            document.getElementById('remoteVideo').srcObject = null;
            document.getElementById('localVideo').srcObject = null;
            
        } catch (err) {
            console.error('Error ending call:', err);
        }
    }

    // Toggle mute function
    function toggleMute() {
        if (localStream) {
            const audioTracks = localStream.getAudioTracks();
            audioTracks.forEach(track => {
                track.enabled = !track.enabled;
            });
            isMuted = !isMuted;
            const muteBtn = document.querySelector('.control-btn:nth-child(1)');
            muteBtn.innerHTML = isMuted 
                ? '<i class="fas fa-microphone-slash"></i>' 
                : '<i class="fas fa-microphone"></i>';
        }
    }

    // Toggle video function
    function toggleVideo() {
        if (localStream) {
            const videoTracks = localStream.getVideoTracks();
            videoTracks.forEach(track => {
                track.enabled = !track.enabled;
            });
            isVideoOff = !isVideoOff;
            const videoBtn = document.querySelector('.control-btn:nth-child(2)');
            videoBtn.innerHTML = isVideoOff 
                ? '<i class="fas fa-video-slash"></i>' 
                : '<i class="fas fa-video"></i>';
        }
    }

    // Message modal functions
    function showMessage(message) {
        const messageContent = document.getElementById('messageContent');
        messageContent.innerHTML = message 
            ? `<p>${message.replace(/\n/g, '<br>')}</p>` 
            : '<p class="text-muted">No message provided</p>';
        document.getElementById('messageModal').style.display = 'block';
    }

    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
    }
</script>

</body>
</html>