

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="jumbotron">
            <?php $__currentLoopData = $project; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center">
                        <h4>Issues for Project <strong><?php echo e($pInfo->ProjectName); ?></strong></h4>
                    </div>
                <br><br>
                <table class="table">
                    <thead class="table-info">
                        <tr>
                            <th scope="col">Issue Number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Status</th>
                            <th scope="col">Assignee</th>
                            <th scope="col">Updated</th>
                        </tr>
                    </thead>
                    <?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="table-warning"><?php echo e($issue->Issue_Id); ?></td>
                        <td class="table-warning"><a href="/project/<?php echo e($pInfo->Project_Id); ?>/issue/<?php echo e($issue->Issue_Id); ?>"><?php echo e($issue->Name); ?></a></td>
                        <td class="table-warning"><?php echo e($issue->Priority); ?></td>
                        <td class="table-warning"><?php echo e($issue->Status); ?></td>
                        <td class="table-warning"><?php echo e($issue->Employee_Id); ?></td>
                        <td class="table-warning"><?php echo e($issue->updated_at); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appNAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\nmstrackersystem\resources\views/issues/index.blade.php ENDPATH**/ ?>