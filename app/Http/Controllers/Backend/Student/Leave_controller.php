<?php
namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_class;
use App\Models\Section;
use App\Models\Student_bill_collection;
use App\Models\Student_leave;
use App\Models\Student_shift;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class Leave_controller extends Controller
{

    public function index()
    {
        $student=Student::latest()->get();
       return view('Backend.Pages.Student.Leave.index',compact('student'));
    }
    public function all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'leave_type','leave_reason','status','start_date', 'end_date'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        /*Start building the query*/
        $query = Student_leave::with('student');

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('leave_type', 'like', "%$search%")
                ->where('leave_reason', 'like', "%$search%")
                  ->orWhere('start_date', 'like', "%$search%")
                  ->orWhere('end_date', 'like', "%$search%")
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Student_leave::count();

        /* Get the count of filtered records*/
        $filteredRecords = $query->count();

        /* Apply ordering, pagination and get the data*/
        $items = $query->orderBy($orderByColumn, $orderDirection)
                    ->skip($request->start)
                    ->take($request->length)
                    ->get();

        /* Return the response in JSON format*/
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $items,
        ]);
    }
    public function store(Request $request){
        /* Validate the form data*/
        $rules = [
            'student_id' => 'required|integer',
            'leave_type' => 'required|string',
            'leave_reason' => 'required|string',
            'leave_status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        /* Create a new Instance*/
        $object = new Student_leave();
        $object->student_id = $request->student_id;
        $object->leave_type = $request->leave_type;
        $object->leave_reason = $request->leave_reason;
        $object->leave_status = $request->leave_status;
        $object->start_date = $request->start_date;
        $object->end_date = $request->end_date;

        /*Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully'
        ]);
    }
    public function get_leave($id){
        $data = Student_leave::find($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function update(Request $request){
        /* Validate the form data */
        $rules = [
            'student_id' => 'required|exists:students,id',
            'leave_type' => 'required|string',
            'leave_reason' => 'required|string',
            'leave_status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /* Find the existing instance */
        $object = Student_leave::find($request->id);
        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Shift not found'
            ], 404);
        }

        /* Update the Instance */
        $object->leave_type = $request->leave_type;
        $object->leave_reason = $request->leave_reason;
        $object->leave_status = $request->leave_status;
        $object->start_date = $request->start_date;
        $object->end_date = $request->end_date;

        /* Save the changes to the database table */
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Updated Successfully'
        ]);
    }

    public function delete(Request $request){
        $object = Student_leave::find($request->id);
        $object->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Successfully'
        ]);
    }
}
