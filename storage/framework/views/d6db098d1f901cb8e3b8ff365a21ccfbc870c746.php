<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Projects</div>
                <div class="card-body" style="height: 75vh;overflow: auto;">
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
                                    <div class="col-12 col-md-4 mb-2 mb-md-0" style="max-width:200px;">
                                        <img class="w-100" src="<?php echo e(asset($project->images->path)); ?>" alt="">
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <?php echo e($project->th_name); ?> (<?php echo e($project->en_name); ?>) <br>
                                        
                                        <p class="pt-3"><?php echo str_limit($project->th_description, 200, '...'); ?></p>
                                        <p class="pb-2 mb-0"><?php echo str_limit($project->en_description, 200, '...'); ?></p>
                                    </div>
                                    <div class="col-12 text-right">
                                        <div class="d-inline-flex">
                                            <a href="<?php echo e(route('projects.edit',[ 'id' => $project->id ])); ?>" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                            <!-- <form class="form-horizontal" action="<?php echo e(route('projects.delete',[ 'id' => $project->id ])); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo e(method_field('DELETE')); ?>

                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>  -->
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-5 mt-3 mb-2 mt-md-0">
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
        Do you want to delete this Sub-project?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="deleteSubProjectBtn" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>