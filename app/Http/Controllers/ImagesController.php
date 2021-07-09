<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Member;
use App\Models\Article;

class ImagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Upload::orderBy('created_at','desc')->get();
        return view('images.list')->with(['images' => $images]);
    }

    public function ajax()
    {
        $images = Upload::get();
        return [ 'status'=> 'success','message' => $images ];
    }

    public function upload(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:jpeg,bmp,png',
            'file_name' => 'required|string'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $request->session()->flash('error',$validator->errors());
            return redirect(route('images'));    
        }
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $checkExt = explode(".", $file_name);
        $ext = $checkExt[1];
        //create random new file name 
        $randomName = str_random(10);
        $newFileName = $randomName.'.'.$ext;
        $path = $file->move('images',$newFileName);
        if(!$path){
            $request->session()->flash('error','Upload fail.Please try again.');
            return redirect(route('images'));   
        }
        $data = [
            'name' => $request['file_name'],
            'path' => 'images/'.$newFileName
        ];
        $save = Upload::create($data);
        if(!$save){
            $request->session()->flash('error',"Upload Success but can't save in DB.Please try again.");
            return redirect(route('images'));   
        }
        $request->session()->flash('success',"Upload Success.");
        return redirect()->back();   
    }

    public function deleteImage(Request $request,$id)
    {
        $image = Upload::find($id);
        if(!$image){
            $request->session()->flash('error','Image not found.');
            return redirect(route('images'));   
        }
        $checkBanner = Banner::where('image_id',$id)->get();
        if(sizeOf($checkBanner)!=0){
            $request->session()->flash('error','Image is used in banners.');
            return redirect(route('images'));   
        }
        $checkMember = Member::where('image_id',$id)->get();
        if(sizeOf($checkMember)!=0){
            $request->session()->flash('error','Image is used in members.');
            return redirect(route('images'));   
        }
        $checkProject = Project::where('image_id',$id)->get();
        if(sizeOf($checkProject)!=0){
            $request->session()->flash('error','Image is used in projects.');
            return redirect(route('images'));   
        }
        $checkSubProject = SubProject::where('image_id',$id)->get();
        if(sizeOf($checkSubProject)!=0){
            $request->session()->flash('error','Image is used in sub-projects.');
            return redirect(route('images'));   
        }
        $checkArticle = Article::where('cover_id',$id)->get();
        if(sizeOf($checkArticle)!=0){
            $request->session()->flash('error','Image is used in articles.');
            return redirect(route('images'));   
        }
        $path = $image->path;   
        $image->delete();
        $isDelete = unlink($path);
        if(!$isDelete){
            $request->session()->flash('error',"Delete fail.");
            return redirect(route('images'));   
        }
        $request->session()->flash('success',"Delete Image Success.");
        return redirect()->back();   
    }
}
