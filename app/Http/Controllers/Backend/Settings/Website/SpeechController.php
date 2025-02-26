<?php

namespace App\Http\Controllers\Backend\Settings\Website;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Speech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeechController extends Controller
{
    
    public function index(){
        return view('Backend.Pages.Settings.Website.Speech.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['title','description','image'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Speech::when($search, function ($query) use ($search) {
           
            $query->where('title', 'like', "%$search%");
            $query->where('description', 'like', "%$search%");
            $query->where('image', 'like', "%$search%");
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

        $object = new Speech();
        $object->title=$request->title;
        $object->position=$request->position ?? 1;
        $object->description=$request->description;
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
        $object = Speech::find($request->id);

        if (empty($object)) {
            return response()->json(['success'=>false,'message' => 'Speech not found.'], 404);
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

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Speech::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Speech not found.']);
        }
    }
    

    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Speech::findOrFail($id);
        $object->title=$request->title;
        $object->description=$request->description;
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
            'message' => 'Speech Update successfully!'
        ]);
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
            'title' => 'required',
            'description' => 'required',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
