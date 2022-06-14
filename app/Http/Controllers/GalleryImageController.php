<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Image;

class GalleryImageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function storeImage(Request $request)
    {
        // return $request;
        
        $request->validate([
            'caption' => 'required|max:255',
            'category_name' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,bmp',
        ], [
            'category_name.required' => 'Please select a category',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = rand(1000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $thumbPath = public_path('userImages/thumb');
            $resize_image = Image::make($file->getRealPath());
            $resize_image->resize(300, 200, function ($c) {

            })->save($thumbPath . '/' . $image_name);
            $file->move(public_path('userImages'), $image_name);
        }
        GalleryImage::create([
            'user_id' => auth()->id(),
            'caption' => $request->caption,
            'category' => $request->category_name,
            'image' => $image_name,
        ]);
        return redirect()->back()->with('status', 'image uploaded successfully');
    }

    public function deleteImage($id)
    {
        $images = GalleryImage::find($id);
        // return $images;
        if (\File::exists(public_path('public/userImages' . $images->image))) {
            \File::delete(public_path('public/userImages' . $images->image));
            \File::delete(public_path('public/userImages/thumb' . $images->image));
        }
        $images->delete();
        return redirect()->back()->with('status', 'image deleted');
    }

//     @if (session('status'))
//     <div class="alert alert-success" role="alert">
//         {{ session('status') }}
//     </div>
// @endif
}
