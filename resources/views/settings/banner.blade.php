@extends('layouts.base')

@section('content')
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Banner</div>

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

                        
                    @foreach ($banners as $key=> $banner)
                        <div class="row banner-wrapper pt-3">
                            <div class="col-6">
                                <div class="form-group" id="image-preview{{ $banner->order_no }}">
                                @if(isset($banner->image))
                                    <img class="w-100" src="{{ asset($banner->image->path)}}" alt="">
                                @else
                                    <div class="image-preview-temp"></div>
                                @endif
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImagesBanner({{ $banner->order_no }})">Choose Image</button>
                                    <input type="hidden" name="image_id{{ $banner->order_no }}">
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-between">
                                <div class="form-group">
                                    <label for="inputAddress"><strong>Order no.</strong> {{ $banner->order_no }}</label>
                                    <input type="text" class="form-control" id="banner_order_no{{ $banner->order_no }}" value="{{ $banner->external_path }}" name="external_path{{ $banner->order_no }}">
                                </div>
                                <div class="form-group text-right">
                                    <!-- @if($key == 4)
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn disabled" disabled><i class="material-icons">keyboard_arrow_down</i></button>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn"><i class="material-icons">keyboard_arrow_down</i></button>
                                    @endif
                                    @if($key == 0)
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn" disabled><i class="material-icons">keyboard_arrow_up</i></button>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn"><i class="material-icons">keyboard_arrow_up</i></button>
                                    @endif -->
                                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="saveBanner({{ $banner->order_no }})">Save</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                <div class="modal-footer" id="bannerChooseBtn">
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
