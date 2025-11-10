<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP - Madridejos Barangay System</title>
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      overflow: hidden;
      position: relative;
      background: #000;
      color: #fff;
    }

    /* === Background Slideshow === */
    .background-slideshow {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      overflow: hidden;
      z-index: -3;
    }

    .background-slideshow img {
      position: absolute;
      width: 100%; height: 100%;
      object-fit: cover;
      opacity: 0;
      animation: slideShow 72s infinite;
      transition: opacity 1s ease-in-out;
    }

    .background-slideshow img:nth-child(1) { animation-delay: 0s; }
    .background-slideshow img:nth-child(2) { animation-delay: 6s; }
    .background-slideshow img:nth-child(3) { animation-delay: 12s; }
    .background-slideshow img:nth-child(4) { animation-delay: 18s; }
    .background-slideshow img:nth-child(5) { animation-delay: 24s; }
    .background-slideshow img:nth-child(6) { animation-delay: 30s; }
    .background-slideshow img:nth-child(7) { animation-delay: 36s; }
    .background-slideshow img:nth-child(8) { animation-delay: 42s; }
    .background-slideshow img:nth-child(9) { animation-delay: 48s; }
    .background-slideshow img:nth-child(10){ animation-delay: 54s; }
    .background-slideshow img:nth-child(11){ animation-delay: 60s; }
    .background-slideshow img:nth-child(12){ animation-delay: 66s; }

    @keyframes slideShow {
      0% { opacity: 0; transform: scale(1); }
      5% { opacity: 1; transform: scale(1.02); }
      25% { opacity: 1; transform: scale(1.04); }
      30% { opacity: 0; transform: scale(1.06); }
      100% { opacity: 0; }
    }

    /* === Overlay === */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(30, 58, 138, 0.3));
      z-index: -2;
      backdrop-filter: blur(8px);
    }

    /* === OTP Container === */
    .otp-container {
      width: 100%;
      max-width: 480px;
      padding: 25px;
      z-index: 1;
    }

    /* === OTP Box === */
    .otp-box {
      background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
      border-radius: 24px;
      padding: 45px 35px;
      backdrop-filter: blur(20px) saturate(180%);
      border: 1px solid rgba(255, 255, 255, 0.3);
      text-align: center;
      animation: floatIn 1s ease forwards;
      box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.3),
        0 0 80px rgba(37, 99, 235, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
      position: relative;
      overflow: hidden;
    }

    .otp-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.5s;
    }

    .otp-box:hover::before {
      left: 100%;
    }

    @keyframes floatIn { 
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; } 
    }

    /* === Icon === */
    .otp-icon {
      width: 100px;
      height: 100px;
      margin: 0 auto 25px;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 48px;
      box-shadow: 
        0 0 30px rgba(37, 99, 235, 0.5),
        0 8px 20px rgba(0, 0, 0, 0.3);
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    /* === Header === */
    .otp-header h2 {
      margin-bottom: 8px;
      font-size: 32px;
      font-weight: 700;
      background: linear-gradient(135deg, #fff, #a5b4fc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.5px;
    }

    .otp-subtitle {
      font-size: 14px;
      color: #e0e7ff;
      font-weight: 400;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .email-display {
      display: inline-block;
      background: rgba(59, 130, 246, 0.2);
      padding: 4px 12px;
      border-radius: 8px;
      color: #93c5fd;
      font-weight: 600;
      margin-top: 8px;
    }

    /* === Alert Messages === */
    .alert {
      padding: 12px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 14px;
      animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
      from { transform: translateY(-10px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .alert-success {
      background: rgba(34, 197, 94, 0.15);
      border: 1px solid rgba(34, 197, 94, 0.4);
      color: #86efac;
    }

    .alert-error {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.4);
      color: #fecaca;
    }

    /* === OTP Input === */
    .otp-input-container {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-bottom: 25px;
    }

    .otp-digit {
      width: 55px;
      height: 60px;
      font-size: 24px;
      font-weight: 700;
      text-align: center;
      background: rgba(255, 255, 255, 0.12);
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      color: #fff;
      transition: all 0.3s ease;
      outline: none;
    }

    .otp-digit:focus {
      background: rgba(255, 255, 255, 0.18);
      border-color: rgba(147, 197, 253, 0.6);
      box-shadow: 
        0 0 0 3px rgba(37, 99, 235, 0.2),
        0 6px 20px rgba(37, 99, 235, 0.3);
      transform: translateY(-2px);
    }

    /* === Timer === */
    .timer-display {
      font-size: 14px;
      color: #93c5fd;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .timer-display.expired {
      color: #fca5a5;
    }

    /* === Buttons === */
    .verify-btn, .resend-btn {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 14px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      position: relative;
      overflow: hidden;
    }

    .verify-btn {
      background: linear-gradient(135deg, #3b82f6, #2563eb, #1e40af);
      color: #fff;
      box-shadow: 
        0 4px 15px rgba(37, 99, 235, 0.4),
        0 0 30px rgba(37, 99, 235, 0.2);
      margin-bottom: 12px;
    }

    .verify-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s;
    }

    .verify-btn:hover::before {
      left: 100%;
    }

    .verify-btn:hover {
      transform: translateY(-3px);
      box-shadow: 
        0 8px 25px rgba(37, 99, 235, 0.5),
        0 0 40px rgba(37, 99, 235, 0.3);
    }

    .verify-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .resend-btn {
      background: rgba(255, 255, 255, 0.12);
      color: #e0e7ff;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .resend-btn:hover:not(:disabled) {
      background: rgba(255, 255, 255, 0.18);
      transform: translateY(-2px);
    }

    .resend-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    /* === Back Link === */
    .back-link {
      margin-top: 25px;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
    }

    .back-link a {
      color: #93c5fd;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      position: relative;
    }

    .back-link a:hover {
      color: #dbeafe;
    }

    /* === Responsive === */
    @media (max-width: 600px) {
      .otp-container {
        padding: 15px;
      }

      .otp-box {
        padding: 35px 25px;
        border-radius: 20px;
      }

      .otp-header h2 {
        font-size: 28px;
      }

      .otp-subtitle {
        font-size: 13px;
      }

      .otp-icon {
        width: 80px;
        height: 80px;
        font-size: 40px;
        margin-bottom: 20px;
      }

      .otp-digit {
        width: 48px;
        height: 55px;
        font-size: 20px;
      }

      .otp-input-container {
        gap: 8px;
      }

      .verify-btn, .resend-btn {
        padding: 13px;
        font-size: 15px;
      }
    }

    @media (max-width: 400px) {
      .otp-box {
        padding: 30px 20px;
      }

      .otp-header h2 {
        font-size: 24px;
      }

      .otp-digit {
        width: 42px;
        height: 50px;
        font-size: 18px;
      }

      .otp-input-container {
        gap: 6px;
      }
    }
  </style>
</head>
<body>
  <!-- Background slideshow -->
  <div class="background-slideshow">
    <img src="/storage/images/malbago.jpg" alt="">
    <img src="/storage/images/poblacion.jpg" alt="">
    <img src="/storage/images/tabagak.jpg" alt="">
    <img src="/storage/images/bunakan.jpg" alt="">
    <img src="/storage/images/kodia.jpg" alt="">
    <img src="/storage/images/tugas.jpg" alt="">
    <img src="/storage/images/san-agustin.jpg" alt="">
    <img src="/storage/images/tarong.jpg" alt="">
    <img src="/storage/images/pili.jpg" alt="">
    <img src="/storage/images/mancilang.jpg" alt="">
    <img src="/storage/images/kaongkod.jpg" alt="">
    <img src="/storage/images/talangnan.jpg" alt="">
  </div>

  <div class="overlay"></div>

  <div class="otp-container">
    <div class="otp-box">
      <div class="otp-icon">🔐</div>

      <div class="otp-header">
        <h2>Account Verification</h2>
        <div class="otp-subtitle">
          Enter the 6-digit OTP sent to
          <div class="email-display">{{ $email ?? 'your@email.com' }}</div>
        </div>
      </div>

      <!-- Flash messages -->
      @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
      @endif

      
      <!-- OTP verification form -->
      <form method="POST" action="{{ route('user.verify-otp.submit') }}" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email ?? '' }}">
        <input type="hidden" name="otp" id="otpValue">

        <div class="otp-input-container">
          <input type="text" maxlength="1" class="otp-digit" data-index="0" inputmode="numeric">
          <input type="text" maxlength="1" class="otp-digit" data-index="1" inputmode="numeric">
          <input type="text" maxlength="1" class="otp-digit" data-index="2" inputmode="numeric">
          <input type="text" maxlength="1" class="otp-digit" data-index="3" inputmode="numeric">
          <input type="text" maxlength="1" class="otp-digit" data-index="4" inputmode="numeric">
          <input type="text" maxlength="1" class="otp-digit" data-index="5" inputmode="numeric">
        </div>

        <button type="submit" class="verify-btn" id="verifyBtn">Verify OTP</button>
      </form>

      <!-- Resend OTP form -->
      <form method="POST" action="{{ route('user.resend-otp') }}" id="resendForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email ?? '' }}">
        <button type="submit" class="resend-btn" id="resendBtn">Resend OTP</button>
      </form>

      <div class="back-link">
        <a href="{{ route('user.login') }}">← Back to Login</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // OTP Input Handler
    const otpInputs = document.querySelectorAll('.otp-digit');
    const otpValue = document.getElementById('otpValue');
    const otpForm = document.getElementById('otpForm');

    otpInputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        // Only allow numbers
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
        
        if (e.target.value && index < otpInputs.length - 1) {
          otpInputs[index + 1].focus();
        }

        // Update hidden field
        updateOtpValue();
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
          otpInputs[index - 1].focus();
        }
      });

      input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
        
        pastedData.split('').forEach((char, i) => {
          if (otpInputs[i]) {
            otpInputs[i].value = char;
          }
        });

        if (pastedData.length > 0) {
          otpInputs[Math.min(pastedData.length, 5)].focus();
        }

        updateOtpValue();
      });
    });

    function updateOtpValue() {
      const otp = Array.from(otpInputs).map(input => input.value).join('');
      otpValue.value = otp;
    }

    // Timer Countdown
    let remainingSeconds = {{ $remainingSeconds ?? 60 }};
    const timerDisplay = document.getElementById('timerDisplay');
    const countdown = document.getElementById('countdown');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendBtn = document.getElementById('resendBtn');

    function updateTimer() {
      if (remainingSeconds <= 0) {
        countdown.textContent = 'EXPIRED';
        timerDisplay.classList.add('expired');
        verifyBtn.disabled = true;
        resendBtn.disabled = false;
        return;
      }

      const minutes = Math.floor(remainingSeconds / 60);
      const seconds = remainingSeconds % 60;
      countdown.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
      
      remainingSeconds--;
      setTimeout(updateTimer, 1000);
    }

    updateTimer();

    // Form submission
    otpForm.addEventListener('submit', (e) => {
      const otp = otpValue.value;
      if (otp.length !== 6) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Incomplete OTP',
          text: 'Please enter all 6 digits',
          confirmButtonColor: '#2563eb'
        });
      }
    });

    // Auto-focus first input
    window.addEventListener('load', () => {
      otpInputs[0].focus();
    });
  </script>
</body>
</html>