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
            'name' => 'required|max:100',
            'email' => 'required|email|unique:teachers|max:100',
            'mobile' => 'required|max:20',
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
            'name' => 'required|max:100',
            'mobile' => 'required|max:20',
        ]);
        if(isset($request->email) && $teacher->email != $request->email){
            $request->validate([
                'email' => 'required|email|unique:teachers|max:100',
            ]);
        }

        $teacher->update($request->all());

        return redirect()->route('teachers.index')
            ->with('success','Teacher updated successfully');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->students()->detach();
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success','Teacher deleted successfully');
    }

    public function students(int $teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if(empty($teacher)){
            return response()->view('errors.' . '404', [], 404);
        }

        $students = $teacher->students()->paginate($this->pageSize);

        return view('teachers.students',compact('students','teacher'))
            ->with('i', (request()->input('page', 1) - 1) * $this->pageSize);
    }

    public function addStudents(int $teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if(empty($teacher)){
            return response()->view('errors.' . '404', [], 404);
        }

        $students = Student::whereNotIn('id', function ($query) use ($teacherId){
            $query->select('student_id')->from('student_teacher')->where('teacher_id','=', $teacherId);
        })->paginate($this->pageSize);

        return view('teachers.add_students',compact('students','teacher'))
            ->with('i', (request()->input('page', 1) - 1) * $this->pageSize);
    }

    public function markStar(Request $request, $teacherId, $studentId)
    {
        $teacher = Teacher::find($teacherId);
        if(empty($teacher)){
            return response()->view('errors.' . '404', [], 404);
        }

        $teacher->students()->updateExistingPivot($studentId, ['star' => $request->all()['star']]);

        $message = $request->all()['star'] ? "added" : "removed";
        return redirect()->route('teachers.students', $teacherId)
            ->with('success',"Star $message successfully");
    }

    public function attachStudent($teacherId, $studentId)
    {
        $teacher = Teacher::find($teacherId);
        $student = Student::find($studentId);
        if(empty($teacher) || empty($student)){
            return response()->view('errors.' . '404', [], 404);
        }

        $teacher->students()->attach($student);

        return redirect()->route('teachers.students', $teacherId)
            ->with('success',"Student added successfully");    }

    public function detachStudent($teacherId, $studentId)
    {
        $teacher = Teacher::find($teacherId);
        $student = Student::find($studentId);
        if(empty($teacher) || empty($student)){
            return response()->view('errors.' . '404', [], 404);
        }

        $teacher->students()->detach($student);

        return redirect()->route('teachers.students', $teacherId)
            ->with('success',"Student removed successfully");
    }
}
