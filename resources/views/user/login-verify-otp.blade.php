<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP - Barangay eBudget Transparency</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
      🔐 Verify Your Login
    </h2>

    @if(session('success'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '{{ session('success') }}',
          confirmButtonColor: '#2563eb'
        });
      </script>
    @endif

    @if($errors->any())
      <div class="mb-4 text-red-600 text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('user.login.verify-otp') }}" method="POST" class="space-y-4">
      @csrf
      <!-- Hidden inputs for geolocation -->
      <input type="hidden" name="latitude" id="latitude">
      <input type="hidden" name="longitude" id="longitude">

      <div>
        <label for="otp" class="block text-gray-700 font-semibold mb-2">Enter OTP</label>
        <input type="text" name="otp" id="otp" maxlength="6"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-center tracking-widest text-xl font-bold focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="______" required>
      </div>

      <p class="text-sm text-gray-600 text-center">
        We’ve sent a 6-digit verification code to your email.  
        <br><span class="font-semibold">Check your inbox or spam folder.</span>
      </p>

      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
        Verify and Continue
      </button>

      <div class="text-center mt-4">
        <a href="{{ route('user.login') }}" class="text-blue-600 hover:underline text-sm">
          ← Back to Login
        </a>
      </div>
    </form>
  </div>

  <!-- Geolocation JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form');

      form.addEventListener('submit', function(e) {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            form.submit(); // submit after filling coordinates
          }, function(err) {
            console.warn("Geolocation failed or denied:", err.message);
            form.submit(); // submit anyway if user denies location
          });

          // Prevent immediate submission until coords are filled
          e.preventDefault();
        }
      });
    });
  </script>

</body>
</html>
