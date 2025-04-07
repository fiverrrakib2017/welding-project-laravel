<?php

namespace App\Http\Controllers\Backend\Settings\Website;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Banner;
use App\Models\Exam_cornar;
use App\Models\Section;
use App\Models\Teacher_corner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherCornerController extends Controller
{
    public function index()
    {
        $sections = Section::latest()->get();

        return view('Backend.Pages.Settings.Website.Teacher_corner.index', compact('sections'));
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'class_id', 'section_id', 'subject_id', 'teacher_id', 'lession', 'file'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $query = Teacher_corner::with(['class', 'section', 'subject', 'teacher'])->when($search, function ($query) use ($search) {
            $query
                ->where('lession', 'like', "%$search%")
                ->orWhereHas('class', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('section', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('teacher', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('subject', function ($query) use ($search) {
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
        $object = new Teacher_corner();
        $object->class_id = $request->class_id;
        $object->section_id = $request->section_id;
        $object->subject_id = $request->subject_id;
        $object->teacher_id = $request->teacher_id;
        $object->lession = $request->lession;
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Backend/uploads/photos/'), $imageName);
            $object->image = $imageName;
        }
        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully!',
        ]);
    }

    public function delete(Request $request)
    {
        $object = Teacher_corner::find($request->id);

        if (empty($object)) {
            return response()->json(['success' => false, 'message' => 'Teacher cornar not found.'], 404);
        }

        /* Image Find And Delete it From Local Machine */
        if (!empty($object->image)) {
            $imagePath = public_path('Backend/uploads/photos/' . $object->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Teacher_corner::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit();
        } else {
            return response()->json(['success' => false, 'message' => 'Teacher Cornar not found.']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $object = Teacher_corner::findOrFail($id);
        $object->class_id = $request->class_id;
        $object->section_id = $request->section_id;
        $object->subject_id = $request->subject_id;
        $object->teacher_id = $request->teacher_id;
        $object->lession = $request->lession;
        if ($request->hasFile('images')) {
            /*Delete Previous Images*/
            $imagePath = public_path('Backend/uploads/photos/' . $object->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            /*Upload New Images*/
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Backend/uploads/photos/'), $imageName);
            $object->image = $imageName;
        }
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Teacher Cornar Update successfully!',
        ]);
    }
    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules = [
            'title' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'lession' => 'required',
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
