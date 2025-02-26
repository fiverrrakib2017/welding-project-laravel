<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_class;
use App\Models\Section;
use App\Models\Student_docs;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    protected $student=Null;
    public function __construct(StudentService $student)
    {
        $this->student=$student;
    }
    public function index(){
        $classes=Student_class::with('section')->latest()->get();
        $section= Section::latest()->get();
        return view('Backend.Pages.Student.index',compact('classes','section'));
    }
    public function create(){
         $data=Student_class::latest()->get();
         $section= Section::latest()->get();
        return view('Backend.Pages.Student.create',compact('data', 'section'));
    }
    public function edit($id){
       // return $this->student->edit($id);
       $student = Student::find($id);
       $data=Student_class::latest()->get();
       $section= Section::latest()->get();
       return view('Backend.Pages.Student.edit',compact('student','data', 'section'));
    }
    public function view($id){
        return $this->student->view($id);
    }
    public function all_data(Request $request){

        return $this->student->get_data($request);
    }
    public function store(Request $request)
    {
        /*Validate the incoming request data*/
        $validator = StudentService::validate($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /* Handle the file upload*/
        $filename = StudentService::handleFileUpload($request);
        $student = new Student();
        StudentService::setData($student, $request, $filename);
        $student->save();

        /* Check if documents are uploaded */
        if ($request->hasFile('documents')) {
            foreach($request->file('documents') as $index => $file){
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/documents/';
                $file->move(public_path($filePath), $filename);
                $docs = new Student_docs();
                $docs->student_id = $student->id;
                $docs->docs_name = $filename;
                $docs->file_path = $filePath . $filename;
                $docs->save();
            }
        }

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Student added successfully!'
        ]);
    }
    public function update(Request $request, $id=NULL){
        /*Validate the incoming request data*/
        $student = Student::findOrFail($id);
        $validator = StudentService::validate($request, $student);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $filename = StudentService::handleFileUpload($request, $student);
        StudentService::setData($student, $request, $filename);
        $student->update();


        /* Check if documents are uploaded */
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/documents/';
                $file->move(public_path($filePath), $filename);

                /* Save the document details in the database */
                $docs = new Student_docs();
                $docs->student_id = $student->id;
                $docs->docs_name = $filename;
                $docs->file_path = $filePath . $filename;
                $docs->save();
            }
        }


        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Student Update Successfully!'
        ]);
    }

    public function delete(Request $request)
    {
        $student = Student::find($request->id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found!'
            ], 404);
        }

        /*Check if the student has a photo*/
        if ($student->photo) {
            /* Delete the student's photo file*/
            $photoPath = public_path('uploads/photos/' . $student->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        /* Delete the student record from the database*/
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully!'
        ]);
    }

    public function get_student($id){
      return   Student::with('currentClass')->find($id);
    }

    public function student_filter(Request $request){
        $filters=array();

        if (isset($request->class_id) && !empty($request->class_id)) {
            $filters['current_class']=$request->class_id;
        }
        if (isset($request->section_id) && !empty($request->section_id)) {
           $filters['section_id']=$request->section_id;
        }
        if (isset($request->student_id) && !empty($request->section_id)) {
           $filters['id']=$request->student_id;
        }

        $students =  Student::with('currentClass','section')->where($filters)->get();
        if ($students->isEmpty()) {
            return response()->json([
                'success' => false,
                'code'=>200,
                'data' => []
            ]);
        }
        return response()->json([
            'success' => true,
            'code'=>200,
            'data' => $students
        ]);
    }

}
