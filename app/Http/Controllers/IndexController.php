<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class IndexController extends Controller
{
    public function index(){
        // // Ascending Order (By Default)
        // $productsAll = Product::get();
        
        // // Descending Order
        // $productsAll = Product::OrderBy('id','DESC')->get();
        $productsAll = Product::inRandomOrder()->where(['status' =>1, 'featured_product'=>1])->get();
        // $productsAll = Product::inRandomOrder()->where(['status' =>1, 'featured_product'=>1])->paginate(3);

        //Get Categories And Sub-Categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;

        $categories_menu = "";
        foreach($categories as $cate){
            $categories_menu .= "
                <div class='panel-heading'>
                    <h4 class='panel-title'>
                        <a data-toggle='collapse' data-parent='#accordian' href='#".$cate->id."'>
                            <span class='badge pull-right'><i class='fa fa-plus'></i></span>
                            ".$cate->name."
                        </a>
                    </h4>
                </div>
                <div id='".$cate->id."' class='panel-collapse collapse'>
                    <div class='panel-body'>
                        <ul>";
                        $sub_categories = Category::where(['parent_id' => $cate->id])->get();
                        foreach($sub_categories as $subcate){
                            $categories_menu .= "<li><a href='".$subcate->url."'>".$subcate->name." </a></li>";
                        }
                        $categories_menu .= "</ul>
                    </div>
                </div>";
        }

        $banners = Banner::where(['status'=>1])->get();
        // echo "<pre>"; print_r($categories); die;
        // Meta Tags
        $meta_title = "Keshri Fashion | Home";
        $meta_description = "Online Shopping site for Men, Women, Kids, and for everyone";
        $meta_keywords = "Shopping, Keshri Fashion, Online Shopping, Kids Wear, Mens Wear, Womans Wear, Electronics, Mobiles, Home Appliances, Kitchen, Appearl, Jwellary, Accessories, and many more";
        return view('index')->with(compact('productsAll','categories','categories_menu','banners','meta_title','meta_description','meta_keywords'));
    }
}
