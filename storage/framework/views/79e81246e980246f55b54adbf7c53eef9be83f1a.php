<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('article.createArticle')); ?>" class="btn btn-outline-info btn-sm">Create Article</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Article</div>

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
                    
                    <?php $__currentLoopData = $articleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articleType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <h5><?php echo e($articleType->type); ?></h5>
                        <ul class="list-group pb-4">
                            <?php $__currentLoopData = $articleType->articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center row mx-1">
                                <div class="col-12 px-0">
                                    <?php echo e($article->title_th); ?> (<?php echo e($article->title_en); ?>) <br>
                                </div>
                                <div class="col-12 text-right px-0">
                                    <?php if($article->completed == 0): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm mr-1" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeleteArticleBtn(<?php echo e($article->id); ?>)">Delete</button>
                                        <a href="<?php echo e(route('article.edit',[ 'id' => $article->id ])); ?>" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <a href="<?php echo e(route('article.publish',[ 'id' => $article->id ])); ?>" class="btn btn btn-success btn-sm mr-1">Publish</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('article.draft',[ 'id' => $article->id ])); ?>" class="btn btn-secondary btn-sm mr-1">Draft</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        Do you want to delete this Publication?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="deleteArticleBtn">Delete</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>