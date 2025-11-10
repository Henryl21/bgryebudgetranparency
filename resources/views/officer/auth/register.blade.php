<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Officer Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center min-h-screen">

  <form id="registerForm" action="{{ route('officer.register.submit') }}" method="POST"
        class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-full max-w-xl border border-green-200">
    @csrf

    <!-- Header -->
    <h2 class="text-3xl font-extrabold text-center mb-6 text-green-700 tracking-wide">
      Officer Registration
    </h2>

    <!-- Personal Info -->
    <div class="mb-6">
      <h3 class="text-sm font-semibold text-green-600 mb-3 uppercase tracking-wide border-b border-green-200 pb-1">
        Personal Information
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Full Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required>
          <p id="name-error" class="text-red-500 text-sm mt-1 hidden">Numbers are not allowed in the name.</p>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required>
        </div>
      </div>
    </div>

    <!-- Role Info -->
    <div class="mb-6">
      <h3 class="text-sm font-semibold text-green-600 mb-3 uppercase tracking-wide border-b border-green-200 pb-1">
        Role Information
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Role -->
        <div>
          <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
          <select name="role" id="role"
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required>
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

        <!-- Barangay -->
        <div>
          <label for="barangay" class="block text-sm font-medium text-gray-700 mb-1">Select Barangay</label>
          <select name="barangay" id="barangay"
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required>
            <option value="">Select Barangay</option>
            @foreach($barangays as $key => $name)
                <option value="{{ $key }}" {{ old('barangay') == $key ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <!-- Security Info -->
    <div class="mb-8">
      <h3 class="text-sm font-semibold text-green-600 mb-3 uppercase tracking-wide border-b border-green-200 pb-1">
        Security
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Password -->
        <div class="relative">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <div class="relative">
            <input id="password" name="password" type="password" required placeholder="Enter your password"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 pr-10">
            <button type="button" id="togglePassword"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
              👁️
            </button>
          </div>
          <p id="password-error" class="text-red-500 text-sm mt-1 hidden">
            Password must be at least 8 characters, include uppercase, lowercase, number, and special character.
          </p>
        </div>

        <!-- Confirm Password -->
        <div class="relative">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
          <div class="relative">
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="Confirm password"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 pr-10" required>
            <button type="button" id="toggleConfirmPassword"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
              👁️
            </button>
          </div>
        </div>

      </div>
    </div>

    <!-- Submit -->
    <button type="submit"
            class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-sm hover:shadow-md">
      Register
    </button>

    <!-- Login Link -->
    <p class="mt-6 text-center text-sm text-gray-700">
      Already have an account?
      <a href="{{ route('officer.login') }}" class="text-green-600 font-medium hover:underline">
        Login
      </a>
    </p>
  </form>

  <!-- JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const nameInput = document.getElementById('name');
      const nameError = document.getElementById('name-error');
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('password_confirmation');
      const passwordError = document.getElementById('password-error');
      const form = document.getElementById('registerForm');

      const togglePassword = document.getElementById('togglePassword');
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

      togglePassword.addEventListener('click', () => {
        if(passwordInput.type === 'password'){
          passwordInput.type = 'text';
          togglePassword.textContent = '🙈';
        } else {
          passwordInput.type = 'password';
          togglePassword.textContent = '👁️';
        }
      });

      toggleConfirmPassword.addEventListener('click', () => {
        if(confirmPasswordInput.type === 'password'){
          confirmPasswordInput.type = 'text';
          toggleConfirmPassword.textContent = '🙈';
        } else {
          confirmPasswordInput.type = 'password';
          toggleConfirmPassword.textContent = '👁️';
        }
      });

      // Restrict numbers in name
      nameInput.addEventListener('input', function() {
        if (/\d/.test(this.value)) {
          this.value = this.value.replace(/[0-9]/g, '');
          nameError.classList.remove('hidden');
        } else {
          nameError.classList.add('hidden');
        }
      });

      // Password validation on submit
      form.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const strongPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;

        if (!strongPassword.test(password)) {
          e.preventDefault();
          passwordError.classList.remove('hidden');
          Swal.fire({
            icon: 'error',
            title: 'Weak Password',
            text: 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character.',
            confirmButtonColor: '#d33'
          });
        }
      });
    });
  </script>

  <!-- SweetAlert Flash Messages -->
  @if (session('success'))
  <script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6'
    });
  </script>
  @endif

  @if (session('error'))
  <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33'
    });
  </script>
  @endif

  @if (session('info'))
  <script>
    Swal.fire({
        icon: 'info',
        title: 'Notice',
        text: '{{ session('info') }}',
        confirmButtonColor: '#17a2b8'
    });
  </script>
  @endif

</body>
</html>
