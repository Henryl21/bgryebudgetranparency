@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="bg-white shadow-md rounded-xl p-6 mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-700">Officer Dashboard</h1>
                    <p class="text-gray-500">
                        Welcome, {{ Auth::guard('officer')->user()->name }}
                    </p>
                </div>

                <!-- Logout Button -->
                <form action="{{ route('officer.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'expenditure' }" class="bg-white shadow-md rounded-xl p-6">
                <div class="flex space-x-4 border-b mb-6">
                    <button @click="tab = 'expenditure'"
                        :class="tab === 'expenditure' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500'"
                        class="p-4 font-semibold transition">
                        Expenditure Request
                    </button>
                    <button @click="tab = 'budget'"
                        :class="tab === 'budget' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500'"
                        class="pb-2 font-semibold transition">
                        Budget Request
                    </button>
                </div>

                <!-- Expenditure Request Tab -->
                <div x-show="tab === 'expenditure'" x-cloak>
                    <h2 class="text-xl font-semibold mb-4">Send Expenditure Request</h2>

                    <form action="{{ route('admin.expenditure.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="expense">

                        <div>
                            <label class="block text-gray-700 font-medium">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Category</label>
                            <select name="category"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                <option value="">Select Category</option>
                                <option value="Infrastructure" {{ old('category') == 'Infrastructure' ? 'selected' : '' }}>
                                    Infrastructure</option>
                                <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education
                                </option>
                                <option value="Healthcare" {{ old('category') == 'Healthcare' ? 'selected' : '' }}>
                                    Healthcare</option>
                                <option value="Public Safety" {{ old('category') == 'Public Safety' ? 'selected' : '' }}>
                                    Public Safety</option>
                                <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities
                                </option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300" required>
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Receipt (optional)</label>
                            <input type="file" name="receipt"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                            @error('receipt')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Resolution Document (Word/PDF)</label>
                            <input type="file" name="resolution" accept=".doc,.docx,.pdf"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                            @error('resolution')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                            Submit for Approval
                        </button>
                    </form>

                    <!-- Expenditure Requests List -->
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold mb-4">My Expenditure Requests</h2>
                        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Title</th>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Resolution</th>
                                    <th class="px-4 py-2">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenditures as $exp)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $exp->title }}</td>
                                        <td class="px-4 py-2">₱{{ number_format($exp->amount, 2) }}</td>
                                        <td class="px-4 py-2">
                                            @if ($exp->status === 'approved')
                                                <span class="text-green-600 font-semibold">Approved</span>
                                            @elseif($exp->status === 'declined')
                                                <span class="text-red-600 font-semibold">Declined</span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($exp->resolution)
                                                <a href="{{ Storage::url($exp->resolution) }}" target="_blank"
                                                    class="text-blue-600 underline">View</a>
                                            @else
                                                <span class="text-gray-400">None</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ $exp->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">No requests yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Budget Request Tab -->
                <div x-show="tab === 'budget'" x-cloak>
                    <h2 class="text-xl font-semibold mb-4">Send Budget Request</h2>

                    <form action="{{ route('officer.expenditures.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="budget">

                        <div>
                            <label class="block text-gray-700 font-medium">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300"
                                required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Category</label>
                            <select name="category"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                <option value="">Select Category</option>
                                <option value="Infrastructure"
                                    {{ old('category') == 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                                <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education
                                </option>
                                <option value="Healthcare" {{ old('category') == 'Healthcare' ? 'selected' : '' }}>
                                    Healthcare</option>
                                <option value="Public Safety" {{ old('category') == 'Public Safety' ? 'selected' : '' }}>
                                    Public Safety</option>
                                <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities
                                </option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Requested Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300"
                                required>
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium">Resolution (Word/PDF)</label>
                            <input type="file" name="resolution" accept=".doc,.docx,.pdf"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                            @error('resolution')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                            Submit Budget Request
                        </button>
                    </form>

                    <!-- Budget Requests List -->
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold mb-4">My Budget Requests</h2>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-2">Name</th>
                                    <th class="border px-4 py-2">Title</th>
                                    <th class="border px-4 py-2">Description</th>
                                    <th class="border px-4 py-2">Amount</th>
                                    <th class="border px-4 py-2">Resoluton</th>
                                    <th class="border px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenditures as $exp)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $exp->officer->name }}</td>
                                        <td class="px-4 py-2">{{ $exp->title }}</td>
                                        <td class="px-4 py-2">{{ $exp->description }}</td>
                                        <td class="px-4 py-2">₱{{ number_format($exp->amount, 2) }}</td>
                                        <td class="px-4 py-2">
                                            @if ($exp->resolution)
                                                <a href="{{ Storage::url($exp->resolution) }}" target="_blank"
                                                    class="text-blue-600 underline">View</a>
                                            @else
                                                <span class="text-gray-400">None</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($exp->status === 'approved')
                                                <span class="text-green-600 font-semibold">Approved</span>
                                            @elseif($exp->status === 'declined')
                                                <span class="text-red-600 font-semibold">Declined - {{ $exp->decline_reason }}</span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">Pending</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">No requests yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js for tabs -->
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
