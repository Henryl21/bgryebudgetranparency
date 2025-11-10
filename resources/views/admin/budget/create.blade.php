@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 p-3 sm:p-6 lg:p-8">
    <div class="max-w-lg mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-6 sm:mb-8 animate-fadeIn">
            <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full mb-3 sm:mb-4 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 animate-bounce-slow">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-800 via-indigo-700 to-gray-600 bg-clip-text text-transparent mb-2 animate-gradient">
                Add New Budget
            </h1>
            <p class="text-sm sm:text-base text-gray-600 px-4">Create a new budget entry to track your finances</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white/80 backdrop-blur-sm p-4 sm:p-6 lg:p-8 rounded-2xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300 animate-slideUp">
            <form action="{{ route('admin.budget.store') }}" method="POST" class="space-y-5 sm:space-y-6" id="budgetForm">
                @csrf

                <!-- Title Field -->
                <div class="group relative">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 flex items-center transition-all duration-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Title
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="titleInput"
                        class="w-full border-2 border-gray-200 p-2.5 sm:p-3 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 bg-gray-50 focus:bg-white placeholder-gray-400 text-sm sm:text-base hover:border-indigo-300" 
                        placeholder="Enter budget title..."
                        pattern="[A-Za-z\s]+"
                        title="Please enter letters only"
                        required
                    >
                    <span class="text-xs text-red-500 mt-1 hidden" id="titleError">Only letters and spaces are allowed</span>
                </div>

                <!-- Amount Field -->
                <div class="group relative">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 flex items-center transition-all duration-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Amount (₱)
                    </label>
                    <div class="relative">
                        <span class="absolute left-2.5 sm:left-3 top-2.5 sm:top-3 text-gray-500 font-medium text-sm sm:text-base">₱</span>
                        <input 
                            type="number" 
                            name="amount" 
                            step="0.01" 
                            min="0"
                            class="w-full border-2 border-gray-200 p-2.5 sm:p-3 pl-7 sm:pl-8 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 bg-gray-50 focus:bg-white placeholder-gray-400 text-sm sm:text-base hover:border-emerald-300" 
                            placeholder="0.00"
                            required
                        >
                    </div>
                </div>

                {{-- Automatically set as income --}}
                <input type="hidden" name="type" value="income">

                <!-- Income Badge -->
                <div class="flex items-center justify-center animate-pulse-slow">
                    <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200 shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        Income Entry
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 pt-4 border-t border-gray-100">
                    <a 
                        href="{{ route('admin.budget.index') }}" 
                        class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-200 hover:scale-105 active:scale-95 hover:shadow-md order-2 sm:order-1"
                    >
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-xs sm:text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 active:scale-95 focus:ring-4 focus:ring-indigo-200 order-1 sm:order-2"
                    >
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Budget
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-4 sm:mt-6 animate-fadeIn">
            <p class="text-xs sm:text-sm text-gray-500 px-4">
                All budget entries are automatically categorized as income
            </p>
        </div>
    </div>
</div>

<style>
    /* Custom animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
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
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes bounceSlow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }
    
    @keyframes pulseSlow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.85;
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.6s ease-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.8s ease-out;
    }
    
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient 4s ease infinite;
    }
    
    .animate-bounce-slow {
        animation: bounceSlow 3s ease-in-out infinite;
    }
    
    .animate-pulse-slow {
        animation: pulseSlow 3s ease-in-out infinite;
    }
    
    /* Hover effects for form fields */
    .group:hover input {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
    }
    
    /* Focus effect */
    input:focus {
        transform: scale(1.01);
    }
    
    /* Button ripple effect */
    button, a {
        position: relative;
        overflow: hidden;
    }
    
    button::before, a::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    button:active::before, a:active::before {
        width: 300px;
        height: 300px;
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .bg-gradient-to-br {
            background-attachment: fixed;
        }
    }
    
    /* Tablet and up */
    @media (min-width: 768px) {
        .group:hover label {
            color: #6366f1;
            transform: translateX(2px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('titleInput');
        const titleError = document.getElementById('titleError');
        const form = document.getElementById('budgetForm');
        
        // Real-time validation for title input
        titleInput.addEventListener('input', function(e) {
            const value = e.target.value;
            const lettersOnly = /^[A-Za-z\s]*$/;
            
            if (!lettersOnly.test(value)) {
                // Remove non-letter characters
                e.target.value = value.replace(/[^A-Za-z\s]/g, '');
                titleError.classList.remove('hidden');
                titleInput.classList.add('border-red-500');
                titleInput.classList.remove('border-gray-200');
                
                // Hide error after 2 seconds
                setTimeout(() => {
                    titleError.classList.add('hidden');
                    titleInput.classList.remove('border-red-500');
                    titleInput.classList.add('border-gray-200');
                }, 2000);
            }
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            const titleValue = titleInput.value.trim();
            const lettersOnly = /^[A-Za-z\s]+$/;
            
            if (!lettersOnly.test(titleValue)) {
                e.preventDefault();
                titleError.classList.remove('hidden');
                titleInput.classList.add('border-red-500');
                titleInput.focus();
                
                setTimeout(() => {
                    titleError.classList.add('hidden');
                    titleInput.classList.remove('border-red-500');
                }, 3000);
            }
        });
        
        // Add shake animation on error
        titleInput.addEventListener('invalid', function() {
            this.classList.add('animate-shake');
            setTimeout(() => {
                this.classList.remove('animate-shake');
            }, 500);
        });
    });
</script>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    
    .animate-shake {
        animation: shake 0.3s ease-in-out;
    }
</style>
@endsection