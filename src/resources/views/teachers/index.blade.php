@extends('teachers.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('teachers.create') }}">add</a>
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
                <th>Mobile</th>
                <th width="250px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($teachers as $teacher)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->mobile }}</td>
                <td>
                    <form action="{{ route('teachers.destroy',$teacher->id) }}" method="POST">

                        <a class="btn btn-secondary" href="{{ route('teachers.edit',$teacher->id) }}">Edit</a>
                        <a class="btn btn-secondary" href="{{ route('teachers.students',$teacher->id) }}">Students</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $teachers->links() !!}

@endsection
