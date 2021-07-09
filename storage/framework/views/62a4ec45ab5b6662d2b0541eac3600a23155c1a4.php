<?php $__env->startSection('content'); ?>
<script>
    fields = <?php echo json_encode($fields); ?>;
    memberFields = <?php echo json_encode($memberFields); ?>;
</script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Members</div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('members.editMembers',['id'=>$member->id])); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 text-center">
                                <div class="form-group" id="image-preview">
                                    <img class="w-100" src="<?php echo e(asset($member->images->path)); ?>" alt="">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImages()">Choose Image</button>
                                    <input type="hidden" name="image_id" value="<?php echo e($member->image_id); ?>">
                                </div>
                                <?php if($errors->has('image_id')): ?>
                                    <small class="form-text text-danger">Please select image</small>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label for="name_th">ชื่อ - นามสกุล</label>
                                    <input type="text" class="form-control" id="name_th" placeholder="ชื่อ-นามสกุล" name="th_name" value="<?php echo e(old('th_name') == null? $member->th_name: old('th_name')); ?>">
                                    <?php if($errors->has('th_name')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('th_name')); ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="name_en">Firstname - Lastname</label>
                                    <input type="text" class="form-control" id="name_en" placeholder="Firstname - Lastname" name="en_name" value="<?php echo e(old('en_name') == null? $member->en_name: old('en_name')); ?>">
                                    <?php if($errors->has('en_name')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('en_name')); ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="education_levels">Education Levels</label>
                                    <select class="form-control" id="education_levels" name="level_id">
                                        <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(old('level_id') == $level['id']): ?>
                                                <option value="<?php echo e($level['id']); ?>" selected><?php echo e($level['name_en']); ?></option>
                                            <?php elseif($level['id'] == $member->level_id && (old('level_id') == '' || old('level_id') == NULL)): ?>
                                                <option value="<?php echo e($level['id']); ?>" selected><?php echo e($level['name_en']); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($level['id']); ?>"><?php echo e($level['name_en']); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="positions">Lab's Position</label>
                                    <select class="form-control" id="positions" name="position_id">
                                        <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(old('position_id') == $level['id']): ?>
                                                <option value="<?php echo e($position['id']); ?>" selected><?php echo e($position['name_en']); ?></option>
                                            <?php elseif($position['id'] == $member->position_id && (old('position_id') == '' || old('position_id') == NULL)): ?>
                                                <option value="<?php echo e($position['id']); ?>" selected><?php echo e($position['name_en']); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($position['id']); ?>"><?php echo e($position['name_en']); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo e(old('email') == null? $member->email: old('email')); ?>">
                                    <?php if($errors->has('email')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('email')); ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website" placeholder="Website" name="website" value="<?php echo e(old('website') == null? $member->website: old('website')); ?>">
                                    <?php if($errors->has('website')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('website')); ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description_th">รายละเอียด</label>
                                    <textarea class="form-control" id="description_th" rows="3" name="th_description"><?php echo e(old('th_description') == null? $member->th_description: old('th_description')); ?></textarea>
                                    <?php if($errors->has('th_description')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('th_description')); ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description_en">Description</label>
                                    <textarea class="form-control" id="description_en" rows="3" name="en_description"><?php echo e(old('en_description') == null? $member->en_description: old('en_description')); ?></textarea>
                                     <?php if($errors->has('en_description')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('en_description')); ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="fields_select">Fields Interest</label>
                                    <div>
                                        <div>
                                            <select class="form-control" id="fields_select" style="width:150px;">
                                                <option value="">Select Fields</option>
                                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($field['id']); ?>"><?php echo e($field['name']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="d-inline-flex w-100">
                                            <div id="fieldsInterest" class=" w-100">
                                            </div>
                                            <input type="hidden" name="field_interest">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Edit Member</button>
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