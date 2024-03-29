<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            $category = new Category;
            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = $status;
            $category->save();
            return redirect('/admin/view-categories')->with('success','Category Inserted Successfully !!!');
        }
        // echo "test"; die;
        $levels = Category::where(['parent_id'=> 0])->get();
        // return view('admin.categories.add_category');

        return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function viewCategories(){
        $categories = Category::get();
        return view('admin.categories.view_categories')->with(compact('categories'));
    }

    public function editCategory(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            Category::where(['id'=>$id])->update(['name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'description'=>$data['description'],'url'=>$data['url'], 'meta_title'=>$data['meta_title'], 'meta_description'=>$data['meta_description'], 'meta_keywords'=>$data['meta_keywords'], 'status'=>$status]);
            return redirect('/admin/view-categories')->with('success','Category Updated Successfully !!!');
        }
        $categoryDetails = Category::where(['id'=>$id])->first();
        // echo "<pre>"; print_r($categoryDetails); die;
        $levels = Category::where(['parent_id'=> 0])->get();
        return view('admin.categories.edit_category')->with(compact('categoryDetails','levels'));
    }

    public function deleteCategory($id = null){
        if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('success','Category Deleted Successfully!!!');
        }
    }
}
