<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 */
class Product extends Model
{
    /**
     * @return Product
     */
    public static function findPromo()
    {
        return DB::select('select * from products where promo = 1');
    }

    /**
     * @param string $slug | category slug
     * @return Product
     */
    public static function findByCategory($slug)
    {
        return DB::table('categories')
            ->join('product_category', 'categories.id', '=', 'product_category.category_id')
            ->join('products', 'product_category.product_id', '=', 'products.id')
            ->where('categories.slug', '=', $slug)
            ->select('products.*', 'categories.slug as catSlug')
            ->paginate(2);
    }

    /**
     * @param string $slug
     * @return Product
     */
    public static function findBySlug($slug)
    {
        $product = DB::select('select * from products where slug = ?', [$slug]);
        return $product[0];
    }
}
