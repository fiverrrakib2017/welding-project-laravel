<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product_Category;
use App\Models\Product_sub_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubCateogryController extends Controller
{
    public function index(){
        $category=Product_Category::latest()->get();
        $data=Product_sub_category::latest()->with('category')->get();
        return view('Backend.Pages.Product.Sub-Category.index',compact('data','category'));
    }
    public function get_sub_category($id){
        $data=Product_sub_category::where(['category_id'=>$id])->get();
        return response()->json($data);
    }
    public function edit($id){
        $category=Product_Category::latest()->get();
        $sub_category=Product_sub_category::find($id);
        return view('Backend.Pages.Product.Sub-Category.Update',compact('sub_category','category'));
    }
    public function store(Request $request){
         //Validate the form data
         $rules = [
            'cat_id' => 'required',
            'sub_cat_name' => 'required',
            'status' => 'required|in:1,0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }
       
       
        // Create a new brand object
        $brand = new Product_sub_category();
        $brand->category_id=$request->cat_id;
        $brand->name=$request->sub_cat_name;
        $brand->status=$request->status;
        // Save  to the database
        $brand->save();
         // Redirect or return a response as needed
        return redirect()->route('admin.subcategory.index')->with('success','Add Successfully');
    }
    public function delete(Request $request){
      
        $object = Product_sub_category::findOrFail($request->id);      

        // Delete the brand from the database
        $object->delete();
        return redirect()->route('admin.subcategory.index')->with('success','Delete Successfull');
    }
    public function update(Request $request , $id){
        $rules = [
            'cat_id' => 'required',
            'sub_cat_name' => 'required',
            'sub_cat_status' => 'required|in:1,0',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }

         $category=Product_sub_category::find($id);
         $category->category_id=$request->cat_id;
         $category->name=$request->sub_cat_name;
        $category->status=$request->sub_cat_status;
        $category->update();

         return redirect()->route('admin.subcategory.index')->with('success','Update Successfully');
    }
}
