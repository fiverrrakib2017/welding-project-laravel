<?php
namespace App\Http\Controllers\Backend\Customer;
use App\Http\Controllers\Controller;
use App\Models\Branch_transaction;
use App\Models\Customer;
use App\Models\Customer_log;
use App\Models\Customer_recharge;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\check_pop_balance;

class CustomerController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Customer.index');
    }
    public function create()
    {
        return view('Backend.Pages.Customer.create');
    }
    public function customer_restore()
    {
        return view('Backend.Pages.Customer.Restore.index');
    }


    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id','id','fullname','package','amount','created_at','expire_date','username','phone','pop_id','area_id','created_at','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer::with(['pop','area','package'])
        ->where('is_delete', '!=', 1)
        ->when($search, function ($query) use ($search) {
            $query->where('phone', 'like', "%$search%")
                   ->orWhere('username', 'like', "%$search%")
                  ->orWhereHas('pop', function ($query) use ($search) {
                      $query->where('fullname', 'like', "%$search%");
                  })
                  ->orWhereHas('area', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('package', function ($query) use ($search) {
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
    public function customer_restore_get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id','id','fullname','package','amount','created_at','expire_date','username','phone','pop_id','area_id','created_at','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer::with(['pop','area','package'])
        ->where('is_delete', '!=', 0)
        ->when($search, function ($query) use ($search) {
            $query->where('phone', 'like', "%$search%")
                   ->orWhere('username', 'like', "%$search%")
                  ->orWhereHas('pop', function ($query) use ($search) {
                      $query->where('fullname', 'like', "%$search%");
                  })
                  ->orWhereHas('area', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('package', function ($query) use ($search) {
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
        /* Validate the form data*/
        $this->validateForm($request);

        /*Check Pop Balance*/
        $pop_balance = check_pop_balance($request->pop_id);

        if ($pop_balance < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Pop balance is not enough',
            ]);
        }
        /* Create a new Customer*/
        $customer = new Customer();
        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->nid = $request->nid;
        $customer->address = $request->address;
        $customer->con_charge = $request->con_charge ?? 0;
        $customer->amount = $request->amount ?? 0;
        $customer->username = $request->username;
        $customer->password = $request->password;
        $customer->package_id = $request->package_id;
        $customer->pop_id = $request->pop_id;
        $customer->area_id = $request->area_id;
        $customer->router_id = $request->router_id;
        $customer->status = $request->status;
        $customer->expire_date = date("Y-m-d", strtotime("+1 month"));
        $customer->remarks = $request->remarks;
        $customer->liabilities = $request->liabilities;
        $customer->save();

         /*Store recharge data*/
         $object = new Customer_recharge();
         $object->user_id = auth()->guard('admin')->user()->id;
         $object->customer_id = $customer->id;
         $object->pop_id = $request->pop_id;
         $object->area_id = $request->area_id;
         $object->recharge_month = implode(',', [date('F')]);
         $object->transaction_type = 'cash';
         $object->paid_until =  date("Y-m-d", strtotime("+1 month"));
         $object->amount = $request->amount;
         $object->note = 'Created';
         $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Customer Created Successfully!',
        ]);
    }
    public function update(Request $request,$id)
    {
        /* Validate the form data*/
        $this->validateForm($request);

        /* update  Customer*/
        $customer = Customer::findOrFail($id);
        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->nid = $request->nid;
        $customer->address = $request->address;
        $customer->con_charge = $request->con_charge ?? 0;
        $customer->amount = $request->amount ?? 0;
        $customer->username = $request->username;
        $customer->password = $request->password;
        $customer->package_id = $request->package_id;
        $customer->pop_id = $request->pop_id;
        $customer->area_id = $request->area_id;
        $customer->router_id = $request->router_id;
        $customer->status = $request->status;
        $customer->remarks = $request->remarks;
        $customer->liabilities = $request->liabilities;

        /* Save to the database table*/
        $customer->save();
        return response()->json([
            'success' => true,
            'message' => 'Update successfully!',
        ]);
    }

    public function delete(Request $request)
    {
        $object = Customer::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->is_delete = 1;
        $object->save();

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function customer_restore_back(Request $request)
    {
        $object = Customer::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->is_delete = 0;
        $object->save();

        return response()->json(['success' => true, 'message' => 'Restored successfully.']);
    }
    public function edit($id)
    {
        $data = Customer::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit();
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    public function view($id)
    {
        $data = Customer::with(['pop','area','package'])->find($id);

        $total_recharged = Customer_recharge::where('customer_id', $id)
        ->where('transaction_type', '!=', 'due_paid')
        ->sum('amount')?? 0;

        $totalPaid = Customer_recharge::where('customer_id', $id)
        ->where('transaction_type', '!=', 'credit')
        ->sum('amount')?? 0;

        $get_total_due = Customer_recharge::where('customer_id', $id)->where('transaction_type', 'credit')->sum('amount') ?? 0;
        $duePaid = Customer_recharge::where('customer_id', $id)->where('transaction_type', 'due_paid')->sum('amount') ?? 0;

        $totalDue=$get_total_due-$duePaid;
        return view('Backend.Pages.Customer.Profile',compact('data','totalDue','totalPaid', 'duePaid','total_recharged'));
    }
    public function customer_recharge(Request $request){
         /*Validate the form data*/
         $rules = [
            'customer_id' => 'required',
            'pop_id' => 'required',
            'area_id' => 'required',
            'payable_amount' => 'required|numeric',
            'recharge_month' => 'required|array',
            'transaction_type' => 'required',
         ];
         $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }
        /*Check Pop Balance*/
        $pop_balance = check_pop_balance($request->pop_id);

        if ($pop_balance < $request->payable_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Pop balance is not enough',
            ]);
            exit;
        }

        try {
            /*Store recharge data*/
            $object = new Customer_recharge();
            $object->user_id = auth()->guard('admin')->user()->id;
            $object->customer_id = $request->customer_id;
            $object->pop_id = $request->pop_id;
            $object->area_id = $request->area_id;
            $object->recharge_month = implode(',', $request->recharge_month);

            if($request->transaction_type !=='due_paid'){
                /*Update Customer Table Expire date*/
                $customer = Customer::find($request->customer_id);
                $months_count = count($request->recharge_month);
                $base_date = (strtotime($customer->expire_date) > time())
                    ? $customer->expire_date
                    : date('Y-m-d');
                $new_expire_date = date("Y-m-d", strtotime("+$months_count months", strtotime($base_date)));
                $customer->expire_date = $new_expire_date;
                $customer->update();
                $object->paid_until = $new_expire_date;
            }



            $object->transaction_type = $request->transaction_type;
            $object->amount = $request->payable_amount;
            $object->note = $request->note;

            if ($object->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Recharge successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Recharge failed. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recharge failed! Error: ' . $e->getMessage()
            ], 500);
        }

    }
    public function customer_recharge_undo($id){
        $object = Customer_recharge::find($id);

        /*Update Customer Table Expire date*/
        $recharge_months = explode(',', $object->recharge_month);
        $months_count = count($recharge_months);
        $new_paid_until = date("Y-m-d", strtotime("-$months_count months", strtotime($object->paid_until)));
        $customer = Customer::find($object->customer_id);
        $customer->expire_date = $new_paid_until;
        $customer->update();

        if ($object) {
            $object->delete();
            return response()->json(['success' => true, 'message' => 'Successfully!']);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    public function customer_payment_history(){
        return view('Backend.Pages.Customer.Payment.payment_history');
    }
    public function customer_payment_history_get_all_data(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $columnsForOrderBy = ['id', 'created_at', 'id', 'recharge_month', 'transaction_type', 'paid_until', 'amount'];
        $orderByColumn = $request->order[0]['column'] ?? 0;
        $orderDirection = $request->order[0]['dir'] ?? 'desc';

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $query = Customer_recharge::with(['customer', 'customer.pop', 'customer.area', 'customer.package'])
            ->when($search, function ($query) use ($search) {
                $query->where('created_at', 'like', "%$search%")
                    ->orWhere('recharge_month', 'like', "%$search%")
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('fullname', 'like', "%$search%");
                    })
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('username', 'like', "%$search%");
                    });
            });
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->status_filter) {
            $query->where('transaction_type', $request->status_filter);
        }

        if ($request->bill_collect) {
            $query->where('user_id', $request->bill_collect);
        }
        $totalRecords = $query->count();
        //  $totalAmount = $query->where('transaction_type', '!=', '0')->sum('amount');
        $totalAmount = $query->sum('amount');
        $data = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
            'totalAmount' => $totalAmount,
        ]);
    }
    public function customer_log(){
        return view('Backend.Pages.Customer.Log.index');
    }
    public function customer_log_get_all_data(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $columnsForOrderBy = ['id', 'created_at', 'id', 'recharge_month', 'transaction_type', 'paid_until', 'amount'];
        $orderByColumn = $request->order[0]['column'] ?? 0;
        $orderDirection = $request->order[0]['dir'] ?? 'desc';

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $query = Customer_log::with(['customer','user'])
            ->when($search, function ($query) use ($search) {
                $query->where('created_at', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('fullname', 'like', "%$search%");
                    })
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('username', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $totalRecords = $query->count();

        $data = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }






    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules = [
           'fullname' => 'required|string|max:100',
            'phone' => 'required|string|max:15|unique:customers,phone',
            'nid' => 'nullable|string|max:20|unique:customers,nid',
            'address' => 'nullable|string',
            'username' => 'required|string|max:100|unique:customers,username',
            'password' => 'required|string|min:6',
            'package_id' => 'required|exists:branch_packages,id',
            'pop_id' => 'required|exists:pop_branches,id',
            'area_id' => 'required|exists:pop_areas,id',
            'router_id' => 'required|exists:routers,id',
            'status' => 'required|in:active,online,offline,blocked,expired,disabled',
            'liabilities' => 'required|in:YES,NO',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }
    }
}
