<?php $__env->startSection('js'); ?>
<script>
var sections = [
    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        '<?php echo e($section->name); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
];
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<home-page></home-page>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base-front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>