@extends('layouts.base')

@section('content')
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">About Us & Contact</div>

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

                        
                    @foreach ($details as $key=> $detail)
                        @if($detail->keyword != "stat-Projects" && $detail->keyword != "stat-Members")
                        <div class="row">
                            <div class="col-12 d-flex flex-column justify-content-between">
                                <div class="form-group mb-0">
                                    <label for="inputAddress"><strong>{{ $detail->keyword }}</strong> </label>
                                </div>
                                @if($detail->th_name != null)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ชื่อ</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $detail->th_name }}" name="th_name{{ $detail->id }}">
                                </div>
                                @endif
                                @if($detail->en_name != null)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Name</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $detail->en_name }}" name="en_name{{ $detail->id }}">
                                </div>
                                @endif
                                @if($detail->th_description != null)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">รายละเอียด</span>
                                    </div>
                                    @if($detail->keyword == "aboutus")
                                        <textarea class="form-control" rows="10" name="th_description{{ $detail->id }}">{{ $detail->th_description }}</textarea>
                                    @else
                                        <textarea class="form-control" rows="3" name="th_description{{ $detail->id }}">{{ $detail->th_description }}</textarea>
                                    @endif
                                </div>
                                @endif
                                @if($detail->en_description != null)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Description</span>
                                    </div>
                                    @if($detail->keyword == "aboutus")
                                        <textarea class="form-control" rows="10" name="en_description{{ $detail->id }}">{{ $detail->en_description }}</textarea>
                                    @else
                                        <textarea class="form-control" rows="3" name="en_description{{ $detail->id }}">{{ $detail->en_description }}</textarea>
                                    @endif
                                </div>
                                @endif
                                @if($detail->path != null)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Link</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $detail->path }}" name="path{{ $detail->id }}">
                                </div>
                                @endif
                                 @if(is_int($detail->amount))
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Amount</span>
                                    </div>
                                    <input type="number" class="form-control" value="{{ $detail->amount }}" name="amount{{ $detail->id }}">
                                </div>
                                @endif
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="saveDetail({{ $detail->id }})">Save</button>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
