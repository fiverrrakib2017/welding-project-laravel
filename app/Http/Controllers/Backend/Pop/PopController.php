<?php
namespace App\Http\Controllers\Backend\Pop;
use App\Http\Controllers\Controller;
use App\Models\Pop_branch;
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
        return view('Backend.Pages.Pop.View',compact('pop'));
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
