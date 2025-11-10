@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">

        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <i class="fas fa-comment-dots mr-2 text-blue-500"></i>
            Submit Feedback
        </h2>

        <form id="feedbackForm" action="{{ route('user.feedback.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Your Feedback</label>
                <textarea id="message" name="message" rows="5"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 transition p-3 text-gray-700"
                    placeholder="Write your feedback here..." required>{{ old('message') }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('user.feedback.index') }}"
                    class="mr-3 text-gray-600 hover:text-gray-800 transition">Cancel</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Send
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feedbackForm');
    const message = document.getElementById('message');

    form.addEventListener('submit', function(e) {
        const msg = message.value.trim();

        // Check for empty message
        if (!msg) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Empty Feedback',
                text: 'Please write your feedback before submitting.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        // Optional: prevent HTML/script tags (sanitization)
        const cleanMsg = msg.replace(/<[^>]*>?/gm, '');
        if (cleanMsg !== msg) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Characters',
                text: 'HTML tags are not allowed in feedback.',
                confirmButtonColor: '#2563eb'
            });
        }
    });
});
</script>
@endsection
