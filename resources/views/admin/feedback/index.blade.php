@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Animated Header Section -->
        <div class="mb-6 sm:mb-8 animate-fadeIn">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-purple-400 to-pink-400 rounded-xl blur opacity-60 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-lg">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            User Feedback
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-600 mt-0.5">View and manage user submissions</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="bg-white rounded-xl shadow-md px-4 py-2 border border-purple-200">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-bold text-gray-700">{{ $feedback->total() }} Total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="group animate-slideUp" style="animation-delay: 0.1s">
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-purple-100 p-5 sm:p-6 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-100 to-purple-50 rounded-full -mr-12 -mt-12 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Feedback</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $feedback->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="group animate-slideUp" style="animation-delay: 0.2s">
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-pink-100 p-5 sm:p-6 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-pink-100 to-pink-50 rounded-full -mr-12 -mt-12 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">This Page</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $feedback->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="group animate-slideUp" style="animation-delay: 0.3s">
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-indigo-100 p-5 sm:p-6 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-full -mr-12 -mt-12 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Current Page</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $feedback->currentPage() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden animate-slideUp" style="animation-delay: 0.4s">
            <!-- Table Header -->
            <div class="relative bg-gradient-to-r from-purple-600 via-pink-600 to-indigo-600 px-4 sm:px-6 py-4 sm:py-5">
                <div class="absolute inset-0 bg-white opacity-10"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Feedback Overview</h2>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                        <span class="w-2 h-2 bg-pink-300 rounded-full animate-pulse"></span>
                        <span class="text-xs font-medium text-white">{{ $feedback->count() }} Shown</span>
                    </div>
                </div>
            </div>

            @if($feedback->count() > 0)
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1 h-4 bg-purple-500 rounded"></span>
                                        User Details
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Message</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($feedback as $index => $item)
                                <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-all duration-200 group" style="animation: slideIn 0.3s ease-out {{ $index * 0.05 }}s backwards">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-110 transition-transform">
                                                    {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                @if ($item->user)
                                                    <div class="text-sm font-bold text-gray-900">{{ $item->user->name }}</div>
                                                    <div class="text-xs text-gray-500 truncate">{{ $item->user->email }}</div>
                                                @else
                                                    <div class="text-sm font-medium text-gray-400 italic">Anonymous User</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ Str::limit($item->message, 100) }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-sm">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $item->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->created_at->format('h:i A') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-lg hover:from-red-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                DELETE
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile & Tablet Cards -->
                <div class="lg:hidden">
                    <div class="p-3 sm:p-4 space-y-3 sm:space-y-4">
                        @foreach($feedback as $index => $item)
                            <div class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 rounded-xl p-4 border-2 border-purple-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" style="animation: slideIn 0.3s ease-out {{ $index * 0.1 }}s backwards">
                                <!-- Decorative Corner -->
                                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-200 to-pink-200 rounded-full -mr-10 -mt-10 opacity-30"></div>
                                
                                <div class="relative">
                                    <!-- User Info -->
                                    <div class="flex items-center gap-3 mb-4 pb-4 border-b-2 border-purple-200">
                                        <div class="flex-shrink-0">
                                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                                {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            @if ($item->user)
                                                <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item->user->name }}</h3>
                                                <p class="text-xs text-gray-500 truncate">{{ $item->user->email }}</p>
                                            @else
                                                <h3 class="text-sm font-medium text-gray-400 italic">Anonymous User</h3>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Message -->
                                    <div class="mb-4 bg-white rounded-lg p-3 shadow-sm">
                                        <div class="flex items-start gap-2 mb-2">
                                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                            <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide">Feedback Message</p>
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed">{{ $item->message }}</p>
                                    </div>

                                    <!-- Date & Actions -->
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-2 shadow-sm">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div class="text-xs">
                                                <div class="font-bold text-gray-900">{{ $item->created_at->format('M d, Y') }}</div>
                                                <div class="text-gray-500">{{ $item->created_at->format('h:i A') }}</div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-lg hover:from-red-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
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
                @if($feedback->hasPages())
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between flex-col sm:flex-row gap-4">
                        <!-- Mobile Pagination -->
                        <div class="flex-1 flex justify-between sm:hidden w-full gap-2">
                            @if ($feedback->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-400 bg-white border-2 border-gray-200 cursor-default rounded-xl">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Previous
                                </span>
                            @else
                                <a href="{{ $feedback->previousPageUrl() }}" 
                                   class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-purple-400 transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Previous
                                </a>
                            @endif

                            @if ($feedback->hasMorePages())
                                <a href="{{ $feedback->nextPageUrl() }}" 
                                   class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-purple-400 transition-all shadow-sm hover:shadow-md">
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
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-bold text-purple-600">{{ $feedback->firstItem() }}</span>
                                    to
                                    <span class="font-bold text-purple-600">{{ $feedback->lastItem() }}</span>
                                    of
                                    <span class="font-bold text-purple-600">{{ $feedback->total() }}</span>
                                    feedback entries
                                </p>
                            </div>
                            <div>
                                {{ $feedback->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-16 sm:py-20 px-4">
                    <div class="relative inline-block mb-6">
                        <div class="absolute -inset-4 bg-gradient-to-r from-purple-200 to-pink-200 rounded-full blur-xl opacity-30 animate-pulse"></div>
                        <div class="relative p-6 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">No Feedback Submitted Yet</h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                        When users submit feedback, it will appear here. Encourage your users to share their thoughts and suggestions!
                    </p>
                </div>
            @endif
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