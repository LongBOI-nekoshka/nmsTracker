

<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php $__currentLoopData = $issue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $isInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h4><?php echo e($isInfo->Name); ?></h4>
            <br>
            <img style="width:50%" src="/storage/picture/<?php echo e($isInfo->Picture); ?>">
            <p><?php echo e($isInfo->Description); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appNAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\nmstrackersystem\resources\views/issues/show.blade.php ENDPATH**/ ?>