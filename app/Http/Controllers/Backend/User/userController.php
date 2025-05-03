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
        $student = DB::table('students')->where('id', $id)->first();
        $courses = DB::table('courses')->get();
        return view('Backend.Pages.Student.edit', compact('student', 'courses'));
    }
    public function view($id)
    {
        $student = DB::table('students')->where('id', $id)->first();
        return view('Backend.Pages.Student.Profile', compact('student'));
    }
    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->nid_or_passport = $request->nid_or_passport;
        $student->father_name = $request->father_name;
        $student->mobile_number = $request->mobile_number;
        $student->permanent_address = $request->permanent_address;
        $student->present_address = $request->present_address;
        $student->course = implode(',', $request->courses);
        $student->course_duration = $request->course_duration ?? '';
        $student->course_end = $request->course_end ?? '';
        $student->update();
        /*Student Log*/
        $object = new Student_log();
        $object->student_id = $student->id;
        $object->action_type = 'edit';
        $object->user_id = Auth::guard('admin')->user()->id;
        $object->description = 'Student updated: ' . $student->name;
        $object->ip_address = request()->ip();
        $object->save();
        /*End Student Log*/
        return response()->json([
            'success' => true,
            'message' => 'Student Updated Successfully',
        ]);
    }
    public function student_certificate($id)
    {
        $student = Student::with('course')->where('id', $id)->first();
        if (empty($student)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        return view('Backend.Pages.Student.certificate', compact('student'));
    }
    public function delete(Request $request)
    {
        $object = Student::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->is_delete = 1;
        $object->save();
        /*Student Log*/
        $log = new Student_log();
        $log->student_id = $object->id;
        $log->action_type = 'delete';
        $log->user_id = Auth::guard('admin')->user()->id;
        $log->description = 'Student deleted: ' . $object->name;
        $log->ip_address = request()->ip();
        $log->save();
        /*End Student Log*/

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function student_restore(Request $request){
        $object = Student::find($request->id);
        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->is_delete = '0';
        $object->save();
        /*Student Log*/
        $log = new Student_log();
        $log->student_id = $object->id;
        $log->action_type = 'delete';
        $log->user_id = Auth::guard('admin')->user()->id;
        $log->description = 'Student Restore: ' . $object->name;
        $log->ip_address = request()->ip();
        $log->save();
        /*End Student Log*/

        return response()->json(['success' => true, 'message' => 'Restore successfully.']);
    }
    public function recycle_delete(Request $request)
    {
        $object = Student::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }
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
