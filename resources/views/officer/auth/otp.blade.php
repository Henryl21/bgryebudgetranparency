@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">🔐 Verify Your Login</h2>

    <form method="POST" action="{{ route('officer.verifyOtp') }}">
        @csrf

        <!-- Hidden fields for latitude and longitude -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <div class="mb-4">
            <label for="otp" class="block text-gray-700 font-semibold mb-2">Enter OTP</label>
            <input type="text" name="otp" id="otp" maxlength="6" placeholder="______" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-center text-xl font-bold tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
            Verify and Continue
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('officer.login') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to Login
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    // Capture geolocation before submitting
    form.addEventListener('submit', function(e) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                document.getElementById('latitude').value = pos.coords.latitude;
                document.getElementById('longitude').value = pos.coords.longitude;
                form.submit();
            }, function(err) {
                console.warn("Geolocation denied or failed:", err.message);
                form.submit(); // submit anyway
            });
            e.preventDefault(); // wait for coordinates
        }
    });

    // SweetAlert notifications
    @if(session('success'))
        Swal.fire('Success!', "{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        Swal.fire('Error!', "{{ session('error') }}", 'error');
    @endif

    @if(session('info'))
        Swal.fire('Info', "{{ session('info') }}", 'info');
    @endif
});
</script>
@endsection
