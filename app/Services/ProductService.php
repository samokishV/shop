<?php

namespace App\Services;

use App\Image;
use App\Product;
use App\ProductsCategory;

class ProductService
{
    /**
     * @param string $categoryId
     * @param array $info | ['title' => string, 'slug' => string, 'description' => string, 'price' => string,
     * 'in_stock' =>string, 'additional' => string]
     * @param $image
     * @param $promo
     * @param $additional
     */
    public function create($categoryId, $info, $image, $promo, $additional)
    {
        $promo = self::getPromo($promo);
        $additional = self::getAdditional($additional);
        $fullImgName = Image::saveOriginal($image);
        $smallImgName =  Image::savePreview($image);
        $product = Product::store($info, $promo, $additional, $fullImgName, $smallImgName);
        $productId = $product->id;
        ProductsCategory::store($categoryId, $productId);
    }

    /**
     * @param string $categoryId
     * @param array $info | ['title' => string, 'slug' => string, 'description' => string, 'price' => string,
     * 'in_stock' =>string, 'additional' => string]
     * @param $image
     * @param $promo
     * @param $additional
     * @param int $id
     */
    public function update($categoryId, $info, $image, $promo, $additional, $id)
    {
        $promo = self::getPromo($promo);
        $additional = self::getAdditional($additional);

        $product = Product::find($id);
        $smallImgName = $product->preview;
        $fullImgName = $product->original_img;

        if ($info['image']) {
            // delete old images from folder
            Image::deleteOriginal($product->original_img);
            Image:: deletePreview($product->preview);
            // save new images
            $fullImgName = Image::saveOriginal($image);
            $smallImgName = Image::savePreview($image);
        }

        Product::updateById($id, $info, $promo, $additional, $fullImgName, $smallImgName);
        $productId = $product->id;
        ProductsCategory::updateCategoryId($categoryId, $productId);
    }

    /**
     * @param string $status
     * @param int $id
     */
    public function updatePromo($status, $id)
    {
        $promo = self::getPromo($status);
        Product::changeStatus($id, $promo);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        Image::deleteOriginal($product->original_img);
        Image:: deletePreview($product->preview);
        $product->delete($id);
    }

    /**
     * @param string $status
     * @return int
     */
    public static function getPromo($status)
    {
        if ($status=="on") {
            $promo = 1;
        } else {
            $promo = 0;
        }
        return $promo;
    }

    public static function getAdditional($additional)
    {
        if ($additional=="{}" || $additional=='{"":""}') {
            $additional = null;
        }

        return $additional;
    }

    /**
     * @param string $keyword
     * @return array
     */
    public function search($keyword)
    {

        $products = Product::searchByKeyword($keyword);
        return self::groupProductsByCategories($products);
    }

    /**
     * @param $products
     * @return array
     */
    public static function groupProductsByCategories($products)
    {
        $result = array();
        foreach ($products as $product) {
            $result[$product->category][] = $product;
        }

        return $result;
    }
}
