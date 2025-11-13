@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-green-100 to-teal-200 flex items-center justify-center py-10 px-4">
    <div class="max-w-3xl w-full bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 transition-all duration-300 hover:shadow-3xl border border-gray-200">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow transition duration-200">
               <span class="text-lg">&larr;</span> Back to Dashboard
            </a>
        </div>

        <!-- Header -->
        <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-tight">
            🌟 My Profile
        </h2>

        <!-- Profile Section -->
        <div class="flex flex-col items-center mb-6">
            <div class="relative">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-green-400 shadow-md hover:scale-105 transition duration-300" 
                         alt="Profile Photo">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-green-400 shadow-md hover:scale-105 transition duration-300" 
                         alt="Default Profile">
                @endif
            </div>
        </div>

        <!-- User Info -->
        <div class="bg-gray-50 rounded-lg p-5 shadow-inner text-gray-800 text-sm sm:text-base space-y-3">
            <p><strong class="text-gray-700">Full Name:</strong> {{ $user->full_name }}</p>
            <p><strong class="text-gray-700">Email:</strong> {{ $user->email }}</p>
            <p><strong class="text-gray-700">Number:</strong> {{ $user->number ?? 'N/A' }}</p>
          
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('user.profile.edit') }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg shadow-md transform hover:-translate-y-1 transition duration-200">
               ✏️ Edit Profile
            </a>

            <form action="{{ route('user.profile.destroy') }}" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-lg shadow-md transform hover:-translate-y-1 transition duration-200">
                    🗑️ Delete Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
