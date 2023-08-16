<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class CmsController extends Controller
{
    public function addCmsPage(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $cmspage = new CmsPage();
            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            $cmspage->status = $status;
            $cmspage->save();
            return redirect()->back()->with('success','Cms Page has been added succesfully');
        }
        return view('admin.pages.add_cms_page');
    }

    public function editCmsPage(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            CmsPage::where(['id' => $id])->update(['title'=>$data['title'], 'url'=>$data['url'], 'description'=>$data['description'], 'status'=>$status]);
            return redirect('/admin/view-cms-pages')->with('success','CMS Page has been updated successfully'); 
        }
        $csmPageDetails = CmsPage::where(['id'=>$id])->first();
        return view('admin.pages.edit_cms_page')->with(compact('csmPageDetails'));
    }

    public function viewCmsPage(Request $request)
    {
        $cmspages = CmsPage::get();
        $cmspages = json_decode(json_encode($cmspages));
        return view('admin.pages.view_cms_pages')->with(compact('cmspages'));
    }

    public function deleteCmsPage($id = null)
    {
        if(!empty($id)){
           CmsPage::where(['id'=>$id])->delete();
           return redirect()->back()->with('success','CMS Page deleted successfully!!!');
        }
    }

   public function cmsPage(Request $request, $url)
   {
    //    Redirect to 404 if CMS Page is disabled or does not exists.
       $cmsPageCount = CmsPage::where(['url'=>$url, 'status'=>1])->count();
       if($cmsPageCount>0){
           // Get CMS Page Details
           $cmsPageDetails = CmsPage::where(['url'=>$url])->first();
       }else{
           abort(404);
       }
    
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
       return view('pages.cms_page')->with(compact('cmsPageDetails','categories','categories_menu','banners'));
   }

   public function contactUs(Request $request){
       if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(),[
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email',
                'subject' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Send Contact Us Email
            $email = "keshrifashionKF@yopmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message'],
            ];
            Mail::send('emails.enquiry',$messageData,function($message)use($email){
                $message->to($email)->subject('Enquiry From Keshri Fashion');
            });
            return redirect()->back()->with('success','Thank you for contacting us. We will get back to you soon');
       }
        $meta_title = "Keshri Fashion | Contact Us";
        $meta_description = "Online Shopping site for Men, Women, Kids, and for everyone";
        $meta_keywords = "Contact Us, Inquiry";
       return view('pages.contact_us')->with(compact('meta_title','meta_description','meta_keywords'));
   }
}
