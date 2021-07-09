<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('users.createUser')); ?>" class="btn btn-outline-info btn-sm">Create User</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

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

                    <ul class="list-group">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="row w-100">
                                <div class="col-12 d-flex justify-content-between ">
                                    <div>
                                        <?php echo e($user->name); ?> (<?php echo e($user->email); ?>) <br>
                                        Created_at <?php echo e($user->created_at->format('d/m/Y')); ?>

                                    </div>
                                    <div class="float-right">
                                        <?php if($user->role_id != 1): ?>
                                            <div class="d-inline-flex">
                                                <a href="<?php echo e(route('users.edit',[ 'id' => $user->id ])); ?>" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                                <form class="form-horizontal" action="<?php echo e(route('users.delete',[ 'id' => $user->id ])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo e(method_field('DELETE')); ?>

                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form> 
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>