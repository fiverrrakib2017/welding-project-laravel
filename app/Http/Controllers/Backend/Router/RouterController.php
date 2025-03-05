<?php
namespace App\Http\Controllers\Backend\Router;
use App\Http\Controllers\Controller;
use App\Models\Pop_branch;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RouterController extends Controller
{
    public function index()
    {
        $routers=Router::latest()->get();
        return view('Backend.Pages.Router.index',compact('routers'));
    }


    public function store(Request $request)
    {
        /* Validate the form data*/
        $this->validateForm($request);

        /* Create a new Supplier*/
        $object = new Router();
        $object->name = $request->name;
        $object->ip_address = $request->ip_address;
        $object->username = $request->username;
        $object->password = $request->password;
        $object->port = $request->port;
        $object->status = $request->status;
        $object->api_version = $request->api_version;
        $object->location = $request->location;
        $object->remarks = $request->remarks;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Router::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Router::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }

    public function update(Request $request, $id){
        $this->validateForm($request);

        $object = Router::findOrFail($id);
        $object->name = $request->name;
        $object->ip_address = $request->ip_address;
        $object->username = $request->username;
        $object->password = $request->password;
        $object->port = $request->port;
        $object->status = $request->status;
        $object->api_version = $request->api_version;
        $object->location = $request->location;
        $object->remarks = $request->remarks;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!',
        ]);
    }



    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'name' => 'required|string|max:100',
            'ip_address' => 'required|ip',
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:100',
            'port' => 'required|numeric',
            'status' => 'required|in:active,inactive',
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
