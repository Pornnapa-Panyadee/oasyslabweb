<?php $__env->startSection('content'); ?>
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Banner</div>

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

                        
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row banner-wrapper pt-3">
                            <div class="col-6">
                                <div class="form-group" id="image-preview<?php echo e($banner->order_no); ?>">
                                <?php if(isset($banner->image)): ?>
                                    <img class="w-100" src="<?php echo e(asset($banner->image->path)); ?>" alt="">
                                <?php else: ?>
                                    <div class="image-preview-temp"></div>
                                <?php endif; ?>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImagesBanner(<?php echo e($banner->order_no); ?>)">Choose Image</button>
                                    <input type="hidden" name="image_id<?php echo e($banner->order_no); ?>">
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-between">
                                <div class="form-group">
                                    <label for="inputAddress"><strong>Order no.</strong> <?php echo e($banner->order_no); ?></label>
                                    <input type="text" class="form-control" id="banner_order_no<?php echo e($banner->order_no); ?>" value="<?php echo e($banner->external_path); ?>" name="external_path<?php echo e($banner->order_no); ?>">
                                </div>
                                <div class="form-group text-right">
                                    <!-- <?php if($key == 4): ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn disabled" disabled><i class="material-icons">keyboard_arrow_down</i></button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn"><i class="material-icons">keyboard_arrow_down</i></button>
                                    <?php endif; ?>
                                    <?php if($key == 0): ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn" disabled><i class="material-icons">keyboard_arrow_up</i></button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mr-1 icon-btn"><i class="material-icons">keyboard_arrow_up</i></button>
                                    <?php endif; ?> -->
                                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="saveBanner(<?php echo e($banner->order_no); ?>)">Save</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <div class="modal-footer" id="bannerChooseBtn">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>