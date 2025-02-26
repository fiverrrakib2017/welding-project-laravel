<?php
namespace App\Http\Controllers\Backend\Teacher\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Student_class;
use App\Models\Student_fees_type;
use App\Models\Teacher;
use App\Models\Teacher_transaction;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherTransaction_controller extends Controller
{

    public function index()
    {
       $teachers=Teacher::get();
       return view('Backend.Pages.Teacher.Transaction.index',compact('teachers'));
    }
    public function all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'type_name', 'amount'];
        $orderByColumnIndex = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $orderByColumn = $columnsForOrderBy[$orderByColumnIndex];

        /*Start building the query*/
        $query = Teacher_transaction::with('teacher');

        /*Apply the search filter*/
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('type', 'like', "%$search%")
                  ->orWhere('amount', 'like', "%$search%")
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        /* Get the total count of records*/
        $totalRecords = Teacher_transaction::count();

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
            'teacher_id' => 'required|integer',
            'type_name' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        /* Create a new instance*/

        $object = new Teacher_transaction();
        $object->teacher_id = $request->teacher_id;
        $object->type = $request->type_name;
        $object->amount = $request->amount;
        $object->transaction_date = $request->transaction_date;
        /*Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully'
        ]);
    }
    public function get_transaction($id,){
        $data = Teacher_transaction::find($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
   
    public function update(Request $request){
        /*Validate the incoming request data*/
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|integer',
            'type_name' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $object =Teacher_transaction::find($request->id);
        $object->teacher_id = $request->teacher_id;
        $object->type = $request->type_name;
        $object->amount = $request->amount;
        $object->transaction_date = $request->transaction_date;
        /*Update to the database table*/
        $object->update();
        return response()->json([
            'success' => true,
            'message' => 'Update Successfully'
        ]);
    }
    public function delete(Request $request){
        $object = Teacher_transaction::find($request->id); 
        $object->delete(); 
        return response()->json([
            'success' => true,
            'message' => 'Delete Successfully'
        ]);
    }
    public function report(){
        $teachers=Teacher::get();
        return view('Backend.Pages.Teacher.Transaction.Report.index',compact('teachers'));
    }
    public function report_generate(Request $request){
        /* Validate date inputs*/
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        /* Get data based on selected date range*/
        $from_date = $request->from_date;
        $to_date = $request->to_date;

    /*Retrieve transactions within the specified date range*/ 
        $transactions = DB::table('teacher_transactions')
        ->join('teachers', 'teacher_transactions.teacher_id', '=', 'teachers.id')
        ->select('teachers.name as teacher_name', 'teacher_transactions.type', 'teacher_transactions.amount', 'teacher_transactions.transaction_date')
        ->whereBetween('transaction_date', [$from_date, $to_date])
        ->orderBy('teacher_transactions.transaction_date', 'asc')
        ->get()
        ->groupBy('teacher_name');
        return view('Backend.Pages.Teacher.Transaction.Report.index', compact('transactions', 'from_date', 'to_date'));
    }
}