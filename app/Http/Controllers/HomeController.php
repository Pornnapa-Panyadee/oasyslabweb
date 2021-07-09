<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Detail;
use App\Models\Color;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Member;
use App\Models\Publication;
use App\Models\PublicationsType;
use App\Models\PublicationsMember;
use App\Models\ResearchInterest;
use App\Models\MemberInterest;
use App\Models\Article;
use App\Models\ArticleType;
use App\Models\Section;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function indexFrontend()
    {
        $colors = Color::get();
        $sections = Section::get();
        return view('frontend.home')->with(['colors' => $colors, 'sections' => $sections]);
    }

    public function indexPublications()
    {
        $colors = Color::get();
        return view('frontend.publications')->with(['colors' => $colors]);
    }

    public function indexMembers()
    {
        $colors = Color::get();
        return view('frontend.members')->with(['colors' => $colors]);
    }

    public function indexMember($slug)
    {
        $colors = Color::get();
        return view('frontend.member')->with(['colors' => $colors]);
    }

    public function indexField($slug)
    {
        $colors = Color::get();
        return view('frontend.field')->with(['colors' => $colors]);
    }

    public function indexArticle($slug)
    {
        $colors = Color::get();
        return view('frontend.article')->with(['colors' => $colors]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function getBanners()
    {
        $banners = Banner::orderBy('order_no','asc')->get();
        foreach ($banners as $key => $banner) {
            $banner->image;
        }
        return response()->json(['data' => $banners], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getAboutUs()
    {
        $data = ['aboutus','stat-Projects','stat-Devices','stat-Areas','stat-Members'];
        $details = Detail::whereIn('keyword',$data)->get();
        foreach($details as $detail){
            if($detail->keyword == 'stat-Projects'){
                $detail->amount = Subproject::get()->count();
            }
            else if($detail->keyword == 'stat-Members'){
                $detail->amount = Member::get()->count();
            }
        }
        return response()->json(['data' => $details], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getContact()
    {
        $data = ['address','email','tel','facebook'];
        $details = Detail::whereIn('keyword',$data)->get();
        return response()->json(['data' => $details], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getProjects()
    {
        $projects = Project::get();
        foreach($projects as $project){
            $project->images;
            $subProjects = SubProject::where('main_id',$project->id)->get();
            foreach($subProjects as $subProject){
                $subProject->images;
            }
            $project->subprojects = $subProjects;
        }
        return response()->json(['data' => $projects], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getMembers()
    {
        $members = Member::get();
        foreach($members as $member){
            $member->positions;
            $member->images;
            $member->levels;
        }
        return response()->json(['data' => $members], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getMember($slug)
    {
        $slug = strtolower($slug);
        $member = Member::where('slug',$slug)->first();
        if(!$member){
            return response()->json(['data' => 'error, Member not found.'], 200, [], JSON_UNESCAPED_SLASHES);
        }
        $member->positions;
        $member->images;
        $member->levels;
        $fieldsInterestList = $member->fieldsInterest;
        foreach ($fieldsInterestList as $key => $fieldsInterest) {
            $tempData = $fieldsInterest->fieldInterest;
            $fieldsInterest->name = $tempData->name;
            $fieldsInterest->slug = $tempData->slug;
            unset($fieldsInterest->fieldInterest);
            unset($fieldsInterest->member_id);
        }
        $publicationLists = $member->publications;
        foreach($publicationLists as $publicationList){
            $publicationList->publications;
            $type = $publicationList->publications->publicationType;
            unset($publicationList->publications->publicationType);
            $publicationList->type = $type;
        }
        return response()->json(['data' => $member], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getPublications()
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
        return response()->json(['data' => $publicationTypes], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getTags()
    {
        $tags = ResearchInterest::get();
        return response()->json(['data' => $tags], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getTag($slug)
    {
        $slug = strtolower($slug);
        $tag = ResearchInterest::where('slug',$slug)->first();
        $tagMembersList = $tag->MembersInterest;
        foreach($tagMembersList as $tagMemberList){
            $temp = $tagMemberList->member;
            $temp->positions;
            $temp->images;
            $temp->levels;
            unset($tagMemberList->member_id);
            unset($tagMemberList->field_id);
            unset($tagMemberList->id);
        }
        return response()->json(['data' => $tag], 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getColors()
    {
        $colors = Color::get();
        return response()->json(['data' => $colors], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function getArticles(Request $request)
    {
        $articleTypes = ArticleType::get();
        foreach($articleTypes as $articleType){
            $articles = $articleType->articles;
            foreach($articles as $article){
                $article->images;
            }
        }
        return response()->json(['data' => $articleTypes], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function getArticle($slug)
    {
        $slug = strtolower($slug);
        $article = Article::where('slug',$slug)->first();
        if(!$article){
            return response()->json(['data' => 'error, Article not found.'], 200, [], JSON_UNESCAPED_SLASHES);
        }
        $article->images;
        return response()->json(['data' => $article], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function getSections()
    {
        $sections = Section::get();
        return response()->json(['data' => $sections], 200, [], JSON_UNESCAPED_SLASHES);
    }
}
