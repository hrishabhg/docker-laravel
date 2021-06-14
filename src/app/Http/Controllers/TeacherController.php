<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private $pageSize = 3;

    public function index()
    {
        $teachers = Teacher::latest()->paginate($this->pageSize);
        return view('teachers.index',compact('teachers'))
            ->with('i', (request()->input('page', 1) - 1) * $this->pageSize);
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ]);

        Teacher::create($request->all());

        return redirect()->route('teachers.index')
            ->with('success','Teacher added.');
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit',compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')
            ->with('success','Teacher updated successfully');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success','Teacher deleted successfully');
    }

    public function students(int $teacherId)
    {
        $teacher = Teacher::find($teacherId);
        $students = $teacher->students()->paginate($this->pageSize);
        return view('teachers.students',compact('students','teacher'))
            ->with('i', (request()->input('page', 1) - 1) * $this->pageSize);
    }

    public function addStudents(int $teacherId)
    {
        $students = Student::join('student_teacher', 'students.id', '=', 'student_teacher.student_id')
            ->where('teacher_id', '!=', $teacherId)->paginate($this->pageSize);
        return view('teachers.addstudents',compact('students'))
            ->with('i', (request()->input('page', 1) - 1) * $this->pageSize);
    }

    public function markStar($teacherId, $studentId)
    {

    }

    public function removeStudent($teacherId, $studentId)
    {

    }
}
