<?php

namespace App\Http\Controllers\Backend\Settings\Website;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    public function index(){
        return view('Backend.Pages.Settings.Website.Contract.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name','email','message'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Contract::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            $query->where('email', 'like', "%$search%");
            $query->where('message', 'like', "%$search%");
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
        $object = new Contract();
        $object->name = $request->name;
        $object->email = $request->email;
        $object->message = $request->message;

        /* Save to the database table*/
        $object->save();
        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }


    public function delete(Request $request)
    {
        $object = Contract::find($request->id);

        if (empty($object)) {
            return response()->json(['success'=>false,'message' => 'Contract not found.'], 404);
        }


        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }

    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
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
