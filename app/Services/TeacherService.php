<?php
namespace App\Services;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;
use Illuminate\Http\Request;
class TeacherService{
    public static function validateTeacher(Request $request, $teacher = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers,email' . ($teacher ? ',' . $teacher->id : ''),
            'phone' => 'required|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'subject' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'address' => 'required|string|max:255',
            'photo' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'birth_date' => 'required|date',
            'national_id' => 'required|string|max:255|unique:teachers,national_id' . ($teacher ? ',' . $teacher->id : ''),
            'religion' => 'required|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'highest_education' => 'required|string|max:255',
            'previous_school' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'salary' => 'required|integer',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:15',
            'remarks' => 'nullable|string|max:500',
            'status'=>'nullable|integer'
        ];

        return Validator::make($request->all(), $rules);
    }

    public static function handleFileUpload(Request $request, $teacher = null) {
        if ($request->hasFile('photo')) {
            if ($teacher && $teacher->photo) {
                $photoPath = public_path('uploads/photos/' . $teacher->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/photos'), $filename);
            return $filename;
        }
        return $teacher ? $teacher->photo : null;
    }

    public static function setTeacherData(Teacher $teacher, Request $request, $filename) {
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->phone_2 = $request->phone_2;
        $teacher->subject = $request->subject;
        $teacher->hire_date = $request->hire_date;
        $teacher->address = $request->address;
        $teacher->photo = $filename;
        $teacher->father_name = $request->father_name;
        $teacher->mother_name = $request->mother_name;
        $teacher->gender = $request->gender;
        $teacher->birth_date = $request->birth_date;
        $teacher->national_id = $request->national_id;
        $teacher->religion = $request->religion;
        $teacher->blood_group = $request->blood_group;
        $teacher->highest_education = $request->highest_education;
        $teacher->previous_school = $request->previous_school;
        $teacher->designation = $request->designation;
        $teacher->salary = $request->salary;
        $teacher->emergency_contact_name = $request->emergency_contact_name;
        $teacher->emergency_contact_phone = $request->emergency_contact_phone;
        $teacher->remarks = $request->remarks;
        $teacher->status = $request->status ?? 1;
    }
}
