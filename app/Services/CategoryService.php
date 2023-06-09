<?php

namespace App\Services;

use App\Category as Category;
use App\Image;
use App\Product as Product;
use Illuminate\Http\UploadedFile;

class CategoryService
{
    /**
     * @param string $parentCategory
     * @param string $categoryTitle
     * @param string $slug
     * @param UploadedFile $image
     */
    public function store($parentCategory, $categoryTitle, $slug, $image)
    {
        $fullImgName = Image::saveOriginal($image);
        $smallImgName =  Image::savePreview($image);

        Category::store($parentCategory, $categoryTitle, $slug, $fullImgName, $smallImgName);
    }

    /**
     * @param string $parentCategory
     * @param string $categoryTitle
     * @param string $slug
     * @param UploadedFile $image
     * @param int $id
     */
    public function update($parentCategory, $categoryTitle, $slug, $image, $id)
    {
        $category = Category::find($id);

        $smallImgName = $category->preview;
        $fullImgName = $category->original_img;

        if ($image) {
            // delete old images from folder
            Image::deleteOriginal($fullImgName);
            Image:: deletePreview($smallImgName);
            // save new images
            $fullImgName = Image::saveOriginal($image);
            $smallImgName =  Image::savePreview($image);
        }

        Category::updateById($id, $parentCategory, $categoryTitle, $slug, $fullImgName, $smallImgName);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        Image::deleteOriginal($category->original_img);
        Image:: deletePreview($category->preview);
        $category->delete();
    }

    /**
     * @param string $order
     * @param string $price
     * @param string $catSlug
     * @return Product
     */
    public function getProducts($order, $price, $catSlug)
    {
        if (!isset($order)) {
            $order = 'default';
        }

        $category = Category::where('slug', $catSlug)->get();
        $catId =  $category[0]->id;

        $cat = Category::select('id', 'category', 'parent_id', 'slug')->get();
        $d = $cat->keyBy('id')->toArray();
        $tree = self::buildTree($d);
        $ids = self::getSubIds($tree, $catId);

        $sort = self::sortCondition($order);

        $products = Product::findByCategory($ids, $sort, $price);
        return $products;
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
     * Get array of all full categories name
     *
     * @return array | ['categoryId1' => string, 'categoryId2' => string, ...] | [10 => "Category", 11 => "Category/Sub_category_1"]
     */
    public static function getCategoriesName()
    {
        $list = [];
        $categories = Category::select('id', 'category', 'parent_id', 'slug')->get();
        $data = $categories->keyBy('id')->toArray();
        $tree = self::buildTree($data);
        foreach ($data as $key => $value) {
            // get all parent nodes for child element
            $arrKeys = self::getKeys($key, $tree);
            $fullCategoryName = self::getFullCategoryName($arrKeys, $data);
            $list[$key] = $fullCategoryName;
        }
        return $list;
    }

    /**
     * Categories array converted in multidimensional (tree) array
     *
     * @param array $data  | $data['key1' => ['id' => int, 'category' => string, 'parent_id' => int], 'key2' => [...]]
     * @return array | ["id"=> int, "category" => string, "parent_id" => int, "childs" => array]
     */
    public static function buildTree($data)
    {
        $childs = array();

        foreach ($data as &$item) {
            $childs[$item['parent_id']][$item['id']] = &$item;
        }
        unset($item);

        foreach ($data as &$item) {
            if (isset($childs[$item['id']])) {
                $item['childs'] = $childs[$item['id']];
            }
        }

        $tree = $childs[0] ?? null;
        return $tree;
    }

    /**
     * Get array of parent ids for nested element
     *
     * @param int $key
     * @param array $tree
     * @return array | ['key1' => int, 'key2' => int, ...]
     */
    public static function getKeys($key, $tree)
    {
        $found_path = [];
        $ritit = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($tree), \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($ritit as $leafValue) {
            $path = array();
            foreach (range(0, $ritit->getDepth()) as $depth) {
                $path[] = $ritit->getSubIterator($depth)->key();
            }

            if (end($path) == $key) {
                $found_path = $path;
                break;
            }
        }

        return $found_path;
    }

    /**
     * Assign the name of categories to the key array
     *
     * @param array $arrKeys | $arrKeys['key1' => int, 'key2' => int, ...]
     * @param array $data | $data['key1' => ['id' => int, 'category' => string, 'parent_id' => int], 'key2' => [...]]
     * @return string | "Category/Sub_category_1/Sub_category_2"
     */
    public static function getFullCategoryName($arrKeys, $data)
    {
        foreach ($arrKeys as $key=>$value) {
            if ($value!="childs") {
                if ($key == 0) {
                    $list = $data[$value]['category'];
                } else {
                    $list .= " / ".$data[$value]['category'];
                }
            }
        }
        return $list;
    }

    /**
     * @param array $w | ["id"=> int, "category" => string, "parent_id" => int, "childs" => array]
     * @param int $id
     * @return array | [0 => string, 1=> string, ...]
     */
    public static function getSubIds($w, $id)
    {
        $result = self::getSubArray($w, $id);
        $list = self::idsArray($result);
        return $list;
    }

    /**
     * Get category sub tree.
     *
     * @param array $w | ["id"=> int, "category" => string, "parent_id" => int, "childs" => array]
     * @param int $catId
     * @return array|null  | ["id"=> int, "category" => string, "parent_id" => int, "childs" => array]
     */
    public static function getSubArray($w, $catId)
    {
        static $myFlag = true;
        static $e = [];

        if (is_array($w) && $myFlag) {
            foreach ($w as $key=>$str) {
                if ($key == $catId) {
                    $e = $str;
                    $myFlag = false;
                }
                self::getSubArray($str, $catId);
            }
        } else {
            null;
        }
        return $e;
    }

    /**
     * Get categories ids array from sub tree array.
     *
     * @param array $w | ["id"=> int, "category" => string, "parent_id" => int, "childs" => array]
     * @return array | [0 => string, 1=> string, ...]
     */
    public static function idsArray($w)
    {
        $it = new \RecursiveArrayIterator($w);
        $tit = new \RecursiveTreeIterator($it);

        $arr = [];
        foreach ($tit as $key => $value) {
            if ($key == "id") {
                $chars = array("|", "-", " ");
                $value = str_replace($chars, "", $value);
                $arr[] = $value;
            }
        }
        return $arr;
    }

    /**
     * @param Category $categories
     * @param int $parent_id
     * @return string|null
     */
    public static function buildMenu($categories, $parent_id)
    {
        $cats = "";

        if ($categories) {
            $cats = array();
            foreach ($categories as $category) {
                $cats[$category->parent_id][] = $category;
            }
        }

        return self::build_tree($cats, $parent_id);
    }

    /**
     * Get ul list of nested categories.
     *
     * @param array $cats
     * @param int $parent_id
     * @return string|null
     */
    public static function build_tree($cats, $parent_id)
    {
        if (is_array($cats) and isset($cats[$parent_id])) {
            $tree = '<ul>';
            foreach ($cats[$parent_id] as $cat) {
                $tree .= '<li><a href=/category/' . $cat->slug . '>' . $cat->category . '</a>';
                $tree .= self::build_tree($cats, $cat->id);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        } else {
            return null;
        }
        return $tree;
    }
}
