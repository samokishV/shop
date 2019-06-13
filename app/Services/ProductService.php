<?php

namespace App\Services;

use App\Product;
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
        Product::store($categoryId, $info, $promo);
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

        Product::updateById($id, $categoryId, $info, $promo);
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
}
