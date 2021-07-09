<?php $__env->startSection('content'); ?>
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
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php elseif(session('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="image">                        
                        <!-- <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" name="search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="image-search">Search</button>
                            </div>
                        </div> -->
                        <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-6 col-md-4 mb-3">
                                <div class="image-wrapper shadow-sm">
                                    <img class="w-100" src="<?php echo e(asset($image->path)); ?>" alt="">
                                    <p class="text-center mb-0 pt-2"><?php echo e($image->name); ?></p>
                                    <div class="text-right pb-2 pr-2">
                                    <form class="form-horizontal" action="<?php echo e(route('images.delete',[ 'id' => $image->id ])); ?>" method="POST">
                                        <?php echo e(csrf_field()); ?>

                                        <?php echo e(method_field('DELETE')); ?>

                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form> 
                                    </div>
                                </div>
                            </div>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <p>No Images</p>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="<?php echo e(route('images.upload')); ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <label for="imagefile">Select Image file</label>
                        <input type="file" class="form-control-file" id="imagefile" name="file">
                    </div>
                    <div class="form-group">
                        <label for="imagename">Image Name</label>
                        <input type="text" class="form-control" id="imagename" placeholder="Image name" name="file_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>