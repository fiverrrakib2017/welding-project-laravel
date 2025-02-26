<?php

namespace App\Http\Controllers\Backend\Customer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Customer_Invoice;
use App\Models\Customer_Transaction_History;
use App\Services\InvoiceService;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    protected $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService=$invoiceService;
    }
    public function create_invoice(){
        return $this->invoiceService->createInvoice('Customer');
    }

    public function show_invoice(){
        return view('Backend.Pages.Customer.invoice');
    }
    public function view_invoice($id){
        $data=  Customer_Invoice::with('customer','items.product')->find($id);
        return view('Backend.Pages.Customer.invoice_view',compact('data'));
    }
    public function edit_invoice($id){
       $invoice_data=  Customer_Invoice::with('customer','items.product')->find($id);
       return view('Backend.Pages.Customer.invoice_edit',compact('invoice_data'));
    }
    public function update_invoice(Request $request){
        /* 1= user id by default */
        return response()->json($this->invoiceService->update_invoice($request,$request->id,1,'customer'));
    }
    public function show_invoice_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'customer_name', 'phone_number','total_amount', 'paid_amount', 'due_amount','status','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer_Invoice::with('customer')->when($search, function ($query) use ($search) {
            $query->where('total_amount', 'like', "%$search%")
                  ->orWhere('paid_amount', 'like', "%$search%")
                  ->orWhere('due_amount', 'like', "%$search%")
                  ->orWhere('created_at', 'like', "%$search%")
                  ->orWhereHas('customer', function ($query) use ($search) {
                      $query->where('fullname', 'like', "%$search%")
                            ->orWhere('phone_number', 'like', "%$search%");
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
    public function store_invoice(Request $request){
        /* 1= user id by default */
        return response()->json($this->invoiceService->store_invoice($request,1,'customer'));
    }

    public function delete_invoice(Request $request){
        return response()->json($this->invoiceService->delete_invoice($request,'customer'));
    }
    public function pay_due_amount(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        $invoice =Customer_Invoice::find($request->id);
        $dueAmount = $invoice->due_amount;

        if ($request->amount > $dueAmount) {
            return response()->json(['success' => false, 'message' => 'Over Amount Not Allowed'], 400);
        }

        $paid_amount = $invoice->paid_amount + $request->amount;
        $due_amount = max($invoice->due_amount - $request->amount, 0);

        $invoice->update([
            'paid_amount' => $paid_amount,
            'due_amount' => $due_amount,
        ]);
        /*Log transaction history*/
        $object = new Customer_Transaction_History();
        $object->invoice_id = $request->id;
        $object->customer_id = $invoice->customer_id;
        $object->amount = $request->amount;
        $object->status = 1;
        $object->save();

        return response()->json(['success'=>true,'message' => 'Payment successful'], 200);
    }
}
