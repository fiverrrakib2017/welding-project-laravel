<?php
namespace App\Http\Controllers\Backend\Pop;
use App\Http\Controllers\Controller;
use App\Models\Branch_package;
use App\Models\Branch_transaction;
use App\Models\Package;
use App\Models\Pop_area;
use App\Models\Pop_branch;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PopController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Pop.index');
    }

    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name','username','phone', 'status'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Pop_branch::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            $query->where('username', 'like', "%$search%");
            $query->where('phone', 'like', "%$search%");
        })->orderBy($columnsForOrderBy[$orderByColumn], $orderDirectection);

        $total = $object->count();
        $item = $object->skip($request->start)->take($request->length)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $item,
        ]);
    }
    public function store(Request $request)
    {
        /* Validate the form data*/
        $this->validateForm($request);

        /* Create a new Supplier*/
        $object = new Pop_branch();
        $object->name = $request->name;
        $object->username = $request->username;
        $object->password = $request->password;
        $object->phone = $request->phone;
        $object->email = $request->email;
        $object->address = $request->address;
        $object->status = $request->status ?? 1;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }
    public function branch_package_store(Request $request)
    {
        /*Validate the form data*/
        $rules=[

            'package_id' => 'required|integer',
            'pop_id' => 'required|integer',
            'purchase_price' => 'required',
            'sales_price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /* Create a new Supplier*/
        $object = new Branch_package();
        $object->name = Package::find(intval($request->package_id))->name;
        $object->package_id = $request->package_id;
        $object->pop_id = $request->pop_id;
        $object->purchase_price = $request->purchase_price;
        $object->sales_price = $request->sales_price;


        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }
    public function branch_recharge_store(Request $request)
    {
        /*Validate the form data*/
        $rules=[
            'pop_id' => 'required|integer',
            'amount' => 'required',
            'transaction_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $object = new Branch_transaction();
        $object->pop_id = $request->pop_id;
        $object->amount = $request->amount;
        $object->transaction_type = $request->transaction_type;
        $object->note = $request->note;


        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }
    public function branch_recharge_undo($id){
        $object = Branch_transaction::find($id);
        if ($object) {
            $object->delete();
            return response()->json(['success' => true, 'message' => 'Successfully!']);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }

    public function branch_package_edit($id){
        $data = Branch_package::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    public function pop_change_status($id){
        $object =Pop_branch::find($id);
        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'POP/Branch not found!'
            ], 404);
        }
        $object->status = $object->status == 1 ? 0 : 1;


        /* Update to the database table*/
        $object->update();
        return response()->json([
            'success' => true,
            'message' => 'Status changed successfully!',
            'new_status' => $object->status
        ]);
    }



    public function branch_package_update(Request $request,$id)
    {
        /*Validate the form data*/
        $rules=[

            'package_id' => 'required|integer',
            'purchase_price' => 'required',
            'sales_price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $object =Branch_package::find($id);
        $object->package_id = $request->package_id;
        $object->purchase_price = $request->purchase_price;
        $object->sales_price = $request->sales_price;


        /* Update to the database table*/
        $object->update();
        return response()->json([
            'success' => true,
            'message' => 'Package Update successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Pop_branch::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Pop_branch::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    public function view($id) {
        $pop=Pop_branch::findOrFail($id);
        $due_paid=Branch_transaction::where('pop_id',$id)->where('transaction_type','due_paid')->sum('amount');
        $get_total_due=Branch_transaction::where('pop_id',$id)->where('transaction_type','credit')->sum('amount');



        $total_paid = Branch_transaction::where('pop_id', $id)
        ->where('transaction_type', '!=', 'credit')
        ->sum('amount');

         $total_due = $get_total_due - $due_paid;

         $total_area=Pop_area::where('pop_id',$id)->count();
         $tickets=Ticket::where('pop_id',$id)->count();
         $ticket_completed=Ticket::where('pop_id',$id)->where('status','1')->count();
         $ticket_pending=Ticket::where('pop_id',$id)->where('status','0')->count();
        return view('Backend.Pages.Pop.View',compact('pop','due_paid','total_paid','total_due','total_area','tickets','ticket_completed','ticket_pending'));
    }

    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Pop_branch::findOrFail($id);
        $object->name = $request->name;
        $object->username = $request->username;
        $object->password = $request->password;
        $object->phone = $request->phone;
        $object->email = $request->email;
        $object->address = $request->address;
        $object->status = $request->status ?? 1;
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
            'name' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'phone' => 'required|string',
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
