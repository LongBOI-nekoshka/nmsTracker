

<?php $__env->startSection('content'); ?>
    <div class="container">
        <br>
        <a href="/project" class="btn btn-secondary">Go Back</a>
        <br><br>
        <h4><?php echo e($project->ProjectName); ?></h4>
        <br>
        <a href="<?php echo e($project->Project_Id); ?>/issue/create" class="btn btn-primary">Create Issue</a>
        <a href="<?php echo e($project->Project_Id); ?>/issue/" class="btn btn-primary">Show all Issues</a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appNAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\nmstrackersystem\resources\views/projects/show.blade.php ENDPATH**/ ?>