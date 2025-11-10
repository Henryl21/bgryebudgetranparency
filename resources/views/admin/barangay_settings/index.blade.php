@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-teal-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 animate-fadeIn">
            <div class="flex items-center space-x-3 mb-2">
                <div class="h-1 w-12 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">
                    Barangay Information
                </h2>
            </div>
            <p class="text-gray-600 ml-15 text-sm md:text-base">View and manage your barangay settings</p>
        </div>

        <!-- Main Info Card -->
        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden mb-6 animate-slideUp" style="animation-delay: 0.1s">
            <!-- Decorative Header -->
            <div class="h-2 bg-gradient-to-r from-teal-500 via-blue-500 to-teal-400"></div>
            
            <div class="p-6 sm:p-8 md:p-10">
                <!-- Logo and Name Display -->
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
                    <!-- Logo Section -->
                    <div class="flex-shrink-0 animate-scaleIn" style="animation-delay: 0.2s">
                        @if($settings?->barangay_logo)
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full opacity-75 group-hover:opacity-100 blur transition duration-300"></div>
                                <img src="{{ asset('storage/'.$settings->barangay_logo) }}"
                                     alt="Barangay Logo" 
                                     class="relative w-32 h-32 md:w-40 md:h-40 object-cover rounded-full border-4 border-white shadow-xl">
                                <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full p-2 shadow-lg">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        @else
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full opacity-50 blur"></div>
                                <div class="relative w-32 h-32 md:w-40 md:h-40 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 rounded-full border-4 border-white shadow-xl">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-gray-500 text-xs font-medium">No Logo</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info Section -->
                    <div class="flex-1 text-center md:text-left animate-slideRight" style="animation-delay: 0.3s">
                        <div class="mb-4">
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                                {{ $settings?->barangay_name ?? 'Not Set' }}
                            </h3>
                            @if($settings?->barangay_name)
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Active
                                </div>
                            @else
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Not Configured
                                </div>
                            @endif
                        </div>

                        <!-- Additional Info Cards -->
                        @if($settings)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-6">
                                <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg p-4 border border-teal-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-teal-500 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-teal-600 font-medium">Configuration</p>
                                            <p class="text-sm font-bold text-teal-800">Complete</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-500 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-600 font-medium">Last Updated</p>
                                            <p class="text-sm font-bold text-blue-800">{{ $settings->updated_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-6 animate-slideUp" style="animation-delay: 0.4s">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if($settings)
                            <!-- Edit Info Button -->
                            <a href="{{ route('admin.barangay_settings.edit', $settings->id) }}"
                               class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-6 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit Info
                                </div>
                            </a>
                        @else
                            <!-- Create Info Button -->
                            <a href="{{ route('admin.barangay_settings.create') }}"
                               class="group relative overflow-hidden bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold px-6 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Create Info
                                </div>
                            </a>
                        @endif

                        <!-- Manage Expenditures Button -->
                        <a href="{{ route('admin.expenditure.index') }}"
                           class="group relative overflow-hidden bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold px-6 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Manage Expenditures
                            </div>
                        </a>

                        <!-- Print Reports Button -->
                        <a href="{{ route('admin.reports.print') }}"
                           target="_blank"
                           class="group relative overflow-hidden bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white font-semibold px-6 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Print Report
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        @if($settings)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slideUp" style="animation-delay: 0.5s">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-teal-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-teal-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-teal-600 bg-teal-50 px-3 py-1 rounded-full">Active</span>
                    </div>
                    <h4 class="text-gray-600 text-sm font-medium mb-1">Barangay Status</h4>
                    <p class="text-2xl font-bold text-gray-800">Configured</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-blue-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Ready</span>
                    </div>
                    <h4 class="text-gray-600 text-sm font-medium mb-1">Logos Uploaded</h4>
                    <p class="text-2xl font-bold text-gray-800">Complete</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-t-4 border-indigo-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Available</span>
                    </div>
                    <h4 class="text-gray-600 text-sm font-medium mb-1">Reports</h4>
                    <p class="text-2xl font-bold text-gray-800">Ready to Print</p>
                </div>
            </div>
        @endif
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

@keyframes slideRight {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.6s ease-out forwards;
    opacity: 0;
}

.animate-slideRight {
    animation: slideRight 0.6s ease-out forwards;
    opacity: 0;
}

.animate-scaleIn {
    animation: scaleIn 0.6s ease-out forwards;
    opacity: 0;
}
</style>
@endsection