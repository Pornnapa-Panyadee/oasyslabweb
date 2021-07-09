<?php $__env->startSection('content'); ?>
<div class="container banner">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Sections setting</div>

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

                    <form method="POST" action="<?php echo e(route('settings.section.edit')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <div class="col-12 d-flex flex-column justify-content-between mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Section <?php echo e($key+1); ?></span>
                                        </div>
                                        <select class="form-control" id="positions" name="data[<?php echo e($key); ?>][id]">
                                            <?php $__currentLoopData = $defaults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($default['name'] == $section->name): ?>
                                                    <option value="<?php echo e($key); ?>" selected><?php echo e($default['name']); ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo e($key); ?>"><?php echo e($default['name']); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
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