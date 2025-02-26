<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Temp_Image;
use App\Models\Template_Image;
use Illuminate\Http\Request;

class TempImageController extends Controller
{
    public function create(Request $request){
        $image = $request->image;

        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '.' . $ext;
            $tempImage = new Temp_Image();
        
            $tempImage->name = $newName;
            $tempImage->save();
        
            $image->move(public_path('temp'), $newName);
        
            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'imagePath' => asset('temp/' . $newName),
                'message' => 'Image uploaded successfully'
            ]);
        }
        
    }
}
