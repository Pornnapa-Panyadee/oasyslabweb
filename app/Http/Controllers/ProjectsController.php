<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\SubProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
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
        $projects = Project::get();
        return view('projects.list')->with(['projects' => $projects]);
    }

    public function getSubProject(Request $request)
    {
        $subprojects = Subproject::where('main_id',$request['id'])->orderBy('order_no','asc')->get();
        foreach($subprojects as $subproject){
            $subproject->images->path;
        }
        return [ 'status'=> 'success','message' => $subprojects ];
    }

    public function create()
    {
        return view('projects.create');
    }

    public function createSub(Request $request)
    {
        return view('projects.createSub')->with(['id' => $request['id']]);
    }

    public function edit(Request $request,$id)
    {
        $project = Project::find($id);
        return view('projects.edit')->with(['project' => $project]);
    }

    public function editSub(Request $request,$id)
    {
        $subproject = Subproject::find($id);
        return view('projects.editSub')->with(['subproject' => $subproject]);
    }

    public function createProject(Request $request)
    {
        $rules = [
            'th_name' => 'required|string',
            'en_name' => 'required|string',
            'th_description' => 'required|string',
            'en_description' => 'required|string',
            'image_id' => 'required|integer',
            'order_no' => 'required|integer',
            'icon_active' => 'required',
            'icon' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $request->session()->flash('error',$validator->errors());
            return redirect(route('projects'));    
        }
        $project = Project::create($request->all());
        if(!$project){
            $request->session()->flash('error',"Create project fail.Please try again.");
            return redirect(route('projects'));   
        }
        $request->session()->flash('success',"Create Project Success.");
        return redirect(route('projects'));   
    }

    public function createSubProject(Request $request)
    {
        $rules = [
            'th_name' => 'required|string',
            'en_name' => 'required|string',
            'th_description' => 'required|string',
            'en_description' => 'required|string',
            'image_id' => 'required',
            'order_no' => 'required|integer',
            'main_id' => 'required|exists:projects,id',
            'external_path' => 'nullable',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $project = Subproject::create($request->all());
        if(!$project){
            $request->session()->flash('error',"Create sub project fail.Please try again.");
            return redirect(route('projects'));   
        }
        $request->session()->flash('success',"Create Sub Project Success.");
        return redirect(route('projects'));   
    }

    public function editProject(Request $request,$id)
    {
        $rules = [
            'th_name' => 'required|string',
            'en_name' => 'required|string',
            'th_description' => 'required|string',
            'en_description' => 'required|string',
            'image_id' => 'required|integer',
            'order_no' => 'required|integer',
            'icon_active' => 'required',
            'icon' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $data = $request->all();
        unset($data['_token']);
        $project = Project::where('id',$id)->update($data);
        if(!$project){
            $request->session()->flash('error',"Update project fail.Please try again.");
            return redirect(route('projects'));   
        }
        $request->session()->flash('success',"Update Project Success.");
        return redirect(route('projects'));   
    }

    public function editSubProject(Request $request,$id)
    {
        $rules = [
            'th_name' => 'required|string',
            'en_name' => 'required|string',
            'th_description' => 'required|string',
            'en_description' => 'required|string',
            'image_id' => 'required|integer',
            'order_no' => 'required|integer',
            'main_id' => 'required|exists:projects,id',
            'external_path' => 'nullable',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $data = $request->all();
        unset($data['_token']);
        $project = Subproject::where('id',$id)->update($data);
        if(!$project){
            $request->session()->flash('error',"Update sub project fail.Please try again.");
            return redirect(route('projects'));   
        }
        $request->session()->flash('success',"Update Sub Project Success.");
        return redirect(route('projects'));   
    }

    public function deleteMainProject(Request $request,$id)
    {
        $project = Project::find($id);
        if(!$project){
            $request->session()->flash('error',"Can't find this project.");
            return redirect(route('projects'));   
        }
        $subproject = Subproject::where('main_id',$id)->delete();
        $project->delete();
        if(!$project){
            $request->session()->flash('error', "Delete project fail.");
            return redirect(route('projects'));   
        }
        $projects = Project::get();
        foreach($projects as $project){
            $project->images->path;
        }
        $request->session()->flash('success',"Delete Project Success.");
        return redirect(route('projects'));   
    }

    public function deleteSubProject(Request $request,$id)
    {
        $subproject = Subproject::find($id);
        if(!$subproject){
            return [ 'status'=> 'error','message' => "Can't find this sub-project." ];
        }
        $main_id = $subproject->main_id;
        $subproject->delete();
        if(!$subproject){
            return [ 'status'=> 'error','message' => "Delete sub-project fail." ];
        }
        $subprojects = Subproject::where('main_id',$main_id)->orderBy('order_no','asc')->get();
        foreach($subprojects as $subproject){
            $subproject->images->path;
        }
        return [ 'status'=> 'success','message' => $subprojects ];
    }
}
