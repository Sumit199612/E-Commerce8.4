<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponsController extends Controller
{
    public function addCoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $coupon = new Coupon;
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = $data['status'];
            $coupon->save();
            return redirect()->action('CouponsController@viewCoupons')->with('success','Coupon has been added Successfully!!!');
        }
        return view('admin.coupons.add_coupon');

    }

    public function viewCoupons(){
        $coupons = Coupon::get();
        return view('admin.coupons.view_coupons')->with(compact('coupons'));
    }

    public function editCoupon(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $coupon = Coupon::find($id);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(empty($data['status'])){
                $data['status'] = 0;
            }
            $coupon->status = $data['status'];
            $coupon->save();
            return redirect()->action('CouponsController@viewCoupons')->with('success','Coupon has been updated Successfully!!!');
        }
        $couponDetails = Coupon::find($id);
        // $couponDetails = json_decode(json_encode($couponDetails));
        // echo "<pre>"; print_r($couponDetails); die;
        return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));
    }

    public function deleteCoupon($id = null){
        if(!empty($id)){
           Coupon::where(['id'=>$id])->delete();
           return redirect()->back()->with('success','Coupon has been deleted Successfully!!!');
        }
   }
}
