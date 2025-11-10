@extends('layouts.admin')

@section('content')
<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.15);
    }

    .gradient-border {
        position: relative;
        background: white;
    }

    .gradient-border::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899, #f59e0b);
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
    }

    .badge-glow {
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
    }

    .total-spent-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .total-spent-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .table-row-hover {
        transition: all 0.2s ease;
    }

    .table-row-hover:hover {
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        transform: scale(1.01);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        transform: translateY(-2px);
    }

    .section-header {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
    }

    .mobile-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #6366f1;
    }

    .mobile-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        transform: translateX(4px);
    }

    .amount-badge {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        color: white;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .empty-state {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 16px;
        padding: 3rem;
    }

    @media (max-width: 640px) {
        .mobile-optimized {
            font-size: 0.875rem;
        }
    }
</style>

<div class="p-3 sm:p-6 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen">
    <!-- Header Section -->
    <div class="mb-4 sm:mb-6 animate-slide-in">
        <h2 class="text-xl sm:text-3xl font-bold mb-3 sm:mb-4 text-gray-800 flex items-center gap-3">
            <span class="text-3xl sm:text-4xl">💰</span>
            Manage Expenditures
        </h2>

        <!-- Total Spent Card -->
        <div class="total-spent-card rounded-xl shadow-lg p-4 sm:p-6 mb-3 sm:mb-4 text-white animate-fade-in">
            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm sm:text-base font-medium text-white text-opacity-90">Total Expenditure</div>
                            <div class="text-2xl sm:text-4xl font-bold tracking-tight">
                                ₱{{ isset($totalSpent) ? number_format($totalSpent, 2) : '0.00' }}
                            </div>
                        </div>
                    </div>
                    <div class="text-xs sm:text-sm text-white text-opacity-75 bg-white bg-opacity-10 px-3 py-1.5 rounded-lg w-fit">
                        Last updated: {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2 sm:gap-3 flex-wrap">
            <!-- Print Report Button -->
            <a href="{{ route('admin.reports.print') }}" target="_blank"
               class="btn-primary text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2 text-sm sm:text-base w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-4 0h-4m0 0v4m0-4h4m-4 0H8" />
                </svg>
                <span>PRINT REPORT</span>
            </a>
        </div>
    </div>

    <!-- Expenditure Records Section -->
    <div class="gradient-border rounded-xl shadow-xl overflow-hidden animate-fade-in">
        <!-- Section Header -->
        <div class="section-header text-white p-4 sm:p-5">
            <h3 class="text-base sm:text-xl font-bold flex items-center gap-3">
                <span class="bg-white bg-opacity-20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </span>
                Expenditure Records
            </h3>
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden lg:block bg-white">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white">
                <div class="grid grid-cols-10 gap-4 p-4 font-bold text-sm">
                    <div class="col-span-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        BARANGAY
                    </div>
                    <div class="col-span-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        CATEGORY
                    </div>
                    <div class="col-span-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        DESCRIPTION
                    </div>
                    <div class="col-span-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        AMOUNT (₱)
                    </div>
                    <div class="col-span-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        DATE
                    </div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-gray-100" id="expenditure-table-body">
                @forelse($expenditures as $exp)
                <div class="grid grid-cols-10 gap-4 p-4 table-row-hover {{ session('new_expenditure_id') == $exp->id ? 'bg-green-50 border-l-4 border-green-500' : '' }}">
                    <!-- BARANGAY -->
                    <div class="col-span-2 flex items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                            <span class="text-gray-700 font-medium truncate" title="{{ $exp->barangay }}">
                                {{ $exp->barangay ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <!-- CATEGORY -->
                    <div class="col-span-2 flex items-center">
                        <span class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-full badge-glow
                            @switch($exp->title)
                                @case('Infrastructure')
                                    bg-blue-100 text-blue-800
                                    @break
                                @case('Education')
                                    bg-green-100 text-green-800
                                    @break
                                @case('Healthcare')
                                    bg-red-100 text-red-800
                                    @break
                                @case('Public Safety')
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @case('Utilities')
                                    bg-purple-100 text-purple-800
                                    @break
                                @default
                                    bg-gray-100 text-gray-800
                            @endswitch">
                            {{ $exp->category ?? 'N/A' }}
                        </span>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="col-span-2 flex items-center font-semibold text-gray-900">
                        {{ $exp->title }}
                    </div>

                    <!-- Amount -->
                    <div class="col-span-2 flex items-center">
                        <span class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">
                            ₱{{ number_format($exp->amount, 2) }}
                        </span>
                    </div>

                    <!-- Date -->
                    <div class="col-span-2 flex items-center text-gray-600 font-medium">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : ($exp->created_at ? $exp->created_at->format('M d, Y') : 'N/A') }}
                    </div>
                </div>
                @empty
                <div class="p-12 text-center empty-state mx-4 my-4">
                    <div class="text-6xl mb-4">📊</div>
                    <div class="text-xl font-bold text-gray-700 mb-2">No expenditures found</div>
                    <div class="text-sm text-gray-500">Click "ADD EXPENDITURE" to get started</div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Mobile/Tablet Card View (visible on small screens) -->
        <div class="lg:hidden bg-gray-50 p-3 sm:p-4 space-y-3 sm:space-y-4">
            @forelse($expenditures as $exp)
            <div class="mobile-card p-4 {{ session('new_expenditure_id') == $exp->id ? 'border-l-green-500' : '' }}">
                <!-- Card Header -->
                <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-100">
                    <div class="flex-1 pr-3">
                        <h4 class="font-bold text-gray-900 text-base mb-2 line-clamp-2">{{ $exp->title }}</h4>
                        <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full
                            @switch($exp->title)
                                @case('Infrastructure')
                                    bg-blue-100 text-blue-800
                                    @break
                                @case('Education')
                                    bg-green-100 text-green-800
                                    @break
                                @case('Healthcare')
                                    bg-red-100 text-red-800
                                    @break
                                @case('Public Safety')
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @case('Utilities')
                                    bg-purple-100 text-purple-800
                                    @break
                                @default
                                    bg-gray-100 text-gray-800
                            @endswitch">
                            {{ $exp->category ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <div class="amount-badge text-sm sm:text-base whitespace-nowrap">
                            ₱{{ number_format($exp->amount, 2) }}
                        </div>
                    </div>
                </div>

                <!-- Card Details -->
                <div class="space-y-2 mobile-optimized">
                    <div class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span class="text-gray-500 font-medium">Barangay:</span>
                        <span class="text-gray-800 font-semibold">{{ $exp->barangay ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-500 font-medium">Date:</span>
                        <span class="text-gray-800 font-semibold">
                            {{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : ($exp->created_at ? $exp->created_at->format('M d, Y') : 'N/A') }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state text-center">
                <div class="text-5xl mb-3">📊</div>
                <div class="text-lg font-bold text-gray-700 mb-1">No expenditures found</div>
                <div class="text-sm text-gray-500">Click "ADD EXPENDITURE" to get started</div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Receipt Modal (for thumbnails) -->
<div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="glass-effect rounded-2xl max-w-4xl max-h-[90vh] overflow-hidden w-full shadow-2xl">
        <div class="flex justify-between items-center p-3 sm:p-4 border-b border-gray-200 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
            <h3 id="receiptTitle" class="text-base sm:text-xl font-bold truncate pr-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Receipt Preview
            </h3>
            <button onclick="closeReceiptModal()" class="text-white hover:text-gray-200 text-3xl font-bold leading-none transition-colors">
                ×
            </button>
        </div>
        <div class="p-3 sm:p-6 overflow-auto max-h-[70vh] bg-gray-100 flex items-center justify-center">
            <div class="max-w-full max-h-full">
                <img id="receiptImage" src="" alt="Receipt Preview"
                     class="max-w-full max-h-full object-contain rounded-xl shadow-2xl bg-white"
                     onload="imageLoaded()" onerror="imageError()">
                <div id="loadingSpinner" class="flex flex-col items-center justify-center p-8 gap-3">
                    <div class="animate-spin rounded-full h-12 w-12 border-4 border-indigo-500 border-t-transparent"></div>
                    <span class="text-gray-600 text-sm sm:text-base font-medium">Loading image...</span>
                </div>
                <div id="errorMessage" class="hidden flex flex-col items-center justify-center p-8 text-center">
                    <div class="text-4xl sm:text-6xl mb-4">📄</div>
                    <p class="text-gray-700 text-base sm:text-lg font-semibold">Unable to display receipt</p>
                    <p class="text-gray-500 text-xs sm:text-sm mt-2">Click "Full View" to open in a new tab</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let currentReceiptUrl = '';
let currentExpenditureId = '';

function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the expenditure and its receipt.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-xl shadow-2xl',
            confirmButton: 'rounded-lg',
            cancelButton: 'rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function viewReceiptModal(imageUrl, title, expenditureId) {
    currentReceiptUrl = imageUrl;
    currentExpenditureId = expenditureId;

    // Reset modal state
    document.getElementById('receiptImage').style.display = 'block';
    document.getElementById('loadingSpinner').style.display = 'flex';
    document.getElementById('errorMessage').classList.add('hidden');

    // Set image source and title
    document.getElementById('receiptImage').src = imageUrl;
    document.getElementById('receiptTitle').textContent = 'Receipt - ' + title;

    // Show modal
    document.getElementById('receiptModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function imageLoaded() {
    document.getElementById('loadingSpinner').style.display = 'none';
    document.getElementById('receiptImage').style.display = 'block';
    document.getElementById('errorMessage').classList.add('hidden');
}

function imageError() {
    document.getElementById('loadingSpinner').style.display = 'none';
    document.getElementById('receiptImage').style.display = 'none';
    document.getElementById('errorMessage').classList.remove('hidden');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('receiptImage').src = '';
}

function openFullReceipt() {
    if (currentExpenditureId) {
        window.open('{{ url("/admin/expenditures") }}/' + currentExpenditureId + '/view-receipt', '_blank');
    }
}
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        customClass: {
            popup: 'rounded-xl shadow-2xl'
        }
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        customClass: {
            popup: 'rounded-xl shadow-2xl'
        }
    });
</script>
@endif

@endsection