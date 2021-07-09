<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Color;
use App\Models\Detail;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bannerIndex(Request $request)
    {
        $banners = Banner::get();
        return view('settings.banner')->with(['banners' => $banners]);
    }

    public function bannerEdit(Request $request,$id)
    {
        $rules = [
            'image_id' => 'integer|nullable',
            'external_path' => 'string|nullable',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => 'Validate Fail.' ];
        }
        $banner = Banner::find($id);
        $banner->image_id = $request["image_id"];
        $banner->external_path = $request["external_path"];
        $banner->save();
        return [ 'status'=> 'success','message' => 'done' ];
    }

    public function detailIndex(Request $request)
    {
        $details = Detail::get();
        return view('settings.detail')->with(['details' => $details]);
    }

    public function detailEdit(Request $request,$id)
    {
        $rules = [
            'th_name' => 'string|nullable',
            'en_name' => 'string|nullable',
            'th_description' => 'string|nullable',
            'en_description' => 'string|nullable',
            'path' => 'string|nullable',
            'amount' => 'integer|nullable'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => 'Validate Fail.' ];
        }
        $detail = Detail::find($id);
        if(isset($request["th_name"])){
            $detail->th_name = $request["th_name"];
        }
        if(isset($request["en_name"])){
            $detail->en_name = $request["en_name"];
        }
        if(isset($request["th_description"])){
            $detail->th_description = $request["th_description"];
        }
        if(isset($request["en_description"])){
            $detail->en_description = $request["en_description"];
        }
        if(isset($request["path"])){
            $detail->path = $request["path"];
        }
        if(isset($request["amount"])){
            $detail->amount = $request["amount"];
        }
        $detail->save();
        if(!$detail){
            return [ 'status'=> 'error','message' => "Update fail.please refresh page and try again." ];
        }
        return [ 'status'=> 'success','message' => 'done' ];
    }

    public function colorIndex(Request $request)
    {
        $colors = Color::get();
        return view('settings.color')->with(['colors' => $colors]);
    }

    public function colorsEdit(Request $request)
    {
        $rules = [
            'bg-main1' => 'required|string',
            'bg-main2' => 'required|string',
            'bg-main3' => 'required|string',
            'bg-main4' => 'required|string',
            "color-main1" => 'required|string',
            "color-main2" => 'required|string',
            "color-main3" => 'required|string',
            "color-main4" => 'required|string',
            "color-main5" => 'required|string',
            "color-main6" => 'required|string',
            "filter" => 'required|string',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $colors = Color::get();
        foreach($colors as $color){
            $color->code = $request[$color->keyword];
            $color->save();
            if(!$color){
                $request->session()->flash('error',"Can't save colors please try again.");
                return redirect(route('settings.color'));   
            }
        }
        $request->session()->flash('success',"Edit Colors Success.");
        return redirect(route('settings.color'));   
    }

    public function sectionIndex(Request $request)
    {
        $sections = Section::get();
        $defaults = [
            [
                'value' => '<Banner />', 'name' => 'Banner', 
            ],[
                'value' => '<About />', 'name' => 'About', 
            ],[
                'value' => '<Project />', 'name' => 'Project', 
            ],[
                'value' => '<News />', 'name' => 'News', 
            ],[
                'value' => '<Members />', 'name' => 'Members', 
            ],[
                'value' => '<Contact />', 'name' => 'Contact', 
            ],[
                'value' => '<Footer />', 'name' => 'Footer', 
            ]
        ];
        return view('settings.section')->with(['sections' => $sections,'defaults' => $defaults]);
    }

    public function sectionsEdit(Request $request)
    {
        $rules = [
            'data.*.id' => 'required|integer',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $sections = Section::get();
        $defaults = [
            [
                'value' => '<Banner />', 'name' => 'Banner', 
            ],[
                'value' => '<About />', 'name' => 'About', 
            ],[
                'value' => '<Project />', 'name' => 'Project', 
            ],[
                'value' => '<News />', 'name' => 'News', 
            ],[
                'value' => '<Members />', 'name' => 'Members', 
            ],[
                'value' => '<Contact />', 'name' => 'Contact', 
            ],[
                'value' => '<Footer />', 'name' => 'Footer', 
            ]
        ];
        foreach($sections as $key => $section){
            $section->value = $defaults[$request['data'][$key]['id']]['value'];
            $section->name = $defaults[$request['data'][$key]['id']]['name'];
            $section->save();
            if(!$section){
                $request->session()->flash('error',"Can't save colors please try again.");
                return redirect(route('settings.color'));   
            }
        }
        $request->session()->flash('success',"Edit Sections Success.");
        return redirect(route('settings.section'));   
    }
}
