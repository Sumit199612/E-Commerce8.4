<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Models\OrdersProduct', 'order_id');
    }

    public static function getOrderDetails($order_id)
    {
        $getOrderDetails = Order::where('id', $order_id)->first();
        return $getOrderDetails;
    }

    public static function getCountryCode($country)
    {
        $getCountryCode = Country::where('country_name', $country)->first();
        return $getCountryCode;

    }
}
