<?php

namespace App\Http\Controllers\Backend\Settings\Website;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Settings.Website.Notice.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $columnsForOrderBy = ['title', 'description', 'image'];
        $orderByColumn = $request->order[0]['column'] ?? 0;
        $orderDirection = $request->order[0]['dir'] ?? 'asc';

        /*Notice and  News  (post_type = 1 for Notice, 2 for News)*/
        $postType = $request->post_type ?? null;

        $query = Notice::when($postType, function ($query) use ($postType) {
            return $query->where('post_type', $postType);
        })->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('image', 'like', "%$search%");
            });
        });

        $total = $query->count();

        $items = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)->skip($request->start)->take($request->length)->get();

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

        $object = new Notice();
        $object->title = $request->title;
        $object->description = $request->description;
        $object->post_type = $request->post_type;
        $object->notice_type = $request->notice_type;
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
        $object = Notice::find($request->id);

        if (empty($object)) {
            return response()->json(['success' => false, 'message' => 'Speech not found.'], 404);
        }

        /* Image Find And Delete it From Local Machine */
        if (!empty($object->image)) {
            $imagePath = public_path('uploads/photos/' . $object->image);

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
        $data = Notice::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit();
        } else {
            return response()->json(['success' => false, 'message' => 'Notice not found.']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $object = Notice::findOrFail($id);
        $object->title = $request->title;
        $object->description = $request->description;
        $object->post_type = $request->post_type;
        $object->notice_type = $request->notice_type;
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
            'message' => 'Notice Update successfully!',
        ]);
    }
    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'post_type' => 'required|integer|in:1,2',
            'notice_type' => 'required|integer|in:1,2',
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
