<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'qt'
    ];

    /**
     * Get product cart info.
     *
     * @param $keys
     * @return Collection
     */
    public static function getProducts($keys)
    {
        return DB::table('products')
            ->whereIn('id', $keys)
            ->get();
    }
}
