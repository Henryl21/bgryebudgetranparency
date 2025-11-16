<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP - Barangay eBudget Transparency</title>
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

    .timer-display {
      color: #90e0ef;
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 25px;
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
    <h2>🔐 Verify OTP</h2>
    <p>Enter the 6-digit code sent to your email</p>

    <form id="otpForm" action="{{ route('user.login.verify-otp') }}" method="POST">
      @csrf

      <!-- Hidden geolocation -->
      <input type="hidden" name="latitude" id="latitude">
      <input type="hidden" name="longitude" id="longitude">

      <div class="otp-input-container">
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
      </div>

      <input type="hidden" name="otp" id="otpValue">

      <p class="timer-display">
        OTP expires in <span id="timer">05:00</span>
      </p>

      <button type="submit" id="verifyBtn">Verify and Continue</button>
    </form>

    <div class="resend-container">
      <p>Didn't receive the code?</p>
      
      <button type="button" class="resend-btn" id="resendBtn" disabled>
        Resend OTP (<span id="resendTimer">30</span>s)
      </button>
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

    // Geolocation + Form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      updateOTPValue();
      
      if (otpValue.value.length !== 6) {
        Swal.fire({
          icon: 'warning',
          title: 'Incomplete OTP',
          text: 'Please enter all 6 digits',
          confirmButtonColor: '#00b4d8',
          background: '#f0faff',
          color: '#023e8a'
        });
        return;
      }

      // Get geolocation
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(pos) {
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            submitForm();
          },
          function() {
            submitForm();
          }
        );
      } else {
        submitForm();
      }
    });

    function submitForm() {
      Swal.fire({
        title: 'Verifying...',
        text: 'Please wait while we verify your code.',
        allowOutsideClick: false,
        background: 'rgba(255,255,255,0.9)',
        color: '#023e8a',
        didOpen: () => Swal.showLoading(),
        showConfirmButton: false,
      });
      form.submit();
    }

    // OTP Countdown Timer (5 minutes)
    let timeLeft = 300;
    const timerDisplay = document.getElementById('timer');

    setInterval(() => {
      let minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;

      timerDisplay.textContent = 
        `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

      if (timeLeft > 0) timeLeft--;
    }, 1000);

    // Resend OTP Timer (30s)
    let resendTime = 30;
    const resendBtn = document.getElementById('resendBtn');
    const resendTimer = document.getElementById('resendTimer');

    let resendInterval = setInterval(() => {
      resendTimer.textContent = resendTime;
      if (resendTime <= 0) {
        clearInterval(resendInterval);
        resendBtn.disabled = false;
        resendBtn.innerHTML = "Resend OTP";
      }
      resendTime--;
    }, 1000);

    // Resend OTP Action
    resendBtn.addEventListener('click', () => {
      resendBtn.disabled = true;
      resendBtn.textContent = "Sending...";

      // Create a form and submit it
      const resendForm = document.createElement('form');
      resendForm.method = 'POST';
      resendForm.action = "{{ route('user.login.resend-otp') }}";

      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = "{{ csrf_token() }}";

      resendForm.appendChild(csrfInput);
      document.body.appendChild(resendForm);
      resendForm.submit();
    });

    // Display session messages
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#00b4d8',
        background: '#f0faff',
        color: '#023e8a'
      });
    @endif

    @if($errors->any())
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ $errors->first() }}',
        confirmButtonColor: '#d33',
        background: '#fff5f5',
        color: '#900'
      });
    @endif
  </script>
</body>
</html>