@extends('layouts.base')

@section('content')
<script>
    allImages = <?php echo json_encode($images); ?>;
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#exampleModalLong">
                Upload Images
            </button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Images</div>

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

                    <div class="image">                        
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" name="search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="image-search-page">Search</button>
                            </div>
                        </div>
                        <div class="row" id="images-list-page" style="max-height: 550px;overflow: auto;">
                        @forelse ($images as $image)
                            <div class="col-6 col-md-4 mb-3">
                                <div class="image-wrapper shadow-sm">
                                    <img class="w-100" src="{{ asset($image->path)}}" alt="">
                                    <p class="text-center mb-0 pt-2">{{ $image->name }}</p>
                                    <div class="text-right pb-2 pr-2">
                                    <form class="form-horizontal" action="{{route('images.delete',[ 'id' => $image->id ])}}" method="POST">
                                        {{ csrf_field() }}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form> 
                                    </div>
                                </div>
                            </div>
                            
                        @empty
                            <div class="col-12">
                                <p>No Images</p>
                            </div>
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('images.upload') }}" enctype="multipart/form-data" id="uploadImage">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="imagefile">Select Image file</label>
                        <input type="file" class="form-control-file" id="imagefile" name="file">
                        <small id="fileHelp" class="form-text text-danger" style="display:none;">Maximum File Size You Can Upload Should Less Than 2.5 MB.</small>
                    </div>
                    <div class="form-group">
                        <label for="imagename">Image Name</label>
                        <input type="text" class="form-control" id="imagename" placeholder="Image name" name="file_name">
                        <small id="nameImage" class="form-text text-danger" style="display:none;">Please fill name of image.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" disabled id="uploadImageBtn">Upload Image</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
