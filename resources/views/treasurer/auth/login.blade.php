@extends('layouts.app') {{-- or your master layout --}}

@section('title', 'Treasurer Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Treasurer Login</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('treasurer.login.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-3 py-2 border rounded @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="mr-1">
                    <label for="remember" class="text-gray-700 text-sm">Remember me</label>
                </div>
                <a href="#" class="text-blue-600 text-sm hover:underline">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold">
                Login
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-4">
            Don't have an account? 
            <a href="{{ route('treasurer.register') }}" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>
</div>
@endsection
