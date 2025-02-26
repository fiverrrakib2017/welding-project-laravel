<?php

namespace App\Http\Controllers\Backend\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Supplier_Invoice;
use App\Models\Supplier_Transaction_History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Supplier.index');
    }

    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'fullname','company_name','phone_number', 'email_address'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Supplier::when($search, function ($query) use ($search) {
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
        /* Validate the form data*/
        $this->validateForm($request);

        /* Create a new Supplier*/
        $object = new Supplier();
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
            'message' => 'Supplier added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Supplier::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Supplier not found.'], 404);
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
        $data = Supplier::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Supplier not found.']);
        }
    }
    public function view($id) {
        $total_invoice=Supplier_Invoice::where('supplier_id',$id)->count();
        $total_paid_amount=Supplier_Invoice::where('supplier_id',$id)->sum('paid_amount');
        $total_due_amount=Supplier_Invoice::where('supplier_id',$id)->sum('due_amount');
        $invoices = Supplier_Invoice::where('supplier_id', $id)->get();
        $data = Supplier::find($id);
         $supplier_transaction_history=Supplier_Transaction_History::where('supplier_id',$id)->get();
        return view('Backend.Pages.Supplier.Profile',compact('data','total_invoice','total_paid_amount','total_due_amount','invoices','supplier_transaction_history'));
    }

    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Supplier::findOrFail($id);
        $object->fullname = $request->fullname;
        $object->company_name = $request->company;
        $object->email_address = $request->email;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        $object->status = $request->status ?? 1;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Supplier Update successfully!'
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
