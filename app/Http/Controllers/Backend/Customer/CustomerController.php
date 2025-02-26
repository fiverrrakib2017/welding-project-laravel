<?php

namespace App\Http\Controllers\Backend\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Customer_Transaction_History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\__get_invoice_data;

class CustomerController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Customer.index');
    }
    public function create()
    {
        return view('Backend.Pages.Customer.Create');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'fullname','company_name','phone_number', 'email_address'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Customer::when($search, function ($query) use ($search) {
            $query->where('fullname', 'like', "%$search%");
            $query->where('company_name', 'like', "%$search%");
            $query->where('phone_number', 'like', "%$search%");
            $query->where('email_address', 'like', "%$search%");
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
        /*Validate the form data*/
        $this->validateForm($request);
        
        $object = new Customer();
        $object->fullname = $request->fullname;
        $object->company_name = $request->company;
        $object->email_address = $request->email;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        $object->status = $request->status ?? 1;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Customer::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Customer not found.'], 404);
        }

        /* Image Find And Delete it From Local Machine */
        if (!empty($object->profile_image)) {
            $imagePath = public_path('Backend/uploads/photos/' . $object->profile_image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Customer::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Customer not found.']);
        }
    }
    public function view($id) {
        $total_invoice=Customer_Invoice::where('customer_id',$id)->count();
        $total_paid_amount=Customer_Invoice::where('customer_id',$id)->sum('paid_amount');
        $total_due_amount=Customer_Invoice::where('customer_id',$id)->sum('due_amount');
        $invoices = Customer_Invoice::where('customer_id', $id)->get();
        $data = Customer::find($id);
        $customer_transaction_history=Customer_Transaction_History::where('customer_id',$id)->get();
        return view('Backend.Pages.Customer.Profile',compact('data','total_invoice','total_paid_amount','total_due_amount','invoices','customer_transaction_history'));
    }

    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Customer::findOrFail($id);
        $object->fullname = $request->fullname;
        $object->company_name = $request->company;
        $object->email_address = $request->email;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        $object->status = $request->status ?? 1;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Customer Update successfully!'
        ]);
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'fullname' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
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
