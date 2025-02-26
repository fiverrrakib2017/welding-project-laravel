<?php

namespace App\Http\Controllers\Backend\Student;
use App\Http\Controllers\Controller;
use App\Models\Customer_ticket;
use App\Models\Section;
use App\Models\Student;
use App\Models\Student_class;
use App\Models\Student_exam;
use App\Models\Student_exam_result;
use App\Models\Student_exam_routine;
use App\Models\Student_subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class Exam_result_controller extends Controller
{

    public function create_result()
    {
        $sections= Section::latest()->get();
        $subjects=Student_subject::latest()->get();
        $students=Student::latest()->get();

        return view('Backend.Pages.Student.Exam.Create_result',compact('sections','subjects','students'));
    }
    public function result_report()
    {
        $sections= Section::latest()->get();
        $subjects=Student_subject::latest()->get();
        $students=Student::latest()->get();
        return view('Backend.Pages.Student.Exam.Result',compact('sections','subjects','students'));
    }


    public function result_store(Request $request)
    {
        /*Validate the form data*/
        $this->validateForm($request);
        $object = new Student_exam_result();
        $object->exam_id  = $request->exam_id;
        $object->class_id  = $request->class_id;
        $object->section_id  = $request->section_id ;
        $object->student_id = $request->student_id;
        $object->subject_id = $request->subject_id;
        $object->marks_obtained = $request->marks_obtained;
        $object->total_marks = $request->total_marks;
        $object->grade = $request->grade;
        $object->remarks = $request->remarks;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Student_exam_result::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }


        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'data'=>$object, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Student_exam_result::find($id);
        $sections= Section::latest()->get();
        $subjects=Student_subject::latest()->get();
        $students=Student::latest()->get();
        return view('Backend.Pages.Student.Exam.Result_update',compact('data','sections','subjects','students'));
    }


    public function update(Request $request)
    {
        $this->validateForm($request);

        $object = Student_exam_result::findOrFail($request->id);
        $object->exam_id  = $request->exam_id;
        $object->class_id  = $request->class_id;
        $object->section_id  = $request->section_id ;
        $object->student_id = $request->student_id;
        $object->subject_id = $request->subject_id;
        $object->marks_obtained = $request->marks_obtained;
        $object->total_marks = $request->total_marks;
        $object->grade = $request->grade;
        $object->remarks = $request->remarks;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!'
        ]);
    }
    public function get_exam_result(Request $request)
{
    $query = Student_exam_result::query();
    if ($request->class_id) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->exam_id) {
        $query->where('exam_id', $request->exam_id);
    }

    if ($request->student_id) {
        $query->where('student_id', $request->student_id);
    }

    /* Load related models*/
    $data = $query->with(['exam', 'student', 'subject', 'class', 'section'])->get();

    /*Check if data exists*/
    if ($data->isNotEmpty()) {
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'No results found.',
    ]);
}

    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules=[
            'exam_id' => 'required|exists:student_exams,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:student_subjects,id',
            'marks_obtained' => 'required|integer',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer',
            'grade' => 'required|string|max:255'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    }
}
