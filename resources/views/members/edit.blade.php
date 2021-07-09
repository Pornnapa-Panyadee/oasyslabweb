@extends('layouts.base')
@section('content')
<script>
    fields = <?php echo json_encode($fields); ?>;
    memberFields = <?php echo json_encode($memberFields); ?>;
</script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Members</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('members.editMembers',['id'=>$member->id]) }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-12 col-md-4 text-center">
                                <div class="form-group" id="image-preview">
                                    <img class="w-100" src="{{ asset($member->images->path)}}" alt="">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImages()">Choose Image</button>
                                    <input type="hidden" name="image_id" value="{{$member->image_id}}">
                                </div>
                                @if ($errors->has('image_id'))
                                    <small class="form-text text-danger">Please select image</small>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label for="name_th">ชื่อ - นามสกุล</label>
                                    <input type="text" class="form-control" id="name_th" placeholder="ชื่อ-นามสกุล" name="th_name" value="{{ old('th_name') == null? $member->th_name: old('th_name')}}">
                                    @if ($errors->has('th_name'))
                                        <small class="form-text text-danger">{{ $errors->first('th_name') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name_en">Firstname - Lastname</label>
                                    <input type="text" class="form-control" id="name_en" placeholder="Firstname - Lastname" name="en_name" value="{{ old('en_name') == null? $member->en_name: old('en_name')}}">
                                    @if ($errors->has('en_name'))
                                        <small class="form-text text-danger">{{ $errors->first('en_name') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="education_levels">Education Levels</label>
                                    <select class="form-control" id="education_levels" name="level_id">
                                        @foreach($levels as $level)
                                            @if(old('level_id') == $level['id'])
                                                <option value="{{$level['id']}}" selected>{{$level['name_en']}}</option>
                                            @elseif($level['id'] == $member->level_id && (old('level_id') == '' || old('level_id') == NULL))
                                                <option value="{{$level['id']}}" selected>{{$level['name_en']}}</option>
                                            @else
                                                <option value="{{$level['id']}}">{{$level['name_en']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="positions">Lab's Position</label>
                                    <select class="form-control" id="positions" name="position_id">
                                        @foreach($positions as $position)
                                            @if(old('position_id') == $level['id'])
                                                <option value="{{$position['id']}}" selected>{{$position['name_en']}}</option>
                                            @elseif($position['id'] == $member->position_id && (old('position_id') == '' || old('position_id') == NULL))
                                                <option value="{{$position['id']}}" selected>{{$position['name_en']}}</option>
                                            @else
                                                <option value="{{$position['id']}}">{{$position['name_en']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') == null? $member->email: old('email')}}">
                                    @if ($errors->has('email'))
                                        <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website" placeholder="Website" name="website" value="{{ old('website') == null? $member->website: old('website')}}">
                                    @if ($errors->has('website'))
                                        <small class="form-text text-danger">{{ $errors->first('website') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description_th">รายละเอียด</label>
                                    <textarea class="form-control" id="description_th" rows="3" name="th_description">{{ old('th_description') == null? $member->th_description: old('th_description')}}</textarea>
                                    @if ($errors->has('th_description'))
                                        <small class="form-text text-danger">{{ $errors->first('th_description') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description_en">Description</label>
                                    <textarea class="form-control" id="description_en" rows="3" name="en_description">{{ old('en_description') == null? $member->en_description: old('en_description')}}</textarea>
                                     @if ($errors->has('en_description'))
                                        <small class="form-text text-danger">{{ $errors->first('en_description') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="fields_select">Fields Interest</label>
                                    <div>
                                        <div>
                                            <select class="form-control" id="fields_select" style="width:150px;">
                                                <option value="">Select Fields</option>
                                                @foreach($fields as $field)
                                                    <option value="{{$field['id']}}">{{$field['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="d-inline-flex w-100">
                                            <div id="fieldsInterest" class=" w-100">
                                            </div>
                                            <input type="hidden" name="field_interest">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Edit Member</button>
                            </div>
                        </div>
                    </form>
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
@endsection
