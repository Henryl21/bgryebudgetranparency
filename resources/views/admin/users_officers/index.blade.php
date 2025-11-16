@extends('layouts.admin')

@section('content')

{{-- ============================= BARANGAY LOADING ANIMATION =============================== --}}
<style>
    #pageLoader {
        position: fixed;
        inset: 0;
        background: linear-gradient(135deg, rgba(109, 40, 217, 0.95) 0%, rgba(79, 70, 229, 0.95) 100%);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity .4s ease;
    }

    .loader-container {
        text-align: center;
    }

    .loader-icon {
        font-size: 5rem;
        color: white;
        animation: barangayPulse 1.4s infinite ease-in-out;
        filter: drop-shadow(0 4px 12px rgba(255, 255, 255, 0.3));
    }

    .loader-text {
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 1rem;
        letter-spacing: 0.05em;
        animation: fadeInOut 1.4s infinite ease-in-out;
    }

    @keyframes barangayPulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.25); opacity: .5; }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes fadeInOut {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    /* Barangay-themed design elements */
    .barangay-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        border-left: 6px solid #6d28d9;
        position: relative;
        overflow: hidden;
    }

    .barangay-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(109, 40, 217, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .barangay-header {
        background: linear-gradient(135deg, #6d28d9 0%, #4f46e5 50%, #7c3aed 100%);
        position: relative;
        overflow: hidden;
    }

    .barangay-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .barangay-badge {
        background: linear-gradient(135deg, #6d28d9 0%, #4f46e5 100%);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.3);
    }

    .time-badge-latest {
        position: relative;
        animation: highlightPulse 2s infinite;
    }

    @keyframes highlightPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
    }

    .table-row-hover {
        transition: all 0.3s ease;
    }

    .table-row-hover:hover {
        transform: translateX(4px);
        box-shadow: -4px 0 0 0 #6d28d9;
    }

    .search-input-custom {
        transition: all 0.3s ease;
    }

    .search-input-custom:focus {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(109, 40, 217, 0.15);
    }

    .action-button {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-button::before {
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

    .action-button:hover::before {
        width: 300px;
        height: 300px;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border-top: 4px solid #6d28d9;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(109, 40, 217, 0.15);
    }

    .barangay-pattern {
        background-image: 
            linear-gradient(30deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff),
            linear-gradient(150deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff),
            linear-gradient(30deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff),
            linear-gradient(150deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff);
        background-size: 80px 140px;
        background-position: 0 0, 0 0, 40px 70px, 40px 70px;
    }
</style>

<div id="pageLoader">
    <div class="loader-container">
        <i class="fas fa-landmark loader-icon"></i>
        <div class="loader-text">Loading Barangay Activity Logs...</div>
    </div>
</div>

<script>
    window.addEventListener("load", () => {
        setTimeout(() => {
            const loader = document.getElementById("pageLoader");
            loader.style.opacity = "0";
            setTimeout(() => loader.remove(), 400);
        }, 400);
    });
</script>
{{-- ========================================================================================= --}}

<div class="p-4 md:p-6 lg:p-8 fade-in barangay-pattern min-h-screen">

    <!-- Page Header -->
    <div class="mb-6 md:mb-8">
        <div class="barangay-card rounded-2xl shadow-xl p-6 md:p-8">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-landmark text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 flex items-center gap-2">
                                Activity Logs Management
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">Real-time monitoring and tracking</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 items-center">
                        <span class="barangay-badge">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>{{ ucfirst($barangayRole) }}</strong> Barangay
                        </span>
                        <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-table"></i>
                            Activity Logs Table
                        </span>
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-sync-alt"></i>
                            Auto-refresh: 30s
                        </span>
                    </div>
                </div>

                @if($accounts->count() > 0)
                <div class="flex flex-col gap-2">
                    <div class="stats-card">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-800">{{ $accounts->count() }}</div>
                                <div class="text-xs text-gray-500">Total Records</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="barangay-card rounded-2xl shadow-xl p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-search text-purple-600 text-xl"></i>
            <h2 class="text-lg font-bold text-gray-800">Search & Filter</h2>
        </div>
        <form method="GET" action="{{ route('admin.users_officers.index') }}" class="flex flex-col md:flex-row gap-3 md:gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-purple-400 text-lg"></i>
                <input type="text" name="search" placeholder="Search by name or email..."
                       value="{{ request('search') }}"
                       class="search-input-custom w-full pl-12 pr-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 text-sm md:text-base transition-all">
            </div>
            <button type="submit" class="action-button bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-xl flex items-center justify-center gap-2 text-sm md:text-base relative z-10">
                <i class="fas fa-search"></i> <span>Search</span>
            </button>
            @if(request('search'))
            <a href="{{ route('admin.users_officers.index') }}" class="action-button bg-gray-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-700 hover:shadow-xl flex items-center justify-center gap-2 text-sm md:text-base relative z-10">
                <i class="fas fa-times"></i> <span>Clear</span>
            </a>
            @endif
        </form>
    </div>

    @if($accounts->count() > 0)

    @php
        $latestTimeIn = $accounts->filter(fn($u) => $u->time_in)->sortByDesc('time_in')->first()?->time_in;
        $latestTimeOut = $accounts->filter(fn($u) => $u->time_out)->sortByDesc('time_out')->first()?->time_out;
    @endphp

    <!-- Table -->
    <div class="barangay-card rounded-2xl shadow-xl overflow-hidden mb-6">
        <div class="barangay-header p-4 relative z-10">
            <div class="flex items-center gap-2 text-white">
                <i class="fas fa-list-alt text-xl"></i>
                <h2 class="text-lg font-bold">Activity Records</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-user mr-2"></i>Full Name
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-map-marked-alt mr-2"></i>Barangay
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-sign-in-alt mr-2"></i>Time In
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-sign-out-alt mr-2"></i>Time Out
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-calendar-plus mr-2"></i>Registered
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-tag mr-2"></i>Type
                        </th>
                        <th class="px-4 py-4 text-left text-sm font-bold tracking-wider uppercase">
                            <i class="fas fa-cog mr-2"></i>Action
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($accounts as $user)
                    <tr class="table-row-hover hover:bg-purple-50">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-400 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-800">{{ $user->full_name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-gray-600 flex items-center gap-2">
                                <i class="fas fa-envelope text-purple-400 text-xs"></i>
                                {{ $user->email }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-map-pin"></i>
                                {{ $user->barangay }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            @if($user->time_in)
                                <div class="@if($user->time_in == $latestTimeIn) time-badge-latest bg-green-100 @else bg-gray-50 @endif px-3 py-2 rounded-lg inline-block">
                                    <div class="flex items-center gap-2 @if($user->time_in == $latestTimeIn) text-green-700 @else text-gray-600 @endif">
                                        <i class="fas fa-clock text-xs"></i>
                                        <div>
                                            <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($user->time_in)->format('M d, Y') }}</div>
                                            <div class="text-xs">{{ \Carbon\Carbon::parse($user->time_in)->format('h:i A') }}</div>
                                        </div>
                                        @if($user->time_in == $latestTimeIn)
                                            <span class="ml-2 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">Latest</span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-4">
                            @if($user->time_out)
                                <div class="@if($user->time_out == $latestTimeOut) time-badge-latest bg-yellow-100 @else bg-gray-50 @endif px-3 py-2 rounded-lg inline-block">
                                    <div class="flex items-center gap-2 @if($user->time_out == $latestTimeOut) text-yellow-700 @else text-gray-600 @endif">
                                        <i class="fas fa-clock text-xs"></i>
                                        <div>
                                            <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($user->time_out)->format('M d, Y') }}</div>
                                            <div class="text-xs">{{ \Carbon\Carbon::parse($user->time_out)->format('h:i A') }}</div>
                                        </div>
                                        @if($user->time_out == $latestTimeOut)
                                            <span class="ml-2 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">Latest</span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 text-gray-600 text-sm">
                                <i class="fas fa-calendar text-purple-400 text-xs"></i>
                                {{ \Carbon\Carbon::parse($user->registered)->format('M d, Y') }}
                            </div>
                        </td>

                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-user-tag"></i>
                                {{ $user->type }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            <a href="{{ route('admin.users_officers.show', $user->email) }}" 
                               class="action-button inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg text-sm hover:shadow-lg relative z-10 font-semibold">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Auto-refresh every 30s -->
    <script>
        setTimeout(() => location.reload(), 30000);
    </script>

    @else
    <!-- Empty State -->
    <div class="barangay-card rounded-2xl shadow-xl p-12 text-center">
        <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="fas fa-users text-6xl text-purple-400"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-3">No Records Found</h3>
        <p class="text-gray-600 mb-6 text-lg">
            @if(request('search'))
                Your search "<strong>{{ request('search') }}</strong>" did not match any activity logs.
            @else
                No users or officers have logged activity yet in the system.
            @endif
        </p>

        @if(request('search'))
        <a href="{{ route('admin.users_officers.index') }}" class="action-button inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:shadow-2xl text-lg relative z-10">
            <i class="fas fa-arrow-left"></i> View All Records
        </a>
        @endif
    </div>
    @endif

</div>

@endsection