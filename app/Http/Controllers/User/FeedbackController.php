<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedbacks = Feedback::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'feedbacks' => $feedbacks->items()
            ]);
        }

        return view('user.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('user.feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Feedback submitted successfully!'
            ]);
        }

        return redirect()->route('user.feedback.index')->with('success', 'Feedback submitted successfully!');
    }

    public function destroy($id, Request $request)
    {
        try {
            $feedback = Feedback::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $feedback->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Feedback deleted successfully.'
                ]);
            }

            return redirect()->route('user.feedback.index')->with('success', 'Feedback deleted successfully.');

        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Feedback not found or you do not have permission to delete it.'
                ], 404);
            }

            return redirect()->route('user.feedback.index')->with('error', 'Feedback not found.');
        }
    }
}
