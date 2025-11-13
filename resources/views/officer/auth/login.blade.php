<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center min-h-screen">
    <form method="POST" action="{{ route('officer.login.submit') }}"
          class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-xl w-96 border border-green-200"
          id="loginForm">
        @csrf

        <h2 class="text-3xl font-bold text-center mb-6 text-green-700">Officer Login</h2>

        <!-- SweetAlert Errors -->
        @if ($errors->has('email') && str_contains($errors->first('email'), 'Please try again in'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const message = {!! json_encode($errors->first('email')) !!};
                    const match = message.match(/(\d+)\s*seconds/);
                    let seconds = match ? parseInt(match[1]) : 60;

                    Swal.fire({
                        icon: 'warning',
                        title: 'Too Many Attempts',
                        html: `<p>Please wait <b><span id="countdown">${seconds}</span></b> seconds before trying again.</p>`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            const countdown = Swal.getHtmlContainer().querySelector('#countdown');
                            const timer = setInterval(() => {
                                seconds--;
                                countdown.textContent = seconds;
                                if (seconds <= 0) {
                                    clearInterval(timer);
                                    Swal.close();
                                    location.reload();
                                }
                            }, 1000);
                        }
                    });
                });
            </script>
        @elseif ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#16a34a'
                    });
                });
            </script>
        @endif

        <!-- Role -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
            <select name="role" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                <option value="" disabled selected>Select Role</option>
                <option value="Officer">Officer</option>
                <option value="Captain">Captain</option>
                <option value="Kagawad">Kagawad</option>
                <option value="SK Chairperson">SK Chairperson</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Record Keeper">Record Keeper</option>
                <option value="Tanod">Tanod</option>
                <option value="Health Worker">Health Worker</option>
                <option value="Nutrition Scholar">Nutrition Scholar</option>
                <option value="Day Care Worker">Day Care Worker</option>
                <option value="IT Officer">IT Officer</option>
                <option value="Utility Worker">Utility Worker</option>
            </select>
        </div>

        <!-- Barangay Dropdown -->
        <div class="mb-4">
            <label for="barangay" class="block text-sm font-medium text-gray-700 mb-1">Select Barangay</label>
            <select name="barangay" id="barangay"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="">Select Barangay</option>
                @foreach($barangays as $key => $name)
                    <option value="{{ $key }}" {{ old('barangay') == $key ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email" required placeholder="Enter your email"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Password with Eye Icon -->
        <div class="mb-2 relative">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" required placeholder="Enter your password"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 pr-10">
                <button type="button" id="togglePassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    👁️
                </button>
            </div>
        </div>
        <div id="passwordStrength" class="text-xs text-gray-600 mb-6"></div>

        <!-- Remember Me -->
        <div class="flex items-center mb-4">
            <input type="checkbox" name="remember" id="remember" class="mr-2 rounded text-green-600 focus:ring-green-500">
            <label for="remember" class="text-sm text-gray-700">Remember Me</label>
        </div>

      
        <button type="submit"
                class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Login
        </button>

        <div class="mt-4 text-center">
            <a href="{{ route('officer.forgot.password') }}" class="text-green-600 text-sm hover:underline">
                Forgot Password?
            </a>
        </div>

        <!-- Register Link -->
        <p class="mt-4 text-center text-sm text-gray-700">
            Don’t have an account?
            <a href="{{ route('officer.register') }}" class="text-green-600 font-medium hover:underline">Register</a>
        </p>
    </form>

   
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire('Success!', "{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        Swal.fire('Error!', "{{ session('error') }}", 'error');
    @endif

    @if(session('info'))
        Swal.fire('Info', "{{ session('info') }}", 'info');
    @endif
</script>

<script>
    const openTerms = document.getElementById('openTermsModal');
    const closeTerms = document.getElementById('closeTermsModal');
    const termsModal = document.getElementById('termsModal');
    const termsCheckbox = document.getElementById('termsCheckbox');
    const registerLink = document.getElementById('registerLink');
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");
    const loginForm = document.getElementById('loginForm');

    
    
    // Password toggle
    togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.type = type;
    });

    // Password Strength Checker
    const strengthText = document.getElementById("passwordStrength");
    passwordInput.addEventListener("input", function () {
        const value = passwordInput.value;
        let strength = 0;
        if (value.length >= 8) strength++;
        if (/[A-Z]/.test(value)) strength++;
        if (/[a-z]/.test(value)) strength++;
        if (/[0-9]/.test(value)) strength++;
        if (/[^A-Za-z0-9]/.test(value)) strength++;

        let message = "";
        let color = "text-red-600";

        if (strength <= 2) {
            message = "Weak password ❌ — use uppercase, lowercase, numbers & symbols.";
        } else if (strength === 3 || strength === 4) {
            message = "Good password ⚠️ — try adding more complexity.";
            color = "text-yellow-600";
        } else {
            message = "Strong password ✅";
            color = "text-green-600";
        }

        strengthText.textContent = message;
        strengthText.className = `text-xs mt-1 ${color}`;
    });

    // Extra form validation with SweetAlert
    loginForm.addEventListener("submit", function (e) {
        const password = passwordInput.value;
        const email = document.getElementById("email").value;
        const role = document.querySelector("select[name='role']").value;
        const barangay = document.querySelector("select[name='barangay']").value;

        if (!role || !barangay || !email || !password) {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "Missing Fields",
                text: "Please fill in all required fields, including Barangay.",
                confirmButtonColor: "#16a34a",
            });
            return;
        }

        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!strongRegex.test(password)) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Weak Password",
                text: "Password must be at least 8 characters with uppercase, lowercase, number, and special symbol.",
                confirmButtonColor: "#16a34a",
            });
        }
    });
</script>
</body>
</html>
