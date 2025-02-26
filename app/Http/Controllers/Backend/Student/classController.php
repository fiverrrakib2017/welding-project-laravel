<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student_class;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class classController extends Controller
{
    public function index(){
       // $studentClasses = Student_class::with('sections')->get();
        $data=Section::latest()->get();
        return view('Backend.Pages.Student.Class.index',compact('data'));
    }
    public function all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'created_at'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        $query = Student_class::with('sections');

        /*Apply the search filter*/ 
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhereHas('sections', function($q) use ($search) {
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
                'sections' => $item->sections->pluck('name')->implode(', '),
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
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /*Create a new class record*/
        $object = new Student_class();
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
        $object = Student_class::find($id);

        if ($object) {
            return response()->json([
                'success' => true,
                'data' => $object
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Class not found'
        ], 404);
    }

    public function update(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $object = Student_class::find($request->id);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Class not found'
            ], 404);
        }

        /* Update the Class record */
        $object->name = $request->name;

        /* Save the updated Class record to the database*/
        $object->save();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Class updated successfully!'
        ]);
    }

    public function delete(Request $request){
        $object = Student_class::find($request->id);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Section not found'
            ], 404);
        }

        /* Delete the class record from the database */
        $object->delete();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Class deleted successfully!'
        ]);
    }
}
