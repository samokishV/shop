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
        // storage path storage/app/public
        $storagePath = $file->store('/public');
        $fullImgName = basename($storagePath);
        return 'storage/'.$fullImgName;
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
        $fullPath = public_path('storage/').$fileName;

        // proportionally reduce the size of the image and add white fields
        $img->resize(290, 430, function ($constraint) {
            $constraint->aspectRatio();
        })->resizeCanvas(290, 430, 'center', false, '#ffffff')
        ->save($fullPath);

        return 'storage/'.$fileName;
    }

    /**
     * @param string $path
     */
    public static function deleteOriginal($path)
    {
        File::delete($path);
    }

    /**
     * @param string $path
     */
    public static function deletePreview($path)
    {
        File::delete($path);
    }
}
