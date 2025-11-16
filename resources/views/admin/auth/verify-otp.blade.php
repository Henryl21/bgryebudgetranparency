<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - Barangay System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Full-page loader overlay */
        #otpLoader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        /* Spinner animation */
        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #f59e0b; /* Barangay yellow */
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin-bottom: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }

        .loader-text {
            font-weight: bold;
            color: #f59e0b;
            font-size: 1.2rem;
        }
    </style>
</head>
<body class="bg-yellow-50 min-h-screen flex items-center justify-center p-4">

    <!-- Loader overlay -->
    <div id="otpLoader">
        <div class="spinner"></div>
        <div class="loader-text">Verifying OTP...</div>
    </div>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6 border-4 border-yellow-400">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-yellow-700">Barangay OTP Verification</h1>
            <p class="text-gray-600 mt-2">Enter the OTP sent to your email</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form id="otpForm" method="POST" action="{{ route('admin.otp.verify') }}">
            @csrf
            <div class="mb-4 flex flex-col items-center">
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-2 text-center">OTP Code</label>
                <input type="text" name="otp" id="otp" value="{{ old('otp') }}"
                    class="w-48 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-center"
                    placeholder="6-digit OTP" required maxlength="6">
                @error('otp')
                    <p class="text-red-600 text-sm mt-1 text-center">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-48 bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition font-semibold mx-auto block">
                Verify OTP
            </button>
        </form>

        <div class="mt-5 text-center text-gray-700 text-sm">
            Didn't receive the code?
            <form id="resend-otp-form" method="POST" action="{{ route('admin.otp.resend') }}" class="inline">
                @csrf
                <button type="submit" id="resend-otp-btn"
                    class="inline-flex items-center text-yellow-700 hover:text-yellow-800 font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="resend-text">Resend OTP</span>
                    <svg id="resend-spinner" class="hidden animate-spin h-5 w-5 ml-2 text-yellow-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"></path>
                    </svg>
                </button>
            </form>
            <span id="countdown" class="ml-2 text-gray-500"></span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const resendBtn = document.getElementById('resend-otp-btn');
            const countdownEl = document.getElementById('countdown');
            const resendSpinner = document.getElementById('resend-spinner');
            const resendText = document.getElementById('resend-text');
            const otpForm = document.getElementById('otpForm');
            const otpLoader = document.getElementById('otpLoader');
            let cooldown = 60; // seconds

            // Check if cooldown is active from server session
            @if(session()->has('otp_last_sent'))
                let sentAt = new Date("{{ session('otp_last_sent') }}").getTime();
                let now = new Date().getTime();
                let remaining = Math.max(0, cooldown - Math.floor((now - sentAt)/1000));
                startCooldown(remaining);
            @endif

            function startCooldown(time) {
                resendBtn.disabled = true;
                countdownEl.textContent = `(${time}s)`;

                let interval = setInterval(() => {
                    time--;
                    if (time <= 0) {
                        resendBtn.disabled = false;
                        countdownEl.textContent = '';
                        clearInterval(interval);
                    } else {
                        countdownEl.textContent = `(${time}s)`;
                    }
                }, 1000);
            }

            resendBtn.addEventListener('click', (e) => {
                resendSpinner.classList.remove('hidden');
                resendText.textContent = 'Sending...';
                resendBtn.disabled = true;
                startCooldown(cooldown);
                document.getElementById('resend-otp-form').submit();
            });

            // Show loader on OTP submit
            otpForm.addEventListener('submit', () => {
                otpLoader.style.display = 'flex';
            });
        });
    </script>
</body>
</html>
