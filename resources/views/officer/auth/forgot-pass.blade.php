<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center min-h-screen px-4 sm:px-0">

    <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl p-6 sm:p-8 w-full max-w-md border border-green-200 transform transition-all hover:scale-[1.02] duration-500 ease-in-out">
        <h2 class="text-3xl font-bold text-center mb-4 text-green-700">Forgot Password</h2>
        <p class="text-center text-gray-600 mb-6 text-sm sm:text-base">
            Enter your email below to receive a password reset link.
        </p>

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('officer.forgot.password.send') }}" class="space-y-4">
            @csrf
            <div>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Enter your email" 
                    required 
                    class="w-full p-3 sm:p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 text-sm sm:text-base"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 transform hover:translate-y-[-2px] shadow-md"
            >
                Send Reset Link
            </button>

            <p class="text-center text-sm mt-4">
                <a href="{{ route('officer.login') }}" class="text-green-600 hover:underline">
                    ← Back to Login
                </a>
            </p>
        </form>
    </div>

    {{-- SweetAlert Notifications --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#1f2937'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#16a34a',
                background: '#ffffff',
                color: '#1f2937'
            });
        </script>
    @endif

</body>
</html>
