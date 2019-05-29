<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Category extends Model
{
    /**
     * @param string $parentId
     * @param string $name
     * @param string $slug
     * @param UploadedFile $image
     */
    public static function store($parentId, $name, $slug, $image)
    {
        $category = new Category();
        $category->parent_id = $parentId;
        $category->category = $name;
        $category->slug = $slug;

        $fullImgName = Image::saveOriginal($image);
        $smallImgName =  Image::savePreview($image);

        $category->preview = $smallImgName;
        $category->original_img = $fullImgName;

        $category->save();
    }

    /**
     * @param int $id
     * @param string $parentId
     * @param string $name
     * @param string $slug
     * @param UploadedFile $image
     */
    public static function updateById($id, $parentId, $name, $slug, $image)
    {
        $category = Category::find($id);

        DB::table('categories')
            ->where('id', $id)
            ->update(['category' => $name, 'slug' => $slug, 'parent_id' => $parentId]);

        if($image) {
            // delete old images from folder
            Image::deleteOriginal($category->original_img);
            Image:: deletePreview($category->preview);
            // save new images
            $fullImgName = Image::saveOriginal($image);
            $smallImgName =  Image::savePreview($image);

            $category->preview = $smallImgName;
            $category->original_img = $fullImgName;

            DB::table('categories')
                ->where('id', $id)
                ->update(['preview' => $smallImgName, 'original_img' => $fullImgName]);
        }
    }

    /**
     * @param int $id
     */
    public static function deleteById($id)
    {
        $category = Category::find($id);

        Image::deleteOriginal($category->original_img);
        Image:: deletePreview($category->preview);

        $category->delete();
    }

    /**
     * @return Category
     */
    public static function findWithProducts()
    {
        $products =  DB::table('categories')
            ->join('products_categories', 'categories.id', '=', 'products_categories.category_id')
            ->groupBy('category_id')
            ->havingRaw('count(category_id) > 0')
            ->select('categories.*')
            ->get();

        return $products;
    }

    /**
     * Get array of all full categories name
     *
     * @return array | ['categoryId1' => string, 'categoryId2' => string, ...] | [10 => "Category", 11 => "Category/Sub_category_1"]
     */
    public static function getCategoriesName()
    {
        $list = [];
        $categories = self::select('id','category', 'parent_id')->get();
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
    public static  function buildTree($data)
    {
        $childs = array();

        foreach($data as &$item) {
            $childs[$item['parent_id']][$item['id']] = &$item;
        }
        unset($item);

        foreach($data as &$item) {
            if (isset($childs[$item['id']])) {
                $item['childs'] = $childs[$item['id']];
            }
        }

        $tree = $childs[0];
        return $tree;
    }

    /**
     * Get array of parent ids for nested element
     *
     * @param int $key
     * @param array $tree
     * @return array | ['key1' => int, 'key2' => int, ...]
     */
    public static function getKeys($key, $tree) {
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
        foreach($arrKeys as $key=>$value) {
            if($value!="childs") {
                if($key == 0) $list = $data[$value]['category'];
                else $list .= " / ".$data[$value]['category'];
            }
        }
        return $list;
    }
}
