@extends('layouts.admin')

@section('content')
<style>
    /* Card Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .user-card {
        animation: fadeInUp 0.5s ease;
    }

    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }

    /* Table Animation */
    .table-row {
        transition: all 0.2s ease;
    }

    .table-row:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .mobile-card {
            display: block;
        }
        
        .desktop-table {
            display: none;
        }
    }

    @media (min-width: 769px) {
        .mobile-card {
            display: none;
        }
        
        .desktop-table {
            display: table;
        }
    }

    /* Badge Colors */
    .badge-male {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .badge-female {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .badge-other {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
</style>

<div class="p-4 md:p-6 lg:p-8">
    <!-- Page Header -->
    <div class="mb-6 md:mb-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-users text-purple-600"></i> Registered Users
                </h1>
                <p class="text-sm md:text-base text-gray-600">
                    <span class="inline-flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-purple-500"></i>
                        <strong>{{ ucfirst($barangayRole) }}</strong> Barangay
                    </span>
                </p>
            </div>
           
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
        <div class="stat-card bg-gradient-to-br from-purple-500 to-indigo-600 text-white rounded-xl p-4 md:p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-white text-opacity-90 mb-1">Total Users</p>
                    <h3 class="text-2xl md:text-3xl font-bold">{{ $users->total() }}</h3>
                </div>
                <div class="w-10 h-10 md:w-14 md:h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-blue-500 to-cyan-600 text-white rounded-xl p-4 md:p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-white text-opacity-90 mb-1">Male</p>
                    <h3 class="text-2xl md:text-3xl font-bold">{{ $users->where('gender', 'male')->count() }}</h3>
                </div>
                <div class="w-10 h-10 md:w-14 md:h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-male text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-xl p-4 md:p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-white text-opacity-90 mb-1">Female</p>
                    <h3 class="text-2xl md:text-3xl font-bold">{{ $users->where('gender', 'female')->count() }}</h3>
                </div>
                <div class="w-10 h-10 md:w-14 md:h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-female text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-green-500 to-teal-600 text-white rounded-xl p-4 md:p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-white text-opacity-90 mb-1">This Month</p>
                    <h3 class="text-2xl md:text-3xl font-bold">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                </div>
                <div class="w-10 h-10 md:w-14 md:h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-check text-lg md:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by name, email, or contact number..." 
                        value="{{ request('search') }}" 
                        class="search-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition-all text-sm md:text-base"
                    >
                </div>
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 text-sm md:text-base">
                    <i class="fas fa-search"></i>
                    <span>Search</span>
                </button>
                @if(request('search'))
                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-300 flex items-center justify-center gap-2 text-sm md:text-base">
                    <i class="fas fa-times"></i>
                    <span>Clear</span>
                </a>
                @endif
            </div>
        </form>
    </div>

    @if($users->count() > 0)
        <!-- Desktop Table View -->
        <div class="desktop-table bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                            <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Full Name
                            </th>
                            <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </th>
                            <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-phone mr-2"></i>Contact
                            </th>
                            <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-venus-mars mr-2"></i>Gender
                            </th>
                            <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt mr-2"></i>Barangay
                            </th>
                            <th class="px-4 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Registered
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $user)
                        <tr class="table-row hover:bg-purple-50 transition-all">
                            <td class="px-4 md:px-6 py-3 md:py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-gray-800 text-sm md:text-base">{{ $user->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-3 md:py-4 text-gray-600 text-sm md:text-base">
                                <i class="fas fa-envelope text-purple-500 mr-2"></i>{{ $user->email }}
                            </td>
                            <td class="px-4 md:px-6 py-3 md:py-4 text-gray-600 text-sm md:text-base">
                                <i class="fas fa-phone text-green-500 mr-2"></i>{{ $user->number }}
                            </td>
                            <td class="px-4 md:px-6 py-3 md:py-4">
                                <span class="badge-{{ strtolower($user->gender) }} text-white px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-{{ $user->gender == 'male' ? 'male' : ($user->gender == 'female' ? 'female' : 'genderless') }}"></i>
                                    {{ ucfirst($user->gender) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-3 md:py-4">
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($user->barangay_role) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-3 md:py-4 text-gray-600 text-sm md:text-base">
                                <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>{{ $user->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="mobile-card space-y-4 mb-6">
            @foreach ($users as $user)
            <div class="user-card bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            {{ strtoupper(substr($user->full_name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 truncate">{{ $user->full_name }}</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="badge-{{ strtolower($user->gender) }} text-white px-2 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-{{ $user->gender == 'male' ? 'male' : ($user->gender == 'female' ? 'female' : 'genderless') }}"></i>
                                    {{ ucfirst($user->gender) }}
                                </span>
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($user->barangay_role) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-envelope text-purple-500 w-5"></i>
                            <span class="truncate">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-phone text-green-500 w-5"></i>
                            <span>{{ $user->number }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-calendar-alt text-indigo-500 w-5"></i>
                            <span>{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-xl shadow-lg p-4">
            {{ $users->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-lg p-8 md:p-16 text-center">
            <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-4xl md:text-5xl text-gray-400"></i>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">No Users Found</h3>
            <p class="text-gray-600 mb-6 text-sm md:text-base">
                @if(request('search'))
                    No users match your search criteria. Try different keywords.
                @else
                    No registered users found for this barangay yet.
                @endif
            </p>
            @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-purple-700 transition-all">
                <i class="fas fa-arrow-left"></i>
                View All Users
            </a>
            @endif
        </div>
    @endif
</div>

<!-- Print Styles -->
<style media="print">
    .sidebar, .toggle-btn, button, .search-input {
        display: none !important;
    }
    
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    
    .stat-card, .user-card {
        break-inside: avoid;
    }
</style>
@endsection