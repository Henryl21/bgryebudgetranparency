@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'error',
    title: 'Access Denied',
    text: 'Only Captain can access this page.',
    confirmButtonText: 'OK'
}).then(() => {
    window.location.href = "{{ route('admin.dashboard') }}";
});
</script>
@endsection
