@extends('layouts.base')
@section('content')
<script>
    members = <?php echo json_encode($members); ?>;
</script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Publications</div>
                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="positions">Publication Types</label>
                                <select class="form-control" id="positions" name="type_id">
                                    @foreach($types as $type)
                                        @if($type->id == $publication->type_id)
                                            <option value="{{$type->id}}" selected>{{$type->en_name}}</option>
                                        @else
                                            <option value="{{$type->id}}">{{$type->en_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small id="type_text" class="form-text text-danger" style="display:none;">Please choose type of publication.</small>
                            </div>
                            <div class="form-group">
                                <label for="detail">Publication Text</label>
                                <textarea class="form-control" id="detail" rows="3" name="detail">{{$publication->detail}}</textarea>
                                <small id="detail_text" class="form-text text-danger" style="display:none;">Please fill detail of publication.</small>
                            </div>
                            <div class="form-group">
                                <label for="total_members">Total Authors</label>
                                <input type="number" class="form-control" id="total_members" placeholder="0" name="total_members" value="{{$publication->total_members}}">
                                <small id="total_text" class="form-text text-danger" style="display:none;">Please fill number of authors.</small>
                            </div>
                            <input type="hidden" class="form-control" name="id" value="{{$publication->id}}">
                        </div>
                        <div class="col-12" id="order_author_list">
                            @for($i = 1; $i <= sizeOf($authors); $i++)
                            <div class="form-group row">
                                <label for="no1" class="col-sm-3 col-form-label">Author order. {{$i}}</label>
                                <input type="hidden" class="form-control" name="no{{$i}}">
                                <div class="col-sm-9">
                                    <select class="form-control" id="member_id_{{$i}}" name="member_id_{{$i}}">
                                            <option value = "">Select Member</option>
                                        @foreach($members as $member)
                                            @if($member->id == $authors[$i-1]['member_id'])
                                                <option value="{{$member->id}}" selected>{{$member->en_name}}</option>
                                            @else
                                                <option value="{{$member->id}}">{{$member->en_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="editPublication({{$publication->id}})">Edit Publications</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
