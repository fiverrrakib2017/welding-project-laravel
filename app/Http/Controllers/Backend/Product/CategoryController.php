<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Product.Category.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'category_name'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $object = Product_Category::when($search, function ($query) use ($search) {
            $query->where('category_name', 'like', "%$search%");
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

        $object = new Product_Category();
        $object->category_name = $request->name;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!'
        ]);
    }


    public function delete(Request $request)
    {
        $object = Product_Category::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Category not found.'], 404);
        }
        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' =>true, 'message'=> 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Product_Category::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit;
        } else {
            return response()->json(['success' => false, 'message' => 'Category not found.']);
        }
    }


    public function update(Request $request, $id)
    {

        $this->validateForm($request);

        $object = Product_Category::findOrFail($id);
        $object->category_name = $request->name;
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
            'category_name' => 'required|string',
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
