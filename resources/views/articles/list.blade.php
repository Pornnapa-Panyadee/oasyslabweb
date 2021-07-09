@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-end mb-3">
            <a href="{{route('article.createArticle')}}" class="btn btn-outline-info btn-sm">Create Article</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Article</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @foreach($articleTypes as $articleType)
                        <h5>{{ $articleType->type }}</h5>
                        <ul class="list-group pb-4">
                            @foreach($articleType->articles as $article)
                            <li class="list-group-item d-flex justify-content-between align-items-center row mx-1">
                                <div class="col-12 px-0">
                                    {{ $article->title_th }} ({{ $article->title_en }}) <br>
                                </div>
                                <div class="col-12 text-right px-0">
                                    @if($article->completed == 0)
                                        <button type="button" class="btn btn-outline-danger btn-sm mr-1" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeleteArticleBtn({{ $article->id}})">Delete</button>
                                        <a href="{{route('article.edit',[ 'id' => $article->id ])}}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <a href="{{route('article.publish',[ 'id' => $article->id ])}}" class="btn btn btn-success btn-sm mr-1">Publish</a>
                                    @else
                                        <a href="{{route('article.draft',[ 'id' => $article->id ])}}" class="btn btn-secondary btn-sm mr-1">Draft</a>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you want to delete this Publication?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="deleteArticleBtn">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection
