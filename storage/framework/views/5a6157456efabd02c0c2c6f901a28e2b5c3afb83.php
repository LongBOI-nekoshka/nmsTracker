

<?php $__env->startSection('content'); ?>
    <div class="container">
        <br>
        <h2> Projects</h2>
        <br>
        <?php if(count($projects) >= 1): ?>
            <ul class='list-group'>
                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class='list-group-item'>
                    <div class="well">
                        <h4><a href="/project/<?php echo e($project->Project_Id); ?>"><?php echo e($project->ProjectName); ?></a></h4>
                        <small>Updated at: <?php echo e($project->updated_at); ?></small>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appNAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\nmstrackersystem\resources\views/projects/project.blade.php ENDPATH**/ ?>