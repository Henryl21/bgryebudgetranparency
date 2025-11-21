<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Register - Madridejos Barangay System</title>
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      min-height: 100vh;
      overflow-y: auto;
      overflow-x: hidden;
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

    /* === Register Container === */
    .register-container {
      width: 100%;
      max-width: 620px;
      padding: 25px;
      margin: 40px 0;
      z-index: 1;
    }

    /* === Register Box === */
    .register-box {
      background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
      border-radius: 24px;
      padding: 45px 35px;
      backdrop-filter: blur(20px) saturate(180%);
      border: 1px solid rgba(255, 255, 255, 0.3);
      text-align: center;
      animation: floatIn 1s ease forwards;
      transform: translateY(20px);
      box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.3),
        0 0 80px rgba(37, 99, 235, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
      position: relative;
      overflow: hidden;
    }

    .register-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.5s;
    }

    .register-box:hover::before {
      left: 100%;
    }

    @keyframes floatIn { 
      to { transform: translateY(0); opacity: 1; } 
    }

    /* === Header === */
    .register-header {
      margin-bottom: 35px;
    }

    .register-box h2 {
      margin-bottom: 8px;
      font-size: 32px;
      font-weight: 700;
      background: linear-gradient(135deg, #fff, #a5b4fc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 20px rgba(255,255,255,0.3);
    }

    .register-subtitle {
      font-size: 14px;
      color: #e0e7ff;
      font-weight: 400;
      letter-spacing: 0.3px;
    }

    /* === Profile Preview === */
    .profile-preview-container {
      position: relative;
      width: 110px;
      height: 110px;
      margin: 0 auto 30px;
    }

    .profile-preview {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid rgba(255, 255, 255, 0.4);
      display: block;
      box-shadow: 
        0 0 30px rgba(37, 99, 235, 0.5),
        0 8px 20px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }

    .profile-preview:hover {
      transform: scale(1.05);
      border-color: rgba(255, 255, 255, 0.6);
      box-shadow: 
        0 0 40px rgba(37, 99, 235, 0.7),
        0 12px 25px rgba(0, 0, 0, 0.4);
    }

    /* === Input Fields === */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 16px;
      margin-bottom: 20px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .input-group {
      position: relative;
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.12);
      border-radius: 14px;
      padding: 14px 16px;
      transition: all 0.3s ease;
      border: 1.5px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .input-group:focus-within {
      background: rgba(255, 255, 255, 0.18);
      border-color: rgba(147, 197, 253, 0.6);
      box-shadow: 
        0 0 0 3px rgba(37, 99, 235, 0.2),
        0 6px 20px rgba(37, 99, 235, 0.3);
      transform: translateY(-2px);
    }

    .input-group input,
    .input-group select {
      border: none;
      outline: none;
      flex: 1;
      background: transparent;
      font-size: 15px;
      color: #fff;
      font-weight: 500;
    }

    .input-group input::placeholder { 
      color: rgba(255, 255, 255, 0.6);
      font-weight: 400;
    }

    .input-group select {
      color: #fff;
      cursor: pointer;
    }

    .input-group select option {
      background: #1e293b;
      color: #fff;
    }

    .toggle-password {
      cursor: pointer;
      position: absolute;
      right: 14px;
      font-size: 20px;
      opacity: 0.7;
      transition: all 0.3s;
      user-select: none;
    }

    .toggle-password:hover { 
      opacity: 1;
      transform: scale(1.1);
    }

    /* === File Input Custom === */
    .file-input-wrapper {
      position: relative;
      overflow: hidden;
    }

    .file-input-wrapper input[type="file"] {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
    }

    .file-input-label {
      color: rgba(255, 255, 255, 0.8);
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .file-input-label::before {
      content: '📷';
      font-size: 18px;
    }

    /* === Button === */
    .register-btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #3b82f6, #2563eb, #1e40af);
      color: #fff;
      border: none;
      border-radius: 14px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 
        0 4px 15px rgba(37, 99, 235, 0.4),
        0 0 30px rgba(37, 99, 235, 0.2);
      margin-top: 10px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      position: relative;
      overflow: hidden;
    }

    .register-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s;
    }

    .register-btn:hover::before {
      left: 100%;
    }

    .register-btn:hover {
      transform: translateY(-3px);
      box-shadow: 
        0 8px 25px rgba(37, 99, 235, 0.5),
        0 0 40px rgba(37, 99, 235, 0.3);
    }

    .register-btn:active {
      transform: translateY(-1px);
    }

    /* === Login Link === */
    .login-link { 
      margin-top: 25px;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
    }

    .login-link a {
      color: #93c5fd;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      position: relative;
    }

    .login-link a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: #93c5fd;
      transition: width 0.3s;
    }

    .login-link a:hover::after {
      width: 100%;
    }

    .login-link a:hover {
      color: #dbeafe;
    }
/* Terms and Conditions Checkbox */
.terms-container {
    margin: 15px 0;
    text-align: left;
    font-size: 13px;
    color: #e0f2fe;
    text-shadow: 0 0 6px rgba(96,165,250,0.8);
}

.terms-label input[type="checkbox"] {
    accent-color: #2563eb;
    transform: scale(1.1);
    margin-right: 8px;
}

.terms-label a {
    color: #93c5fd;
    text-decoration: underline;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.terms-label a:hover {
    color: #ffffff;
    text-shadow: 0 0 8px #60a5fa;
}
/* Modal Styling */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(6px);
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.4s ease;
}

.modal-content {
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 25px 30px;
    width: 90%;
    max-width: 600px;
    color: #e0f2fe;
    box-shadow: 0 0 20px rgba(37,99,235,0.5), inset 0 0 10px rgba(255,255,255,0.1);
    text-align: left;
    animation: slideUp 0.4s ease;
}

.modal-content h3 {
    font-size: 22px;
    color: #ffffff;
    text-align: center;
    text-shadow: 0 0 8px rgba(59,130,246,0.9);
    margin-bottom: 10px;
}

.modal-content h4 {
    margin-top: 20px;
    color: #bfdbfe;
}

.modal-content ul {
    margin-left: 20px;
    list-style: disc;
}

.modal-content p, .modal-content li {
    line-height: 1.5;
    font-size: 14px;
}

.close-btn {
    margin-top: 20px;
    display: block;
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 0 12px rgba(59,130,246,0.6);
}

.close-btn:hover {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    box-shadow: 0 0 18px rgba(96,165,250,0.8);
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

    /* === Error Display === */
    #formErrors {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.4);
      border-radius: 10px;
      padding: 12px;
      margin-bottom: 15px;
      color: #fecaca;
      text-align: left;
      font-size: 13px;
      backdrop-filter: blur(10px);
    }

    #formErrors div {
      margin: 4px 0;
    }

    /* === Responsive === */
    @media (max-width: 600px) {
      .register-container {
        padding: 15px;
        margin: 20px 0;
      }

      .register-box {
        padding: 30px 20px;
        border-radius: 20px;
      }

      .register-header {
        margin-bottom: 25px;
      }

      .register-box h2 {
        font-size: 24px;
      }

      .register-subtitle {
        font-size: 12px;
      }

      .profile-preview-container {
        width: 90px;
        height: 90px;
        margin-bottom: 20px;
      }

      .profile-preview {
        width: 90px;
        height: 90px;
        border-width: 3px;
      }

      .form-grid {
        gap: 12px;
      }

      .form-row {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .input-group {
        padding: 12px 14px;
      }

      .input-group input,
      .input-group select {
        font-size: 14px;
      }

      .register-btn {
        padding: 13px;
        font-size: 15px;
      }

      .login-link {
        font-size: 13px;
        margin-top: 20px;
      }
    }

    @media (max-width: 400px) {
      .register-box {
        padding: 25px 18px;
      }

      .register-box h2 {
        font-size: 22px;
      }

      .register-subtitle {
        font-size: 11px;
      }
/* Fix for Birthdate label disappearing on mobile */
@media (max-width: 600px) {
  .input-group.date-wrapper {
    display: block !important;
    padding: 10px 14px !important;
  }

  .date-wrapper label {
    display: block;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 6px;
  }

  .date-wrapper input[type="date"] {
    width: 100%;
    display: block;
    font-size: 15px;
    padding: 10px;
    background: rgba(255, 255, 255, 0.12);
    border: 1.5px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
  }
}

      .profile-preview-container {
        width: 80px;
        height: 80px;
      }

      .profile-preview {
        width: 80px;
        height: 80px;
      }

      .input-group {
        padding: 11px 12px;
      }

      .input-group input,
      .input-group select {
        font-size: 13px;
      }

      .register-btn {
        padding: 12px;
        font-size: 14px;
      }

      .file-input-label {
        font-size: 13px;
      }
    }

    @media (min-width: 601px) and (max-width: 768px) {
      .register-container {
        max-width: 560px;
        padding: 20px;
      }

      .register-box {
        padding: 40px 30px;
      }
    }

    @media (min-width: 769px) {
      body {
        align-items: center;
      }

      .register-container {
        margin: 20px 0;
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

  <div class="register-container">
    <div class="register-box">
      <div class="register-header">
        <h2>User Registration</h2>
        <div class="register-subtitle">Barangay eBudget Transparency System</div>
      </div>

      <form method="POST" action="{{ route('user.register.store') }}" enctype="multipart/form-data" novalidate>
  @csrf

  <div class="profile-preview-container">
    <img id="preview-image"
         src="{{ $user->profile_photo 
                ? asset('profile_photos/' . $user->profile_photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name ?? 'User') . '&background=3b82f6&color=fff&size=110' }}"
         class="profile-preview"
         alt="Preview">
</div>


  <div class="form-grid">
    <div class="form-row">
      <div class="input-group">
        <input type="text" name="first_name" placeholder="First Name" 
               required pattern="^[A-Za-z\s'-]+$"
               title="Only letters, spaces, hyphens, apostrophes."
               value="{{ old('first_name') }}">
      </div>
      @error('first_name')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
      @enderror

     <div class="input-group">
        <input type="text" name="middle_name" placeholder="Middle Name" 
                pattern="^[A-Za-zÑñ\s]+$"
                style="text-transform: capitalize;"
               value="{{ old('middle_name') }}">
      </div>
      @error('middle_name')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div> 

    <div class="form-row">
      <div class="input-group">
        <input type="text" name="last_name" placeholder="Last Name" required
               pattern="^[A-Za-z\s'-]+$"
               value="{{ old('last_name') }}">
      </div>
      @error('last_name')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
      @enderror

     <div class="input-group">
  <input type="text" name="suffix" placeholder="Suffix"
         pattern="^[A-Za-z]{1,2,3}\.?$"
         title="Suffix must be 1–3 letters and may end with a period"
         value="{{ old('suffix') }}">
</div>

      @error('suffix')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="input-group">
      <input type="tel" name="number" id="number"
             placeholder="Contact Number (11 digits)" required
             pattern="^\d{11}$"
             maxlength="11"
             inputmode="numeric"
             title="Must be exactly 11 digits."
             value="{{ old('number') }}">
    </div>
    @error('number')
      <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
    @enderror

    <div class="form-row">
      <div class="input-group">
        <input type="date" id="birthdate" name="birthdate" required value="{{ old('birthdate') }}">
      </div>
      @error('birthdate')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
      @enderror

      <div class="input-group">
        <input type="number" id="age" name="age" placeholder="Age" readonly required value="{{ old('age') }}">
      </div>
      @error('age')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="input-group">
      <select name="gender" required>
        <option value="">-- Select Gender --</option>
        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
        <option value="rather_not_say" {{ old('gender') == 'rather_not_say' ? 'selected' : '' }}>Rather Not to Say</option>
      </select>
    </div>
    @error('gender')
      <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
    @enderror

    <div class="input-group">
      <select name="barangay_role" required>
        <option value="">-- Select Barangay --</option>
        @foreach (\App\Models\User::getBarangays() as $key => $name)
          <option value="{{ $key }}" {{ old('barangay_role') == $key ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>
    @error('barangay_role')
      <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
    @enderror

    <div class="input-group file-input-wrapper">
        <label class="file-input-label">
            Upload Profile Photo
            <input type="file" name="profile_photo" accept="image/*" onchange="previewFile(event)">
        </label>
    </div>
    @error('profile_photo')
        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
    @enderror


    <div class="input-group">
      <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}">
    </div>
    @error('email')
      <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
    @enderror

    <div class="input-group">
      <input type="password" name="password" id="password" placeholder="Password" required>
      <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
    </div>
    @error('password')
      <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
    @enderror

    <div class="input-group">
      <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
      <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁️</span>
    </div>
  </div>
<!-- Terms checkbox -->
<label class="terms-label">
  <input type="checkbox" id="termsCheckbox">
  I agree to the <a href="#" id="openTermsModal">Terms & Conditions</a>
</label>
  <button type="submit" class="register-btn">Register</button>
</form>

      <div class="login-link">
        Already have an account? <a href="{{ route('user.login') }}">Login here</a>
      </div>
    </div>
  </div>
<div id="termsModal" class="modal-overlay">
  <div class="modal-content">
    <h3>📜 Terms and Conditions</h3>
    <p>By accessing and using this system, you agree to comply with the following terms:</p>
    <ul>
      <li>You will provide accurate and truthful information during registration and login.</li>
      <li>You will use this platform solely for authorized barangay transparency purposes.</li>
      <li>Unauthorized access or misuse of system data is strictly prohibited.</li>
      <li>Violations may result in account suspension or legal action.</li>
    </ul>

    <h4>🔒 Data Privacy Act of 2012 (Republic Act No. 10173)</h4>
    <p>
      The Madridejos Barangay eBudget Transparency System values your privacy.  
      All collected personal data are handled in accordance with the Data Privacy Act of 2012.  
      Your information will only be used for legitimate administrative and reporting purposes  
      and will not be shared without consent, except as required by law.
    </p>

    <button id="closeTermsModal" class="close-btn">Close</button>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // SweetAlert validation errors
    @if ($errors->any())
        let errors = {!! json_encode($errors->toArray()) !!};
        let firstField = Object.keys(errors)[0];
        let messages = Object.values(errors).map(err => '• ' + err.join('<br>')).join('<br><br>');

        if (firstField) {
            const field = document.querySelector(`[name="${firstField}"]`);
            if (field) {
                field.style.borderColor = '#ef4444';
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                field.focus();
            }
        }

        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            html: messages,
            confirmButtonColor: '#2563eb'
        });
    @endif
// Client-side validation with preserved inputs
document.querySelector('form').addEventListener('submit', function(e) {
  const fields = this.querySelectorAll('input[required], select[required]');
  let invalids = [];

  fields.forEach(field => {
    field.style.borderColor = '';
    if (!field.checkValidity()) {
      invalids.push({
        name: field.name,
        message: field.title || field.validationMessage
      });
      field.style.borderColor = '#ef4444';
    }
  });

  if (invalids.length) {
    e.preventDefault();
    Swal.fire({
      icon: 'error',
      title: 'Invalid Input',
      html: invalids.map(f => `• <b>${f.name}</b>: ${f.message}`).join('<br>'),
      confirmButtonColor: '#2563eb'
    });
    invalids[0].field?.focus();
  }
});
<!-- ✅ Place your modal JavaScript just below it -->

const openTerms = document.getElementById("openTermsModal");
const closeTerms = document.getElementById("closeTermsModal");
const modal = document.getElementById("termsModal");

openTerms.addEventListener("click", (e) => {
    e.preventDefault();
    modal.style.display = "flex";
});

closeTerms.addEventListener("click", () => {
    modal.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
});

    // SweetAlert success
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Successfully Registered!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });
    @endif

    // SweetAlert error
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#2563eb'
        });
    @endif
    // Age calculation
    document.getElementById('birthdate').addEventListener('change', function () {
      let b = new Date(this.value), t = new Date();
      let age = t.getFullYear() - b.getFullYear();
      let m = t.getMonth() - b.getMonth();
      if (m < 0 || (m === 0 && t.getDate() < b.getDate())) age--;
      document.getElementById('age').value = age >= 0 ? age : "";
    });

    // Profile preview
    function previewFile(event) {
      const file = event.target.files[0];
      if (file) {
        // ✅ Check if the file is an image
        if (!file.type.startsWith('image/')) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid File',
            text: 'Please upload a valid image file (JPG, PNG, etc.)',
            confirmButtonColor: '#2563eb'
          });
          event.target.value = ''; // Reset the input
          return;
        }

        const reader = new FileReader();
        reader.onload = e => {
          document.getElementById('preview-image').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
    // Toggle password visibility
    function togglePassword(id, icon) {
      const field = document.getElementById(id);
      if (field.type === "password") {
        field.type = "text";
        icon.textContent = "🙈";
      } else {
        field.type = "password";
        icon.textContent = "👁️";
      }
    }
// Terms checkbox enforcement
document.querySelector('form').addEventListener('submit', function(e) {
    const termsCheckbox = document.getElementById('termsCheckbox');

    if (!termsCheckbox.checked) {
        e.preventDefault(); // Stop form submission
        Swal.fire({
            icon: 'warning',
            title: 'Agreement Required',
            text: 'You must agree to the Terms & Conditions before registering.',
            confirmButtonColor: '#2563eb'
        });
        return false;
    }
});

    // Form validation
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form[method="POST"]');
      const number = document.getElementById('number');
      const errorsDiv = document.getElementById('formErrors');

      function validateNumber(val) {
        return /^\d{11}$/.test(val.trim());
      }

      form.addEventListener('submit', function (e) {
        errorsDiv.style.display = 'none';
        errorsDiv.innerHTML = '';

        const numVal = number.value || '';
        const errs = [];

        if (!validateNumber(numVal)) {
          errs.push('Contact Number must be exactly 11 digits (numbers only).');
        }

        if (errs.length) {
          e.preventDefault();
          errorsDiv.style.display = 'block';
          errorsDiv.innerHTML = errs.map(x => `<div>• ${x}</div>`).join('');
          number.focus();
          return false;
        }

        return true;
      });

      // Live feedback
      number.addEventListener('input', () => {
        number.value = number.value.replace(/[^\d]/g, '').slice(0, 11);
      });
    });
  </script>
</body>
</html>