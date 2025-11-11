@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded mt-6">
    <h2 class="text-2xl font-bold mb-6">Edit Profile</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Full Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" 
                class="w-full border rounded p-2">
            @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                class="w-full border rounded p-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Number -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Number</label>
            <input type="text" name="number" value="{{ old('number', $user->number) }}" 
                class="w-full border rounded p-2">
            @error('number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Barangay Role -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Barangay Role</label>
            <input type="text" name="barangay_role" value="{{ old('barangay_role', $user->barangay_role) }}" 
                class="w-full border rounded p-2">
            @error('barangay_role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Profile Photo -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Profile Photo</label>
            @if($user->profile_photo)
                <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" 
                     class="w-20 h-20 rounded-full mb-2" alt="Profile Photo">
            @endif
            <input type="file" name="profile_photo" class="w-full border rounded p-2">
            @error('profile_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password (optional) -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">New Password (optional)</label>
            <input type="password" name="password" class="w-full border rounded p-2">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Profile</button>
        <a href="{{ route('user.profile.show') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
