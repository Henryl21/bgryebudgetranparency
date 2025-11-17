@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="bg-white shadow-xl rounded-2xl p-8 transition-transform transform hover:scale-[1.01] hover:shadow-2xl duration-300 ease-in-out">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Edit Profile</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4 text-center animate-fade-in">
                <strong>⚠️ Please fix the errors below.</strong>
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- Full Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition">
                @error('full_name') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition">
                @error('email') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Number --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Number</label>
                <input type="text" name="number" value="{{ old('number', $user->number) }}"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition">
                @error('number') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Profile Photo --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Photo</label>

                <div class="flex items-center gap-4">
                    <div class="relative group">
                        @if($user->profile_photo && file_exists(public_path('profile_photos/' . $user->profile_photo)))
                            <img id="photoPreview" src="{{ asset('profile_photos/' . $user->profile_photo) }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-green-300 shadow-md group-hover:shadow-lg transition duration-300"
                                 alt="Profile Photo">
                        @else
                            <img id="photoPreview" src="{{ asset('images/default-avatar.png') }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 shadow-md"
                                 alt="Default Profile">
                        @endif
                    </div>

                    <div>
                        <input type="file" name="profile_photo" id="profile_photo"
                               class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer p-2 focus:ring-2 focus:ring-green-400 transition" 
                               onchange="previewImage(event)">
                        <p class="text-xs text-gray-500 mt-1">Accepted: JPG, PNG, GIF (max 2MB)</p>
                    </div>
                </div>

                @error('profile_photo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center gap-4 mt-8">
                <button type="submit" 
                        class="bg-green-500 text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-green-600 active:scale-95 transition duration-150">
                    💾 Save Changes
                </button>
                <a href="{{ route('user.profile.show') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 active:scale-95 transition duration-150">
                    ✖ Cancel
                </a>
            </div>
        </form>
    </div>
</div>

{{-- JS for live photo preview --}}
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('photoPreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
