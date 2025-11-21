@extends('layouts.app')

@section('header')
    <h2 class="text-2xl font-bold leading-tight text-gray-800">
        Officer Dashboard
    </h2>
@endsection

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-8 border border-blue-200">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Welcome, {{ Auth::guard('officer')->user()->name }} 👋
                    </h1>
                    <p class="text-gray-600 mt-1">Manage your budget requests below.</p>
                </div>

                <!-- Logout -->
                <form action="{{ route('officer.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-red-700 text-white px-5 py-2 rounded-xl shadow-md hover:scale-105 transition">
                        🔒 Logout
                    </button>
                </form>
            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'budget' }" class="bg-white rounded-xl shadow-inner p-6">
                <div class="flex space-x-6 border-b pb-2 mb-6">
                    <button @click="tab = 'budget'"
                        :class="tab === 'budget' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500'"
                        class="pb-2 font-semibold text-lg transition">
                        💰 Budget Request
                    </button>
                    <button @click="tab = 'history'"
                        :class="tab === 'history' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500'"
                        class="pb-2 font-semibold text-lg transition">
                        📄 Request History
                    </button>
                </div>

                <!-- Budget Request Form -->
                <div x-show="tab === 'budget'" x-transition.opacity.duration.500ms>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Create New Budget Request</h2>

                    <form id="budgetForm" action="{{ route('officer.expenditures.store') }}" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        <input type="hidden" name="type" value="budget">

                        <!-- Category -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Category</label>
                            <select name="category"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300">
                                <option value="">Select Category</option>
                                <option value="Infrastructure">Infrastructure</option>
                                <option value="Education">Education</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Public Safety">Public Safety</option>
                                <option value="Utilities">Utilities</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Title -->
                       <div>
    <label class="block text-gray-700 font-medium mb-1">Details</label>

    <textarea name="title" id="title" rows="3"
        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 resize-y overflow-hidden"
        required></textarea>
</div>


                        <!-- Amount -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Requested Amount</label>
                            <input type="number" step="0.01" name="amount"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300" required>
                        </div>

                        <!-- Resolution Upload -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Resolution (Word/PDF)</label>
                            <input type="file" name="resolution" accept=".doc,.docx,.pdf"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300">
                        </div>

                        <!-- Receipt Upload -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Receipt (Optional)</label>
                            <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300">
                            <p class="text-sm text-gray-500">Accepted: JPG, PNG, PDF, DOC, DOCX</p>
                        </div>

                        <!-- Submit -->
                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow hover:scale-105 transition">
                                🚀 Submit Request
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Request History -->
                <div x-show="tab === 'history'" x-transition.opacity.duration.500ms>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">My Budget Requests</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 bg-white rounded-xl shadow-md">
                            <thead class="bg-blue-50 text-blue-800">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Details</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Amount</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Resolution</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Receipt</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($expenditures as $exp)
                                   <td class="px-4 py-3 align-top">
    <textarea 
        class="w-full border border-gray-300 rounded-lg p-2 resize-y overflow-hidden focus:ring-2 focus:ring-blue-300"
        oninput="autoResize(this)"
    >{{ $exp->title }}</textarea>
</td>


                                        <td class="px-4 py-3 font-semibold text-gray-800">
                                            ₱{{ number_format($exp->amount, 2) }}
                                        </td>

                                        <!-- Resolution -->
                                        <td class="px-4 py-3">
                                            @if ($exp->resolution)
                                                <a href="{{ Storage::url($exp->resolution) }}" target="_blank"
                                                    class="text-blue-600 font-medium hover:underline">View</a>
                                            @else
                                                <span class="text-gray-400">None</span>
                                            @endif
                                        </td>

                                        <!-- Receipt -->
                                        <td class="px-4 py-3">
                                            @if ($exp->receipt)
                                                <a href="{{ Storage::url($exp->receipt) }}" target="_blank"
                                                    class="text-blue-600 font-medium hover:underline">View</a>
                                            @else
                                                <span class="text-gray-400">None</span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="px-4 py-3">
                                            @if ($exp->status === 'approved')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                                            @elseif($exp->status === 'declined')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Declined</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">Pending</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-4 py-3 flex space-x-2">

                                            <a href="{{ route('officer.expenditures.edit', $exp->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow">
                                                ✏️ Edit
                                            </a>

                                            <form action="{{ route('officer.expenditures.destroy', $exp->id) }}" method="POST"
                                                class="delete-form inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="delete-btn bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">No requests yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // SweetAlert delete confirm
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This request will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
                function autoResize(textarea) {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
}

            });
        });
    });

});
</script>
@endsection
