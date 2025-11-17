@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 py-10 px-4">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl border-t-4 border-blue-700">

        <!-- Header -->
        <h2 class="text-3xl font-extrabold mb-4 text-blue-800 flex items-center gap-3">
            <i class="fas fa-comment-dots text-blue-600 text-3xl"></i>
            Submit Feedback
        </h2>

        <div class="h-1 w-full bg-gradient-to-r from-blue-700 via-yellow-400 to-red-500 rounded mb-6"></div>

        <!-- Form -->
        <form id="feedbackForm" action="{{ route('user.feedback.store') }}" method="POST">
            @csrf

            <!-- Feedback Input -->
            <div class="mb-6">
                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                    Your Feedback
                </label>

                <textarea id="message" name="message" rows="5"
                    class="w-full p-4 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition text-gray-700 resize-none"
                    placeholder="Write your feedback here..." required>{{ old('message') }}</textarea>

                <p id="charCount" class="text-right text-gray-500 text-sm mt-1">0 / 500</p>
            </div>

            <!-- Preview -->
            <div id="previewBox" class="hidden bg-gray-50 border border-gray-200 p-4 rounded-xl mb-5">
                <p class="font-medium text-gray-700 mb-1">Preview:</p>
                <p id="previewText" class="text-gray-600 whitespace-pre-line"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end mt-8 space-x-4">
                <a href="{{ route('user.feedback.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition shadow-sm">
                    Cancel
                </a>

                <button type="submit"
                    class="bg-blue-700 text-white px-6 py-2.5 rounded-lg shadow-lg hover:bg-blue-800 transition font-medium flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send Feedback
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
    const charCount = document.getElementById('charCount');
    const previewBox = document.getElementById('previewBox');
    const previewText = document.getElementById('previewText');

    const maxChars = 500;

    // Character Counter + Preview
    message.addEventListener('input', function() {
        const length = message.value.length;

        charCount.textContent = `${length} / ${maxChars}`;

        if (length > maxChars) {
            message.value = message.value.substring(0, maxChars);
            charCount.textContent = `${maxChars} / ${maxChars}`;
        }

        // Live preview
        if (message.value.trim() !== "") {
            previewBox.classList.remove('hidden');
            previewText.textContent = message.value;
        } else {
            previewBox.classList.add('hidden');
        }
    });

    // Validation
    form.addEventListener('submit', function(e) {
        const msg = message.value.trim();

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

        // Prevent HTML tags
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
