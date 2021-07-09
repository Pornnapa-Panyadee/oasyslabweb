@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-end mb-3">
            <a href="{{route('users.createUser')}}" class="btn btn-outline-info btn-sm">Create User</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

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

                    <ul class="list-group">
                        @foreach($users as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="row w-100">
                                <div class="col-12 d-flex justify-content-between ">
                                    <div>
                                        {{ $user->name }} ({{ $user->email }}) <br>
                                        Created_at {{ $user->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="float-right">
                                        @if($user->role_id != 1)
                                            <div class="d-inline-flex">
                                                <a href="{{route('users.edit',[ 'id' => $user->id ])}}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                                <form class="form-horizontal" action="{{route('users.delete',[ 'id' => $user->id ])}}" method="POST">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form> 
                                            </div>
                                        @endif
                                    </div>
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
@endsection
