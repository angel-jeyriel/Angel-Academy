<?php

namespace App\Http\Controllers;

use App\Events\TestSubmitted;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->isStaff()) {
                return redirect()->route('home')->with('error', 'Access denied.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $courses = Course::with('subjects.tests')->get();
        return view('student.dashboard', compact('courses'));
    }

    public function start(Test $test)
    {
        $attempt = TestAttempt::create([
            'user_id' => Auth::id(),
            'test_id' => $test->id,
            'score' => 0,
        ]);

        return view('student.test', compact('test', 'attempt'));
    }

    public function submit(Request $request, TestAttempt $attempt)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|in:a,b,c,d',
        ]);

        $score = 0;
        $questions = $attempt->test->questions;

        foreach ($questions as $question) {
            $selected = $request->answers[$question->id] ?? null;
            if ($selected) {
                Answer::create([
                    'test_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_option' => $selected,
                ]);
                if ($selected === $question->correct_option) {
                    $score++;
                }
            }
        }

        $attempt->update([
            'score' => $score,
            'completed_at' => now(),
        ]);

        event(new TestSubmitted($attempt));

        return redirect()->route('student.results', $attempt)->with('success', 'Test submitted successfully.');
    }

    public function results(TestAttempt $attempt)
    {
        return view('student.results', compact('attempt'));
    }
}
