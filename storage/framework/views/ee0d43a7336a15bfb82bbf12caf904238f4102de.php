<?php $__env->startSection('content'); ?>
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Color setting</div>

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

                    <form method="POST" action="<?php echo e(route('settings.colors.edit')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $colors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <div class="col-2 col-md-1">
                                    <div class="form-group mb-0 border">
                                        <div style="background-color:<?php echo e($colors->code); ?>;height:2rem;"></div>
                                    </div>
                                </div>
                                <div class="col-10 col-md-11 d-flex flex-column justify-content-between mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><?php echo e($colors->keyword); ?></span>
                                        </div>
                                        <input type="text" class="form-control" value="<?php echo e($colors->code); ?>" name="<?php echo e($colors->keyword); ?>">
                                    </div>
                                    <?php if($errors->has($colors->keyword)): ?>
                                        <span class="help-block text-danger">
                                            <strong><?php echo e($errors->first($colors->keyword)); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>