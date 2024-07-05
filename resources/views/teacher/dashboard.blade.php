@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
<div class="container">
    <h1>Teacher Dashboard</h1>
    <a href="{{ route('teacher.create-assignment') }}" class="btn btn-primary">Create Assignment</a>
    
    <h2>Assignments</h2>
    @foreach ($assignments as $assignment)
        <div class="card mt-3">
            <div class="card-header">{{ $assignment->subject }}</div>
            <div class="card-body">
                <p>{{ $assignment->description }}</p>
                <h3>Submissions</h3>
                @foreach ($assignment->submissions as $submission)
                    <div class="card mt-2">
                        <div class="card-body">
                            <p>Student: {{ $submission->student->name }}</p>
                            <p>Submitted: {{ $submission->created_at }}</p>
                            <a href="{{ route('teacher.view-submission', $submission) }}" class="btn btn-sm btn-info">View Submission</a>
                            <a href="{{ route('teacher.download-submission', $submission) }}" class="btn btn-sm btn-secondary">Download Submission</a>
                            <form action="{{ route('teacher.grade-submission', $submission) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="grade">Grade</label>
                                    <input type="number" name="grade" id="grade" class="form-control" value="{{ $submission->grade }}" min="0" max="100">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Grade</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection