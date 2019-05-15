<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    /**
    * @param $image
    * @return string
    */
    public function uploadImages(Request $request, $image)
    {
        return Image::make(storage_path().'/app/img/'.$image)->response();
    }
}