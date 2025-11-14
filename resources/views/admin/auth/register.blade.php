<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - Madridejos Barangay System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }
        
        .register-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 450px;
            max-width: 100%;
            text-align: center;
        }
        
        .register-box h2 {
            color: white;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .register-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }
        
        .register-box input[type="text"],
        .register-box input[type="email"],
        .register-box input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            padding-right: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .register-box select {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            appearance: none;
            cursor: pointer;
        }

        .register-box select option {
            background: #2a4365;
            color: white;
            padding: 10px;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: "▼";
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            pointer-events: none;
            font-size: 12px;
        }
        
        .register-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .register-box input:focus,
        .register-box select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            pointer-events: none;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            user-select: none;
            z-index: 10;
            transition: all 0.3s ease;
            padding: 5px;
        }

        .toggle-password:hover {
            transform: translateY(-50%) scale(1.1);
        }

        .toggle-password:active {
            transform: translateY(-50%) scale(0.95);
        }

        .label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
            text-align: left;
        }

        .password-requirements {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: left;
        }

        .password-requirements h4 {
            color: #ffffff;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 0;
        }

        .password-requirements li {
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .password-requirements li:before {
            content: "✓";
            color: #4ade80;
            position: absolute;
            left: 0;
            font-weight: bold;
        }
        
        .photo-upload-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }
        
        .photo-upload-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }
        
        .file-input-button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .file-input-button:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }
        
        .file-input-button.has-file {
            border-style: solid;
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .photo-preview {
            margin-top: 15px;
            text-align: center;
        }
        
        .photo-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
        }
        
        .register-box button {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .register-box button:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .register-box button:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: rgba(255, 107, 107, 0.2);
            border: 1px solid rgba(255, 107, 107, 0.4);
            color: #ffcccb;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .error-message div {
            margin-bottom: 4px;
        }
        
        .error-message div:last-child {
            margin-bottom: 0;
        }

        .success-message {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #2ecc71;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .login-link {
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }
        
        .login-link a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-link a:hover {
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        .user-icon::before {
            content: "👤";
        }
        
        .email-icon::before {
            content: "✉";
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .register-box {
                width: 100%;
                padding: 35px 25px;
            }
            
            .register-box h2 {
                font-size: 26px;
                letter-spacing: 1.5px;
            }

            .register-subtitle {
                font-size: 13px;
            }

            .register-box input[type="text"],
            .register-box input[type="email"],
            .register-box input[type="password"],
            .register-box select {
                font-size: 16px; /* Prevents zoom on iOS */
                padding: 14px 18px;
            }

            .toggle-password {
                font-size: 19px;
                right: 12px;
            }

            .password-requirements {
                padding: 12px;
            }

            .password-requirements h4 {
                font-size: 13px;
            }

            .password-requirements li {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .register-box {
                padding: 30px 20px;
                border-radius: 12px;
            }
            
            .register-box h2 {
                font-size: 24px;
                letter-spacing: 1px;
                margin-bottom: 8px;
            }

            .register-subtitle {
                font-size: 12px;
                margin-bottom: 25px;
            }

            .input-group {
                margin-bottom: 20px;
            }

            .register-box input[type="text"],
            .register-box input[type="email"],
            .register-box input[type="password"],
            .register-box select {
                padding: 13px 16px;
                padding-right: 45px;
                font-size: 15px;
            }

            .toggle-password {
                font-size: 18px;
                right: 12px;
            }

            .input-icon {
                font-size: 16px;
                right: 12px;
            }

            .label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .password-requirements {
                padding: 10px 12px;
                margin-bottom: 20px;
            }

            .password-requirements h4 {
                font-size: 12px;
                margin-bottom: 8px;
            }

            .password-requirements li {
                font-size: 11px;
                padding-left: 18px;
                margin-bottom: 4px;
            }

            .file-input-button {
                padding: 13px 16px;
                font-size: 13px;
            }

            .photo-preview img {
                max-width: 100px;
                max-height: 100px;
            }

            .register-box button {
                padding: 13px;
                font-size: 15px;
                letter-spacing: 0.5px;
            }

            .login-link {
                font-size: 13px;
                margin-top: 20px;
            }
        }

        @media (max-width: 360px) {
            .register-box {
                padding: 25px 15px;
            }

            .register-box h2 {
                font-size: 22px;
            }

            .register-subtitle {
                font-size: 11px;
            }

            .register-box input[type="text"],
            .register-box input[type="email"],
            .register-box input[type="password"],
            .register-box select {
                padding: 12px 14px;
                padding-right: 42px;
                font-size: 14px;
            }

            .toggle-password {
                font-size: 17px;
                right: 10px;
            }

            .password-requirements li {
                font-size: 10px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .register-box {
                width: 500px;
                padding: 45px;
            }
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Admin Register</h2>
        <div class="register-subtitle">Madridejos Barangay Management System</div>

        <div class="password-requirements">
            <h4>Password Requirements:</h4>
            <ul>
                <li id="req-length">At least 8 characters long</li>
                <li id="req-uppercase">One uppercase letter (A-Z)</li>
                <li id="req-lowercase">One lowercase letter (a-z)</li>
                <li id="req-number">One number (0-9)</li>
                <li id="req-symbol">One symbol (@$!%*?&)</li>
            </ul>
        </div>

        <form id="registerForm">
            <div class="input-group">
                <input type="text" name="name" id="name" placeholder="Admin Full Name" required>
                <div class="input-icon user-icon"></div>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email Address" required>
                <div class="input-icon email-icon"></div>
            </div>

            <div class="input-group">
                <label class="label">Barangay Assignment</label>
                <div class="select-wrapper">
                    <select name="barangay_role" id="barangay_role" required>
                        <option value="">Select Barangay</option>
                        <option value="bunakan">Bunakan</option>
                        <option value="kangwayan">Kangwayan</option>
                        <option value="kaongkod">Kaongkod</option>
                        <option value="kodia">Kodia</option>
                        <option value="maalat">Maalat</option>
                        <option value="malbago">Malbago</option>
                        <option value="mancilang">Mancilang</option>
                        <option value="pili">Pili</option>
                        <option value="poblacion">Poblacion</option>
                        <option value="san_agustin">San Agustin</option>
                        <option value="tabagak">Tabagak</option>
                        <option value="talangnan">Talangnan</option>
                        <option value="tarong">Tarong</option>
                        <option value="tugas">Tugas</option>
                    </select>
                </div>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" data-target="password">🔒</span>
            </div>
            
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                <span class="toggle-password" data-target="password_confirmation">🔒</span>
            </div>
            
            <div class="photo-upload-group">
                <label class="photo-upload-label">Profile Photo (Optional)</label>
                <div class="file-input-wrapper">
                    <input type="file" name="profile_photo" class="file-input" id="profile_photo" accept="image/*">
                    <label for="profile_photo" class="file-input-button" id="file-button">
                        📸 Choose Profile Photo
                    </label>
                </div>
                <div class="photo-preview" id="photo-preview" style="display: none;">
                    <img id="preview-image" src="" alt="Profile Preview">
                </div>
            </div>
            
            <button type="submit">Register Admin Account</button>
        </form>

          <div class="login-link">
            Already have an account?
            <a href="{{ route('admin.login') }}">Login here</a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                
                if (input.type === 'password') {
                    input.type = 'text';
                    this.textContent = '🔓';
                } else {
                    input.type = 'password';
                    this.textContent = '🔒';
                }
            });
        });

        // Profile photo handling
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileButton = document.getElementById('file-button');
            const photoPreview = document.getElementById('photo-preview');
            const previewImage = document.getElementById('preview-image');
            
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }

                if (!file.type.match(/^image\/(jpeg|jpg|png|gif)$/)) {
                    alert('Please select a valid image file (JPEG, PNG, or GIF)');
                    this.value = '';
                    return;
                }
                
                fileButton.textContent = `📸 ${file.name}`;
                fileButton.classList.add('has-file');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    photoPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                fileButton.textContent = '📸 Choose Profile Photo';
                fileButton.classList.remove('has-file');
                photoPreview.style.display = 'none';
            }
        });

        // Real-time password validation
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            
            const requirements = {
                'req-length': password.length >= 8,
                'req-uppercase': /[A-Z]/.test(password),
                'req-lowercase': /[a-z]/.test(password),
                'req-number': /\d/.test(password),
                'req-symbol': /[@$!%*?&]/.test(password)
            };
            
            for (const [id, passed] of Object.entries(requirements)) {
                const element = document.getElementById(id);
                if (passed) {
                    element.style.color = '#4ade80';
                    element.style.fontWeight = '500';
                } else {
                    element.style.color = 'rgba(255, 255, 255, 0.8)';
                    element.style.fontWeight = '400';
                }
            }
        });

        // Form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Registration form submitted! (This is a demo)');
        });
    </script>
</body>
</html>