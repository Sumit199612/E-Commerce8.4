<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\Category;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Image;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if (empty($data['category_id'])) {
                return redirect()->back()->with('error', 'Missing Under Category !!!');
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if (!empty($data['product_description'])) {
                $product->product_description = $data['product_description'];
            } else {
                $product->product_description = '';
            }
            if (!empty($data['care'])) {
                $product->care = $data['care'];
            } else {
                $product->care = '';
            }
            $product->product_description = $data['product_description'];
            $product->product_price = $data['product_price'];

            //Upload Image
            if ($request->hasFile('product_image')) {
                echo $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    // echo "Success"; die;

                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $filename;
                    $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                    $small_image_path = 'images/backend_images/products/small/' . $filename;
                    //Resize Image Code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    //     //Store image name in product table
                    $product->product_image = $filename;
                }
            }

            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            if (empty($data['featured_product'])) {
                $featured_product = 0;
            } else {
                $featured_product = 1;
            }

            $product->status = $status;
            $product->featured_product = $featured_product;
            $product->save();
            return redirect('/admin/view-products')->with('success', 'Product Inserted Successfully !!!');
            // return redirect()->back()->with('success','Product Inserted Successfully !!!');
        }

        //Category Dropdown Start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' disabled selected>Select Category</option>";
        foreach ($categories as $cate) {
            $categories_dropdown .= "<option value='" . $cate->id . "'>" . $cate->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cate->id])->get();
            foreach ($sub_categories as $sub_cate) {
                $categories_dropdown .= "<option value=' " . $sub_cate->id . "'>&nbsp;--&nbsp;" . $sub_cate->name . "</option>";
            }
        }
        //Category Dropdown End

        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function editProduct(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //Upload Image
            if ($request->hasFile('product_image')) {
                echo $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    // echo "Success"; die;

                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $filename;
                    $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                    $small_image_path = 'images/backend_images/products/small/' . $filename;
                    //Resize Image Code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                }
            } else if (!empty($data['current_product_image'])) {
                $filename = $data['current_product_image'];
            } else {
                $filename = '';
            }

            if (empty($data['product_description'])) {
                $data['product_description'] = '';
            }

            if (empty($data['care'])) {
                $data['care'] = '';
            }

            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }

            if (empty($data['featured_product'])) {
                $featured_product = 0;
            } else {
                $featured_product = 1;
            }

            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => $data['product_name'], 'product_code' => $data['product_code'], 'product_color' => $data['product_color'], 'product_description' => $data['product_description'], 'care' => $data['care'], 'product_price' => $data['product_price'], 'product_image' => $filename, 'status' => $status, 'featured_product' => $featured_product]);
            // return redirect('/admin/view-categories')->with('success','Category Updated Successfully !!!');
            return redirect('/admin/view-products')->with('success', 'Product Updated Successfully !!!');
        }

        //Get Product Details
        $productDetails = Product::where(['id' => $id])->first();

        //Category Dropdown Start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cate) {
            if ($cate->id == $productDetails->category_id) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option value='" . $cate->id . "' " . $selected . ">" . $cate->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cate->id])->get();
            foreach ($sub_categories as $sub_cate) {
                if ($sub_cate->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value=' " . $sub_cate->id . "' " . $selected . ">&nbsp;--&nbsp;" . $sub_cate->name . "</option>";
            }
        }
        //Category Dropdown End

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_dropdown'));
    }

    public function deleteProductImage($id = null)
    {

        //Get Product Image Name
        $productImage = Product::where(['id' => $id])->first();
        // echo $productImage->product_image; die;

        //Get Product Image Paths
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //Delete Large Product Image if not exists in folder
        if (file_exists($large_image_path . $productImage->product_image)) {
            unlink($large_image_path . $productImage->product_image);
        }

        //Delete Meduium Product Image if not exists in folder
        if (file_exists($medium_image_path . $productImage->product_image)) {
            unlink($medium_image_path . $productImage->product_image);
        }

        //Delete Small Product Image if not exists in folder
        if (file_exists($small_image_path . $productImage->product_image)) {
            unlink($small_image_path . $productImage->product_image);
        }

        //Delete Product Image from Product table
        Product::where(['id' => $id])->update(['product_image' => '']);
        return redirect()->back()->with('success', 'Product Image has been Deleted Successfully !!!');
    }

    public function deleteAltImage($id = null)
    {

        //Get Product Image Name
        $productImage = ProductsImage::where(['id' => $id])->first();
        // echo $productImage->product_image; die;

        //Get Product Image Paths
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //Delete Large Product Image if not exists in folder
        if (file_exists($large_image_path . $productImage->product_image)) {
            unlink($large_image_path . $productImage->product_image);
        }

        //Delete Meduium Product Image if not exists in folder
        if (file_exists($medium_image_path . $productImage->product_image)) {
            unlink($medium_image_path . $productImage->product_image);
        }

        //Delete Small Product Image if not exists in folder
        if (file_exists($small_image_path . $productImage->product_image)) {
            unlink($small_image_path . $productImage->product_image);
        }

        //Delete Product Image from Product table
        ProductsImage::where(['id' => $id])->delete();
        return redirect()->back()->with('success', 'Product Altenate Image(s) has been Deleted Successfully !!!');
    }

    public function deleteProduct($id = null)
    {
        if (!empty($id)) {
            Product::where(['id' => $id])->delete();
            return redirect()->back()->with('success', 'Product Deleted Successfully!!!');
        }
    }

    public function viewProducts()
    {
        $products = Product::orderby('id', 'DESC')->get();
        $products = json_decode(json_encode($products));
        foreach ($products as $key => $val) {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
            // echo "<pre>"; print_r($products); die;
        }
        // echo "<pre>"; print_r($products); die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function addAttributes(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails); die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {
                    
                    

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }

            return redirect('admin/add-attributes/' . $id)->with('success', 'Product attributes has been added Successfully!!!!');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function editAttributes(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<per>"; print_r($data); die;
            foreach ($data['idAttr'] as $key => $attr) {
                productsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }

            return redirect()->back()->with('success', 'Product attributes has been updated Successfully!!!!');

        }
    }

    public function addImages(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $data = json_decode(json_encode($productDetails));
        // echo "<pre>";
        // print_r($data);die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($request->hasFile('product_image')) {
                $files = $request->file('product_image');
                foreach ($files as $file) {
                    // Upload Images after resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $fileName;
                    $medium_image_path = 'images/backend_images/products/medium/' . $fileName;
                    $small_image_path = 'images/backend_images/products/small/' . $fileName;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->product_image = $fileName;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            return redirect('admin/add-images/' . $id)->with('success', 'Image has been added Successfully!!!');
        }

        $productsImage = ProductsImage::where(['product_id' => $id])->get();

        return view('admin.products.add_images')->with(compact('productDetails', 'productsImage'));
    }

    public function deleteAttribute($id = null)
    {
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('success', 'Attribute has been deleted Successfully!!!');
    }

    public function products($url = null)
    {
        // Show 404 page if Category Url does not exists.
        $countCategory = Category::where(['url' => $url, 'status' => 1])->count();
        if ($countCategory == 0) {
            abort(404);
        }
        // Get all Categories and Sub-Categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        $categoryDetails = Category::where(['url' => $url])->first();

        if ($categoryDetails->parent_id == 0) {
            // If Url is Main Category Url
            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach ($subCategories as $subcate) {
                $cate_ids[] = $subcate->id;
            }
            $productAll = Product::whereIn('category_id', $cate_ids)->where('status', 1)->get();
            // $productAll = Product::whereIn('category_id', $cate_ids)->where('status', 1)->paginate(3);
            // $productAll = json_decode(json_encode($productAll));
            // echo "<pre>"; print_r($productAll);
        } else {
            // If Url is Sub-Category Url
            $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status', 1)->get();
            $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status', 1)->paginate(3);
        }
        // echo $categoryDetails->id; die;
        // $productAll = Product::where(['category_id' => $categoryDetails->id])->get();
        return view('products.listing')->with(compact('categories', 'categoryDetails', 'productAll'));
    }

    public function searchProducts(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();

            $searchProduct = $data['product'];

            $productAll = Product::where('product_name', 'like', '%'.$searchProduct.'%')->orwhere('product_code',$searchProduct)->where('status',1)->get();

            return view('products.listing')->with(compact('categories','productAll','searchProduct'));
        }
    }

    public function product($id = null)
    {

        // Show 404 page if product is disabled
        $productsCount = Product::where(['id' => $id, 'status' => 1])->count();
        if ($productsCount == 0) {
            abort(404);
        }

        //Get Product Details
        $productDetails = Product::with('attributes')->where('id', $id)->first();
        $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails); die;

        $relatedProducts = Product::where('id', '!=', $id)->where(['category_id' => $productDetails->category_id])->get();
        // $relatedProducts = json_decode(json_encode($relatedProducts));
        // echo "<pre>"; print_r($relatedProducts); die;

        // foreach($relatedProducts->chunk(3) as $chunk){
        //     foreach($chunk as $item){
        //         echo $item; echo "<br>";
        //     }
        //     echo "<br><br><br>";
        // }
        // die;

        // Get all Categories and Sub-Categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        // Get Product Alternate Images
        $productAltImages = ProductsImage::where('product_id', $id)->get();
        // $productAltImages = json_decode(json_encode($productAltImages));
        // echo "<pre>"; print_r($productAltImages); die;

        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('products.detail')->with(compact('productDetails', 'categories', 'productAltImages', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $proArr = explode("-", $data['idSize']);
        // echo $proArr[0]; echo $proArr[1]; die;
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }

    public function addtocart(Request $request)
    {

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        // echo "<pre>"; print_r($data); die;

        // Check Product Stock is available or not.
        $productSize = explode("-", $data['Size']);
        $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'], 'Size' => $productSize[1]])->first();
        // echo "<pre>"; print_r($getProductStock->stock); die;

        if($getProductStock->stock<$data['quantity']){
            return redirect()->back()->with('error', 'Required Quantity is not available');
        }

        if (empty(Auth::user()->id)) {
            $data['user_id'] = '';
        } else {
            $data['user_id'] = Auth::user()->id;
        }

        $session_id = Session::get('session_id');

        if (!isset($session_id)) {
            $session_id = str_random(40);
            Session::put('session_id', $session_id);
        }
        $sizeArr = explode("-", $data['Size']);
        $productsSize = $sizeArr[1];

        if(empty(Auth::check())){
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'], 'product_color' => $data['product_color'], 'Size' => $productsSize, 'session_id' => $session_id])->count();
            // echo $countProducts; die;
    
            if ($countProducts > 0) {
                return redirect()->back()->with('error', 'This product is already exists in your Cart!!!');
            }
        }else{
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'], 'product_color' => $data['product_color'], 'Size' => $productsSize, 'user_id' => $data['user_id']])->count();
            // echo $countProducts; die;
    
            if ($countProducts > 0) {
                return redirect()->back()->with('error', 'This product is already exists in your Cart!!!');
            }
        }

         

        $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'Size' => $sizeArr[1]])->first();

        DB::table('cart')->insert(['product_id' => $data['product_id'], 'product_name' => $data['product_name'], 'product_code' => $getSKU->sku, 'product_color' => $data['product_color'], 'product_price' => $data['product_price'], 'Size' => $sizeArr[1], 'quantity' => $data['quantity'], 'user_id' => $data['user_id'], 'session_id' => $session_id]);
        

        return redirect('cart')->with('success', 'Product has been added in Cart!!!');
    }

    public function cart()
    {
        $session_id = Session::get('session_id');
        $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
        // echo "<pre>"; print_r($userCart); die;
        foreach ($userCart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->product_image = $productDetails->product_image;
        }
        // dd($userCart);
        // echo "<pre>"; print_r($userCart); die;
        return view('products.cart')->with(compact('userCart'));
    }

    public function deleteCartProduct($id = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('cart')->where('id', $id)->delete();
        return redirect('cart')->with('success', 'Product has been deleted from Cart!!!');
    }

    public function updateCartQuantity($id = null, $quantity = null)
    {

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $getCartDetails = DB::table('cart')->where('id', $id)->first();
        $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
        $updated_quantity = $getCartDetails->quantity + $quantity;
        if ($getAttributeStock->stock >= $updated_quantity) {
            DB::table('cart')->where('id', $id)->increment('quantity', $quantity);
            return redirect('cart')->with('success', 'Product Quantity has been updated Successfully!!!');
        } else {
            return redirect('cart')->with('error', 'Required Product Quantity is not Available!!!');
        }

    }

    public function applyCoupon(Request $request)
    {

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('error', 'This Coupon does not exists!!!');
        } else {
            // echo "Success"; die;

            //with perform other checks like Active/Inactive, Expiry date, etc.

            //Get Coupon Details
            $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();

            //If coupon is Inactive
            if ($couponDetails->status == 0) {
                return redirect()->back()->with('error', 'This Coupon is not Active!!!');
            }

            //If Coupon is Expired
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if ($expiry_date < $current_date) {
                return redirect()->back()->with('error', 'This Coupon is expired!!!');
            }

            // echo "success"; die;

            //If Coupon is valid for Discount

            //Get Cart Total Amount
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
            $total_amount = 0;
            foreach ($userCart as $item) {
                $total_amount = $total_amount + ($item->product_price * $item->quantity);
            }

            //Check if  amount type is Fixed or Precentage
            if ($couponDetails->amount_type == "Fixed") {
                $couponAmount = $couponDetails->amount;
            } else {
                $couponAmount = $total_amount * ($couponDetails->amount / 100);
            }

            // echo $couponAmount; die;

            //Add Coupon Code & Amount in Session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['coupon_code']);

            return redirect()->back()->with('Success', 'The Coupon Code Successfully applied. You are availing Discount');

        }
    }

    public function checkout(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        //Check if Billing Address exists
        $billingCount = BillingAddress::where('user_id', $user_id)->count();
        if ($billingCount > 0) {
            $userDetails = BillingAddress::where('user_id', $user_id)->first();

        }

        //Check if Shipping Address exists
        $shippingCount = DeliveryAddress::where('user_id', $user_id)->count();
        $shippingDetails = array();
        if ($shippingCount > 0) {
            $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        }

        // Update cart table with user email
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id' => $session_id])->update(['user_id' => $user_id]);

        if ($request->isMethod('post')) {

            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            /*Return to checkout page if any of these fields left empty*/
            if (empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])) {
                return redirect()->back()->with('error', 'Please fill all the fields to Checkout.');
            }

            // Fill Or Update Data of Billing Address Table
            if ($billingCount > 0) {
                // Update Billing Address
                BillingAddress::where('user_id', $user_id)->update(['name' => $data['billing_name'], 'address' => $data['billing_address'], 'city' => $data['billing_city'], 'state' => $data['billing_state'], 'address' => $data['billing_address'], 'pincode' => $data['billing_pincode'], 'mobile' => $data['billing_mobile']]);
            } else {
                // Add New Billing Address
                $billing = new BillingAddress;
                $billing->user_id = Auth::user()->id;
                $billing->user_email = Auth::user()->email;
                $billing->name = $data['billing_name'];
                $billing->address = $data['billing_address'];
                $billing->city = $data['billing_city'];
                $billing->state = $data['billing_state'];
                $billing->country = $data['billing_country'];
                $billing->pincode = $data['billing_pincode'];
                $billing->mobile = $data['billing_mobile'];
                $billing->save();
            }
            /********************This Part can be used if we want to change the details of user in user table. Only Uncomment the single line comment.************************************** */
            /*Update User Details*/
            //User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'country'=>$data['billing_country'],'pincode'=>$data['billing_pincode'],'mobile'=>$data['billing_mobile']]);
            /******************************************************************************************************************************************************************************* */
            // Fill Or Update Data of Shipping Address Table
            if ($shippingCount > 0) {
                // Update shipping Address
                DeliveryAddress::where('user_id', $user_id)->update(['name' => $data['shipping_name'], 'address' => $data['shipping_address'], 'city' => $data['shipping_city'], 'state' => $data['shipping_state'], 'country' => $data['shipping_country'], 'pincode' => $data['shipping_pincode'], 'mobile' => $data['shipping_mobile']]);
            } else {
                // Add New shipping Address
                //dd($user_id);
                $shipping = new DeliveryAddress;
                $shipping->user_id = Auth::user()->id;
                $shipping->user_email = Auth::user()->email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->country = $data['shipping_country'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }

            return redirect()->action('ProductsController@orderReview');

            // echo "Redirect to Order Review Page"; die;
        }
        return view('products.checkout')->with(compact('userDetails', 'countries', 'shippingDetails'));
    }

    public function orderReview()
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id', $user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $session_id = Session::get('session_id');
        $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
        foreach ($userCart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->product_image = $productDetails->product_image;
        }
        // echo "<pre>"; print_r($userCart); die;
        return view('products.order_review')->with(compact('userDetails', 'shippingDetails', 'userCart'));
    }

    public function placeOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            // Get Shipping Address of user.
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();

            // echo "<pre>"; print_r($data); die;

            if (empty(Session::get('CouponCode'))) {
                $coupon_code = '';
            } else {
                $coupon_code = Session::get('CouponCode');
            }

            if (empty(Session::get('CouponAmount'))) {
                $coupon_amount = '';
            } else {
                $coupon_amount = Session::get('CouponAmount');
            }

            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];
            $order->save();
            // dd($shippingDetails);
            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('cart')->where(['user_id' => $user_id])->get();
            foreach ($cartProducts as $pro) {
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->size = $pro->size;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_price = $pro->product_price;
                $cartPro->quantity = $pro->quantity;
                // $cartPro->quantity = $pro->product_image;
                // dd($cartPro);
                $cartPro->save();
            }

            Session::put('order_id', $order_id);
            Session::put('grand_total', $data['grand_total']);

            if ($data['payment_method'] == "COD") {

                $productDetails = Order::with('orders')->where('id', $order_id)->first();
                $productDetails = json_decode(json_encode($productDetails), true);
                // echo "<pre>"; print_r($productDetails); die;

                $userDetails = User::where('id', $user_id)->first();
                $userDetails = json_decode(json_encode($userDetails), true);
                // echo "<pre>"; print_r($userDetails);die;

                /* Code for Order Email Start*/
                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name' => $shippingDetails->name,
                    'order_id' => $order_id,
                    'productDetails' => $productDetails,
                    'userDetails' => $userDetails,
                ];
                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Placed - From Keshris Fashion');
                });
                /* Code for Order Email Ends*/
                // COD - Redirect user to Thanks page after saving order
                return redirect('/thanks');

            } elseif ($data['payment_method'] == "PayTm") {
                // paytm - Redirect user to paytm page after saving order
                return redirect('/paytm');
            } else {
                // Paypal - Redirect user to paypal page after saving order
                return redirect('/paypal');
            }
        }
        // return view('products.place_order');
    }

    public function thanks(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $user_id = Auth::user()->id;
        DB::table('cart')->where('user_id', $user_id)->delete();
        return view('orders.thanks');
    }

    public function paypal(Request $request)
    {
        return view('orders.paypal');
    }

    public function paytm(Request $request)
    {

        return view('orders.paytm');
    }

    public function userOrders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        // $orders =json_decode(json_encode($orders));
        // echo "<pre>"; print_r($orders); die;
        return view('orders.user_orders')->with(compact('orders'));
    }

    public function userOrderDetails($order_id)
    {
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        // echo "<pre>"; print_r($orderDetails); die;
        return view('orders.user_order_details')->with(compact('orderDetails'));
    }

    public function viewOrders()
    {
        $orders = Order::with('orders')->orderBy('id', 'Desc')->get();
        // $orders =json_decode(json_encode($orders));
        // echo "<pre>"; print_r($orders); die;
        return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id)
    {
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        // echo "<pre>"; print_r($orderDetails); die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.orders.order_details')->with(compact('orderDetails', 'userDetails'));
    }

    public function viewOrderInvoice($order_id)
    {
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        // echo "<pre>"; print_r($orderDetails); die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }

    public function updateOrderStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);
            return redirect()->back()->with('success', 'Order Status has been updated');
        }
    }
}
