@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8 rounded-t-2xl shadow-2xl relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        Budget Request Management
                    </h2>
                    <p class="text-indigo-100 text-sm mt-2 ml-1">Review and process officer budget requests efficiently</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white bg-opacity-20 backdrop-blur-md px-5 py-3 rounded-xl border border-white border-opacity-30">
                        <p class="text-white text-xs font-medium uppercase tracking-wide">Total Requests</p>
                        <p class="text-white text-2xl font-bold mt-1">{{ count($budget_request) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-b-2xl shadow-2xl overflow-hidden border-t-4 border-indigo-500">
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-indigo-200">
                            <th class="px-6 py-5 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Officer</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Details</th>
                           
                            <th class="px-6 py-5 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Resolution</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($budget_request as $budget)
                            <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            {{ strtoupper(substr($budget->officer->name, 0, 2)) }}
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900">{{ $budget->officer->name }}</p>
                                            <p class="text-xs text-indigo-600 font-medium">Officer</p>
                                        </div>
                                    </div>
                                </td>
                              <td class="px-6 py-5 align-top">
    <textarea
        class="w-full border border-gray-300 rounded-lg p-2 text-sm font-semibold text-gray-900 
               resize-y overflow-hidden focus:ring-2 focus:ring-indigo-400"
        oninput="autoResize(this)"
    >{{ $budget->title }}</textarea>
</td>

                              
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="bg-gradient-to-r from-emerald-100 to-teal-100 px-4 py-2 rounded-lg inline-block">
                                        <span class="text-sm font-bold text-emerald-800">₱{{ number_format($budget->amount, 2) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($budget->resolution)
                                        <a href="{{ Storage::url($budget->resolution) }}" target="_blank" 
                                           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm italic">No file</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($budget->status === 'approved')
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-lg">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Approved
                                        </span>
                                    @elseif($budget->status === 'declined')
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-red-400 to-pink-500 text-white shadow-lg">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Declined
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg animate-pulse">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button"
                                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 disabled:hover:translate-y-0 disabled:hover:shadow-lg"
                                            onclick="declineBudget({{ $budget->id }})"
                                            @if(strtolower($budget->status) == 'approved' || strtolower($budget->status) == 'declined') disabled @endif>
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Decline
                                        </button>
                                        <button type="button"
                                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 disabled:hover:translate-y-0 disabled:hover:shadow-lg"
                                            onclick="approveBudget({{ $budget->id }})"
                                            @if(strtolower($budget->status) == 'approved' || strtolower($budget->status) == 'declined') disabled @endif>
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Approve
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gradient-to-br from-indigo-100 to-purple-100 p-6 rounded-full mb-6">
                                            <svg class="w-20 h-20 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-700 font-bold text-lg">No budget requests yet</p>
                                        <p class="text-gray-400 text-sm mt-2">New requests will appear here for your review</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden divide-y divide-gray-100">
                @forelse($budget_request as $budget)
                    <div class="p-5 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300">
                        <!-- Officer Info -->
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-14 w-14 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ strtoupper(substr($budget->officer->name, 0, 2)) }}
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-bold text-gray-900">{{ $budget->officer->name }}</p>
                                <p class="text-xs text-indigo-600 font-medium">Officer</p>
                            </div>
                            @if($budget->status === 'approved')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-md">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Approved
                                </span>
                            @elseif($budget->status === 'declined')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-red-400 to-pink-500 text-white shadow-md">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Declined
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-md animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </div>

                        <!-- Request Details -->
                        <div class="space-y-3 mb-5">
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-xl border-l-4 border-indigo-500">
                                <p class="text-xs text-indigo-700 uppercase tracking-wide font-bold mb-1">Detai;s</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $budget->title }}</p>
                            </div>
                            
                            <div class="flex gap-3">
                                <div class="flex-1 bg-gradient-to-br from-emerald-100 to-teal-100 p-4 rounded-xl border-2 border-emerald-300">
                                    <p class="text-xs text-emerald-700 uppercase tracking-wide font-bold mb-1">Amount</p>
                                    <p class="text-xl font-bold text-emerald-800">₱{{ number_format($budget->amount, 2) }}</p>
                                </div>
                                <div class="flex-1 bg-gradient-to-br from-blue-100 to-cyan-100 p-4 rounded-xl border-2 border-blue-300">
                                    <p class="text-xs text-blue-700 uppercase tracking-wide font-bold mb-1">Resolution</p>
                                    @if($budget->resolution)
                                        <a href="{{ Storage::url($budget->resolution) }}" target="_blank" 
                                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-bold text-sm mt-1 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    @else
                                        <p class="text-gray-400 text-sm mt-1 italic">No file</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button type="button"
                                class="flex-1 inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"
                                onclick="declineBudget({{ $budget->id }})"
                                @if(strtolower($budget->status) == 'approved' || strtolower($budget->status) == 'declined') disabled @endif>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Decline
                            </button>
                            <button type="button"
                                class="flex-1 inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"
                                onclick="approveBudget({{ $budget->id }})"
                                @if(strtolower($budget->status) == 'approved' || strtolower($budget->status) == 'declined') disabled @endif>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Approve
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-gradient-to-br from-indigo-100 to-purple-100 p-6 rounded-full mb-6">
                                <svg class="w-20 h-20 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 6 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-bold text-lg">No budget requests yet</p>
                            <p class="text-gray-400 text-sm mt-2">New requests will appear here for your review</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}
</style>
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session("success") }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Cannot Approve',
            text: '{{ session("error") }}',
            timer: 4000,
            showConfirmButton: true
        });
    @endif
</script>

<script>
    function declineBudget(id) {
        Swal.fire({
            title: '<span style="background: linear-gradient(135deg, #ef4444 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Decline Budget Request</span>',
            input: 'textarea',
            inputLabel: 'Reason for declining',
            inputPlaceholder: 'Please provide a detailed reason...',
            inputAttributes: {
                'aria-label': 'Reason for declining',
                'rows': 4,
                'style': 'border: 2px solid #e5e7eb; border-radius: 0.75rem; padding: 1rem;'
            },
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-times mr-2"></i>Decline Request',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'shadow-lg hover:shadow-xl transition-all rounded-xl font-bold px-6 py-3',
                cancelButton: 'shadow-lg hover:shadow-xl transition-all rounded-xl font-bold px-6 py-3'
            },
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('Please provide a reason for declining');
                    return false;
                }
                if (reason.length < 10) {
                    Swal.showValidationMessage('Reason must be at least 10 characters');
                    return false;
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/admin/officers/${id}/budget-decline`;
                form.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
function autoResize(textarea) {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
}

                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = result.value;
                form.appendChild(reasonInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function approveBudget(id) {
        Swal.fire({
            title: '<span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Approve Budget Request?</span>',
            html: '<p class="text-gray-600">Are you sure you want to approve this budget request?</p><p class="text-sm text-gray-400 mt-2">This action cannot be undone.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Yes, Approve',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'shadow-lg hover:shadow-xl transition-all rounded-xl font-bold px-6 py-3',
                cancelButton: 'shadow-lg hover:shadow-xl transition-all rounded-xl font-bold px-6 py-3'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/admin/officers/${id}/budget-approve`;
                form.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection