<?php

namespace App\Http\Controllers\Backend\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Teacher_docs;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService=Null;
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService=$teacherService;
    }
    public function create(){
        return view('Backend.Pages.Teacher.create');
    }
    public function index(){
        return view('Backend.Pages.Teacher.index');
    }
    public function all_data(Request $request){
        $search = $request->search['value'];

        $columnsForOrderBy = ['id', 'name', 'gender'];

        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Teacher::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('gender', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('phone_2', 'like', "%$search%");
            });
        }

        if (isset($columnsForOrderBy[$orderByColumn])) {
            $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection);
        }

        $total = $query->count();

        $data = $query->skip($request->start)->take($request->length)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }
    public function store(Request $request){
        /*Validate the incoming request data*/
        $validator = TeacherService::validateTeacher($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        /* Handle the file upload*/
        $filename = TeacherService::handleFileUpload($request);
        $teacher = new Teacher();
        TeacherService::setTeacherData($teacher, $request, $filename);
        $teacher->save();
        /* Check if documents are uploaded */
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/documents/';
                $file->move(public_path($filePath), $filename);

                /* Save the document details in the database */
                $docs = new Teacher_docs();
                $docs->teacher_id = $teacher->id;
                $docs->docs_name = $filename;
                $docs->file_path = $filePath . $filename;
                $docs->save();
            }
        }

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Teacher added successfully!'
        ]);
    }
    public function edit($id){
        $data = Teacher::find($id);

        if ($data) {
            return view('Backend.Pages.Teacher.edit',compact('data'));
        }
    }
    public function view($id){
        $teacher = Teacher::find($id);

        if ($teacher) {
            return view('Backend.Pages.Teacher.view',compact('teacher'));
        }
    }
    public function update(Request $request, $id=NULL){
        $teacher = Teacher::findOrFail($id);
        $validator = TeacherService::validateTeacher($request, $teacher);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $filename = TeacherService::handleFileUpload($request, $teacher);
        TeacherService::setTeacherData($teacher, $request, $filename);
        $teacher->update();
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/documents/';
                $file->move(public_path($filePath), $filename);

                /* Save the document details in the database */
                $docs = new Teacher_docs();
                $docs->teacher_id = $teacher->id;
                $docs->docs_name = $filename;
                $docs->file_path = $filePath . $filename;
                $docs->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully!'
        ]);
    }
    public function delete(Request $request)
    {
        $teacher = Teacher::find($request->id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found!'
            ], 404);
        }

        /*Check if the Teacher has a photo*/
        if ($teacher->photo) {
            /* Delete the Teacher's photo file*/
            $photoPath = public_path('uploads/photos/' . $teacher->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        /* Delete the Teacher record from the database*/
        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully!'
        ]);
    }
}
