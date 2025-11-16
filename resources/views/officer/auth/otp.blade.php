@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOutDown {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(30px);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes sparkle {
        0%, 100% {
            opacity: 0.3;
            transform: scale(0.8) rotate(0deg);
        }
        50% {
            opacity: 1;
            transform: scale(1) rotate(180deg);
        }
    }

    .animate-container {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-container.fade-out {
        animation: fadeOutDown 0.4s ease-in forwards;
    }

    .animate-icon-left {
        animation: slideInLeft 0.8s ease-out 0.2s both;
    }

    .animate-icon-right {
        animation: slideInRight 0.8s ease-out 0.2s both;
    }

    .animate-shield {
        animation: scaleIn 0.6s ease-out 0.4s both;
    }

    .animate-otp-box {
        animation: fadeInUp 0.5s ease-out 0.6s both;
    }

    .animate-button {
        animation: fadeInUp 0.5s ease-out 0.8s both;
    }

    .sparkle {
        animation: sparkle 2s ease-in-out infinite;
    }

    .otp-input:focus {
        animation: pulse 0.3s ease-in-out;
    }

    /* Loading Spinner */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .loading-spinner {
        border: 3px solid rgba(59, 130, 246, 0.2);
        border-top-color: #3B82F6;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 0.8s linear infinite;
    }

    /* OTP Input Boxes */
    .otp-boxes {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .otp-box {
        width: 45px;
        height: 55px;
        border: 2px solid #CBD5E1;
        border-radius: 8px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        transition: all 0.3s ease;
        background: white;
    }

    .otp-box:focus {
        border-color: #3B82F6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .otp-box.filled {
        border-color: #3B82F6;
        background: #EFF6FF;
    }

    /* Decorative elements */
    .cloud {
        background: linear-gradient(180deg, #DBEAFE 0%, #BFDBFE 100%);
        border-radius: 50%;
        opacity: 0.5;
    }
</style>

<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <!-- Decorative clouds -->
    <div class="cloud absolute w-64 h-32" style="top: 10%; left: 5%; animation: slideInLeft 1s ease-out;"></div>
    <div class="cloud absolute w-48 h-24" style="top: 20%; right: 10%; animation: slideInRight 1s ease-out;"></div>
    <div class="cloud absolute w-56 h-28" style="bottom: 15%; left: 15%; animation: slideInLeft 1.2s ease-out;"></div>

    <div class="max-w-md w-full animate-container" id="mainContainer">
        <div class="bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">
            <!-- Sparkle decorations -->
            <div class="sparkle absolute text-3xl" style="top: 15px; left: 20px;">✨</div>
            <div class="sparkle absolute text-3xl" style="top: 15px; right: 20px; animation-delay: 0.5s;">✨</div>

            <!-- Icons Row -->
            <div class="flex justify-between items-center mb-6">
                <!-- Email Icon -->
                <div class="animate-icon-left">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-orange-200 to-orange-300 rounded-xl p-4 shadow-md">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="absolute -top-1 -left-1 bg-white rounded-lg px-2 py-1 text-xs font-bold text-gray-700 shadow">OTP</div>
                    </div>
                </div>

                <!-- Shield Icon (Center) -->
                <div class="animate-shield">
                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-full p-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>

                <!-- Login Badge -->
                <div class="animate-icon-right">
                    <div class="bg-gradient-to-br from-orange-300 to-orange-400 rounded-xl px-4 py-3 shadow-md">
                        <span class="text-white font-bold text-sm tracking-wider">LOGIN</span>
                    </div>
                </div>
            </div>

            <!-- Fingerprint Icon -->
            <div class="flex justify-center mb-6 animate-icon-left" style="animation-delay: 0.3s;">
                <div class="bg-gradient-to-br from-orange-200 to-orange-300 rounded-full p-6 shadow-md">
                    <svg class="w-12 h-12 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-2 text-center text-gray-800 animate-otp-box">🔐 Verify Your Login</h2>
            <p class="text-gray-600 text-center mb-6 animate-otp-box">Enter the 6-digit code sent to your device</p>

            <form method="POST" action="{{ route('officer.verifyOtp') }}" id="otpForm">
                @csrf

                <!-- Hidden fields -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="otp" id="hiddenOtp">

                <!-- OTP Input Boxes -->
                <div class="mb-6 animate-otp-box">
                    <div class="otp-boxes">
                        <input type="text" maxlength="1" class="otp-box otp-input" data-index="0" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-box otp-input" data-index="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-box otp-input" data-index="2" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-box otp-input" data-index="3" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-box otp-input" data-index="4" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-box otp-input" data-index="5" inputmode="numeric" pattern="[0-9]">
                    </div>
                </div>

                <!-- Verify Button -->
                <button type="submit" id="verifyBtn"
                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg animate-button">
                    VERIFY OTP
                </button>

                <!-- Loading State -->
                <div id="loadingState" class="hidden w-full bg-gray-100 py-3 rounded-xl flex items-center justify-center">
                    <div class="loading-spinner mr-3"></div>
                    <span class="text-gray-700 font-semibold">Verifying...</span>
                </div>

                <div class="text-center mt-6 animate-button">
                    <a href="{{ route('officer.login') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Login
                    </a>
                </div>
            </form>

            <!-- Decorative plant -->
            <div class="absolute bottom-4 right-4 opacity-30">
                <svg class="w-16 h-16 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c-1.1 0-2-.9-2-2v-8c-2.21 0-4-1.79-4-4 0-2.76 2.24-5 5-5h2c2.76 0 5 2.24 5 5 0 2.21-1.79 4-4 4v8c0 1.1-.9 2-2 2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('otpForm');
    const otpInputs = document.querySelectorAll('.otp-input');
    const hiddenOtp = document.getElementById('hiddenOtp');
    const verifyBtn = document.getElementById('verifyBtn');
    const loadingState = document.getElementById('loadingState');
    const mainContainer = document.getElementById('mainContainer');

    // Focus first input
    otpInputs[0].focus();

    // OTP Input Logic
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value;

            // Only allow numbers
            if (!/^\d$/.test(value) && value !== '') {
                e.target.value = '';
                return;
            }

            if (value !== '') {
                e.target.classList.add('filled');
                // Move to next input
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            } else {
                e.target.classList.remove('filled');
            }

            updateHiddenOtp();
        });

        input.addEventListener('keydown', function(e) {
            // Backspace handling
            if (e.key === 'Backspace' && input.value === '' && index > 0) {
                otpInputs[index - 1].focus();
                otpInputs[index - 1].value = '';
                otpInputs[index - 1].classList.remove('filled');
                updateHiddenOtp();
            }

            // Arrow key navigation
            if (e.key === 'ArrowLeft' && index > 0) {
                otpInputs[index - 1].focus();
            }
            if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        // Paste handling
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').slice(0, 6);
            const digits = pastedData.match(/\d/g);
            
            if (digits) {
                digits.forEach((digit, i) => {
                    if (i < otpInputs.length) {
                        otpInputs[i].value = digit;
                        otpInputs[i].classList.add('filled');
                    }
                });
                updateHiddenOtp();
                otpInputs[Math.min(digits.length, otpInputs.length - 1)].focus();
            }
        });
    });

    function updateHiddenOtp() {
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        hiddenOtp.value = otp;
    }

    // Form submission with animations
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const otp = hiddenOtp.value;
        if (otp.length !== 6) {
            Swal.fire('Error!', 'Please enter all 6 digits', 'error');
            return;
        }

        // Show loading state
        verifyBtn.classList.add('hidden');
        loadingState.classList.remove('hidden');

        // Add exit animation
        mainContainer.classList.add('fade-out');

        // Capture geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                document.getElementById('latitude').value = pos.coords.latitude;
                document.getElementById('longitude').value = pos.coords.longitude;
                
                // Submit after animation completes
                setTimeout(() => {
                    form.submit();
                }, 400);
            }, function(err) {
                console.warn("Geolocation denied or failed:", err.message);
                setTimeout(() => {
                    form.submit();
                }, 400);
            });
        } else {
            setTimeout(() => {
                form.submit();
            }, 400);
        }
    });

    // SweetAlert notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}"
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: "{{ session('info') }}"
        });
    @endif
});
</script>
@endsection