<?php

namespace App\Http\Controllers\Backend\Settings\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index(){
        return view('Backend.Pages.Settings.Website.Banner.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'title','description','images'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Banner::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%$search%");
            $query->where('description', 'like', "%$search%");
            $query->where('images', 'like', "%$search%");
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
        $object = new Banner();
        $object->title = $request->title;
        $object->description = $request->description;
        if($request->hasFile('images')){
            $image = $request->file('images');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('Backend/uploads/photos/'),$imageName);
            $object->image = $imageName;
        }
        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added Successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Banner::find($request->id);

        if (empty($object)) {
            return response()->json(['success'=>false,'message' => 'Banner not found.'], 404);
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

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Banner::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Banner not found.']);
        }
    }
    

    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Banner::findOrFail($id);
        $object->title = $request->title;
        $object->description = $request->description;
        if($request->hasFile('images')){
            /*Delete Previous Images*/
            $imagePath = public_path('Backend/uploads/photos/' . $object->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            /*Upload New Images*/
            $image = $request->file('images');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('Backend/uploads/photos/'),$imageName);
            $object->image = $imageName;
        }
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Banner Update successfully!'
        ]);
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'title' => 'required',
            'description' => 'required',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
