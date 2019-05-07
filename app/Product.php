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
     * @param string $order
     * @param string $price
     * @return Product
     */
    public static function findByCategory($slug, $order, $price = null)
    {
        $sort = self::sortCondition($order);

        return DB::table('categories')
            ->join('product_category', 'categories.id', '=', 'product_category.category_id')
            ->join('products', 'product_category.product_id', '=', 'products.id')
            ->where('categories.slug', '=', $slug)
            ->when($price, function ($query) use ($price) {
                return $query->where('price', '<=', $price);
            })
            ->select('products.*', 'categories.slug as catSlug')
            ->when($sort, function ($query) use ($sort) {
                return $query->orderBy($sort['field'], $sort['type']);
                    })
            ->paginate(2);
    }

    /**
     * @param string $order | "price-asc"
     * @return array | null
     */
    public static function sortCondition($order)
    {
        if($order!='default') {
            $sort = explode("-", $order);
            $sort['field'] = $sort[0];
            $sort['type'] = $sort[1];
        } else {
            $sort = null;
        }

        return $sort;
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

    /**
     * @param string $keyword
     * @return array
     */
    public static function searchByKeyword($keyword)
    {
        $products =  DB::table('categories')
            ->join('product_category', 'categories.id', '=', 'product_category.category_id')
            ->join('products', 'product_category.product_id', '=', 'products.id')
            ->where('title', 'LIKE', "%{$keyword}%")
            ->select('products.*', 'categories.category')
            ->get();

        // group products by category

        $result = array();
        foreach ($products as $product) {
           $result[$product->category][] = $product;
        }

        return $result;
    }
}
