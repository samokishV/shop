<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'category', 'slug', 'preview', 'original_img'
    ];

    /**
     * @param string $parentId
     * @param string $name
     * @param string $slug
     * @param string $fullImgName
     * @param string $smallImgName
     * @return Category
     */
    public static function store($parentId, $name, $slug,  $fullImgName, $smallImgName)
    {
        return Category::create(['parent_id' => $parentId, 'category' => $name, 'slug' => $slug, 'preview' => $smallImgName,
            'original_img' => $fullImgName]);
    }

    /**
     * @param int $id
     * @param string $parentId
     * @param string $name
     * @param string $slug
     * @param string $fullImgName
     * @param string $smallImgName
     * @return Category
     */
    public static function updateById($id, $parentId, $name, $slug,  $fullImgName, $smallImgName)
    {
        return Category::where('id', $id)
            ->update(['category' => $name, 'slug' => $slug, 'parent_id' => $parentId, 'preview' => $smallImgName,
                'original_img' => $fullImgName]);
    }

    /**
     * Select first level categories.
     *
     * @return Category
     */
    public static function firstLevelCategories()
    {
        return  Category::where('parent_id', '=', 0)->get();
    }
}
