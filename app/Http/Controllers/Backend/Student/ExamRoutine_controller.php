<?php

namespace App\Http\Controllers\Backend\Student;
use App\Http\Controllers\Controller;
use App\Models\Customer_ticket;
use App\Models\Student_exam_routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExamRoutine_controller extends Controller
{

    public function index()
    {
        return view('Backend.Pages.Student.Exam.Routine');
    }

    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'status', 'created_at','priority_id', 'customer_id', 'customer_id','customer_id','customer_id','customer_id','customer_id','customer_id','customer_id','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer_ticket::with(['customer','assign','complain_type'])->when($search, function ($query) use ($search) {
            $query->where('status', 'like', "%$search%")
                //    ->orWhere('priority', 'like', "%$search%")
                  ->orWhereHas('customer', function ($query) use ($search) {
                      $query->where('fullname', 'like', "%$search%")
                            ->orWhere('phone_number', 'like', "%$search%");
                  })
                  ->orWhereHas('complain_type', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('assign', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  });
        }) ->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)
        ->paginate($request->length);


        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $query->total(),
            'recordsFiltered' => $query->total(),
            'data' => $query->items(),
        ]);
    }
    public function store(Request $request)
    {
        $start_time = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s');
        $end_time = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s');
        /*Validate the form data*/
        $this->validateForm($request);
        $object = new Student_exam_routine();
        $object->exam_id  = $request->exam_id ;
        $object->class_id = $request->class_id;
        $object->subject_id = $request->subject_id;
        $object->exam_date = $request->exam_date;
        $object->start_time = $start_time;
        $object->end_time = $end_time;
        $object->room_number = $request->room_number;
        $object->invigilator = $request->invigilator_name;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Student_exam_routine::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }


        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'data'=>$object, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Student_exam_routine::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }


    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $object = Student_exam_routine::findOrFail($id);
        $object->exam_id  = $request->exam_id ;
        $object->class_id = $request->class_id;
        $object->subject_id = $request->subject_id;
        $object->exam_date = $request->exam_date;
        $object->start_time = $request->start_time;
        $object->end_time = $request->end_time;
        $object->room_number = $request->room_number;
        $object->invigilator = $request->invigilator_name;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!'
        ]);
    }
    public function get_exam_routine(Request $request){

        $class_id = $request->class_id;
        $exam_id = $request->exam_id;
        $data = Student_exam_routine::with(['exam','class','subject'])->where(['exam_id'=>$exam_id, 'class_id'=>$class_id])->get();
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'exam_id' => 'required|exists:student_exams,id',
            'class_id' => 'required|exists:student_classes,id',
            'subject_id' => 'required|exists:student_subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'required|integer',
            'invigilator' => 'required|string|max:255'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    }
}
