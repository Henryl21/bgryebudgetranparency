@extends('layouts.admin')

@section('content')
<div class="p-4 md:p-6 lg:p-8">
    <!-- Page Header -->
    <div class="mb-6 md:mb-8 flex flex-wrap justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-users text-purple-600"></i> Registered Users & Officers
            </h1>
            <p class="text-sm md:text-base text-gray-600 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-purple-500"></i>
                <strong>{{ ucfirst($barangayRole) }}</strong> Barangay
            </p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <form method="GET" action="{{ route('admin.users_officers.index') }}" class="flex flex-col md:flex-row gap-3 md:gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" placeholder="Search by name or email..."
                       value="{{ request('search') }}"
                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm md:text-base transition-all">
            </div>
            <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg flex items-center gap-2 text-sm md:text-base">
                <i class="fas fa-search"></i> <span>Search</span>
            </button>
            @if(request('search'))
            <a href="{{ route('admin.users_officers.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 flex items-center gap-2 text-sm md:text-base">
                <i class="fas fa-times"></i> <span>Clear</span>
            </a>
            @endif
        </form>
    </div>

    @if($accounts->count() > 0)
    @php
        // Determine latest time_in and time_out
        $latestTimeIn = $accounts->filter(fn($u) => $u->time_in)->sortByDesc('time_in')->first()?->time_in;
        $latestTimeOut = $accounts->filter(fn($u) => $u->time_out)->sortByDesc('time_out')->first()?->time_out;
    @endphp

    <!-- Combined Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Full Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Barangay</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Time In</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Time Out</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Registered</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Type</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($accounts as $user)
                <tr class="hover:bg-purple-50 transition-all">
                    <td class="px-4 py-3">{{ $user->full_name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">{{ $user->barangay }}</td>

                    {{-- Highlight latest Time In --}}
                    <td class="px-4 py-3 text-gray-600 text-sm @if($user->time_in == $latestTimeIn) bg-green-100 font-semibold @endif">
                        {{ $user->time_in ? \Carbon\Carbon::parse($user->time_in)->format('M d, Y h:i A') : '-' }}
                    </td>

                    {{-- Highlight latest Time Out --}}
                    <td class="px-4 py-3 text-gray-600 text-sm @if($user->time_out == $latestTimeOut) bg-yellow-100 font-semibold @endif">
                        {{ $user->time_out ? \Carbon\Carbon::parse($user->time_out)->format('M d, Y h:i A') : '-' }}
                    </td>

                    <td class="px-4 py-3 text-gray-600 text-sm">
                        {{ \Carbon\Carbon::parse($user->registered)->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $user->type }}</td>

                    {{-- Action button --}}
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.users_officers.show', $user->email) }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Auto-refresh script -->
    <script>
        setTimeout(() => {
            location.reload();
        }, 30000); // Refresh every 30 seconds
    </script>

    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-lg p-8 md:p-16 text-center">
        <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-users text-4xl md:text-5xl text-gray-400"></i>
        </div>
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">No Users or Officers Found</h3>
        <p class="text-gray-600 mb-6 text-sm md:text-base">
            @if(request('search'))
                No results match your search criteria.
            @else
                No registered users or officers found for this barangay yet.
            @endif
        </p>
        @if(request('search'))
        <a href="{{ route('admin.users_officers.index') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-purple-700">
            <i class="fas fa-arrow-left"></i> View All
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
