<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(){
        return view('Backend.Pages.Product.Color.index');
     }
     public function get_all_data(Request $request){
         $search = $request->search['value'];
         $columnsForOrderBy = ['id', 'name','status', 'created_at'];
         $orderByColumn = $request->order[0]['column'];
         $orderDirectection = $request->order[0]['dir'];
     
         $object = Color::when($search, function ($query) use ($search) {
             $query->where('name', 'like', "%$search%");
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
     public function store(Request $request){
         $request->validate([
             'name' => 'required|string|max:255',
             'status' => 'required|in:0,1',
         ]);
         
         // Create a new Color instance
         $category = new Color();
         $category->name = $request->name;
         $category->status = $request->status;
         $category->save();
 
         return response()->json(['success' =>true, 'message'=> 'Added Successfully']);
     }
     public function edit($id){
         $data = Color::find($id);
 
         return response()->json(['success'=>true,'data' => $data]); 
     }
     public function delete(Request $request){
         $data = Color::find($request->id);
 
         if (!$data) {
             return response()->json(['error' => 'not found']);
         }
         // Delete the data
         $data->delete();
 
         return response()->json(['success' =>true, 'message'=> 'Deleted successfully']); 
     }
     public function update(Request $request){
         $request->validate([
             'name' => 'required|string|max:255',
             'status' => 'required|in:0,1',
         ]);
         
         // Create a new  instance
         $category =Color::find($request->id);
         $category->name = $request->name;
         $category->status = $request->status;
         $category->update();
 
         return response()->json(['success' =>true, 'message'=> 'Update successfully']); 
     }
}
