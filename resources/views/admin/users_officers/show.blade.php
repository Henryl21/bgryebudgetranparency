@extends('layouts.admin')

@section('content')

{{-- ============================= STYLES =============================== --}}
<style>
    .barangay-pattern {
        background-image: 
            linear-gradient(30deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff),
            linear-gradient(150deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff),
            linear-gradient(30deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff),
            linear-gradient(150deg, #f0f9ff 12%, transparent 12.5%, transparent 87%, #f0f9ff 87.5%, #f0f9ff);
        background-size: 80px 140px;
        background-position: 0 0, 0 0, 40px 70px, 40px 70px;
    }

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

    .info-row {
        display: flex;
        align-items: start;
        padding: 1rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .info-row::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, #6d28d9, #4f46e5);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .info-row:hover {
        background: linear-gradient(to right, rgba(109, 40, 217, 0.05), transparent);
        transform: translateX(4px);
    }

    .info-row:hover::before {
        transform: scaleY(1);
    }

    .info-label {
        font-weight: 600;
        color: #6d28d9;
        min-width: 180px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        color: #374151;
        font-weight: 500;
        flex: 1;
    }

    .profile-header {
        background: linear-gradient(135deg, #6d28d9 0%, #4f46e5 50%, #7c3aed 100%);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #ffffff 0%, #f3e8ff 100%);
        border: 6px solid white;
        box-shadow: 0 8px 24px rgba(109, 40, 217, 0.3);
    }

    .status-badge {
        animation: statusPulse 2s infinite;
    }

    @keyframes statusPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
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

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(109, 40, 217, 0.3);
    }

    .map-container {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border: 4px solid #6d28d9;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(to right, #6d28d9, #4f46e5);
        color: white;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        font-size: 1.25rem;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.3);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .leaflet-popup-content-wrapper {
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.2);
    }

    .leaflet-popup-content {
        font-family: inherit;
    }
</style>
{{-- ================================================================== --}}

<div class="p-4 md:p-6 lg:p-8 barangay-pattern min-h-screen fade-in">

    {{-- Profile Header --}}
    <div class="barangay-card rounded-2xl shadow-2xl overflow-hidden mb-6">
        <div class="profile-header p-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="avatar-circle rounded-full flex items-center justify-center text-6xl font-bold text-purple-600">
                    {{ strtoupper(substr($account->full_name, 0, 1)) }}
                </div>
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                        {{ $account->full_name }}
                    </h1>
                    <p class="text-purple-100 text-lg mb-3">{{ $account->email }}</p>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $account->barangay }}
                        </span>
                        <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-user-tag"></i>
                            {{ $account->type }}
                        </span>
                        <span class="status-badge inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle"></i>
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- User Information Section --}}
    <div class="barangay-card rounded-2xl shadow-xl p-6 md:p-8 mb-6">
        <div class="section-header">
            <i class="fas fa-id-card text-2xl"></i>
            <span>Account Information</span>
        </div>

        <div class="space-y-2">
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-user text-lg"></i>
                    <span>Full Name:</span>
                </div>
                <div class="info-value text-lg">{{ $account->full_name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-envelope text-lg"></i>
                    <span>Email Address:</span>
                </div>
                <div class="info-value">{{ $account->email }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-map-marked-alt text-lg"></i>
                    <span>Barangay:</span>
                </div>
                <div class="info-value">
                    <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-map-pin text-xs"></i>
                        {{ $account->barangay }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-user-shield text-lg"></i>
                    <span>Account Type:</span>
                </div>
                <div class="info-value">
                    <span class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-tag text-xs"></i>
                        {{ $account->type }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-calendar-plus text-lg"></i>
                    <span>Registered Date:</span>
                </div>
                <div class="info-value">
                    <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-calendar text-xs"></i>
                        {{ \Carbon\Carbon::parse($account->registered)->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Activity Tracking Section --}}
    <div class="barangay-card rounded-2xl shadow-xl p-6 md:p-8 mb-6">
        <div class="section-header">
            <i class="fas fa-clock text-2xl"></i>
            <span>Activity Tracking</span>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Time In Card --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200 shadow-md">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-sign-in-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-green-700">Latest Time In</h3>
                        <p class="text-xs text-green-600">Last login timestamp</p>
                    </div>
                </div>
                @if($account->time_in)
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-2xl font-bold text-gray-800 mb-1">
                            {{ \Carbon\Carbon::parse($account->time_in)->format('h:i A') }}
                        </div>
                        <div class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fas fa-calendar-day text-green-500"></i>
                            {{ \Carbon\Carbon::parse($account->time_in)->format('M d, Y') }}
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                        <i class="fas fa-minus-circle text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-500 italic">No time in recorded</p>
                    </div>
                @endif
            </div>

            {{-- Time Out Card --}}
            <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-6 border-2 border-yellow-200 shadow-md">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-sign-out-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-yellow-700">Latest Time Out</h3>
                        <p class="text-xs text-yellow-600">Last logout timestamp</p>
                    </div>
                </div>
                @if($account->time_out)
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-2xl font-bold text-gray-800 mb-1">
                            {{ \Carbon\Carbon::parse($account->time_out)->format('h:i A') }}
                        </div>
                        <div class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fas fa-calendar-day text-yellow-500"></i>
                            {{ \Carbon\Carbon::parse($account->time_out)->format('M d, Y') }}
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                        <i class="fas fa-minus-circle text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-500 italic">No time out recorded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Map Section --}}
    <div class="barangay-card rounded-2xl shadow-xl p-6 md:p-8 mb-6">
        <div class="section-header">
            <i class="fas fa-map-location-dot text-2xl"></i>
            <span>Location Tracking</span>
        </div>

        <div class="map-container">
            <div id="userMap" style="height: 450px;" class="w-full"></div>
        </div>

        <div class="mt-4 bg-purple-50 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-purple-600 text-xl mt-1"></i>
                <div>
                    <h4 class="font-semibold text-purple-900 mb-1">Location Information</h4>
                    @php
                        $lat = !empty($account->latitude) ? $account->latitude : '10.2877';
                        $lng = !empty($account->longitude) ? $account->longitude : '123.9414';
                        $isDefault = empty($account->latitude) || empty($account->longitude);
                    @endphp
                    <p class="text-sm text-purple-700">
                        <strong>Coordinates:</strong> {{ $lat }}, {{ $lng }}
                        @if($isDefault)
                            (Default location)
                        @endif
                    </p>
                    <p class="text-xs text-purple-600 mt-1">
                        This map shows the registered location of {{ $account->full_name }} within {{ $account->barangay ?? 'the area' }} barangay.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.users_officers.index') }}" 
           class="action-button inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:shadow-2xl text-lg relative z-10">
            <i class="fas fa-arrow-left"></i> 
            <span>Back to Activity Logs</span>
        </a>

        <button onclick="window.print()" 
                class="action-button inline-flex items-center gap-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-8 py-4 rounded-xl font-bold hover:shadow-2xl text-lg relative z-10">
            <i class="fas fa-print"></i>
            <span>Print Details</span>
        </button>
    </div>
</div>

{{-- =================== LEAFLET MAP =================== --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const lat = parseFloat("{{ $lat }}");
    const lng = parseFloat("{{ $lng }}");

    const map = L.map('userMap').setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const purpleIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: linear-gradient(135deg, #6d28d9, #4f46e5); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 4px solid white; box-shadow: 0 4px 12px rgba(109, 40, 217, 0.5); display: flex; align-items: center; justify-content: center;"><i class="fas fa-user" style="color: white; transform: rotate(45deg); font-size: 16px;"></i></div>',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    L.marker([lat, lng], { icon: purpleIcon })
        .addTo(map)
        .bindPopup(`
            <div style="text-align: center; padding: 8px;">
                <h3 style="margin: 0 0 8px 0; color: #6d28d9; font-weight: bold; font-size: 16px;">
                    <i class="fas fa-user-circle"></i> {{ $account->full_name }}
                </h3>
                <p style="margin: 4px 0; color: #666; font-size: 14px;">
                    <i class="fas fa-map-marker-alt" style="color: #6d28d9;"></i> {{ $account->barangay ?? 'Unknown' }}
                </p>
                <p style="margin: 4px 0; color: #666; font-size: 12px;">
                    <i class="fas fa-envelope" style="color: #6d28d9;"></i> {{ $account->email }}
                </p>
            </div>
        `)
        .openPopup();

    window.addEventListener('resize', () => {
        map.invalidateSize();
    });
});
</script>
{{-- ==================================================== --}}

@endsection
