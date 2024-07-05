<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $assignments = Assignment::where('teacher_id', auth()->id())->with('submissions')->get();
        return view('teacher.dashboard', compact('assignments'));
    }

    public function createAssignment()
    {
        return view('teacher.create-assignment');
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ]);

        Assignment::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()->route('teacher.dashboard')->with('success', 'Assignment created successfully');
    }

    public function gradeSubmission(Request $request, Submission $submission)
    {
        $request->validate([
            'grade' => 'required|integer|min:0|max:100',
        ]);

        $submission->update(['grade' => $request->grade]);

        return back()->with('success', 'Submission graded successfully');
    }

    public function viewSubmission(Submission $submission)
    {
        if ($submission->assignment->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('teacher.view-submission', compact('submission'));
    }

    public function downloadSubmission(Submission $submission)
    {
        if ($submission->assignment->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return Storage::download($submission->file_path, $submission->original_filename);
    }
}
