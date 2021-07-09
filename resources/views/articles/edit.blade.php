@extends('layouts.base')

@section('content')
<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Article</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('article.editArticle',$article->id) }}" aria-label="{{ __('edit') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="slug" class="col-4 col-md-2 col-form-label">Name URL</label>
                                <div class="col-8 col-md-10">
                                    <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug') == null? $article->slug:old('slug') }}" required autofocus>
                                    @if ($errors->has('slug'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title_th" class="col-4 col-md-2 col-form-label">ชื่อเรื่อง</label>
                                <div class="col-8 col-md-10">
                                    <input id="title_th" type="text" class="form-control{{ $errors->has('title_th') ? ' is-invalid' : '' }}" name="title_th" value="{{ old('title_th') == null? $article->title_th:old('title_th') }}" required autofocus>
                                    @if ($errors->has('title_th'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title_th') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title_en" class="col-4 col-md-2 col-form-label">Title</label>
                                <div class="col-8 col-md-10">
                                    <input id="title_en" type="text" class="form-control{{ $errors->has('title_en') ? ' is-invalid' : '' }}" name="title_en" value="{{ old('title_en') == null? $article->title_en:old('title_en') }}" required autofocus>
                                    @if ($errors->has('title_en'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type_id" class="col-4 col-md-2 col-form-label">Type</label>
                                <div class="col-8 col-md-10">
                                    <select class="form-control{{ $errors->has('type_id') ? ' is-invalid' : '' }}" id="type_id" name="type_id">
                                        @foreach($types as $type)
                                            @if(old('type_id') == $type['id'])
                                                <option value="{{$type['id']}}" selected>{{$type['type']}}</option>
                                            @elseif($type['id'] == $article->type_id && (old('type_id') == '' || old('type_id') == NULL))
                                                <option value="{{$type['id']}}" selected>{{$type['type']}}</option>
                                            @else
                                                <option value="{{$type['id']}}">{{$type['type']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title_en" class="col-4 col-md-2 col-form-label">Cover Image</label>
                                <div class="col-8 col-md-10">
                                    <div class="form-group" id="image-preview">
                                        @if($article->cover_id)
                                            <img class="w-100" src="{{ asset($article->images->path)}}" alt="">
                                        @else
                                            <div class="image-preview-temp" style="height: 200px;"></div>
                                        @endif
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImages()">Choose Image</button>
                                        <input type="hidden" name="image_id">
                                    </div>
                                    @if ($errors->has('image_id'))
                                        <small class="form-text text-danger">Please select image</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="detail_th" class="col-4 col-md-2 col-form-label">รายละเอียด</label>
                                <div class="col-12">
                                    <textarea name="detail_th" id="editor" row="10">{{ old('detail_th') == null? $article->detail_th:old('detail_th') }}</textarea>
                                    <!-- <input id="detail_th" type="text" class="form-control{{ $errors->has('detail_th') ? ' is-invalid' : '' }}" name="detail_th" value="{{ old('detail_th') }}" required autofocus> -->
                                    @if ($errors->has('detail_th'))
                                            <small class="form-text text-danger">{{ $errors->first('detail_th') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="detail_en" class="col-4 col-md-2 col-form-label">Description</label>

                                <div class="col-12">
                                    <!-- <input id="detail_en" type="text" class="form-control{{ $errors->has('detail_en') ? ' is-invalid' : '' }}" name="detail_en" value="{{ old('detail_en') }}" required autofocus> -->
                                    <textarea name="detail_en" id="editor1" row="10">{{ old('detail_en') == null? $article->detail_en:old('detail_en') }}</textarea>
                                    @if ($errors->has('detail_en'))
                                            <small class="form-text text-danger">{{ $errors->first('detail_en') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="order_no" class="col-4 col-md-2 col-form-label">Order No.</label>
                                <div class="col-8 col-md-10">
                                    <input type="text" class="form-control" id="order_no" placeholder="ลำดับการโชว์" name="order_no" value="{{ old('order_no') == null? $article->order_no:old('order_no') }}">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="imagesmodal" tabindex="-1" role="dialog" aria-labelledby="imagesmodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="fields-edit">
                <div class="modal-body image">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="image-search">Search</button>
                        </div>
                    </div>
                    <div class="row" id="images-list">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="chooseImageBtn()">Choose</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'editor' );
    CKEDITOR.replace( 'editor1' );
</script>
@endsection
