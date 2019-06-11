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
     * @param array $ids | [0 => string, 1 => string, ...]
     * @param string $order
     * @param string $price
     * @return Product
     */
    public static function findByCategory($ids, $order, $price = null)
    {
        $sort = self::sortCondition($order);

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
     * @param string $order | "price-asc"
     * @return array | null
     */
    public static function sortCondition($order)
    {
        if ($order!='default') {
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
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
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

    /**
     * @return Product
     */
    public static function findAll()
    {
        $products =  DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
            ->select('products.*', 'categories.id as catId')
            ->get();

        return $products;
    }

    /**
     * @param int $id
     * @return Product
     */
    public static function findById($id)
    {
        $products =  DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->join('products', 'products_categories.product_id', '=', 'products.id')
            ->where('products.id', '=', $id)
            ->select('products.*', 'categories.id as category_id')
            ->get();

        return $products;
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
     * @param string $categoryId
     * @param array $info | ['title' => string , 'slug' => string, 'description' => string, 'price' => string,
     * 'in_stock' => string, 'image' => string, 'additional' => string]
     * @param bool $promo
     * @return bool|void
     */
    public static function store($categoryId, $info, $promo)
    {
        $product = new Product();

        $product->title = $info['title'];
        $product->slug = $info['slug'];
        $product->description = $info['description'];
        $product->price = $info['price'];
        $product->in_stock = $info['in_stock'];
        $product->promo = $promo;

        $additional = $info['additional'];
        if ($additional!="{}" && $additional!='{"":""}') {
            $product->additional = $info['additional'];
        }
        $fullImgName = Image::saveOriginal($info['image']);
        $smallImgName =  Image::savePreview($info['image']);

        $product->preview = $smallImgName;
        $product->original_img = $fullImgName;

        $product->save();

        $products_categories = new ProductsCategory();

        $products_categories->category_id = $categoryId;
        $products_categories->product_id = $product->id;

        $products_categories->save();
    }

    /**
     * @param int $id
     * @param string $categoryId
     * @param array $info | ['title' => string , 'slug' => string, 'description' => string, 'price' => string,
     * 'in_stock' => string, 'image' => string, 'additional' => string]
     * @param bool $promo
     * @return bool|void
     */
    public static function updateById($id, $categoryId, $info, $promo)
    {
        $product = Product::find($id);

        $additional = $info['additional'];
        if ($additional=="{}" || $additional=='{"":""}') {
            $additional = null;
        }

        DB::table('products')
            ->where('id', $id)
            ->update(['title' => $info['title'], 'slug' => $info['slug'], 'description' => $info['description'],
                'price' => $info['price'], 'in_stock' => $info['in_stock'], 'promo' => $promo,
                'additional' => $additional]);

        if ($info['image']) {
            // delete old images from folder
            Image::deleteOriginal($product->original_img);
            Image:: deletePreview($product->preview);
            // save new images
            $fullImgName = Image::saveOriginal($info['image']);
            $smallImgName = Image::savePreview($info['image']);

            $product->preview = $smallImgName;
            $product->original_img = $fullImgName;

            DB::table('products')
                ->where('id', $id)
                ->update(['preview' => $smallImgName, 'original_img' => $fullImgName]);
        }

        $products_categories = DB::table('products_categories')
            ->where('product_id', $product->id)
            ->update(['category_id' => $categoryId]);
    }
}
