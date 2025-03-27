@include('layouts.header')

<style>
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
                @include('layouts.usernavbar')
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
                                @foreach($patient->appointments as $index => $appointment)
                                <tr class="tabile_row">
                                    <td class="um_sn"><p>{{ $index + 1 }}</p></td>
                                    <td class="um_name">
                                        <p>{{ $appointment->doctor->name }}</p>
                                    </td>
                                    <td class="um_name">
                                        <p>{{ $appointment->doctor->department }}</p>
                                    </td>
                                    <td class="um_date">
                                        <p>{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                        <span class="date_time">{{ $appointment->appointment_time }}</span>
                                    </td>
                                    <td class="um_duration">
                                        <p>{{ $appointment->appointment_time }}</p>
                                    </td>
                                    <td class="um_action">
                                        @if($appointment->status === 'pending')
                                            <span class="text-warning">Pending</span>
                                        @elseif($appointment->status === 'confirmed' && $appointment->appointment_date >= now()->toDateString())
                                            <!-- Action buttons for upcoming confirmed appointments -->
                                            <button class="voice_call_btn" title="Voice Call" onclick="initiateVoiceCall()">
                                                <i class="fas fa-phone"></i> Call
                                            </button>
                                            <button class="video_call_btn" title="Video Call" 
                                                onclick="initiateVideoCall('{{ $appointment->doctor->id }}')">
                                            <i class="fas fa-video"></i> Video
                                        </button>
                                            <button class="email_btn" title="Send Email" onclick="sendEmail()">
                                                <i class="fas fa-envelope"></i> Email
                                            </button>
                                        @else
                                            <span class="text-danger">
                                                {{ $appointment->status === 'cancelled' ? 'Cancelled' : 'Expired' }}
                                            </span>
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

<!-- Video Call Modal -->
<div id="videoCallModal">
    <div class="video-call-container">
        <span class="close-btn" onclick="endCall()">&times;</span>
        <div class="call-status" id="callStatus">Connecting to doctor...</div>
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

<!-- Include Twilio Video JS -->
<!-- Remove this line -->
<script src="https://sdk.twilio.com/js/video/releases/2.23.0/twilio-video.min.js"></script>

<!-- Add this to your patient dashboard -->
<script src="https://unpkg.com/peerjs@1.4.7/dist/peerjs.min.js"></script>
<script>
    // PeerJS variables
    let peer;
    let currentCall;
    let localStream;
    let isMuted = false;
    let isVideoOff = false;
    
    // Initialize PeerJS when page loads
    document.addEventListener('DOMContentLoaded', function() {
        try {
            console.log('Initializing PeerJS for patient-{{ $patient->id }}');
            
            peer = new Peer(`patient-{{ $patient->id }}`, {
                debug: 3,
                config: {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' },
                        { urls: 'stun:stun2.l.google.com:19302' }
                    ]
                }
            });
            
            peer.on('open', (id) => {
                console.log('Patient PeerJS ready with ID:', id);
            });
            
            peer.on('error', (err) => {
                console.error('PeerJS error:', err);
                alert('Connection error: ' + err.message);
            });
        } catch (err) {
            console.error('PeerJS initialization failed:', err);
            alert('Failed to initialize video call system');
        }
    });
    
    // Video call function - UPDATED
    async function initiateVideoCall(doctorId) {
        try {
            console.log(`Attempting to call doctor-${doctorId}`);
            
            // Show call modal
            const videoModal = document.getElementById('videoCallModal');
            const callStatus = document.getElementById('callStatus');
            
            videoModal.style.display = 'block';
            callStatus.textContent = 'Calling doctor...';
            
            // Get local media
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: true, 
                audio: true 
            });
            
            console.log('Patient obtained local media stream');
            
            // Show local video
            document.getElementById('localVideo').srcObject = stream;
            localStream = stream;
            
            // Call the doctor
            const call = peer.call(`doctor-${doctorId}`, stream);
            currentCall = call;
            console.log('Call initiated to doctor');
            
            // Handle remote stream
            call.on('stream', (remoteStream) => {
                console.log('Received remote stream from doctor');
                document.getElementById('remoteVideo').srcObject = remoteStream;
                callStatus.textContent = 'Call connected';
            });
            
            // Handle call ending
            call.on('close', () => {
                console.log('Call ended by doctor');
                endCall();
            });
            
            call.on('error', (err) => {
                console.error('Call error:', err);
                callStatus.textContent = 'Call failed: ' + err.message;
                setTimeout(endCall, 3000);
            });
            
        } catch (err) {
            console.error('Call initiation failed:', err);
            document.getElementById('callStatus').textContent = 
                'Failed to start call: ' + (err.message || 'Unknown error');
            setTimeout(endCall, 3000);
        }
    }
    
    // End call function - IMPROVED
    function endCall() {
        try {
            if (currentCall) {
                console.log('Ending current call');
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
</script>
</body>
</html>