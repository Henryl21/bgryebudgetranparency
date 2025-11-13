<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-green-50">

<div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-green-700 mb-6">Verify OTP</h2>
    <p class="mb-4 text-center text-gray-600">Enter the OTP sent to your email</p>

    <form action="{{ route('officer.register.verifyOtp') }}" method="POST">
        @csrf
        <input type="text" name="otp" maxlength="6" required
               class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-green-500">
        <button type="submit"
                class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold hover:bg-green-700">
            Verify OTP
        </button>
    </form>
</div>

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '{{ session('error') }}',
});
</script>
@endif

@if(session('info'))
<script>
Swal.fire({
    icon: 'info',
    title: 'Notice',
    text: '{{ session('info') }}',
});
</script>
@endif

</body>
</html>
