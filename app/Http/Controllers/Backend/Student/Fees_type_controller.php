<?php
namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_class;
use App\Models\Section;
use App\Models\Student_bill_collection;
use App\Models\Student_fees_type;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Fees_type_controller extends Controller
{

    public function index()
    {
       $classes=Student_class::get();
       return view('Backend.Pages.Student.Fees_type.index',compact('classes'));
    }
    public function all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'type_name', 'amount'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        /*Start building the query*/
        $query = Student_fees_type::with('class');

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('type_name', 'like', "%$search%")
                  ->orWhere('amount', 'like', "%$search%")
                  ->orWhereHas('class', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Student_fees_type::count();

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
        $rules=[
            'type_name' => 'required|string',
            'class_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        /* Create a new Supplier*/
       


        $object = new Student_fees_type();
        $object->type_name = $request->type_name;
        $object->class_id = $request->class_id;
        $object->amount = $request->amount;
        $object->is_monthly = $request->is_monthly ?? 1;
        /*Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully'
        ]);
    }
    public function get_fees_type($id,){
        $data = Student_fees_type::find($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function get_fees_for_class($id){
        $data = Student_fees_type::where(['class_id'=>$id])->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function update(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'type_name' => 'required|string',
            'class_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $object =Student_fees_type::find($request->id);
        $object->type_name = $request->type_name;
        $object->class_id = $request->class_id;
        $object->amount = $request->amount;
        /*Update to the database table*/
        $object->update();
        return response()->json([
            'success' => true,
            'message' => 'Update Successfully'
        ]);
    }
    public function delete(Request $request){
        $object = Student_fees_type::find($request->id); 
        $object->delete(); 
        return response()->json([
            'success' => true,
            'message' => 'Delete Successfully'
        ]);
    }
}