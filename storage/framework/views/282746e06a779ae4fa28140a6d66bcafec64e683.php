

<?php $__env->startSection('content'); ?>
    <br>
    <div class="jumbotron text-center" >
        <h1><?php echo e($title); ?></h1>
        <a class="btn btn-primary btn-lg" href="/project">See Projects</a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appNAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\nmstrackersystem\resources\views/pages/index.blade.php ENDPATH**/ ?>