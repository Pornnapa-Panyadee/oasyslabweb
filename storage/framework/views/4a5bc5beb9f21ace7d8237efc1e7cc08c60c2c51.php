<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Projects</div>
                <div class="card-body" style="height: 75vh;overflow: auto;">
                    <!-- <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <a href="<?php echo e(route('projects.create')); ?>" class="btn btn-outline-info btn-sm">Create Main Projects</a>
                        </div>
                    </div> -->
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php elseif(session('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <ul class="list-group">
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center project<?php echo e($project->id); ?>" onclick='showSubProjectPanel(<?php echo e($project->id); ?>)'>
                                <div class="row">
                                    <div class="col-4" style="max-width:200px;">
                                        <img class="w-100" src="<?php echo e(asset($project->images->path)); ?>" alt="">
                                    </div>
                                    <div class="col-8">
                                        <?php echo e($project->th_name); ?> (<?php echo e($project->en_name); ?>) <br>

                                        <p class="pt-3"><?php echo e($project->th_description); ?></p>
                                        <p class="pb-2 mb-0"><?php echo e($project->en_description); ?></p>
                                    </div>
                                    <div class="col-12 text-right">
                                        <div class="d-inline-flex">
                                            <a href="<?php echo e(route('projects.edit',[ 'id' => $project->id ])); ?>" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                            <form class="form-horizontal" action="<?php echo e(route('projects.delete',[ 'id' => $project->id ])); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('DELETE')); ?>

                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Sub Projects</div>
                <div class="card-body" style="max-height: 75vh;overflow: auto;">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mb-3" id="create-sub-project-btn" style="display:none;">
                            <div class="w-100 text-center">
                                Please select main projects.
                            </div>
                        </div>
                    </div>
                    <ul class="list-group" id="sub-project-list">
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>