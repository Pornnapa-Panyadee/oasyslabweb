<?php $__env->startSection('content'); ?>
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">About Us & Contact</div>

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

                        
                    <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($detail->keyword != "stat-Projects" && $detail->keyword != "stat-Members"): ?>
                        <div class="row">
                            <div class="col-12 d-flex flex-column justify-content-between">
                                <div class="form-group mb-0">
                                    <label for="inputAddress"><strong><?php echo e($detail->keyword); ?></strong> </label>
                                </div>
                                <?php if($detail->th_name != null): ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ชื่อ</span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo e($detail->th_name); ?>" name="th_name<?php echo e($detail->id); ?>">
                                </div>
                                <?php endif; ?>
                                <?php if($detail->en_name != null): ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Name</span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo e($detail->en_name); ?>" name="en_name<?php echo e($detail->id); ?>">
                                </div>
                                <?php endif; ?>
                                <?php if($detail->th_description != null): ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">รายละเอียด</span>
                                    </div>
                                    <?php if($detail->keyword == "aboutus"): ?>
                                        <textarea class="form-control" rows="10" name="th_description<?php echo e($detail->id); ?>"><?php echo e($detail->th_description); ?></textarea>
                                    <?php else: ?>
                                        <textarea class="form-control" rows="3" name="th_description<?php echo e($detail->id); ?>"><?php echo e($detail->th_description); ?></textarea>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php if($detail->en_description != null): ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Description</span>
                                    </div>
                                    <?php if($detail->keyword == "aboutus"): ?>
                                        <textarea class="form-control" rows="10" name="en_description<?php echo e($detail->id); ?>"><?php echo e($detail->en_description); ?></textarea>
                                    <?php else: ?>
                                        <textarea class="form-control" rows="3" name="en_description<?php echo e($detail->id); ?>"><?php echo e($detail->en_description); ?></textarea>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php if($detail->path != null): ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Link</span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo e($detail->path); ?>" name="path<?php echo e($detail->id); ?>">
                                </div>
                                <?php endif; ?>
                                 <?php if(is_int($detail->amount)): ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Amount</span>
                                    </div>
                                    <input type="number" class="form-control" value="<?php echo e($detail->amount); ?>" name="amount<?php echo e($detail->id); ?>">
                                </div>
                                <?php endif; ?>
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="saveDetail(<?php echo e($detail->id); ?>)">Save</button>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>