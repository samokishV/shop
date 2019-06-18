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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'price', 'promo', 'in_stock', 'additional', 'preview', 'original_img'
    ];

    /**
     * @return Product
     */
    public static function findPromo()
    {
        return Product::where('promo', '=', 1)->get();
    }

    /**
     * @param array $ids | [0 => string, 1 => string, ...]
     * @param array | null $sort
     * @param string $price
     * @return Product
     */
    public static function findByCategory($ids, $sort, $price = null)
    {
        return DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
            ->whereIn('categories.id', $ids)
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
     * @param string $slug
     * @return Product
     */
    public static function findBySlug($slug)
    {
        return Product::where('slug', '=', $slug)->first();
    }

    /**
     * @param string $keyword
     * @return array
     */
    public static function searchByKeyword($keyword)
    {
        return  DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
            ->where('title', 'LIKE', "%{$keyword}%")
            ->select('products.*', 'categories.category')
            ->get();
    }

    /**
     * @return Product
     */
    public static function findAll()
    {
        return  DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
            ->select('products.*', 'categories.id as catId')
            ->get();
    }

    /**
     * @param int $id
     * @return Product
     */
    public static function findById($id)
    {
        return  DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
            ->where('products.id', '=', $id)
            ->select('products.*', 'categories.id as category_id')
            ->get();
    }

    /**
     * @param int $id
     * @param bool $status
     */
    public static function changeStatus($id, $status)
    {
        $product = Product::find($id);
        $product->promo = $status;
        $product->save();
    }

    /**
     * @param array $info | ['title' => string , 'slug' => string, 'description' => string, 'price' => string,
     * 'in_stock' => string, 'image' => string]
     * @param bool $promo
     * @param $additional
     * @param string $fullImgName
     * @param string $smallImgName
     * @return bool|void
     */
    public static function store($info, $promo, $additional, $fullImgName, $smallImgName)
    {
        return Product::create(['title' => $info['title'], 'slug' => $info['slug'], 'description' => $info['description'],
            'price' => $info['price'], 'in_stock' => $info['in_stock'], 'promo' => $promo, 'additional' => $additional,
            'preview' => $smallImgName, 'original_img' => $fullImgName]);
    }

    /**
     * @param int $id
     * @param array $info | ['title' => string , 'slug' => string, 'description' => string, 'price' => string,
     * 'in_stock' => string, 'image' => string, 'additional' => string]
     * @param bool $promo
     * @param string | null $additional
     * @param string $fullImgName
     * @param string $smallImgName
     * @return bool|void
     */
    public static function updateById($id, $info, $promo, $additional, $fullImgName, $smallImgName)
    {
        return Product::where('id', $id)
            ->update(['title' => $info['title'], 'slug' => $info['slug'], 'description' => $info['description'],
                'price' => $info['price'], 'in_stock' => $info['in_stock'], 'promo' => $promo,
                'additional' => $additional, 'preview' => $smallImgName, 'original_img' => $fullImgName]);
    }
}
