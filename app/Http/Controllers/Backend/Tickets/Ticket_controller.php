<?php

namespace App\Http\Controllers\Backend\Tickets;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Customer_Transaction_History;
use App\Models\Ticket;
use App\Models\Ticket_complain_type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Ticket_controller extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Tickets.index');
    }

    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'status', 'created_at','priority_id', 'student_id', 'student_id','student_id','student_id','student_id','student_id','student_id','student_id','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Ticket::with(['student','assign','complain_type'])->when($search, function ($query) use ($search) {
            $query->where('status', 'like', "%$search%")
                //    ->orWhere('priority', 'like', "%$search%")
                  ->orWhereHas('student', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%")
                            ->orWhere('phone', 'like', "%$search%");
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
        /*Validate the form data*/
        $this->validateForm($request);
        $object = new Ticket();
        $object->student_id = $request->student_id;
        $object->ticket_for = $request->ticket_for;
        $object->ticket_assign_id = $request->ticket_assign_id;
        $object->ticket_complain_id = $request->ticket_complain_id;
        $object->priority_id = $request->priority_id;
        $object->subject = $request->subject;
        $object->description = $request->description;
        $object->note = $request->note;
        $object->percentage = $request->percentage ?? '0%';
        $object->status = $request->status_id;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Ticket::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }


        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Ticket::find($id);
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

        $object = Ticket::findOrFail($id);
        $object->student_id = $request->student_id;
        $object->ticket_for = $request->ticket_for;
        $object->ticket_assign_id = $request->ticket_assign_id;
        $object->ticket_complain_id = $request->ticket_complain_id;
        $object->priority_id = $request->priority_id;
        $object->subject = $request->subject;
        $object->description = $request->description;
        $object->note = $request->note;
        $object->percentage = $request->percentage ?? '0%';
        $object->status = $request->status_id ;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!'
        ]);
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'student_id' => 'required|integer',
            'ticket_for' => 'required|integer',
            'ticket_assign_id' => 'required|integer',
            'ticket_complain_id' => 'required|integer',
            'priority_id' => 'required|integer',
            'subject' => 'required|string',
            'description' => 'required',
            'status_id'=>'required|integer',
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
