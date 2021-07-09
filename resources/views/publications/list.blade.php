@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Publications</div>
                <div class="card-body" style="max-height: 680px;overflow: auto;">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <a href="{{route('publications.create')}}" class="btn btn-outline-info btn-sm">Create Publication</a>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @foreach($publicationTypes as $publicationType)
                    <h5>{{$publicationType->en_name}}</h5>
                    <ul class="list-group mb-4" id="publication-list">
                        @foreach($publicationType->publications as $publication)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="row">
                                <div class="col-12">
                                    {!! $publication->detail !!}
                                </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="{{route('publications.edit',[ 'id' => $publication->id ])}}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeletePublicationBtn({{ $publication->id}})">Delete</button>
                                    </div>
                                </div>
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
        <button type="button" class="btn btn-primary" id="deletePublicationBtn">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection
