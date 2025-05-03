<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class userController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.User.index');
    }
    public function create(){
        return view('Backend.Pages.User.Create');
    }
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $this->validateForm($request);
    
            /*Check if password and confirm password match*/ 
            if ($request->password !== $request->confirm_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password and Confirm Password do not match',
                ]);
            }
    
            $student = new Admin();
            $student->name = $request->name;
            $student->username = $request->username;
            $student->email = $request->email;
            $student->phone = $request->mobile_number;
            $student->password = bcrypt($request->password);
            $student->password_text = $request->password;
            $student->user_type = '2';
            $student->save();
    
            return response()->json([
                'success' => true,
                'message' => 'User Created Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function edit($id)
    {
       if(empty($id)){
        return ([
            'success' => false,
            'message' => 'User Not Found',
        ]);
        exit; 
       }
       $data=Admin::find($id);
        return view('Backend.Pages.User.Update',compact('data'));
    }
    public function update(Request $request, $id)
{
    try {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,' . $id,
            'email' => 'required|email|max:255|unique:admins,email,' . $id,
            'mobile_number' => 'required|string|max:20',
            'password' => 'required',
        ]);

        if(isset($request->password) || isset($request->confirm_password)){
            if (trim($request->password) !== trim($request->confirm_password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password and Confirm Password do not match',
                ]);
                exit; 
            }
        }

        // Find the user
        $object = Admin::findOrFail($id);

        // Update basic fields
        $object->name = $request->name;
        $object->username = $request->username;
        $object->email = $request->email;
        $object->phone = $request->mobile_number;

        // If password is provided, update it
        if (!empty($request->password)) {
            $object->password = bcrypt($request->password);
            $object->password_text = $request->password;
        }

        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'User Updated Successfully',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

   
    public function delete(Request $request)
    {
        $object = Admin::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }
        /* Delete it From Database Table */
        $object->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    
    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:admins,username',
            'phone' => 'required|unique:admins,mobile_number',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
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
