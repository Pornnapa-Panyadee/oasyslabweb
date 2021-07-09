<?php $__env->startSection('content'); ?>
<script>
    members = <?php echo json_encode($members); ?>;
</script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Publications</div>
                <div class="card-body">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="positions">Publication Types</label>
                                <select class="form-control" id="positions" name="type_id">
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($type->id == $publication->type_id): ?>
                                            <option value="<?php echo e($type->id); ?>" selected><?php echo e($type->en_name); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->en_name); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small id="type_text" class="form-text text-danger" style="display:none;">Please choose type of publication.</small>
                            </div>
                            <div class="form-group">
                                <label for="detail">Publication Text</label>
                                <textarea class="form-control" id="detail" rows="3" name="detail"><?php echo e($publication->detail); ?></textarea>
                                <small id="detail_text" class="form-text text-danger" style="display:none;">Please fill detail of publication.</small>
                            </div>
                            <div class="form-group">
                                <label for="total_members">Total Authors</label>
                                <input type="number" class="form-control" id="total_members" placeholder="0" name="total_members" value="<?php echo e($publication->total_members); ?>">
                                <small id="total_text" class="form-text text-danger" style="display:none;">Please fill number of authors.</small>
                            </div>
                            <input type="hidden" class="form-control" name="id" value="<?php echo e($publication->id); ?>">
                        </div>
                        <div class="col-12" id="order_author_list">
                            <?php for($i = 1; $i <= sizeOf($authors); $i++): ?>
                            <div class="form-group row">
                                <label for="no1" class="col-sm-3 col-form-label">Author order. <?php echo e($i); ?></label>
                                <input type="hidden" class="form-control" name="no<?php echo e($i); ?>">
                                <div class="col-sm-9">
                                    <select class="form-control" id="member_id_<?php echo e($i); ?>" name="member_id_<?php echo e($i); ?>">
                                            <option value = "">Select Member</option>
                                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($member->id == $authors[$i-1]['member_id']): ?>
                                                <option value="<?php echo e($member->id); ?>" selected><?php echo e($member->en_name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($member->id); ?>"><?php echo e($member->en_name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="editPublication(<?php echo e($publication->id); ?>)">Edit Publications</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>