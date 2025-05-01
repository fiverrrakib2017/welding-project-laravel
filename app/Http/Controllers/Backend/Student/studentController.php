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
use Illuminate\Support\Facades\View;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::with('course')->where('is_delete', 0)->latest()->get();
        return view('Backend.Pages.Student.index', compact('students'));
    }
    public function create()
    {
        $courses = DB::table('courses')->get();
        return view('Backend.Pages.Student.create', compact('courses'));
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'] ?? null;

        $columnsForOrderBy = ['id', 'name', 'nid_or_passport', 'mobile_number', 'father_name', 'permanent_address', 'present_address', 'course_id'];

        $orderByColumnIndex = $request->order[0]['column'] ?? 0;
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex] ?? 'id'; // fallback id
        $orderDirection = $request->order[0]['dir'] ?? 'asc';

        $query = Student::with(['course'])->when($search, function ($q) use ($search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('nid_or_passport', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%");
            });
        });

        $totalRecords = Student::count();
        $filteredRecords = $query->count();

        $items = $query
            ->orderBy($orderByColumn, $orderDirection)
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
    public function get_certificate(Request $request)
    {
        $student = Student::where('nid_or_passport', $request->nid_or_passport)->where('mobile_number', $request->mobile_number)->first();
        if (empty($student)) {
            return response()->json(['success' => false, 'message' => 'Student not found.'], 404);
            exit;
        }
        if($student->is_delete == 1) {
            return response()->json(['success' => false, 'message' => 'Student not found.'], 404);
            exit;
        }
        if ($student->is_completed == 0) {
            return response()->json(['success' => false, 'message' => 'Student not completed the course.'], 404);
            exit;
        }
         /*Render the certificate view as HTML*/
        $html = View::make('Backend.Pages.Student.certificate_partial', compact('student'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Student found.',
            'data' => $html,
        ]);
        exit;

    }

    public function course_list()
    {
        $courses = DB::table('courses')->get();
        return view('Backend.Pages.Student.course', compact('courses'));
    }
    public function change_status($id)
    {
        $object = Student::find($id);
        $object->is_completed = $object->is_completed == 1 ? 0 : 1;
        $object->user_id = Auth::guard('admin')->user()->id;
        $object->update();
        return response()->json([
            'success' => true,
            'message' => 'Completed successfully!',
        ]);
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
            $student->reg_no = $request->regestration_no;

            $student->course = implode(',', $request->courses);

            $student->course_duration = $request->course_duration ?? '';
            $student->course_end = $request->course_end ?? '';
            $student->is_delete = '0';
            $student->is_completed = '0';
            $student->user_id = '0';
            $student->save();

            /*Student Log*/
            $object = new Student_log();
            $object->student_id = $student->id;
            $object->action_type = 'add';
            $object->user_id = Auth::guard('admin')->user()->id;
            $object->description = 'New student added: ' . $student->name;
            $object->ip_address = request()->ip();
            $object->save();
            /*End Student Log*/
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Student Created Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function edit($id)
    {
        $student = DB::table('students')->where('id', $id)->first();
        $courses = DB::table('courses')->get();
        return view('Backend.Pages.Student.edit', compact('student', 'courses'));
    }
    public function view($id)
    {
        $student = DB::table('students')->where('id', $id)->first();
        return view('Backend.Pages.Student.Profile', compact('student'));
    }
    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->nid_or_passport = $request->nid_or_passport;
        $student->father_name = $request->father_name;
        $student->mobile_number = $request->mobile_number;
        $student->permanent_address = $request->permanent_address;
        $student->present_address = $request->present_address;
        $student->course = implode(',', $request->courses);
        $student->course_duration = $request->course_duration ?? '';
        $student->course_end = $request->course_end ?? '';
        $student->update();
        /*Student Log*/
        $object = new Student_log();
        $object->student_id = $student->id;
        $object->action_type = 'edit';
        $object->user_id = Auth::guard('admin')->user()->id;
        $object->description = 'Student updated: ' . $student->name;
        $object->ip_address = request()->ip();
        $object->save();
        /*End Student Log*/
        return response()->json([
            'success' => true,
            'message' => 'Student Updated Successfully',
        ]);
    }
    public function student_certificate($id)
    {
        $student = Student::with('course')->where('id', $id)->first();
        if (empty($student)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        return view('Backend.Pages.Student.certificate', compact('student'));
    }
    public function delete(Request $request)
    {
        $object = Student::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->is_delete = 1;
        $object->save();
        /*Student Log*/
        $log = new Student_log();
        $log->student_id = $object->id;
        $log->action_type = 'delete';
        $log->user_id = Auth::guard('admin')->user()->id;
        $log->description = 'Student deleted: ' . $object->name;
        $log->ip_address = request()->ip();
        $log->save();
        /*End Student Log*/

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function recycle_delete(Request $request)
    {
        $object = Student::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }
        $object->delete();
        /*Student Log*/
        // $log = new Student_log();
        // $log->student_id = $object->id;
        // $log->action_type = 'delete';
        // $log->user_id = Auth::guard('admin')->user()->id;
        // $log->description = 'Student deleted Confirm By Admin: ' . Auth::guard('admin')->user()->name;
        // $log->ip_address = request()->ip();
        // $log->save();
        /*End Student Log*/

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function student_logs()
    {
        $logs = Student_log::with('student')->latest()->get();
        return view('Backend.Pages.Student.log', compact('logs'));
    }
    public function student_log_get_all_data(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $columnsForOrderBy = ['id', 'student_id', 'user_id', 'action_type', 'description', 'created_at'];
        $orderByColumn = $request->order[0]['column'] ?? 0;
        $orderDirection = $request->order[0]['dir'] ?? 'desc';

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $query = Student_log::with(['student', 'user'])->when($search, function ($query) use ($search) {
            $query
                ->where('created_at', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhereHas('student', function ($query) use ($search) {
                    $query->where('nid_or_passport', 'like', "%$search%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        });
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $totalRecords = $query->count();

        $data = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
    public function student_recycle()
    {
        $students = Student::with('course')->where('is_delete', 1)->latest()->get();
        return view('Backend.Pages.Student.recycle', compact('students'));
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
