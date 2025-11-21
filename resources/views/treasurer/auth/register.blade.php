@extends('layouts.app') {{-- or your master layout --}}

@section('title', 'Treasurer Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Treasurer Registration</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('treasurer.register.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border rounded @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-3 py-2 border rounded">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded font-semibold">
                Register
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-4">
            Already have an account? 
            <a href="{{ route('treasurer.login') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection
