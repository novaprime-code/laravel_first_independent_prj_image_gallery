<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = GalleryImage::where('user_id', auth()->id());

        // $query = GalleryImage::all();
        // return $query;
        // $query = GalleryImage::where('user_id');
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->sortby) {
            $order = ($request->sortby == 'oldest') ? 'asc' : 'desc';
            $query->orderBy('created_at', $order)->get();
        } else {
            $query->orderBy('created_at', 'desc')->get();
        }
        $data['images'] = $query->paginate(4);
        return view('home', $data);
    }
    public function createCategory()
    {

    }
    public function categoryStore(Request $request)
    {

    }
}
