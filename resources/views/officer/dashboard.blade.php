@extends('layouts.app')

@section('header')
    <h2 class="text-2xl font-bold leading-tight text-gray-800">
        Officer Dashboard
    </h2>
@endsection

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-8 border border-blue-200 transition transform hover:shadow-2xl duration-300">
            
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
                        class="bg-gradient-to-r from-red-500 to-red-700 text-white px-5 py-2 rounded-xl shadow-md hover:scale-105 transform transition duration-300">
                        🔒 Logout
                    </button>
                </form>
            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'budget' }" class="bg-white rounded-xl shadow-inner p-6">
                <div class="flex space-x-6 border-b pb-2 mb-6">
                    <button @click="tab = 'budget'"
                        :class="tab === 'budget' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-800'"
                        class="pb-2 font-semibold text-lg transition-all duration-300">
                        💰 Budget Request
                    </button>
                    <button @click="tab = 'history'"
                        :class="tab === 'history' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-800'"
                        class="pb-2 font-semibold text-lg transition-all duration-300">
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

                        <!-- Title -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition" 
                                pattern="[A-Za-z\s]+" title="Letters only" required>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Category</label>
                            <select name="category"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition">
                                <option value="">Select Category</option>
                                <option value="Infrastructure">Infrastructure</option>
                                <option value="Education">Education</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Public Safety">Public Safety</option>
                                <option value="Utilities">Utilities</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-1">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition" 
                                pattern="[A-Za-z\s]+" title="Letters only" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Requested Amount -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Requested Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition" required>
                        </div>

                        <!-- Resolution File -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Resolution (Word/PDF)</label>
                            <input type="file" name="resolution" accept=".doc,.docx,.pdf"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition">
                        </div>

                        <!-- Submit -->
                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow hover:scale-105 transform transition duration-300">
                                🚀 Submit Request
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Request History -->
                <div x-show="tab === 'history'" x-transition.opacity.duration.500ms>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">My Budget Requests</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 bg-white rounded-xl shadow-md overflow-hidden">
                            <thead class="bg-blue-50 text-blue-800">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Description</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Amount</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Resolution</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($expenditures as $exp)
                                    <tr class="hover:bg-blue-50 transition duration-200">
                                        <td class="px-4 py-3">{{ $exp->title }}</td>
                                        <td class="px-4 py-3">{{ $exp->description }}</td>
                                        <td class="px-4 py-3 font-semibold text-gray-800">₱{{ number_format($exp->amount, 2) }}</td>
                                        <td class="px-4 py-3">
                                            @if ($exp->resolution)
                                                <a href="{{ Storage::url($exp->resolution) }}" target="_blank"
                                                    class="text-blue-600 font-medium hover:underline">View</a>
                                            @else
                                                <span class="text-gray-400">None</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($exp->status === 'approved')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                                            @elseif($exp->status === 'declined')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Declined</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 flex space-x-2">
                                            <a href="{{ route('officer.expenditures.edit', $exp->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow transition duration-300">
                                                ✏️ Edit
                                            </a>

                                            <form action="{{ route('officer.expenditures.destroy', $exp->id) }}" method="POST" class="delete-form inline">
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
    // SweetAlert delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This request will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Restrict Title and Description to letters only
    const title = document.getElementById('title');
    const description = document.getElementById('description');

    [title, description].forEach(field => {
        field.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z\s]/g, '');
        });
    });
});
</script>
@endsection
