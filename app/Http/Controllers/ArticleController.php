<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $articleTypes = ArticleType::get();
        foreach($articleTypes as $articleType){
            $articles = $articleType->articles;
            foreach($articles as $article){
                $article->images;
            }
        }
        return view('articles.list')->with(['articleTypes' => $articleTypes]);
    }

    public function showCreateArticleForm(Request $request)
    {
        $types = ArticleType::get();
        return view('articles.create')->with(['types' => $types]);
    }

    public function create(Request $request)
    {
        $rules = [
            'slug' => 'required|string|unique:articles,slug',
            'title_th' => 'required|string',
            'title_en' => 'required|string',
            'type_id' => 'required|integer',
            'cover_id' => 'integer|nullable',
            'detail_th' => 'required|string',
            'detail_en' => 'required|string',
            'order_no' => 'string|nullable',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $crateStatus = Article::store($request->all());
        if($crateStatus == 'fail'){
            return view('articles.create');
        }
        return redirect(route('article'));
    }

    public function showEditArticleForm(Request $request,$id)
    {
        $article = Article::find($id);
        $types = ArticleType::get();
        if(!$article){
            $request->session()->flash('error',"Article not found.");
            return redirect(route('article'));
        }
        return view('articles.edit')->with(['article' => $article,'types' => $types]);
    }

    public function edit(Request $request,$id)
    {
        $rules = [
            'slug' => 'required|string|unique:articles,slug,'.$id,
            'title_th' => 'required|string',
            'title_en' => 'required|string',
            'type_id' => 'required|integer',
            'cover_id' => 'integer|nullable',
            'detail_th' => 'required|string',
            'detail_en' => 'required|string',
            'order_no' => 'string|nullable',
        ];
        $validator = Validator::make($request->all(),$rules)->validate();
        $editStatus = Article::edit_article($request->all(),$id);
        if($editStatus == 'fail'){
            return view('articles.edit')->with(['article' => $article]);
        }
        return redirect(route('article'));
    }

    public function delete(Request $request,$id)
    {
        $deleteStatus = Article::delete_article($request->all(),$id);
        return [ 'status'=> 'success','message' => '' ];
    }

    public function changeToPublish(Request $request,$id)
    {
        $article = Article::find($id);
        if(!$article){
            $request->session()->flash('error',"Article not found.");
            return redirect(route('article'));
        }
        $article->completed = 1;
        $article->save();
        if(!$article){
            $request->session()->flash('error',"Update article fail.");
            return redirect(route('article'));
        }
        return redirect(route('article'));
    }

    public function changeToDraft(Request $request,$id)
    {
        $article = Article::find($id);
        if(!$article){
            $request->session()->flash('error',"Article not found.");
            return redirect(route('article'));
        }
        $article->completed = 0;
        $article->save();
        if(!$article){
            $request->session()->flash('error',"Update article fail.");
            return redirect(route('article'));
        }
        return redirect(route('article'));
    }
}
