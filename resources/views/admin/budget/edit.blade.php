@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-green-50 py-4 sm:py-8 px-3 sm:px-4 lg:px-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mb-4 sm:mb-6 hover:shadow-xl transition-all duration-300 animate-slideDown">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent flex items-center animate-gradient">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3 text-emerald-600 animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Income Record
                    </h1>
                    <a href="{{ route('admin.budget.index') }}" 
                       class="text-gray-500 hover:text-gray-700 hover:bg-gray-100 p-2 rounded-full transition-all duration-200 hover:scale-110 active:scale-95">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">Update income details and save changes</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6 shadow-md animate-shake">
                <div class="flex items-start">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-400 mt-0.5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-xs sm:text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                        <ul class="text-xs sm:text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300 animate-slideUp">
            <form action="{{ route('admin.budget.update', $budget->id) }}" method="POST" class="p-4 sm:p-6" id="editBudgetForm">
                @csrf
                @method('PUT')

                <div class="space-y-5 sm:space-y-6">
                    <!-- Title Field -->
                    <div class="group">
                        <label for="title" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 transition-all duration-200">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Income Title
                            </span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title"
                               value="{{ old('title', $budget->title) }}"
                               class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400 text-sm sm:text-base bg-gray-50 focus:bg-white hover:border-green-400"
                               placeholder="Enter income title..."
                               pattern="[A-Za-z\s]+"
                               title="Please enter letters only"
                               required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="titleError">Only letters and spaces are allowed</span>
                    </div>

                    <!-- Hidden Type Field - Always Income -->
                    <input type="hidden" name="type" value="income">

                    <!-- Type Display (Read-only) -->
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                Record Type
                            </span>
                        </label>
                        <div class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-green-200 rounded-lg bg-gradient-to-r from-green-50 to-emerald-50 animate-pulse-slow">
                            <div class="flex items-center flex-wrap gap-2">
                                <span class="inline-flex px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-medium rounded-full bg-green-100 text-green-800 shadow-sm">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    Income
                                </span>
                                <span class="text-xs sm:text-sm text-gray-600">This record is categorized as income</span>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Field -->
                    <div class="group">
                        <label for="amount" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 transition-all duration-200">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                Income Amount (₱)
                            </span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-2.5 sm:left-3 top-1/2 transform -translate-y-1/2 text-green-600 font-medium text-sm sm:text-base">₱</span>
                            <input type="number" 
                                   name="amount" 
                                   id="amount"
                                   value="{{ old('amount', $budget->amount) }}"
                                   class="w-full pl-7 sm:pl-8 pr-3 sm:pr-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400 text-sm sm:text-base bg-gray-50 focus:bg-white hover:border-green-400"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1.5">Enter the income amount in Philippine Pesos</p>
                    </div>

                    <!-- Description Field (Optional) -->
                    <div class="group">
                        <label for="description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 transition-all duration-200">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Description (Optional)
                            </span>
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  rows="3"
                                  class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400 resize-none text-sm sm:text-base bg-gray-50 focus:bg-white hover:border-green-400"
                                  placeholder="Add any additional notes about this income...">{{ old('description', $budget->description ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1.5">Optional: Add details about the source or nature of this income</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-5 sm:pt-6 mt-5 sm:mt-6 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-green-700 focus:ring-4 focus:ring-emerald-200 transition-all duration-200 hover:scale-105 active:scale-95 shadow-md hover:shadow-lg text-sm sm:text-base">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Income Record
                    </button>
                    
                    <a href="{{ route('admin.budget.index') }}"
                       class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 transition-all duration-200 hover:scale-105 active:scale-95 shadow-sm hover:shadow-md text-sm sm:text-base">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-3 sm:p-4 mt-4 sm:mt-6 shadow-md hover:shadow-lg transition-all duration-300 animate-fadeIn">
            <div class="flex items-start">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400 mt-0.5 mr-2 sm:mr-3 flex-shrink-0 animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-xs sm:text-sm font-medium text-green-800 mb-1.5">Income Record Management</h3>
                    <ul class="text-xs sm:text-sm text-green-700 space-y-1">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>This form is specifically for editing income records only</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Use clear, descriptive titles for easy identification</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>All changes are saved immediately after clicking Update</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Add descriptions to provide context for future reference</span>
                        </li>
                    </ul>
                </div>
            </div>
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
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
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
    
    @keyframes pulseSlow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.6s ease-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.8s ease-out;
    }
    
    .animate-slideDown {
        animation: slideDown 0.6s ease-out;
    }
    
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient 4s ease infinite;
    }
    
    .animate-pulse-slow {
        animation: pulseSlow 3s ease-in-out infinite;
    }
    
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
    
    /* Hover effects for form fields */
    .group:hover input,
    .group:hover textarea {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.1);
    }
    
    /* Focus effect */
    input:focus,
    textarea:focus {
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
            color: #059669;
            transform: translateX(2px);
        }
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const titleError = document.getElementById('titleError');
        const form = document.getElementById('editBudgetForm');
        
        // Real-time validation for title input (letters only)
        titleInput.addEventListener('input', function(e) {
            const value = e.target.value;
            const lettersOnly = /^[A-Za-z\s]*$/;
            
            if (!lettersOnly.test(value)) {
                // Remove non-letter characters
                e.target.value = value.replace(/[^A-Za-z\s]/g, '');
                titleError.classList.remove('hidden');
                titleInput.classList.add('border-red-500', 'shake-animation');
                titleInput.classList.remove('border-gray-300');
                
                // Hide error after 2 seconds
                setTimeout(() => {
                    titleError.classList.add('hidden');
                    titleInput.classList.remove('border-red-500', 'shake-animation');
                    titleInput.classList.add('border-gray-300');
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
                
                // Add shake animation
                titleInput.classList.add('animate-shake');
                setTimeout(() => {
                    titleInput.classList.remove('animate-shake');
                }, 500);
                
                setTimeout(() => {
                    titleError.classList.add('hidden');
                    titleInput.classList.remove('border-red-500');
                }, 3000);
            }
        });
        
        // Add shake animation on invalid
        titleInput.addEventListener('invalid', function() {
            this.classList.add('animate-shake');
            setTimeout(() => {
                this.classList.remove('animate-shake');
            }, 500);
        });
        
        // Amount field formatting
        const amountInput = document.getElementById('amount');
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
        
        // Auto-resize textarea
        const descriptionTextarea = document.getElementById('description');
        if (descriptionTextarea) {
            descriptionTextarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endsection