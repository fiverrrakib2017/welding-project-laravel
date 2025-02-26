<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student_class;
use App\Models\Student_class_routine;
use App\Models\Student_subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassRoutine_controller extends Controller
{
    public function index(){
       $classes = Student_class::latest()->get();
       $subjects= Student_subject::latest()->get();
       $teachers=Teacher::latest()->get();
       $sections= Section::latest()->get();
        return view('Backend.Pages.Student.Routine.index',compact('classes','subjects', 'teachers', 'sections'));
    }
    public function all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'created_at'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        $query =  Student_class_routine::with('class', 'subject', 'teacher');

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhereHas('class', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhereHas('subject', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhereHas('teacher', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Student_class_routine::count();

        // Get the count of filtered records
        $filteredRecords = $query->count();

        if ($request->has('class_id') && !empty($request->class_id)) {
            $query->where('class_id', $request->class_id);
        }
        /* Apply ordering, pagination and get the data*/
        $items = $query->orderBy($orderByColumn, $orderDirection)
                    ->skip($request->start)
                    ->take($request->length)
                    ->get();


        /* Format the data for DataTables*/
        // $formattedData = $items->map(function ($item) {
        //     return [
        //         'id' => $item->id,
        //         'name' => $item->name,
        //         'subjects' => $item->subjects->pluck('name')->implode(', '),
        //     ];
        // });

        /* Return the response in JSON format*/
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $items,
        ]);
    }

    public function store(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'teacher_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /*Create a new  record*/
        $object = new Student_class_routine();
        $object->class_id = $request->class_id;
        $object->section_id = $request->section_id;
        $object->subject_id = $request->subject_id;
        $object->teacher_id = $request->teacher_id;
        $object->day = $request->day;
        $object->start_time = $request->start_time;
        $object->end_time = $request->start_time;

        /* Save the class record to the database*/
        $object->save();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }

    public function edit($id){
        $object = Student_class_routine::find($id);

        if ($object) {
            return response()->json([
                'success' => true,
                'data' => $object
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Not found'
        ], 404);
    }

    public function get_routine_data(Request $request){

        $query = Student_class_routine::query();
        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->section_id) {
            $query->where('section_id', $request->section_id);
        }

        /* Load related models*/
        $data = $query->with(['class', 'subject', 'teacher'])->get();

        /*Check if data exists*/
        if ($data->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'code'=>200,
                'data' => $data
            ]);
        }
    }

    public function update(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'teacher_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $object = Student_class_routine::find($request->id);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Subject not found'
            ], 404);
        }

        /* Update the  record */
        $object->class_id = $request->class_id;
        $object->section_id = $request->section_id;
        $object->subject_id = $request->subject_id;
        $object->teacher_id = $request->teacher_id;
        $object->day = $request->day;
        $object->start_time = $request->start_time;
        $object->end_time = $request->start_time;
        $object->update();

        /* Return success response*/
        return response()->json([
            'success' => true,
            'message' => 'Updated successfully!'
        ]);
    }

    public function delete(Request $request){
        $object = Student_class_routine::find($request->id);

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
    public function print(Request $request){
        $class_id = $request->input('class_id');

        $routines = Student_class_routine::where('class_id', $class_id)->get();

        $view = view('Backend.Pages.Student.Routine.print_routine', compact('routines'))->render();

        return response()->json($view);
    }
}
