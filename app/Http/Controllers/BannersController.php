<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Image;
use Illuminate\Support\Facades\Input;

class BannersController extends Controller
{
    public function addBanner(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $banner = new Banner;
            $banner->banner_title = $data['banner_title'];
            $banner->banner_link = $data['banner_link'];    
            
            //Upload Image
            if($request->hasFile('banner_image')){
                $image_tmp = $request->file('banner_image');
                if($image_tmp->isValid()){
                    // echo "Success"; die;

                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $banner_path = 'images/frontend_images/banners/'.$filename;
                    //Resize Image Code
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
                     //Store image name in banner table
                    $banner->banner_image = $filename;
               }
           }

           if(empty($data['status'])){
               $status = 0;
           }else{
               $status = 1;
           }

           $banner->status = $status;
            $banner->save();
            return redirect()->back()->with('success','Banner Inserted Successfully !!!');
        }
        return view('admin.banners.add_banner');
    }

    public function editBanner(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            if(empty($data['banner_title'])){
                $data['banner_title'] = '';
            }

            if(empty($data['banner_link'])){
                $data['banner_link'] = '';
            }

            //Upload Image
            if($request->hasFile('banner_image')){
                $image_tmp = $request->file('banner_image');
                if($image_tmp->isValid()){
                    // echo "Success"; die;

                    // Upload Image after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $banner_path = 'images/frontend_images/banners/'.$filename;
                    //Resize Image Code
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
               }
           }else if(!empty($data['current_banner_image'])){
                $filename = $data['current_banner_image'];
            }else{
                $filename = '';  
            }

            Banner::where(['id'=>$id])->update(['status'=>$status,'banner_title'=>$data['banner_title'],'banner_link'=>$data['banner_link'],'banner_image'=>$filename]);
            return redirect()->back()->with('success','Banner Updated Successfully !!!');
        }
        //Get Banner Details
        $bannerDetails = Banner::where(['id'=>$id])->first();
        return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
    }

    public function viewBanners(){
        $banners = Banner::orderby('id','DESC')->get();
        return view('admin.banners.view_banners')->with(compact('banners'));
    }

    public function deleteBannerImage($id = null){

        //Get Banner Image Name
        $bannerImage = Banner::where(['id'=>$id])->first();
        // echo $bannerImage->banner_image; die;

        //Get Banner Image Paths
        $banner_path = 'images/frontend_images/banners'.'/';

        //Delete Banner Image if not exists in folder
        if(file_exists($banner_path.$bannerImage->banner_image)){
            unlink($banner_path.$bannerImage->banner_image);
        }

        //Delete Banner Image from Product table
        Banner::where(['id'=>$id])->update(['banner_image'=>'']);
        return redirect()->back()->with('success','Banner Image has been Deleted Successfully !!!');
    }

    public function deleteBanner($id = null){
        if(!empty($id)){
           Banner::where(['id'=>$id])->delete();
           return redirect()->back()->with('success','Banner Deleted Successfully!!!');
        }
   }
}
