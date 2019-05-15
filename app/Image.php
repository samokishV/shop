<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Img;
use Illuminate\Support\Facades\File;

class Image
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public static function saveOriginal($file)
    {
        $fullImgName = $file->store('img');
        return $fullImgName;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public static function savePreview($file)
    {
        $img = Img::make($file->getRealPath());
        $ext = $file->getClientOriginalExtension();
        $fileName = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

        $fileName = 'small_'.$fileName.".".$ext;
        $fullPath = storage_path('/app/img/'.$fileName);

        // proportionally reduce the size of the image and add white fields
        $img->resize(290, 430, function ($constraint) {
            $constraint->aspectRatio();
        })->resizeCanvas(290, 430, 'center', false, '#ffffff')
        ->save($fullPath);

        return "img/".$fileName;
    }

    /**
     * @param string $path
     */
    public static function deleteOriginal($path)
    {
        File::delete(storage_path('/app/'.$path));
    }

    /**
     * @param string $path
     */
    public static function deletePreview($path)
    {
        File::delete(storage_path('/app/'.$path));
    }
}