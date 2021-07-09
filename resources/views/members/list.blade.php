@extends('layouts.base')

@section('content')
<script>
    var positions = <?php echo json_encode($positions); ?>;
    var members = <?php echo json_encode($members); ?>;
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mb-3 mb-md-0 order-1 order-md-0">
            <div class="card">
                <div class="card-header">Members</div>
                <div class="card-body" style="max-height: 680px;overflow: auto;">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <a href="{{route('members.create')}}" class="btn btn-outline-info btn-sm">Create Members</a>
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

                    <ul class="list-group" id="member-list">
                        @foreach($members as $member)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="row">
                                <div class="col-4" style="max-width:200px;">
                                    <img class="w-100" src="{{ asset($member->images->path) }}" alt="">
                                </div>
                                <div class="col-8">
                                    {{ $member->th_name }} ({{ $member->en_name }}) <br>
                                    <p class="pt-3 mb-0"><strong>Position:</strong> {{ $member->positions->name_en }}</p>
                                    <p><strong>Education Level:</strong> {{ $member->levels->name_en }}</p>
                                </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="{{route('members.edit',[ 'id' => $member->id ])}}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeleteMemberBtn({{ $member->id}})">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0 order-md-1">
            <div class="card">
                <div class="card-header">Members Interest Fields</div>
                <div class="card-body" style="max-height: 680px;overflow: auto;">
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="javascript:interestFieldsfilter(-1)">Show All</a>
                                </li>
                                @foreach($fields as $field)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="javascript:interestFieldsfilter({{ $field['id'] }})">{{ $field['name'] }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4 mb-3 mb-md-0 order-2'>
            <div class="card mb-3">
                <div class="card-header">Add Position</div>
                <div class="card-body">
                    <form id="position-add">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Thai</span>
                            </div>
                            <input type="text" class="form-control" placeholder="ชื่อตำแหน่ง" name="position_th">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">English</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Position Name" name="position_en">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Priority</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Number of priority" name="priority_pos">
                        </div>
                        <div class="w-100 text-right">
                            <button type="submit" class="btn btn-outline-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Members Position</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-group" id="position-list">
                                @foreach($positions as $position)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $position['name_th'] }} / {{ $position['name_en'] }}
                                    </div>
                                    <div class="float-right">
                                        <div class="d-inline-flex">
                                            <button class="btn btn-outline-danger btn-sm" onclick="deletePosition({{$position['id'] }})">Delete</button>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
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
        Do you want to delete this Member?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="deleteMemberBtn" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection
