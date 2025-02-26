<?php 
namespace App\Http\Controllers\Backend\Settings\Website;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Http\Controllers\Controller;
class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::all();
        return view('Backend.Pages.Settings.Website.Gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageName = time() . '.' . $request->image->extension();
       $request->image->move(public_path('Backend/uploads/photos/'),$imageName);

        Gallery::create(['image' => $imageName]);

        return back()->with('success', 'Image Uploaded Successfully!');
    }

    public function delete($id)
    {
        $gallery = Gallery::findOrFail($id);
        $imagePath = public_path('Backend/uploads/photos/' . $gallery->image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $gallery->delete();

        return back()->with('success', 'Image Deleted Successfully!');
    }
}
