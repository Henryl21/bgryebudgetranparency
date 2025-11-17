@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 py-10 px-4">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-xl border-t-4 border-blue-700">

        <!-- Cute Back Button -->
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 mb-6 bg-white border border-blue-300 text-blue-700 
                  px-4 py-2 rounded-full shadow-sm hover:shadow-md hover:bg-blue-50 transition-all">

            <span class="flex h-8 w-8 items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </span>

            <span class="font-medium">Back</span>
        </a>

        <!-- Header -->
        <h2 class="text-3xl font-bold text-blue-800 mb-6 flex items-center gap-3">
            <i class="fa-solid fa-comment-dots text-blue-600 text-3xl"></i>
            User Feedback
        </h2>

        <div class="h-1 w-full bg-gradient-to-r from-blue-700 via-yellow-400 to-red-500 rounded mb-6"></div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-600 p-4 rounded shadow">
                <p class="text-green-800 font-medium">
                    <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
                </p>
            </div>
        @endif

        <!-- Add Feedback Button -->
        <div class="mb-6">
            <a href="{{ route('user.feedback.create') }}"
               class="inline-flex items-center gap-2 bg-blue-700 text-white px-5 py-3 rounded-lg shadow hover:bg-blue-800 transition">
                <i class="fa-solid fa-plus"></i>
                Write Feedback
            </a>
        </div>

        <!-- Feedback List -->
        @if($feedbacks->count())
            <ul class="space-y-5">
                @foreach($feedbacks as $feedback)
                    <li class="p-5 bg-white border border-gray-300 rounded-xl shadow hover:shadow-lg transition">

                        <div class="flex justify-between items-start">

                            <!-- Message -->
                            <div class="pr-4">
                                <p class="text-gray-800 text-lg leading-relaxed">
                                    {{ $feedback->message }}
                                </p>

                                <small class="flex items-center gap-2 mt-2 text-gray-500">
                                    <i class="fa-solid fa-clock"></i>
                                    Sent {{ $feedback->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <!-- Delete -->
                            <form action="{{ route('user.feedback.destroy', $feedback->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition p-2 rounded-lg hover:bg-red-50">
                                    <i class="fa-solid fa-trash text-xl"></i>
                                </button>
                            </form>

                        </div>

                    </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $feedbacks->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <i class="fa-solid fa-inbox text-gray-400 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-3">No feedback found.</p>

                <a href="{{ route('user.feedback.create') }}"
                   class="inline-block bg-blue-700 text-white px-5 py-2.5 rounded-lg hover:bg-blue-800 transition">
                    Add First Feedback
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
