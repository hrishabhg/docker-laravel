@extends('teachers.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Student List: {{ $teacher->name }}</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('teachers.index') }}"> Back</a>
                <a class="btn btn-secondary" href="{{ route('teachers.addStudents', $teacher->id) }}">Add</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Grade</th>
            <th>Star Mark</th>
            <th width="250px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->grade }}</td>
                <td>

                    <form action="{{ route('teachers.markStar',[$teacher->id,$student->id]) }}" method="POST">
                        <button type="submit" class="btn">{{$student->pivot->star ? 'Remove' : 'Add'}}</button>

                        @csrf
                        @method('PUT')

                    </form>
                </td>
                <td>
                    <form action="{{ route('teachers.removeStudent',[$teacher->id,$student->id]) }}" method="POST">


                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $students->links() !!}

@endsection
