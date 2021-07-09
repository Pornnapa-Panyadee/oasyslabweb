<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MembersPosition;
use App\Models\ResearchInterest;
use App\Models\MemberInterest;
use App\Models\MembersLevel;
use App\Models\PublicationsMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $fields = ResearchInterest::get()->toArray();
        $positions = MembersPosition::get()->toArray();
        $members = Member::get();
        foreach($members as $member){
            $member->positions;
            $member->images;
            $member->levels;
            $memberFields = MemberInterest::where('member_id',$member->id)->pluck('field_id');
            $fieldsList = ResearchInterest::whereIn('id',$memberFields)->get();
            $member->field = $fieldsList;
        }
        return view('members.list')->with(['members' => $members,'positions' => $positions,'fields' => $fields]);
    }

    public function create(Request $request)
    {
        $fields = ResearchInterest::get()->toArray();
        $positions = MembersPosition::get()->toArray();
        $levels = MembersLevel::get()->toArray();
        return view('members.create')->with(['positions' => $positions,'fields' => $fields,'levels' => $levels]);
    }

    public function createMember(Request $request)
    {
        $rules = [
            'th_name' => 'required|string',
            'en_name' => 'required|string|unique:members,en_name',
            'level_id' => 'required|integer',
            'position_id' => 'required|integer',
            'email' => 'email|nullable',
            'website' => 'string|nullable',
            'th_description' => 'string|nullable',
            'en_description' => 'string|nullable',
            'image_id' => 'required',
            'order_no' => 'nullable|integer',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $data = $request->all();
        $tempName = explode(" ", strtolower($data['en_name']));
        $slug = join("-",$tempName);
        $data['slug'] = $slug;
        unset($data['_token']);
        $member = Member::create($data);
        if(!$member){
            $request->session()->flash('error',"Create member fail.Please try again.");
            return redirect(route('members'));
        }
        if(isset($data['field_interest'])){
            $fields = explode(",",$data['field_interest']);
            foreach($fields as $field){
                $data = [
                    'field_id' => $field,
                    'member_id' => $member->id
                ];
                $fieldMember = MemberInterest::create($data);
                if(!$fieldMember){
                    $request->session()->flash('error',"Can't add field interest to member.Please try again.");
                    return redirect(route('members'));
                }
            }
        }
        $request->session()->flash('success',"Create Member Success.");
        return redirect(route('members'));
    }

    public function edit(Request $request,$id)
    {
        $member = Member::find($id);
        if(!$member){
            $request->session()->flash('error',"Member not found.");
            return redirect(route('members'));
        }
        $memberFields = MemberInterest::where('member_id',$id)->get();
        foreach ($memberFields as $key => $memberField) {
            $memberField->fieldInterest;
        }
        $fields = ResearchInterest::get()->toArray();
        $positions = MembersPosition::get()->toArray();
        $levels = MembersLevel::get()->toArray();
        return view('members.edit')->with(['member' => $member,'positions' => $positions,'fields' => $fields,'levels' => $levels,'memberFields' => $memberFields]);
    }

    public function editMember(Request $request,$id)
    {
        $rules = [
            'th_name' => 'required|string',
            'en_name' => 'required|string|unique:members,en_name,'.$id,
            'level_id' => 'required|integer',
            'position_id' => 'required|integer',
            'email' => 'email|nullable',
            'website' => 'string|nullable',
            'th_description' => 'string|nullable',
            'en_description' => 'string|nullable',
            'image_id' => 'required',
            'order_no' => 'nullable|integer',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $data = $request->all();
        $fields = $data['field_interest'];
        $tempName = explode(" ", strtolower($data['en_name']));
        $slug = join("-",$tempName);
        $data['slug'] = $slug;
        unset($data['_token']);
        unset($data['field_interest']);
        $member = Member::where('id',$id)->update($data);
        if(!$member){
            $request->session()->flash('error',"Create member fail.Please try again.");
            return redirect(route('members'));
        }
        if(isset($fields)){
            $fields = explode(",",$fields);
            $fieldMembers = MemberInterest::where('member_id',$id)->get();
            foreach($fieldMembers as $fieldMember){
                if(!in_array($fieldMember->field_id, $fields)){
                    $fieldMember->delete();
                }else{
                    $key = array_search($fieldMember->field_id, $fields);
                    if(is_int($key)){
                        array_splice($fields, $key, 1);
                    }
                }
            }
            foreach($fields as $field){
                $data = [
                    'field_id' => $field,
                    'member_id' => $id
                ];
                $fieldMember = MemberInterest::create($data);
                if(!$fieldMember){
                    $request->session()->flash('error',"Can't add field interest to member.Please try again.");
                    return redirect(route('members'));
                }
            }
        }
        $request->session()->flash('success',"Create Member Success.");
        return redirect(route('members'));
    }

    public function deleteMember(Request $request,$id)
    {
        $member = Member::find($id);
        if(!$member){
            return [ 'status'=> 'error','message' => "Can't find this member." ];
        }
        $fieldMembers = MemberInterest::where('member_id',$id)->delete();
        $publicationMember = PublicationsMember::where('member_id',$id)->delete();
        $member->delete();
        if(!$member){
            return [ 'status'=> 'error','message' => "Delete Member fail." ];
        }
        $members = Member::get();
        foreach($members as $member){
            $member->positions;
            $member->images;
            $member->levels;
        }
        return [ 'status'=> 'success','message' => $members ];
    }

    public function createPosition(Request $request)
    {
        $rules = [
            'name_th' => 'required',
            'name_en' => 'required',
            'priority' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => 'Validate Fail.' ];
        }
        $position = MembersPosition::store($request->all());
        if($position == 'fail'){
            return [ 'status'=> 'error','message' => 'Create Fail.' ];
        }
        $positions = MembersPosition::orderBy('priority','asc')->get()->toArray();
        return [ 'status'=> 'success','message' => $positions ];
    }

    public function deletePosition(Request $request,$id)
    {
        $checkIdMember = Member::where('position_id',$id)->get()->toArray();
        if($checkIdMember){
            return [ 'status'=> 'error','message' => 'This position is already use.' ];
        }else{
            $position = MembersPosition::find($id);
            if(!$position){
                return [ 'status'=> 'error','message' => "Can't find this position." ];
            }else{
                $position->delete();
                if(!$position){
                    return [ 'status'=> 'error','message' => "Delete Position fail." ];
                }
            }
        }
        $positions = MembersPosition::orderBy('priority','asc')->get()->toArray();
        return [ 'status'=> 'success','message' => $positions ];
    }

    public function createField(Request $request)
    {
        $rules = [
            'name' => 'required|unique:research_interest_fields,name',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => 'Validate Fail.' ];
        }
        $tempName = explode(" ", strtolower($request['name']));
        $slug = join("-",$tempName);
        $field = ResearchInterest::updateOrCreate(['name' => $request['name'], 'slug' => $slug]);
        if(!$field){
            return [ 'status'=> 'error','message' => 'Create Fail.' ];
        }
        $fields = ResearchInterest::get()->toArray();
        return [ 'status'=> 'success','message' => $fields ];
    }

    public function editField(Request $request,$id)
    {
        $rules = [
            'name' => 'required|string|unique:research_interest_fields,name,'.$id,
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => 'Validate Fail.' ];
        }
        $field = ResearchInterest::find($id);
        if(!$field){
            return [ 'status'=> 'error','message' => "Can't find this field."];
        }else{
            $tempName = explode(" ", strtolower($request['name']));
            $slug = join("-",$tempName);
            $field->name = $request['name'];
            $field->slug = $slug;
            $field->save();
            if(!$field){
                return [ 'status'=> 'error','message' => "Update Field fail." ];
            }
        }
        $fields = ResearchInterest::get()->toArray();
        return [ 'status'=> 'success','message' => $fields ];
    }

    public function deleteField(Request $request,$id)
    {
        $checkIdMember = MemberInterest::where('field_id',$id)->get()->toArray();
        if($checkIdMember){
            return [ 'status'=> 'error','message' => 'This field is already use.' ];
        }else{
            $field = ResearchInterest::find($id);
            if(!$field){
                return [ 'status'=> 'error','message' => "Can't find this field." ];
            }else{
                $field->delete();
                if(!$field){
                    return [ 'status'=> 'error','message' => "Delete Field fail." ];
                }
            }
        }
        $fields = ResearchInterest::get()->toArray();
        return [ 'status'=> 'success','message' => $fields ];
    }

    // public function showDeletedUsers(Request $request)
    // {
    //     if(Auth::user()->role_id != 1){
    //         $request->session()->flash('error',"Permission Denied.");
    //         return redirect(route('home'));
    //     }
    //     $users = User::onlyTrashed()->get();
    //     if(!$users){
    //         $request->session()->flash('error',"User not found.");
    //         return redirect(route('users'));
    //     }
    //     return view('users.deleted')->with(['users' => $users]);
    // }

    // public function RestoreUser(Request $request,$id)
    // {
    //     if(Auth::user()->role_id != 1){
    //         $request->session()->flash('error',"Permission Denied.");
    //         return redirect(route('home'));
    //     }
    //     $user = User::withTrashed()->where('id', $id)->restore();
    //     if(!$user){
    //         $request->session()->flash('error',"Restore User fail.");
    //         return redirect(route('users'));
    //     }
    //     $request->session()->flash('status','success');
    //     return redirect(route('users'));
    // }
}
