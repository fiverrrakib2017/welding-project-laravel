<?php
namespace App\Http\Controllers\Backend\Product;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Product.Store.index');

    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'brand_name'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Store::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            $query->where('phone_number', 'like', "%$search%");
            $query->where('address', 'like', "%$search%");
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

        $object = new Store();
        $object->name = $request->name;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        $object->note = $request->note;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Store::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Store not found.'], 404);
        }
        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Store::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Store not found.']);
        }
    }


    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $object = Store::findOrFail($id);
        $object->name = $request->name;
        $object->phone_number = $request->phone_number;
        $object->address = $request->address;
        $object->note = $request->note;
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
            'phone_number' => 'required',
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
