<?php
namespace App\Http\Controllers\Backend\Customer;
use App\Http\Controllers\Controller;
use App\Models\Ip_pools;
use App\Models\Pop_area;
use App\Models\Pop_branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PoolController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Customer.Pool.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'router_id', 'name','start_ip',	'end_ip','netmask','gateway','dns'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $query = Ip_pools::with(['router'])->when($search, function ($query) use ($search) {
            $query
                ->where('name', 'like', "%$search%")
                ->where('start_ip', 'like', "%$search%")
                ->where('end_ip', 'like', "%$search%")
                ->where('netmask', 'like', "%$search%")
                ->where('gateway', 'like', "%$search%")
                ->where('dns', 'like', "%$search%")
                ->orWhereHas('router', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        });

        $total = $query->count();

        $query = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirectection);

        $items = $query->skip($request->start)->take($request->length)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $items,
        ]);
    }
    public function store(Request $request)
    {
        /* Validate the form data*/
        $this->validateForm($request);

        /* Create a new Supplier*/
        $object = new Ip_pools();
        $object->router_id = $request->router_id;
        $object->name = $request->name;
        $object->start_ip = $request->start_ip;
        $object->end_ip = $request->end_ip;
        $object->netmask = $request->netmask;
        $object->gateway = $request->gateway;
        $object->dns = $request->dns;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!',
        ]);
    }

    public function delete(Request $request)
    {
        $object = Ip_pools::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Ip_pools::find($id);
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

        $object = Ip_pools::findOrFail($id);
        $object->router_id = $request->router_id;
        $object->name = $request->name;
        $object->start_ip = $request->start_ip;
        $object->end_ip = $request->end_ip;
        $object->netmask = $request->netmask;
        $object->gateway = $request->gateway;
        $object->dns = $request->dns;
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
            'router_id' => 'required|string',
            'name' => 'required|string',
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
