<?php
namespace App\Http\Controllers\Backend\Customer;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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

    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id','id','fullname','package','amount','created_at','expire_date','username','phone','pop_id','area_id','created_at','created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];

        $query = Customer::with(['pop','area','package'])->when($search, function ($query) use ($search) {
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
        $customer->expire_date = $request->expire_date;
        $customer->remarks = $request->remarks;
        $customer->liabilities = $request->liabilities;

        /* Save to the database table*/
        $customer->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!',
        ]);
    }

    public function delete(Request $request)
    {
        $object = Customer::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
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

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $object = Package::findOrFail($id);
        $object->pool_id = $request->pool_id;
        $object->name = $request->name;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!',
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
