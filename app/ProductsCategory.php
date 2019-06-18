<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'product_id'
    ];

    /**
     * @param int $categoryId
     * @param int $productId
     * @return mixed
     */
    public static function store($categoryId, $productId)
    {
        return ProductsCategory::create(['category_id' => $categoryId, 'product_id' => $productId]);
    }

    public static function updateCategoryId($categoryId, $productId)
    {
        return ProductsCategory::where('product_id', $productId)
            ->update(['category_id' => $categoryId]);
    }
}
