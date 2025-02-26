<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product_Category;
use App\Models\Product_child_category;
use App\Models\Product_sub_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChildCategoryController extends Controller
{
    public function index(){
        $category=Product_Category::latest()->get();
        $sub_category=Product_sub_category::latest()->get();
        $child_category=Product_child_category::latest()->with('category','sub_category')->get();
        return view('Backend.Pages.Product.Child-Category.index',compact('category','sub_category','child_category'));
    }
    public function get_child_category($id){
        $data=Product_child_category::where(['sub_cat_id'=>$id])->get();
        return response()->json($data);
    }
    public function edit($id){
        $category=Product_Category::latest()->get();
        $sub_category=Product_sub_category::latest()->get();
        $child_category=Product_child_category::find($id);
        return view('Backend.Pages.Product.Child-Category.Update',compact('category','sub_category','child_category'));
    }
    public function store(Request $request){
         //Validate the form data
         $rules = [
            'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'child_cat_name' => 'required',
            'child_cat_status' => 'required|in:1,0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }
       
       
        // Create a new brand object
        $brand = new Product_child_category();
        $brand->category_id=$request->cat_id;
        $brand->sub_cat_id=$request->sub_cat_id;
        $brand->name=$request->child_cat_name;
        $brand->status=$request->child_cat_status;
        // Save  to the database
        $brand->save();
         // Redirect or return a response as needed
        return redirect()->route('admin.childcategory.index')->with('success','Add Successfully');
    }
    public function delete(Request $request){
      
        $object = Product_child_category::findOrFail($request->id);      

        // Delete data from the database
        $object->delete();
        return redirect()->route('admin.childcategory.index')->with('success','Delete Successfull');
    }
    public function update(Request $request , $id){
        $rules = [
            'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'child_cat_name' => 'required',
            'child_cat_status' => 'required|in:1,0',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors()->all())->withInput();
        }

         $category=Product_child_category::find($id);
         $category->category_id=$request->cat_id;
         $category->sub_cat_id=$request->sub_cat_id;
         $category->name=$request->child_cat_name;
        $category->status=$request->child_cat_status;
        $category->update();

         return redirect()->route('admin.childcategory.index')->with('success','Update Successfully');
    }
}
