<?php

namespace App\Http\Controllers\Backend\Settings\Website;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    
    public function index(){
        return view('Backend.Pages.Settings.Website.Slider.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['image'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Slider::when($search, function ($query) use ($search) {
           
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

        $object = new Slider();
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
        $object = Slider::find($request->id);

        if (empty($object)) {
            return response()->json(['success'=>false,'message' => 'Slider not found.'], 404);
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
        $data = Slider::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Slider not found.']);
        }
    }
    

    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Slider::findOrFail($id);
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
            'message' => 'Slider Update successfully!'
        ]);
    }
    private function validateForm($request)
    {

        /*Validate the form data*/
        $rules=[
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
