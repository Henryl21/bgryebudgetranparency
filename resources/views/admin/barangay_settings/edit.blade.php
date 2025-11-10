@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-teal-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 animate-fadeIn">
            <div class="flex items-center space-x-3 mb-2">
                <div class="h-1 w-12 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full"></div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">
                    Edit Barangay Information
                </h2>
            </div>
            <p class="text-gray-600 ml-15 text-sm md:text-base">Update your barangay profile details</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
            <!-- Decorative Header -->
            <div class="h-2 bg-gradient-to-r from-blue-500 via-teal-500 to-blue-400"></div>
            
            <div class="p-6 sm:p-8 md:p-10">
                <form action="{{ route('admin.barangay_settings.update', $settings->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Barangay Name -->
                    <div class="form-group animate-slideUp" style="animation-delay: 0.1s">
                        <label class="block text-gray-700 font-semibold mb-3 text-sm md:text-base">
                            Barangay Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="barangay_name" 
                                   value="{{ old('barangay_name', $settings->barangay_name) }}"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 outline-none hover:border-gray-300" 
                                   placeholder="Enter barangay name"
                                   required>
                        </div>
                        @error('barangay_name')
                            <p class="text-red-500 text-sm mt-2 flex items-center animate-shake">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Logo Upload Section -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Barangay Logo -->
                        <div class="form-group animate-slideUp" style="animation-delay: 0.2s">
                            <label class="block text-gray-700 font-semibold mb-3 text-sm md:text-base">
                                Barangay Logo
                            </label>
                            
                            <!-- Current Logo Preview -->
                            @if($settings->poblacion_logo)
                                <div class="mb-4 relative group">
                                    <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-4 rounded-xl border-2 border-teal-200">
                                        <p class="text-xs font-semibold text-teal-700 mb-2 uppercase tracking-wide">Current Logo</p>
                                        <div class="flex justify-center">
                                            <div class="relative">
                                                <img src="{{ asset('storage/'.$settings->poblacion_logo) }}" 
                                                     class="w-32 h-32 object-cover rounded-xl shadow-lg border-4 border-white ring-2 ring-teal-200"
                                                     alt="Current Barangay Logo">
                                                <div class="absolute -top-2 -right-2 bg-teal-500 text-white rounded-full p-1.5 shadow-lg">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Upload New Logo -->
                            <div class="relative group">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-teal-400 transition-all duration-300 cursor-pointer bg-gray-50 hover:bg-teal-50 group-hover:shadow-md">
                                    <input type="file" 
                                           name="poblacion_logo" 
                                           accept="image/*"
                                           class="hidden"
                                           id="poblacion_logo"
                                           onchange="previewImage(this, 'poblacion_preview')">
                                    <label for="poblacion_logo" class="cursor-pointer">
                                        <div id="poblacion_preview" class="mb-3">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-teal-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-600 group-hover:text-teal-600 transition-colors">
                                            <span class="font-semibold">Upload new logo</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                                    </label>
                                </div>
                            </div>
                            @error('poblacion_logo')
                                <p class="text-red-500 text-sm mt-2 flex items-center animate-shake">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Municipality Logo -->
                        <div class="form-group animate-slideUp" style="animation-delay: 0.3s">
                            <label class="block text-gray-700 font-semibold mb-3 text-sm md:text-base">
                                Municipality Logo
                            </label>
                            
                            <!-- Current Logo Preview -->
                            @if($settings->barangay_logo)
                                <div class="mb-4 relative group">
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border-2 border-blue-200">
                                        <p class="text-xs font-semibold text-blue-700 mb-2 uppercase tracking-wide">Current Logo</p>
                                        <div class="flex justify-center">
                                            <div class="relative">
                                                <img src="{{ asset('storage/'.$settings->barangay_logo) }}" 
                                                     class="w-32 h-32 object-cover rounded-xl shadow-lg border-4 border-white ring-2 ring-blue-200"
                                                     alt="Current Municipality Logo">
                                                <div class="absolute -top-2 -right-2 bg-blue-500 text-white rounded-full p-1.5 shadow-lg">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Upload New Logo -->
                            <div class="relative group">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition-all duration-300 cursor-pointer bg-gray-50 hover:bg-blue-50 group-hover:shadow-md">
                                    <input type="file" 
                                           name="barangay_logo" 
                                           accept="image/*"
                                           class="hidden"
                                           id="barangay_logo"
                                           onchange="previewImage(this, 'barangay_preview')">
                                    <label for="barangay_logo" class="cursor-pointer">
                                        <div id="barangay_preview" class="mb-3">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors">
                                            <span class="font-semibold">Upload new logo</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                                    </label>
                                </div>
                            </div>
                            @error('barangay_logo')
                                <p class="text-red-500 text-sm mt-2 flex items-center animate-shake">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 animate-slideUp" style="animation-delay: 0.4s">
                        <button type="submit"
                                class="flex-1 sm:flex-none bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Update Barangay Info
                            </span>
                        </button>
                        <a href="{{ route('admin.barangay_settings.index') }}"
                           class="flex-1 sm:flex-none text-center bg-white border-2 border-gray-300 text-gray-700 font-semibold px-8 py-3 rounded-xl hover:bg-gray-50 hover:border-gray-400 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-gray-200">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Notice -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg animate-fadeIn" style="animation-delay: 0.5s">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm text-blue-700 font-medium">Leave the file inputs empty if you don't want to change the logos</p>
                    <p class="text-xs text-blue-600 mt-1">Only upload new files if you need to replace the existing logos</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    75% {
        transform: translateX(5px);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.6s ease-out forwards;
    opacity: 0;
}

.animate-shake {
    animation: shake 0.3s ease-in-out;
}
</style>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="relative inline-block">
                    <img src="${e.target.result}" 
                         class="mx-auto h-32 w-32 object-cover rounded-xl shadow-lg border-4 border-white ring-2 ring-green-200"
                         alt="New Preview">
                    <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1.5 shadow-lg animate-pulse">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-xs text-green-600 font-semibold mt-2 text-center">New Logo Selected</p>
                </div>
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection