<?php

namespace App\Services;

use App\Image;
use App\Product;
use App\ProductsCategory;
use Illuminate\Http\Request;

class ProductService
{
    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        $categoryId = $request['category'];
        $info = $request->only('title', 'slug', 'description', 'price', 'in_stock', 'additional');
        $info["image"] = $request->file("image");
        $promo = self::getPromo($request);
        $additional = self::getAdditional($request);
        $fullImgName = Image::saveOriginal($info['image']);
        $smallImgName =  Image::savePreview($info['image']);
        $product = Product::store($info, $promo, $additional, $fullImgName, $smallImgName);
        $productId = $product->id;
        ProductsCategory::store($categoryId, $productId);
    }

    /**
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $categoryId = $request['category'];
        $info = $request->only('title', 'slug', 'description', 'price', 'in_stock', 'additional');
        $info["image"] = $request->file("image");
        $promo = self::getPromo($request);
        $additional = self::getAdditional($request);

        $product = Product::find($id);
        $smallImgName = $product->preview;
        $fullImgName = $product->original_img;

        if ($info['image']) {
            // delete old images from folder
            Image::deleteOriginal($product->original_img);
            Image:: deletePreview($product->preview);
            // save new images
            $fullImgName = Image::saveOriginal($info['image']);
            $smallImgName = Image::savePreview($info['image']);
        }

        Product::updateById($id, $info, $promo, $additional, $fullImgName, $smallImgName);
        $productId = $product->id;
        ProductsCategory::updateCategoryId($categoryId, $productId);
    }

    /**
     * @param Request $request
     * @param int $id
     */
    public function updatePromo(Request $request, $id)
    {
        $promo = self::getPromo($request);
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
     * @param Request $request
     * @return int
     */
    public static function getPromo(Request $request)
    {
        $status = $request['promo'];

        if ($status=="on") {
            $promo = 1;
        } else {
            $promo = 0;
        }
        return $promo;
    }

    public static function getAdditional(Request $request)
    {
        $additional = $request['additional'];
        if ($additional=="{}" || $additional=='{"":""}') {
            $additional = null;
        }

        return $additional;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $keyword = $request['keyword'];
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
