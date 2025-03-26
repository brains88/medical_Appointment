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
                                            <button class="video_call_btn" title="Video Call" onclick="initiateVideoCall()">
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

<!-- Add PeerJS library -->
<script src="https://unpkg.com/peerjs@1.4.7/dist/peerjs.min.js"></script>

<script>
    // Pass PHP variables to JavaScript (KEEP THESE)
    const doctorPhoneNumber = "<?php echo $appointment->doctor->mobile; ?>";
    const doctorEmail = "<?php echo $appointment->doctor->email; ?>";
    const patientId = "<?php echo $appointment->id; ?>";
    const doctorId = "<?php echo $appointment->doctor->id; ?>";
    const appointmentId = "<?php echo $appointment->id; ?>";

    // PeerJS Variables (REPLACE WebRTC vars)
    let peer;
    let currentCall;
    let localStream;

    // --- KEEP THESE FUNCTIONS UNCHANGED ---
    function initiateVoiceCall() {
        window.location.href = `tel:${doctorPhoneNumber}`;
    }

    function sendEmail() {
        const subject = "Appointment Query";
        const body = "Hello Doctor, I have a question regarding my appointment.";
        window.location.href = `mailto:${doctorEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    }

    // --- MODIFIED VIDEO CALL FUNCTIONS ---
    async function initiateVideoCall() {
        console.log("Starting PeerJS video call...");
        document.getElementById('videoCallModal').style.display = 'block';
        document.getElementById('callStatus').textContent = 'Starting call...';

        try {
            // 1. Initialize PeerJS (Patient ID = patient-123)
            peer = new Peer(`patient-${patientId}`);
            
            // 2. Get camera/microphone
            localStream = await navigator.mediaDevices.getUserMedia({
                audio: true,
                video: { width: 640, height: 480 }
            });
            
            // 3. Show local video
            document.getElementById('localVideo').srcObject = localStream;
            
            // 4. Call the doctor (Doctor ID = doctor-456)
            currentCall = peer.call(`doctor-${doctorId}`, localStream);
            
            // 5. Handle remote stream
            currentCall.on('stream', (remoteStream) => {
                document.getElementById('remoteVideo').srcObject = remoteStream;
                document.getElementById('callStatus').textContent = 'Call connected!';
            });
            
            // Error handling
            currentCall.on('error', (err) => {
                console.error("Call error:", err);
                document.getElementById('callStatus').textContent = 'Call failed: ' + err.message;
            });

        } catch (error) {
            console.error("Error starting call:", error);
            document.getElementById('callStatus').textContent = 'Error: ' + error.message;
        }
    }

    // Simplified end call
    function endCall() {
        if (currentCall) currentCall.close();
        if (localStream) localStream.getTracks().forEach(track => track.stop());
        document.getElementById('videoCallModal').style.display = 'none';
    }

    // Keep toggle functions unchanged
    function toggleMute() { /* ... */ }
    function toggleVideo() { /* ... */ }
</script>

</body>
</html>