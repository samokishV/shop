<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Category extends Model
{
    /**
     * @param string $name
     * @param string $slug
     * @param UploadedFile $image
     */
    public static function store($name, $slug, $image)
    {
        $category = new Category();
        $category->category = $name;
        $category->slug = $slug;

        $fullImgName = Image::saveOriginal($image);
        $smallImgName =  Image::savePreview($image);

        $category->preview = $smallImgName;
        $category->original_img = $fullImgName;

        $category->save();
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param UploadedFile $image
     */
    public static function updateById($id, $name, $slug, $image)
    {
        $category = Category::find($id);

        DB::table('categories')
            ->where('id', $id)
            ->update(['category' => $name, 'slug' => $slug]);

        if($image) {
            // delete old images from folder
            Image::deleteOriginal($category->original_img);
            Image:: deletePreview($category->preview);
            // save new images
            $fullImgName = Image::saveOriginal($image);
            $smallImgName =  Image::savePreview($image);

            $category->preview = $smallImgName;
            $category->original_img = $fullImgName;

            DB::table('categories')
                ->where('id', $id)
                ->update(['preview' => $smallImgName, 'original_img' => $fullImgName]);
        }
    }

    /**
     * @param int $id
     */
    public static function deleteById($id)
    {
        $category = Category::find($id);

        Image::deleteOriginal($category->original_img);
        Image:: deletePreview($category->preview);

        $category->delete();
    }
}
