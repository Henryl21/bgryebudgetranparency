<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verify OTP | Madridejos Barangay System</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    .swal2-container {
      background: rgba(0, 0, 0, 0.1) !important;
      backdrop-filter: blur(3px);
    }

    body::before {
      content: "";
      position: absolute;
      width: 1000px;
      height: 1000px;
      background: radial-gradient(circle, #00b4d8 0%, transparent 70%);
      top: -400px;
      left: -400px;
      filter: blur(200px);
      opacity: 0.4;
      animation: glowMove 8s ease-in-out infinite alternate;
      z-index: 0;
    }

    @keyframes glowMove {
      0% { transform: translate(0, 0); }
      100% { transform: translate(100px, 80px); }
    }

    .card {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 50px 40px;
      width: 100%;
      max-width: 450px;
      color: #fff;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
      z-index: 1;
      position: relative;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .card h2 {
      font-size: 28px;
      margin-bottom: 10px;
      color: #fff;
      text-shadow: 0 0 10px rgba(255,255,255,0.3);
    }

    .card p {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .email-display {
      background: rgba(255, 255, 255, 0.1);
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 25px;
      font-weight: 600;
      color: #90e0ef;
      word-break: break-all;
    }

    .otp-input-container {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin: 30px 0;
    }

    .otp-input {
      width: 55px;
      height: 55px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
      outline: none;
      transition: all 0.3s ease;
    }

    .otp-input:focus {
      background: rgba(255, 255, 255, 0.25);
      border-color: #00b4d8;
      box-shadow: 0 0 15px rgba(0,180,216,0.6);
      transform: scale(1.05);
    }

    button {
      margin-top: 25px;
      width: 100%;
      background: linear-gradient(135deg, #00b4d8, #0077b6);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 14px 0;
      font-size: 16px;
      letter-spacing: 1px;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 0 12px rgba(0,180,216,0.4);
    }

    button:hover:not(:disabled) {
      background: linear-gradient(135deg, #0096c7, #023e8a);
      box-shadow: 0 0 25px rgba(0,180,216,0.7);
      transform: translateY(-3px);
    }

    button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .resend-container {
      margin-top: 25px;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
    }

    .resend-btn {
      background: transparent;
      border: 1px solid rgba(255, 255, 255, 0.3);
      margin-top: 10px;
      padding: 10px 0;
    }

    .resend-btn:hover:not(:disabled) {
      background: rgba(255, 255, 255, 0.1);
      border-color: #90e0ef;
    }

    .timer {
      color: #90e0ef;
      font-weight: 600;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #90e0ef;
      font-size: 14px;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .back-link:hover {
      color: #caf0f8;
    }

    @media (max-width: 480px) {
      .card {
        padding: 40px 25px;
      }
      .card h2 {
        font-size: 24px;
      }
      .otp-input {
        width: 45px;
        height: 45px;
        font-size: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="card">
    <h2>🔐 Verify Your Email</h2>
    <p>We've sent a 6-digit verification code to:</p>
    <div class="email-display">{{ $email ?? 'your email' }}</div>

    @if (session('success'))
      <script>
        window.addEventListener('load', () => {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#00b4d8',
            background: '#f0faff',
            color: '#023e8a'
          });
        });
      </script>
    @endif

    @if (session('error'))
      <script>
        window.addEventListener('load', () => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session("error") }}',
            confirmButtonColor: '#d33',
            background: '#fff5f5',
            color: '#900'
          });
        });
      </script>
    @endif

    @if ($errors->any())
      <script>
        window.addEventListener('load', () => {
          Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33',
            background: '#fff5f5',
            color: '#900'
          });
        });
      </script>
    @endif

    <form id="otpForm" method="POST" action="{{ route('user.verify.otp') }}">
      @csrf
      <input type="hidden" name="email" value="{{ $email ?? '' }}">

      <div class="otp-input-container">
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
      </div>

      <input type="hidden" name="otp" id="otpValue">

      <button type="submit" id="verifyBtn">Verify Email</button>
    </form>

    <div class="resend-container">
      <p>Didn't receive the code?</p>
      <p class="timer" id="timer">Resend available in <span id="countdown">60</span>s</p>
      
      <form method="POST" action="{{ route('user.resend.otp') }}" id="resendForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email ?? '' }}">
        <button type="submit" class="resend-btn" id="resendBtn" disabled>Resend OTP</button>
      </form>
    </div>

    <a href="{{ route('user.login') }}" class="back-link">← Back to Login</a>
  </div>

  <script>
    // OTP Input Handling
    const inputs = document.querySelectorAll('.otp-input');
    const otpValue = document.getElementById('otpValue');
    const form = document.getElementById('otpForm');

    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        const value = e.target.value;

        // Only allow numbers
        if (!/^\d$/.test(value)) {
          e.target.value = '';
          return;
        }

        // Move to next input
        if (value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }

        // Update hidden OTP value
        updateOTPValue();
      });

      input.addEventListener('keydown', (e) => {
        // Handle backspace
        if (e.key === 'Backspace' && !input.value && index > 0) {
          inputs[index - 1].focus();
        }

        // Handle paste
        if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
          e.preventDefault();
          navigator.clipboard.readText().then(text => {
            const digits = text.replace(/\D/g, '').slice(0, 6);
            digits.split('').forEach((digit, i) => {
              if (inputs[i]) {
                inputs[i].value = digit;
              }
            });
            updateOTPValue();
            inputs[Math.min(digits.length, 5)].focus();
          });
        }
      });

      // Auto-focus first input
      if (index === 0) {
        input.focus();
      }
    });

    function updateOTPValue() {
      const otp = Array.from(inputs).map(input => input.value).join('');
      otpValue.value = otp;
    }

    // Form submission with loading
    form.addEventListener('submit', (e) => {
      updateOTPValue();
      
      if (otpValue.value.length !== 6) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Incomplete OTP',
          text: 'Please enter all 6 digits',
          confirmButtonColor: '#00b4d8'
        });
        return;
      }

      Swal.fire({
        title: 'Verifying...',
        text: 'Please wait while we verify your code.',
        allowOutsideClick: false,
        background: 'rgba(255,255,255,0.9)',
        color: '#023e8a',
        didOpen: () => Swal.showLoading(),
        showConfirmButton: false,
      });
    });

    // Countdown Timer for Resend
    let countdown = 60;
    const countdownEl = document.getElementById('countdown');
    const resendBtn = document.getElementById('resendBtn');
    const timerEl = document.getElementById('timer');

    const timer = setInterval(() => {
      countdown--;
      countdownEl.textContent = countdown;

      if (countdown <= 0) {
        clearInterval(timer);
        resendBtn.disabled = false;
        timerEl.style.display = 'none';
      }
    }, 1000);

    // Resend form handling
    document.getElementById('resendForm').addEventListener('submit', (e) => {
      Swal.fire({
        title: 'Resending OTP...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
        showConfirmButton: false,
      });

      setTimeout(() => {
        Swal.close();
      }, 1500);
    });
  </script>
</body>
</html>