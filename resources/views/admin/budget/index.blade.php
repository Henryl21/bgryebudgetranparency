@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-green-50 py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Animated Header Section -->
        <div class="mb-6 sm:mb-8 animate-fadeIn">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-green-400 to-emerald-400 rounded-xl blur opacity-60 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                            Income Records
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-600 mt-0.5">Track and manage your income sources</p>
                    </div>
                </div>

                <a href="{{ route('admin.budget.create') }}"
                   class="group relative overflow-hidden inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold text-sm sm:text-base rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:ring-4 focus:ring-emerald-300 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 whitespace-nowrap">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="relative z-10">ADD INCOME</span>
                </a>
            </div>
        </div>

        <!-- Enhanced Stats Cards with Animation -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="group animate-slideUp" style="animation-delay: 0.1s">
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-blue-100 p-5 sm:p-6 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                    <div class="relative flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 sm:p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Records</p>
                            @php
                                $incomeRecords = $budgets->filter(function($budget) {
                                    return $budget->type === 'income' || !isset($budget->type);
                                });
                            @endphp
                            <p class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">
                                {{ $incomeRecords->count() }}
                            </p>
                            <div class="mt-2 flex items-center text-xs text-blue-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">Income entries</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group animate-slideUp" style="animation-delay: 0.2s">
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-green-100 p-5 sm:p-6 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                    <div class="relative flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="p-3 sm:p-4 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Amount</p>
                            <p class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                ₱{{ number_format($incomeRecords->sum('amount'), 2) }}
                            </p>
                            <div class="mt-2 flex items-center text-xs text-green-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">Total income collected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-6 p-4 sm:p-6 animate-slideUp" style="animation-delay: 0.3s">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-base sm:text-lg font-bold text-gray-900">Search & Filter</h3>
            </div>
            <form method="GET" action="{{ route('admin.budget.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:gap-3 sm:items-end">
                <div class="flex-1">
                    <label for="search" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Search Income Records</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Search by income title..."
                               class="w-full pl-10 pr-4 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all hover:border-gray-300">
                    </div>
                </div>

                <input type="hidden" name="type" value="income">

                <div class="flex gap-2 sm:gap-3">
                    <button type="submit"
                            class="flex-1 sm:flex-none px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold text-sm rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all inline-flex items-center justify-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search
                    </button>
                    <a href="{{ route('admin.budget.index') }}?type=income"
                       class="flex-1 sm:flex-none px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Enhanced Table Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden animate-slideUp" style="animation-delay: 0.4s">
            <!-- Table Header with Gradient -->
            <div class="relative bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-4 sm:px-6 py-4 sm:py-5">
                <div class="absolute inset-0 bg-white opacity-10"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Income Records Overview</h2>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                        <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                        <span class="text-xs font-medium text-white">{{ $incomeRecords->count() }} Records</span>
                    </div>
                </div>
            </div>

            @php
                $visibleBudgets = $budgets->filter(function($budget) {
                    return $budget->type === 'income' || !isset($budget->type) || $budget->type !== 'expense';
                });
            @endphp

            @if($visibleBudgets->count() > 0)
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1 h-4 bg-green-500 rounded"></span>
                                        ID
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Income Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date Added</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($visibleBudgets as $index => $budget)
                                <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200 group" style="animation: slideIn 0.3s ease-out {{ $index * 0.05 }}s backwards">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-900">#{{ $budget->id }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $budget->title }}</div>
                                                @if($budget->description)
                                                    <div class="text-xs text-gray-500 mt-0.5">{{ Str::limit($budget->description, 50) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-green-600">₱{{ number_format($budget->amount, 2) }}</span>
                                            <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Income</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $budget->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $budget->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.budget.edit', $budget->id) }}"
                                               class="group/btn relative inline-flex items-center px-3 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-semibold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                EDIT
                                            </a>
                                            <form action="{{ route('admin.budget.destroy', $budget->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this income record? This action cannot be undone.')"
                                                        class="group/btn relative inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-lg hover:from-red-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    DELETE
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile & Tablet Cards -->
                <div class="lg:hidden">
                    <div class="p-3 sm:p-4 space-y-3 sm:space-y-4">
                        @foreach($visibleBudgets as $index => $budget)
                            <div class="relative overflow-hidden bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 rounded-xl p-4 border-2 border-green-200 hover:border-green-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" style="animation: slideIn 0.3s ease-out {{ $index * 0.1 }}s backwards">
                                <!-- Decorative Corner -->
                                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-200 to-emerald-200 rounded-full -mr-10 -mt-10 opacity-30"></div>
                                
                                <div class="relative">
                                    <div class="flex items-start justify-between mb-3 gap-2">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                {{ $budget->title }}
                                            </h3>
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Income
                                            </span>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500 bg-white px-2 py-1 rounded-lg shadow-sm">#{{ $budget->id }}</span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 mb-3 py-3 border-y border-green-200">
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <p class="text-xs text-gray-500 mb-1 font-medium">Amount</p>
                                            <p class="text-base sm:text-lg font-bold text-green-600">₱{{ number_format($budget->amount, 2) }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <p class="text-xs text-gray-500 mb-1 font-medium">Date Added</p>
                                            <p class="text-xs sm:text-sm text-gray-900 font-semibold">{{ $budget->created_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $budget->created_at->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    @if($budget->description)
                                        <div class="mb-3 pb-3 border-b border-green-200 bg-white rounded-lg p-3 shadow-sm">
                                            <p class="text-xs text-gray-500 mb-1 font-semibold">Description</p>
                                            <p class="text-xs text-gray-700 leading-relaxed">{{ Str::limit($budget->description, 100) }}</p>
                                        </div>
                                    @endif

                                    <div class="flex gap-2 pt-2">
                                        <a href="{{ route('admin.budget.edit', $budget->id) }}"
                                           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-bold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.budget.destroy', $budget->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this income record? This action cannot be undone.')"
                                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-lg hover:from-red-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Enhanced Pagination -->
                @if(method_exists($budgets, 'hasPages') && $budgets->hasPages())
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between flex-col sm:flex-row gap-4">
                        <!-- Mobile Pagination -->
                        <div class="flex-1 flex justify-between sm:hidden w-full gap-2">
                            @if ($budgets->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-400 bg-white border-2 border-gray-200 cursor-default rounded-xl">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Previous
                                </span>
                            @else
                                <a href="{{ $budgets->appends(['type' => 'income'])->previousPageUrl() }}" 
                                   class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-green-400 transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Previous
                                </a>
                            @endif

                            @if ($budgets->hasMorePages())
                                <a href="{{ $budgets->appends(['type' => 'income'])->nextPageUrl() }}" 
                                   class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-green-400 transition-all shadow-sm hover:shadow-md">
                                    Next
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-400 bg-white border-2 border-gray-200 cursor-default rounded-xl">
                                    Next
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            @endif
                        </div>

                        <!-- Desktop Pagination -->
                        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-bold text-green-600">{{ $budgets->firstItem() }}</span>
                                    to
                                    <span class="font-bold text-green-600">{{ $budgets->lastItem() }}</span>
                                    of
                                    <span class="font-bold text-green-600">{{ $visibleBudgets->count() }}</span>
                                    income records
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-xl shadow-sm -space-x-px" aria-label="Pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($budgets->onFirstPage())
                                        <span class="relative inline-flex items-center px-3 py-2 rounded-l-xl border-2 border-gray-200 bg-white text-sm font-semibold text-gray-400 cursor-default">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $budgets->appends(['type' => 'income'])->previousPageUrl() }}" 
                                           class="relative inline-flex items-center px-3 py-2 rounded-l-xl border-2 border-gray-300 bg-white text-sm font-semibold text-gray-700 hover:bg-green-50 hover:border-green-400 transition-all">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($budgets->appends(['type' => 'income'])->getUrlRange(1, $budgets->lastPage()) as $page => $url)
                                        @if ($page == $budgets->currentPage())
                                            <span class="relative inline-flex items-center px-4 py-2 border-2 border-green-500 bg-gradient-to-r from-green-500 to-emerald-500 text-sm font-bold text-white shadow-md">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" 
                                               class="relative inline-flex items-center px-4 py-2 border-2 border-gray-300 bg-white text-sm font-semibold text-gray-700 hover:bg-green-50 hover:border-green-400 transition-all">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($budgets->hasMorePages())
                                        <a href="{{ $budgets->appends(['type' => 'income'])->nextPageUrl() }}" 
                                           class="relative inline-flex items-center px-3 py-2 rounded-r-xl border-2 border-gray-300 bg-white text-sm font-semibold text-gray-700 hover:bg-green-50 hover:border-green-400 transition-all">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-3 py-2 rounded-r-xl border-2 border-gray-200 bg-white text-sm font-semibold text-gray-400 cursor-default">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-16 sm:py-20 px-4">
                    <div class="relative inline-block mb-6">
                        <div class="absolute -inset-4 bg-gradient-to-r from-green-200 to-emerald-200 rounded-full blur-xl opacity-30 animate-pulse"></div>
                        <div class="relative p-6 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">
                        @if(request()->has('search'))
                            No Results Found
                        @else
                            No Income Records Yet
                        @endif
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                        @if(request()->has('search'))
                            We couldn't find any income records matching "<span class="font-semibold text-green-600">{{ request('search') }}</span>". Try adjusting your search terms.
                        @else
                            Start tracking your income by creating your first income record. Keep your finances organized and transparent.
                        @endif
                    </p>
                    @if(!request()->has('search'))
                        <a href="{{ route('admin.budget.create') }}"
                           class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold text-sm sm:text-base rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Your First Income
                        </a>
                    @else
                        <a href="{{ route('admin.budget.index') }}?type=income"
                           class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gray-600 text-white font-bold text-sm sm:text-base rounded-xl hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear Search
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Hidden expenses section -->
        <div style="display: none;">
            @php
                $expenses = $budgets->filter(function($budget) {
                    return $budget->type === 'expense';
                });
            @endphp

            @foreach($expenses as $expense)
                <span data-expense-id="{{ $expense->id }}"
                      data-expense-amount="{{ $expense->amount }}"
                      data-expense-title="{{ $expense->title }}"></span>
            @endforeach
        </div>
    </div>
</div>

<style>
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

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.6s ease-out forwards;
    opacity: 0;
}
</style>
@endsection