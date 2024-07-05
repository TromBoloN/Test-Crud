@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
<div class="container">
    <h1>Student Dashboard</h1>
    
    <h2>Assignments</h2>
    @foreach ($assignments as $assignment)
        <div class="card mt-3">
            <div class="card-header">{{ $assignment->subject }}</div>
            <div class="card-body">
                <p>{{ $assignment->description }}</p>
                <form action="{{ route('student.submit-assignment', $assignment) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Upload Assignment</label>
                        <input type="file" name="file" id="file" class="form-control-file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Assignment</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection