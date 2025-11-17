@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex flex-col items-center py-10 px-4 sm:px-6 lg:px-8">

    <!-- Profile Card -->
    <div class="w-full max-w-3xl bg-white shadow-2xl rounded-2xl p-8 sm:p-10 relative transition-transform transform hover:scale-[1.01] hover:shadow-3xl duration-300">

        <!-- Header with Go Back Button -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                <i class="fas fa-user-circle text-blue-600"></i> Admin Profile
            </h2>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 hover:scale-105 transform transition duration-200">
                ← Go to Dashboard
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-6 border border-green-300 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Form -->
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Image -->
            <div class="flex flex-col items-center mb-8">
                <div class="relative group">
                    @if($admin->profile_photo)
                        <img src="{{ asset('storage/' . $admin->profile_photo) }}" alt="Profile Photo">
                             alt="Profile Photo"
                             class="w-32 h-32 rounded-full object-cover border-4 border-blue-400 shadow-lg group-hover:opacity-80 transition duration-300">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-4xl font-bold shadow-md">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-30 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300">
                        <label class="bg-white text-blue-700 text-sm px-3 py-1 rounded-md cursor-pointer shadow-md hover:bg-blue-50">
                            Change
                            <input type="file" name="profile_photo" class="hidden">
                        </label>
                    </div>
                </div>
            </div>

            <!-- Input Fields -->
            <div class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end items-center gap-3 mt-8">
                <a href="{{ route('admin.dashboard') }}" 
                   class="w-full sm:w-auto text-center bg-gray-200 text-gray-800 px-5 py-2 rounded-md hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 hover:scale-105 hover:shadow-lg transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Optional animation -->
<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(-5px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.4s ease-in-out;
}
</style>
@endsection
