@extends('layouts.app')

@section('header')
<h2 class="text-2xl font-bold leading-tight text-gray-800">
    Edit Budget Request
</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8 mt-10">
    <form action="{{ route('officer.expenditures.update', $expenditure->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $expenditure->title) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Category</label>
            <select name="category"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition">
                <option value="Infrastructure" {{ $expenditure->category == 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                <option value="Education" {{ $expenditure->category == 'Education' ? 'selected' : '' }}>Education</option>
                <option value="Healthcare" {{ $expenditure->category == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                <option value="Public Safety" {{ $expenditure->category == 'Public Safety' ? 'selected' : '' }}>Public Safety</option>
                <option value="Utilities" {{ $expenditure->category == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                <option value="Other" {{ $expenditure->category == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition">{{ old('description', $expenditure->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Amount</label>
            <input type="number" name="amount" step="0.01" value="{{ old('amount', $expenditure->amount) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Date</label>
            <input type="date" name="date" value="{{ old('date', $expenditure->date) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Receipt (optional)</label>
            <input type="file" name="receipt"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 transition">
            @if ($expenditure->receipt_path)
                <p class="text-sm mt-2">Current: 
                    <a href="{{ Storage::url($expenditure->receipt_path) }}" target="_blank" class="text-blue-500 underline">
                        View Receipt
                    </a>
                </p>
            @endif
        </div>

        <div class="flex justify-between">
            <a href="{{ route('officer.dashboard') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg shadow">
                ← Back
            </a>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                💾 Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
