<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $pageSize = 3;

    public function index()
    {
        $students = Student::latest()->paginate($this->pageSize);
        return view('students.index',compact('students'))
            ->with('i', (request()->input('page', 1) - 1) * $this->pageSize);
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:students|max:100',
            'grade' => 'required|max:4',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success','Student added.');
    }

    public function edit(Student $student)
    {
        return view('students.edit',compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|max:100',
            'grade' => 'required|max:4',
        ]);
        if(isset($request->email) && $student->email != $request->email){
            $request->validate([
                'email' => 'required|email|unique:students|max:100',
            ]);
        }

        $student->update($request->all());

        return redirect()->route('students.index')
            ->with('success','Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $student->teachers()->detach();
        $student->delete();

        return redirect()->route('students.index')
            ->with('success','Student deleted successfully');
    }
}
