<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student_exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exam_controller extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Student.Exam.index');
    }

    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name','year','start_date', 'end_date'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Student_exam::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            $query->where('year', 'like', "%$search%");
            $query->where('start_date', 'like', "%$search%");
            $query->where('end_date', 'like', "%$search%");
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

        $object = new Student_exam();
        $object->name = $request->name;
        $object->year = $request->year;
        $object->start_date = $request->start_date;
        $object->end_date = $request->end_date;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Student_exam::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Examincation not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Student_exam::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Data Not Found.']);
        }
    }
    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Student_exam::findOrFail($id);
        $object->name = $request->name;
        $object->year = $request->year;
        $object->start_date = $request->start_date;
        $object->end_date = $request->end_date;
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
            'year' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
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
