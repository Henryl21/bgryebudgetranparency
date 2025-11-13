@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow p-8 rounded mt-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Database Backup</h1>
        <span class="text-gray-500 text-sm">Barangay: {{ $barangayName }}</span>
    </div>

    <p class="text-gray-600 mb-8">
        Click the button below to back up and download the current database of the Barangay eBudget Transparency System.
    </p>

    <div class="flex justify-center">
        <button id="download-db-btn"
           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded shadow flex items-center gap-2">
            <i class="fas fa-database"></i>
            Download Database Now
        </button>
    </div>

    <div class="mt-8 text-gray-400 text-sm text-center">
        <i class="fas fa-info-circle"></i> The file will be downloaded as a <strong>.sql</strong> backup.
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('download-db-btn').addEventListener('click', function(e) {
    e.preventDefault(); // prevent immediate download

    Swal.fire({
        title: 'Are you sure?',
        text: "This will back up and download the full database!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, download it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Trigger the download
            window.location.href = "{{ route('admin.downloadDatabase') }}";
        }
    });
});
</script>
@endsection
