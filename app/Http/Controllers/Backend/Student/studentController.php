<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class studentController extends Controller
{
    public function index(){
        $students=Student::with('course')->latest()->get();
        return view('Backend.Pages.Student.index',compact('students'));
    }
    public function create(){
        $courses=DB::table('courses')->get();
        return view('Backend.Pages.Student.create',compact('courses'));
    }
    public function get_all_data(Request $request)
{
    $search = $request->search['value'] ?? null;

    $columnsForOrderBy = ['id', 'name', 'nid_or_passport', 'mobile_number', 'father_name', 'permanent_address', 'present_address', 'course_id'];

    $orderByColumnIndex = $request->order[0]['column'] ?? 0;
    $orderByColumn = $columnsForOrderBy[$orderByColumnIndex] ?? 'id'; // fallback id
    $orderDirection = $request->order[0]['dir'] ?? 'asc';

    $query = Student::with(['course'])
        ->when($search, function ($q) use ($search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%")
                         ->orWhere('nid_or_passport', 'like', "%{$search}%")
                         ->orWhere('mobile_number', 'like', "%{$search}%");
            });
        });

    $totalRecords = Student::count(); // মোট কত রেকর্ড
    $filteredRecords = $query->count(); // সার্চ করার পর কত রেকর্ড বাকি

    $items = $query->orderBy($orderByColumn, $orderDirection)
                   ->skip($request->start ?? 0)
                   ->take($request->length ?? 10)
                   ->get();

    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $items,
    ]);
}

    public function course_list(){
        $courses=DB::table('courses')->get();
        return view('Backend.Pages.Student.course',compact('courses'));
    }
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $this->validateForm($request);

            // Create new student
            $student = new Student();
            $student->name = $request->name;
            $student->nid_or_passport = $request->nid_or_passport;
            $student->father_name = $request->father_name;
            $student->mobile_number = $request->mobile_number;
            $student->permanent_address = $request->permanent_address;
            $student->present_address = $request->present_address;
            $student->course_id = $request->course_id;
            $student->is_delete = '0';
            $student->save();

            /*Student Log*/
            $object=new Student_log();
            $object->student_id=$student->id;
            $object->action_type='add';
            $object->user_id=Auth::guard('admin')->user()->id;
            $object->description='New student added: ' . $student->name;
            $object->ip_address=request()->ip();
            $object->save();
            /*End Student Log*/
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Student Created Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id){
        $student=DB::table('students')->where('id',$id)->first();
        $courses=DB::table('courses')->get();
        return view('Backend.Pages.Student.edit',compact('student','courses'));
    }
    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules = [
            'name' => 'required',
            'nid_or_passport' => 'required|unique:students,nid_or_passport',
            'mobile_number' => 'required|unique:students,mobile_number',
            'father_name' => 'required',
            'permanent_address' => 'nullable',
            'present_address' => 'nullable',
            'course_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }
    }
}
