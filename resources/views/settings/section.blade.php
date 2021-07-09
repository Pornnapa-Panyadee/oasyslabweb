@extends('layouts.base')

@section('content')
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Sections setting</div>

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

                    <form method="POST" action="{{ route('settings.section.edit') }}">
                        {{ csrf_field() }}
                        @foreach ($sections as $key=> $section)
                            <div class="row">
                                <div class="col-12 d-flex flex-column justify-content-between mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Section {{ $key+1 }}</span>
                                        </div>
                                        <select class="form-control" id="positions" name="data[{{$key}}][id]">
                                            @foreach($defaults as $key=>$default)
                                                @if($default['name'] == $section->name)
                                                    <option value="{{$key}}" selected>{{$default['name']}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$default['name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success btn-sm mr-1">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
