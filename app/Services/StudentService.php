<?php
namespace App\Services;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Models\Student_class;
use App\Models\Student_docs;
use Illuminate\Http\Request;
class StudentService{
    public static function validate(Request $request, $teacher = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'roll_no' => 'nullable|integer',
            'gender' => 'required|string|max:10',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'current_class' => 'required|max:50',
            'section_id' => 'required|max:50',
            'previous_school' => 'nullable|string|max:255',
            'previous_class' => 'nullable|max:50',
            'academic_results' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'health_conditions' => 'nullable|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:15',
            'religion' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
            'status'=>'nullable'
        ];

        return Validator::make($request->all(), $rules);
    }

    public static function handleFileUpload(Request $request, $student = null) {
        if ($request->hasFile('photo')) {
            if ($student && $student->photo) {
                $photoPath = public_path('uploads/photos/' . $student->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/photos'), $filename);
            return $filename;
        }
        return $student ? $student->photo : null;
    }

    public static function setData(Student $student, Request $request, $filename) {
        $student->name = $request->name;
        $student->birth_date = $request->birth_date;
        $student->roll_no = $request->roll_no;
        $student->gender = $request->gender;
        $student->father_name = $request->father_name;
        $student->mother_name = $request->mother_name;
        $student->guardian_name = $request->guardian_name;
        $student->photo = $filename;
        $student->current_address = $request->current_address;
        $student->permanent_address = $request->permanent_address;
        $student->phone = $request->phone;
        $student->phone_2 = $request->phone_2;
        $student->current_class = $request->current_class;
        $student->section_id = $request->section_id;
        $student->previous_school = $request->previous_school;
        $student->academic_results = $request->academic_results;
        $student->blood_group = $request->blood_group;
        $student->health_conditions = $request->health_conditions;
        $student->emergency_contact_name = $request->emergency_contact_name;
        $student->emergency_contact_phone = $request->emergency_contact_phone;
        $student->religion = $request->religion;
        $student->nationality = $request->nationality;
        $student->remarks = $request->remarks;
    }
    // public function get_data(Request $request)
    // {
    //     $search = $request->search['value'];

    //     $columnsForOrderBy = ['id', 'name', 'current_class'];

    //     $orderByColumn = $request->order[0]['column'];
    //     $orderDirection = $request->order[0]['dir'];

    //     $query = Student::with(['currentClass', 'currentClass.section']);

    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('name', 'like', "%$search%")
    //             ->orWhere('gender', 'like', "%$search%")
    //             ->orWhere('phone', 'like', "%$search%")
    //             ->orWhere('phone_2', 'like', "%$search%");
    //         });
    //     }

    //     if (isset($columnsForOrderBy[$orderByColumn])) {
    //         $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection);
    //     }

    //     $total = $query->count();

    //     $data = $query->skip($request->start)->take($request->length)->get();

    //     return response()->json([
    //         'draw' => $request->draw,
    //         'recordsTotal' => $total,
    //         'recordsFiltered' => $total,
    //         'data' => $data,
    //     ]);
    // }
    public function get_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'current_class'];
        $orderByColumn = $columnsForOrderBy[$request->order[0]['column']];
        $orderDirection = $request->order[0]['dir'];

        $query = Student::with(['currentClass'])->when($search, function ($query) use ($search) {

            $query->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")

                //   ->orWhereHas('currentClass', function ($query) use ($search) {
                //       $query->where('name', 'like', "%$search%")
                //             ->orWhere('district_name_en', 'like', "%$search%");
                //   })
                  ->orWhereHas('currentClass', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  });
        });

        if ($request->has('class_id') && !empty($request->class_id)) {
            $query->where('current_class', $request->class_id);
        }

        $total = $query->count();
        $items = $query->orderBy($orderByColumn, $orderDirection)
                       ->skip($request->start)
                       ->take($request->length)
                       ->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $items,
        ]);
    }
    public function view($id){
         $student = Student::with('currentClass')->find($id);
         $student_docs=Student_docs::where(['student_id' => $student->id])->get();
        if ($student) {
            return view('Backend.Pages.Student.view',compact('student','student_docs'));
        }
    }
    public function edit($id){
        $data = Student::find($id);
        $class_data=Student_class::latest()->get();
        if ($data) {
            return view('Backend.Pages.Student.edit',compact('data','class_data'));
        }
    }
}
