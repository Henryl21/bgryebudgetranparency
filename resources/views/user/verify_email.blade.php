<form method="POST" action="{{ route('user.verify-email.submit') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <label>Enter OTP sent to your email:</label>
    <input type="text" name="otp" maxlength="6" required>
    <button type="submit">Verify Email</button>
</form>
