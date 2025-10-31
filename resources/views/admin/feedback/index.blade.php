@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">User Feedback</h1>
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-200">
                    {{-- <th class="px-4 py-2">ID</th> --}}
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Message</th>
                    <th class="px-4 py-2">Submitted At</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback as $item)
                    <tr>
                        {{-- <td class="border px-4 py-2">{{ $item->id }}</td> --}}
                        <td class="border px-4 py-2">
                            @if ($item->user)
                                {{ $item->user->name }}<br>
                                <small class="text-gray-500">{{ $item->user->email }}</small>
                            @else
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $item->message }}</td>
                        <td class="border px-4 py-2">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">No feedback submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $feedback->links() }}
        </div>
    </div>
@endsection
