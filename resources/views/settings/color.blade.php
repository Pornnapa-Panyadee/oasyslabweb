@extends('layouts.base')

@section('content')
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Color setting</div>

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

                    <form method="POST" action="{{ route('settings.colors.edit') }}">
                        {{ csrf_field() }}
                        @foreach ($colors as $key=> $colors)
                            <div class="row">
                                <div class="col-2 col-md-1">
                                    <div class="form-group mb-0 border">
                                        <div style="background-color:{{ $colors->code }};height:2rem;"></div>
                                    </div>
                                </div>
                                <div class="col-10 col-md-11 d-flex flex-column justify-content-between mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">{{ $colors->keyword }}</span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $colors->code }}" name="{{ $colors->keyword }}">
                                    </div>
                                    @if ($errors->has($colors->keyword))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first($colors->keyword) }}</strong>
                                        </span>
                                    @endif
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
