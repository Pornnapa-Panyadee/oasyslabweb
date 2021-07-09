<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Publication;
use App\Models\PublicationsType;
use App\Models\PublicationsMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PublicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $publicationTypes = PublicationsType::get();
        foreach($publicationTypes as $publicationType){
            $publications = $publicationType->publications;
            foreach($publications as $publication){
                $publicationMembers = $publication->publicationMembers;
                foreach($publicationMembers as $publicationMember){
                    $member = $publicationMember->members;
                    $member->images;
                }
            }
        }
        return view('publications.list')->with(['publicationTypes' => $publicationTypes]);
    }

    public function create(Request $request)
    {
        $members = Member::get();
        $types = PublicationsType::get();
        return view('publications.create')->with(['types' => $types,'members' => $members]);
    }

    public function createPublication(Request $request)
    {
        $rules = [
            'type_id' => 'required|integer',
            'detail' => 'required|string',
            'total_members' => 'required|integer',
            'members' => 'required|array',
            'members.*.order_id' => 'required',
            'members.*.member_id' => 'integer|nullable',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => $validator->errors() ];
        }
        $data = $request->all();
        $members = $data['members'];
        unset($data['_token']);
        unset($data['members']);
        $publication = Publication::create($data);
        if(!$publication){
            return [ 'status'=> 'error','message' => 'Create publication fail.' ];
        }
        if(isset($members)){
            foreach($members as $member){
                if(!empty($member['member_id'])){
                    $data = [
                        'order_member' => $member['order_id'],
                        'member_id' => $member['member_id'],
                        'publication_id' => $publication->id
                    ];
                    $publicationMember = PublicationsMember::create($data);
                    if(!$publicationMember){
                        return [ 'status'=> 'error','message' => 'Add member to publication fail.' ];
                    }
                }
            }
        } 
        return [ 'status'=> 'success','message' => 'done' ];
    }

    public function edit(Request $request,$id)
    {
        $publication = Publication::find($id);
        $members = Member::get();
        $types = PublicationsType::get();
        $order_authors = $publication->publicationMembers;
        $authors = [];
        for ($i=1; $i <= (int)$publication->total_members; $i++) { 
            $temp = '';
            foreach($order_authors as $order_author){
                if($order_author->order_member == $i){
                    $temp = [
                        'order_no' => $order_author->order_member,
                        'member_id' => $order_author->member_id
                    ];
                }
            }
            if($temp == ''){
                $temp = [
                    'order_no' => $i,
                    'member_id' => ''
                ];
            }
            array_push($authors,$temp);
        }
        return view('publications.edit')->with(['publication' => $publication,'types' => $types,'members' => $members,'authors'=> $authors]);
    }

    public function editPublication(Request $request,$id)
    {
        $rules = [
            'type_id' => 'required|integer',
            'detail' => 'required|string',
            'total_members' => 'required|integer',
            'members' => 'required|array',
            'members.*.order_id' => 'required',
            'members.*.member_id' => 'integer|nullable',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [ 'status'=> 'error','message' => $validator->errors() ];
        }
        $data = $request->all();
        $members = $data['members'];
        unset($data['_token']);
        unset($data['members']);
        $publication = Publication::where('id',$id)->update($data);
        if(!$publication){
            return [ 'status'=> 'error','message' => 'Create publication fail.' ];
        }
        if(isset($members)){
            foreach($members as $member){
                if(!empty($member['member_id'])){
                    $data = [
                        'order_member' => $member['order_id'],
                        'member_id' => $member['member_id'],
                        'publication_id' => $id
                    ];
                    $publicationMember = PublicationsMember::updateOrCreate(
                        ['order_member' => $data['order_member'],'publication_id' => $data['publication_id']],
                        ['member_id' => $data['member_id']]
                    );
                    if(!$publicationMember){
                        return [ 'status'=> 'error','message' => 'Edit member to publication fail.' ];
                    }
                }else{
                    PublicationsMember::where('publication_id',$id)->where('order_member',$member['order_id'])->delete();
                }
            }
        } 
        return [ 'status'=> 'success','message' => 'done' ];
    }

    public function deletePublication(Request $request,$id)
    {
        $publication = Publication::find($id);
        if(!$publication){
            return [ 'status'=> 'error','message' => "Can't find this publication." ];   
        }
        $publicationMember = PublicationsMember::where('publication_id',$id)->delete();
        $publication->delete();
        if(!$publication){
            return [ 'status'=> 'error','message' => "Delete publication fail." ]; 
        }
        return [ 'status'=> 'success','message' => 'done' ];
    }
}
