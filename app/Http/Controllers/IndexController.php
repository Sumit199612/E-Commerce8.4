<?php

namespace App\Http\Controllers;

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
        
        // Random Order
        $productsAll = Product::inRandomOrder()->where('status',1)->get();

        //Get Categories And Sub-Categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;

        /*$categories_menu = "";
        foreach($categories as $cate){
            $categories_menu .= "<div class='panel-heading'>
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
                            </div>
                            ";
        }*/
        // echo "<pre>"; print_r($categories); die;
        return view('index')->with(compact('productsAll','categories',/*'categories_menu'*/));
    }
}
