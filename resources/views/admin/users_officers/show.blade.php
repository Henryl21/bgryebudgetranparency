@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">
        <i class="fas fa-user"></i> User/Officer Details
    </h2>

    {{-- User Info --}}
    <div class="bg-white rounded-xl shadow-lg p-6 space-y-3">
        <p><strong>Full Name:</strong> {{ $account->full_name }}</p>
        <p><strong>Email:</strong> {{ $account->email }}</p>
        <p><strong>Barangay:</strong> {{ $account->barangay }}</p>
        <p><strong>Type:</strong> {{ $account->type }}</p>
        <p><strong>Registered:</strong> {{ \Carbon\Carbon::parse($account->registered)->format('M d, Y') }}</p>
        <p><strong>Latest Time In:</strong> {{ $account->time_in ? \Carbon\Carbon::parse($account->time_in)->format('M d, Y h:i A') : '-' }}</p>
        <p><strong>Latest Time Out:</strong> {{ $account->time_out ? \Carbon\Carbon::parse($account->time_out)->format('M d, Y h:i A') : '-' }}</p>
    </div>

    {{-- Map Section --}}
    @if(isset($account->latitude) && isset($account->longitude))
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-2">Location</h3>
        <div id="userMap" style="height: 400px;" class="rounded-xl shadow-lg w-full"></div>
    </div>
    @endif

    {{-- Back Button --}}
    <a href="{{ route('admin.users_officers.index') }}" class="inline-block mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

{{-- Leaflet JS --}}
@if(isset($account->latitude) && isset($account->longitude))
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Ensure latitude and longitude are numbers
    const lat = parseFloat("{{ $account->latitude }}");
    const lng = parseFloat("{{ $account->longitude }}");

    if (!isNaN(lat) && !isNaN(lng)) {
        const map = L.map('userMap').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup(`<b>{{ $account->full_name }}</b><br>{{ $account->barangay }}`)
            .openPopup();

        // Optional: make map responsive
        window.addEventListener('resize', () => {
            map.invalidateSize();
        });
    } else {
        console.error("Invalid latitude or longitude for user map.");
    }
});
</script>
@endif
@endsection
