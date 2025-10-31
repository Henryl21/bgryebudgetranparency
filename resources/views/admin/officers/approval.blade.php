@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold mb-4">Officer Approval</h2>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Amount</th>
                <th class="border px-4 py-2">Resoluton</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($budget_request as $budget)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $budget->officer->name }}</td>
                    <td class="px-4 py-2">{{ $budget->title }}</td>
                    <td class="px-4 py-2">{{ $budget->description }}</td>
                    <td class="px-4 py-2">₱{{ number_format($budget->amount, 2) }}</td>
                    <td class="px-4 py-2">
                        @if($budget->resolution)
                            <a href="{{ Storage::url($budget->resolution) }}" target="_blank" class="text-blue-600 underline">View</a>
                        @else
                            <span class="text-gray-400">None</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($budget->status === 'approved')
                            <span class="text-green-600 font-semibold">Approved</span>
                        @elseif($budget->status === 'declined')
                            <span class="text-red-600 font-semibold">Declined</span>
                        @else
                            <span class="text-yellow-600 font-semibold">Pending</span>
                        @endif
                    </td>

                    <td class="px-4 py-2">
                        <button type="button"
                            class="border-2 border-red-500 hover:bg-red-600 text-red-500 hover:text-white disabled:bg-gray-300 disabled:cursor-not-allowed font-semibold py-2 px-4 rounded-lg"
                            onclick="declineBudget({{ $budget->id }})"
                            @if(strtolower($budget->status) == 'approved' || strtolower($budget->status) == 'declined') disabled @endif>decline</button>
                        <button type="button"
                            class="bg-green-500 hover:bg-green-600 disabled:bg-gray-300 text-white font-semibold py-2 px-4 rounded-lg"
                            onclick="approveBudget({{ $budget->id }})"
                            @if(strtolower($budget->status) == 'approved' || strtolower($budget->status) == 'declined') disabled @endif>approve</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No requests yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function declineBudget(id) {
        Swal.fire({
            title: 'Decline Officer',
            input: 'text',
            inputLabel: 'Reason for declining',
            inputPlaceholder: 'Enter reason...',
            showCancelButton: true,
            confirmButtonText: 'Decline',
            confirmButtonColor: '#e3342f',
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('Reason is required');
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/admin/officers/${id}/budget-decline`;
                form.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = result.value;
                form.appendChild(reasonInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function approveBudget(id) {
        Swal.fire({
            title: 'Approve Budget Request?',
            text: 'Are you sure you want to approve this budget?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/admin/officers/${id}/budget-approve`;
                form.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
