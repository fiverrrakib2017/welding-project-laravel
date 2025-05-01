<?php

namespace App\Http\Controllers\Backend\Signature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Signature;

class SignatureController extends Controller
{
    public function index()
    {
        $data = Signature::latest()->get();
        return view('Backend.Pages.Signature.index', compact('data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageName = time() . '.' . $request->image->extension();
       $request->image->move(public_path('Backend/uploads/photos/'),$imageName);

       $object=new Signature();
       $object->name=$imageName;
       $object->user_id = Auth::guard('admin')->user()->id;
       $object->save();

        return response()->json([
            'success' => true,
            'message' => 'Signature Image Uploaded Successfully!',
        ]);
    }

    public function delete($id)
    {
        $gallery = Signature::findOrFail($id);
        $imagePath = public_path('Backend/uploads/photos/' . $gallery->image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image Deleted Successfully!',
        ]);
    }

}
