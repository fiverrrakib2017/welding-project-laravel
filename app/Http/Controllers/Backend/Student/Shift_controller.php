<?php
namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_class;
use App\Models\Section;
use App\Models\Student_bill_collection;
use App\Models\Student_shift;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class Shift_controller extends Controller
{

    public function index()
    {
       $student=Student::get();
       return view('Backend.Pages.Student.Shift.index',compact('student'));
    }
    public function all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'shift_name', 'start_time', 'end_time'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        /*Start building the query*/
        $query = Student_shift::query();

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('shift_name', 'like', "%$search%")
                ->where('time_in', 'like', "%$search%")
                  ->orWhere('time_out', 'like', "%$search%");
                //   ->orWhereHas('student', function($q) use ($search) {
                //       $q->where('name', 'like', "%$search%");
                //   });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Student_shift::count();

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
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        /* Create a new Instance*/
        $object = new Student_shift();
        $object->shift_name = $request->shift_name;
        $object->start_time = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s'); 
        $object->end_time = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s'); 

        /*Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully'
        ]);
    }
    public function get_shift($id){
        $data = Student_shift::find($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function update(Request $request){
        /* Validate the form data */
        $rules = [
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /* Find the existing instance */
        $object = Student_shift::find($request->id);
        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Shift not found'
            ], 404);
        }

        /* Update the Instance */
        $object->shift_name = $request->shift_name;
        $object->start_time = $request->start_time;
        $object->end_time = $request->end_time;

        /* Save the changes to the database table */
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Updated Successfully'
        ]);
    }

    public function delete(Request $request){
        $object = Student_shift::find($request->id); 
        $object->delete(); 
        return response()->json([
            'success' => true,
            'message' => 'Delete Successfully'
        ]);
    }
}