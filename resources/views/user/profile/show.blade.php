@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded mt-6">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('user.dashboard') }}" 
           class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
           &larr; Back to Dashboard
        </a>
    </div>

    <h2 class="text-2xl font-bold mb-6 text-gray-800">My Profile</h2>

    <!-- Profile Photo -->
    <div class="flex flex-col items-center mb-6">
        <img src="{{ $user->profile_photo ? asset('storage/profile_photos/' . $user->profile_photo) : asset('default-avatar.png') }}" 
             alt="{{ $user->full_name }}" 
             class="w-28 h-28 rounded-full border-4 border-yellow-400 shadow-md object-cover">
    </div>

    <!-- User Info -->
    <div class="text-gray-800 text-sm sm:text-base space-y-2">
        <p><strong>Full Name:</strong> {{ $user->full_name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Number:</strong> {{ $user->number ?? 'N/A' }}</p>
        <p><strong>Barangay Role:</strong> {{ $user->barangay_role ?? 'N/A' }}</p>
    </div>

    <!-- Buttons -->
    <div class="mt-6 flex gap-3 justify-end">
        <a href="{{ route('user.profile.edit') }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
           Edit Profile
        </a>

        <form action="{{ route('user.profile.destroy') }}" 
              method="POST" 
              onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection
