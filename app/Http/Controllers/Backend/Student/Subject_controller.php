<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student_class;
use App\Models\Student_subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Subject_controller extends Controller
{
    public function index(){

       $classes = Student_class::get();
       $subjects = Student_subject::join('student_classes', 'student_subjects.class_id', '=', 'student_classes.id')
       ->select('student_subjects.*', 'student_classes.name as class_name')
       ->orderBy('student_subjects.class_id')
       ->get();
        return view('Backend.Pages.Student.Subject.index',compact('classes', 'subjects'));
    }
    public function all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'created_at'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        $query = Student_class::with('subjects');

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhereHas('subjects', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Student_class::count();

        // Get the count of filtered records
        $filteredRecords = $query->count();

        /* Apply ordering, pagination and get the data*/
        $items = $query->orderBy($orderByColumn, $orderDirection)
                    ->skip($request->start)
                    ->take($request->length)
                    ->get();

        /* Format the data for DataTables*/
        $formattedData = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'subjects' => $item->subjects->pluck('name')->implode(', '),
            ];
        });

        /* Return the response in JSON format*/
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $formattedData,
        ]);
    }
    public function store(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /*Create a new  record*/
        $object = new Student_subject();
        $object->class_id = $request->class_id;
        $object->name = $request->name;

        /* Save the class record to the database*/
        $object->save();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }

    public function edit($id){
        $object = Student_subject::find($id);

        if ($object) {
            return response()->json([
                'success' => true,
                'data' => $object
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Subject not found'
        ], 404);
    }
    public function get_subject_by_class(Request $request){
        $object = Student_subject::where('class_id', $request->class_id)->get();

        if ($object) {
            return response()->json([
                'success' => true,
                'data' => $object
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Subject not found'
        ], 404);
    }

    public function update(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $object = Student_subject::find($request->id);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Subject not found'
            ], 404);
        }

        /* Update the  record */
        $object->class_id = $request->class_id;
        $object->name = $request->name;
        $object->save();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Updated successfully!'
        ]);
    }

    public function delete(Request $request){
        $object = Student_subject::find($request->id);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'not found'
            ], 404);
        }

        /* Delete the class record from the database */
        $object->delete();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }
}
