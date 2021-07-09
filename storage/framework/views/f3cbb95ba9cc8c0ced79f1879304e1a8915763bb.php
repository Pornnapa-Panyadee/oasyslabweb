<?php $__env->startSection('content'); ?>
<script>
    var positions = <?php echo json_encode($positions); ?>;
    var members = <?php echo json_encode($members); ?>;
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mb-3 mb-md-0 order-1 order-md-0">
            <div class="card">
                <div class="card-header">Members</div>
                <div class="card-body" style="max-height: 680px;overflow: auto;">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <a href="<?php echo e(route('members.create')); ?>" class="btn btn-outline-info btn-sm">Create Members</a>
                        </div>
                    </div>
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php elseif(session('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <ul class="list-group" id="member-list">
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="row">
                                <div class="col-4" style="max-width:200px;">
                                    <img class="w-100" src="<?php echo e(asset($member->images->path)); ?>" alt="">
                                </div>
                                <div class="col-8">
                                    <?php echo e($member->th_name); ?> (<?php echo e($member->en_name); ?>) <br>
                                    <p class="pt-3 mb-0"><strong>Position:</strong> <?php echo e($member->positions->name_en); ?></p>
                                    <p><strong>Education Level:</strong> <?php echo e($member->levels->name_en); ?></p>
                                </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="<?php echo e(route('members.edit',[ 'id' => $member->id ])); ?>" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeleteMemberBtn(<?php echo e($member->id); ?>)">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0 order-md-1">
            <div class="card">
                <div class="card-header">Members Interest Fields</div>
                <div class="card-body" style="max-height: 680px;overflow: auto;">
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="javascript:interestFieldsfilter(-1)">Show All</a>
                                </li>
                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="javascript:interestFieldsfilter(<?php echo e($field['id']); ?>)"><?php echo e($field['name']); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4 mb-3 mb-md-0 order-2'>
            <div class="card mb-3">
                <div class="card-header">Add Position</div>
                <div class="card-body">
                    <form id="position-add">
                        <?php echo e(csrf_field()); ?>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Thai</span>
                            </div>
                            <input type="text" class="form-control" placeholder="ชื่อตำแหน่ง" name="position_th">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">English</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Position Name" name="position_en">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Priority</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Number of priority" name="priority_pos">
                        </div>
                        <div class="w-100 text-right">
                            <button type="submit" class="btn btn-outline-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Members Position</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-group" id="position-list">
                                <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php echo e($position['name_th']); ?> / <?php echo e($position['name_en']); ?>

                                    </div>
                                    <div class="float-right">
                                        <div class="d-inline-flex">
                                            <button class="btn btn-outline-danger btn-sm" onclick="deletePosition(<?php echo e($position['id']); ?>)">Delete</button>
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
        Do you want to delete this Member?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="deleteMemberBtn" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>