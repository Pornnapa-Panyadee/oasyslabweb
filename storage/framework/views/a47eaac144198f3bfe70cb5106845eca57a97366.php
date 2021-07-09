<?php $__env->startSection('content'); ?>
<script>
    members = <?php echo json_encode($members); ?>;
</script>
<div class="container member">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Publications</div>
                <div class="card-body">
                    <!-- <form method="POST" action="<?php echo e(route('publications.createPublication')); ?>" id='publication_add'> -->
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="positions">Publication Types</label>
                                    <select class="form-control" id="positions" name="type_id">
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->en_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small id="type_text" class="form-text text-danger" style="display:none;">Please choose type of publication.</small>
                                </div>
                                <div class="form-group">
                                    <label for="detail">Publication Text</label>
                                    <textarea class="form-control" id="detail" rows="3" name="detail"></textarea>
                                    <small id="detail_text" class="form-text text-danger" style="display:none;">Please fill detail of publication.</small>
                                </div>
                                <div class="form-group">
                                    <label for="total_members">Total Authors</label>
                                    <input type="number" class="form-control" id="total_members" placeholder="0" name="total_members">
                                    <small id="total_text" class="form-text text-danger" style="display:none;">Please fill number of authors.</small>
                                </div>
                            </div>
                            <div class="col-12" id="order_author_list">
                            </div>
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary" onclick="addPublication()">Create Publications</button>
                            </div>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="membermodal" tabindex="-1" role="dialog" aria-labelledby="membermodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form id="fields-edit"> -->
                <div class="modal-body image">
                    <!-- <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="image-search">Search</button>
                        </div>
                    </div> -->
                    <div class="row" id="member-modal">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="chooseMember()">Choose</button>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>