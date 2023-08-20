<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute','product_id');
    }

    public static function cartCount(){
        if(Auth::check()){
            // User is logged in, so we will use Auth
            $user_email = Auth::user()->email;
            $user_id = Auth::user()->id;
            $cartCount = DB::table('cart')->where(['user_id' => $user_id])->sum('quantity');
            
        }else{
            // User is not logged in, so we will use Session
            $session_id = Session::get('session_id');
            $cartCount = DB::table('cart')->where(['session_id' => $session_id])->sum('quantity');
            
        }
        return $cartCount;
    }

    public static function productCount($cate_id){
        $catCount = Product::where(['category_id' => $cate_id, 'status' => 1])->count();
        return $catCount;
    }
}
