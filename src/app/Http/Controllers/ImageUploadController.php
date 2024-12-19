<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageUploadController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function index()
    {
        $images = Image::all();

        return view('image', ['path' => $images]);
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        $path = $image->store('public/image');

        $model = new Image;
        $model->image_name = $path;
        $model->save();

        return redirect()->rpute('image');
    }
}
