<?php $__env->startSection('content'); ?>
<script>
    var project = <?php echo json_encode($project); ?>;
</script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Main Project</div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('projects.editProject',['id'=>$project->id])); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 text-center">
                                <div class="form-group" id="image-preview">
                                    <img class="w-100" src="<?php echo e(asset($project->images->path)); ?>" alt="">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImages()">Choose Image</button>
                                    <input type="hidden" name="image_id" value="<?php echo e($project->image_id); ?>">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label for="th_name">ชื่อ</label>
                                    <input type="text" class="form-control" id="th_name" placeholder="ชื่อ" name="th_name" value="<?php echo e($project->th_name); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="en_name">Name</label>
                                    <input type="text" class="form-control" id="en_name" placeholder="Name" name="en_name" value="<?php echo e($project->en_name); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="th_description">รายละเอียด</label>
                                    <textarea class="form-control" id="th_description" rows="3" name="th_description"><?php echo e($project->th_description); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="en_description">Description</label>
                                    <textarea class="form-control" id="en_description" rows="3" name="en_description"><?php echo e($project->en_description); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="order_no">Ordering No.</label>
                                    <input type="text" class="form-control" id="order_no" placeholder="ลำดับการโชว์" name="order_no" value="<?php echo e($project->order_no); ?>">
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Edit Project</button>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>