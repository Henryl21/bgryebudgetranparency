@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">Enter OTP</h2>

    <form method="POST" action="{{ route('officer.verifyOtp') }}">
        @csrf

        <input type="text" name="otp" placeholder="Enter OTP" required class="w-full mb-4 p-2 border rounded">
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Verify OTP</button>
    </form>
</div>
@endsection
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

