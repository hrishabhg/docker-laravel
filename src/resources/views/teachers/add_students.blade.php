@extends('teachers.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Other Students</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('teachers.students', $teacher->id) }}"> Back</a>
                <a class="btn btn-default" href="{{ route('teachers.addStudents', $teacher->id) }}">Create</a>
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
                    <form action="{{ route('teachers.attachStudent',[$teacher->id,$student->id]) }}" method="POST">


                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $students->links() !!}

@endsection
