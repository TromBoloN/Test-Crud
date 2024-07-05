<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function dashboard()
    {
        $assignments = Assignment::all();
        return view('student.dashboard', compact('assignments'));
    }

    public function submitAssignment(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $path = $request->file('file')->store('submissions');
        $originalFilename = $request->file('file')->getClientOriginalName();

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => auth()->id(),
            'file_path' => $path,
            'original_filename' => $originalFilename,
        ]);

        return back()->with('success', 'Assignment submitted successfully');
    }
}
