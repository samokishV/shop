<?php

namespace App;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Config;

class myModel extends Model
{
    public function getCreatedAtAttribute($value)
    {
        return self::timeLocalization($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return self::timeLocalization($value);
    }

    public static function timeLocalization($value)
    {
        $user = Auth::user();
        // If no user is logged in, we'll just default to the
        // application timezone
        $timezone = $user ? $user->timezone : Config::get('app.timezone');

        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone($timezone)
// Leave this part off if you want to keep the property as
// a Carbon object rather than always just returning a string
            ->toDateTimeString();
    }
}
