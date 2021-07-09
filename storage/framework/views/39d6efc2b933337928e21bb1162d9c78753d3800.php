<?php $__env->startSection('content'); ?>
<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Article</div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('article.create')); ?>" aria-label="createArticle">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <label for="slug" class="col-4 col-md-2 col-form-label">Name URL</label>
                            <div class="col-8 col-md-10">
                                <input id="slug" type="text" class="form-control<?php echo e($errors->has('slug') ? ' is-invalid' : ''); ?>" name="slug" value="<?php echo e(old('slug')); ?>" placeholder="test-name-url" required autofocus>
                                <?php if($errors->has('slug')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('slug')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title_th" class="col-4 col-md-2 col-form-label">ชื่อเรื่อง</label>
                            <div class="col-8 col-md-10">
                                <input id="title_th" type="text" class="form-control<?php echo e($errors->has('title_th') ? ' is-invalid' : ''); ?>" name="title_th" value="<?php echo e(old('title_th')); ?>" required autofocus>
                                <?php if($errors->has('title_th')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('title_th')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title_en" class="col-4 col-md-2 col-form-label">Title</label>
                            <div class="col-8 col-md-10">
                                <input id="title_en" type="text" class="form-control<?php echo e($errors->has('title_en') ? ' is-invalid' : ''); ?>" name="title_en" value="<?php echo e(old('title_en')); ?>" required autofocus>
                                <?php if($errors->has('title_en')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('title_en')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type_id" class="col-4 col-md-2 col-form-label">Type</label>
                            <div class="col-8 col-md-10">
                                <select class="form-control<?php echo e($errors->has('type_id') ? ' is-invalid' : ''); ?>" id="type_id" name="type_id">
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('type_id') == $type['id']): ?>
                                            <option value="<?php echo e($type['id']); ?>" selected><?php echo e($type['type']); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($type['id']); ?>"><?php echo e($type['type']); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('type_id')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('type_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title_en" class="col-4 col-md-2 col-form-label">Cover Image</label>
                            <div class="col-8 col-md-10">
                                <div class="form-group" id="image-preview">
                                    <div class="image-preview-temp" style="height: 200px;"></div>
                                </div>
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#imagesmodal" onclick="loadImages()">Choose Image</button>
                                    <input type="hidden" name="image_id">
                                </div>
                                <?php if($errors->has('image_id')): ?>
                                    <small class="form-text text-danger">Please select image</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="detail_th" class="col-4 col-md-2 col-form-label">รายละเอียด</label>
                            <div class="col-12">
                                <textarea name="detail_th" id="editor" row="10"><?php echo e(old('detail_th')); ?></textarea>
                                <!-- <input id="detail_th" type="text" class="form-control<?php echo e($errors->has('detail_th') ? ' is-invalid' : ''); ?>" name="detail_th" value="<?php echo e(old('detail_th')); ?>" required autofocus> -->
                                <?php if($errors->has('detail_th')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('detail_th')); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="detail_en" class="col-4 col-md-2 col-form-label">Description</label>

                            <div class="col-12">
                                <!-- <input id="detail_en" type="text" class="form-control<?php echo e($errors->has('detail_en') ? ' is-invalid' : ''); ?>" name="detail_en" value="<?php echo e(old('detail_en')); ?>" required autofocus> -->
                                <textarea name="detail_en" id="editor1" row="10"><?php echo e(old('detail_en')); ?></textarea>
                                <?php if($errors->has('detail_en')): ?>
                                        <small class="form-text text-danger"><?php echo e($errors->first('detail_en')); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order_no" class="col-4 col-md-2 col-form-label">Order No.</label>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" id="order_no" placeholder="ลำดับการโชว์" name="order_no">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Create</button>
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

<script>
    CKEDITOR.replace( 'editor' );
    CKEDITOR.replace( 'editor1' );
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>