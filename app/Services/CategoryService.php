<?php

namespace App\Services;

use App\Category as Category;
use App\Product as Product;
use Illuminate\Http\Request;

class CategoryService
{
    /**
     * @param Request $request
     * @param string $catSlug
     * @return Product
     */
    public function getProducts(Request $request, $catSlug)
    {
        $order = $request->input('sort-options');
        if (!isset($order)) {
            $order = 'default';
        }

        $price = $request->input('price');

        $category = Category::where('slug', $catSlug)->get();
        $catId =  $category[0]->id;

        $cat = Category::select('id', 'category', 'parent_id', 'slug')->get();
        $d = $cat->keyBy('id')->toArray();
        $tree = Category::buildTree($d);
        $ids = Category::getSubIds($tree, $catId);

        $products = Product::findByCategory($ids, $order, $price);

        return $products;
    }
}
