<?php
namespace App\Http\Controllers\Backend\Teacher\Leave;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_leave;
use App\Models\Teacher;
use App\Models\Teacher_leave;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class Leave_controller extends Controller
{

    public function index()
    {
        $teacher=Teacher::latest()->get();
       return view('Backend.Pages.Teacher.Leave.index',compact('teacher'));
    }
    public function all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'leave_type','leave_reason','status','start_date', 'end_date'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        /*Start building the query*/
        $query = Teacher_leave::with('teacher');

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('leave_type', 'like', "%$search%")
                ->where('leave_reason', 'like', "%$search%")
                  ->orWhere('start_date', 'like', "%$search%")
                  ->orWhere('end_date', 'like', "%$search%")
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Teacher_leave::count();

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
            'teacher_id' => 'required|integer',
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
        $object = new Teacher_leave();
        $object->teacher_id = $request->teacher_id;
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
        $data = Teacher_leave::find($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function update(Request $request){
        /* Validate the form data */
        $rules = [
            'teacher_id' => 'required|exists:teachers,id',
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
        $object = Teacher_leave::find($request->id);
        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'not found'
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
        $object = Teacher_leave::find($request->id);
        $object->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Successfully'
        ]);
    }
}
