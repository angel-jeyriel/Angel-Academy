<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isStaff()) {
                return redirect()->route('home')->with('error', 'Access denied.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $tests = Test::with('subject.course')->get();
        return view('staff.tests-index', compact('tests'));
    }

    public function create()
    {
        $courses = Course::all();
        $subjects = Subject::all();
        return view('staff.tests-create', compact('courses', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c,d',
        ]);

        $test = Test::create([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'duration' => $request->duration,
        ]);

        foreach ($request->questions as $q) {
            Question::create([
                'test_id' => $test->id,
                'text' => $q['text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_option' => $q['correct_option'],
            ]);
        }

        return redirect()->route('staff.tests.index')->with('success', 'Test created successfully.');
    }

    public function edit(Test $test)
    {
        $courses = Course::all();
        $subjects = Subject::all();
        return view('staff.tests-edit', compact('test', 'courses', 'subjects'));
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c,d',
        ]);

        $test->update([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'duration' => $request->duration,
        ]);

        $test->questions()->delete();
        foreach ($request->questions as $q) {
            Question::create([
                'test_id' => $test->id,
                'text' => $q['text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_option' => $q['correct_option'],
            ]);
        }

        return redirect()->route('staff.tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('staff.tests.index')->with('success', 'Test deleted successfully.');
    }

    public function results(Test $test)
    {
        $attempts = $test->testAttempts()->with('user')->get();
        return view('staff.tests-results', compact('test', 'attempts'));
    }

    public function createCourse()
    {
        return view('staff.create-course');
    }

    public function addCourse(Request $request)
    {
        $course = Course::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back();
    }

    public function createSubject()
    {
        $courses = Course::all();
        return view('staff.create-subject', compact('courses'));
    }

    public function addSubject(Request $request)
    {
        $subject = Subject::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
        ]);

        return back();
    }

    public function generatePdf(Test $test)
    {
        $attempts = $test->testAttempts()->with('user')->get();
        $pdf = Pdf::loadView('staff.tests-pdf', compact('test', 'attempts'));
        return $pdf->download('test_results_' . $test->id . '.pdf');
    }
}
