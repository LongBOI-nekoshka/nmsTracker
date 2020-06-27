

<?php $__env->startSection('content'); ?>
    <div class="container">
        <a href="/project/<?php echo e($project_Id); ?>" class="btn btn-secondary_">Go Back</a>
        <br>
        <br>
        <h4>Create Issue</h4>
        <?php echo Form::open(['action' => ['IssueController@store',$project_Id], 'method' => 'POST', 'enctype' => 'multipart/form-data']); ?>

            <div class="form-group">
                <?php echo e(Form::label('name','Name')); ?>

                <?php echo e(Form::text('name','',['class' => 'form-control','placeholder' => 'Name of Issue'])); ?>

            </div>
            <div class="form-group">
                <?php echo e(Form::label('description','Description')); ?>

                <?php echo e(Form::textarea('description','',['class' => 'form-control','rows' =>'4','cols' => '11'])); ?>

                <br>
                <?php echo e(Form::file('picture')); ?>

            </div>
            <div class="form-group">
                <?php echo e(Form::label('email','Email')); ?>

                <?php echo e(Form::text('email','',['class' => 'form-control','placeholder' => 'Email'])); ?>

                <?php echo e(Form::hidden('secret',$project_Id)); ?>

            </div>
            <?php echo e(Form::submit('Submit',['class' => 'btn btn-primary'])); ?>

        <?php echo Form::close(); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appNAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\nmstrackersystem\resources\views/issues/create.blade.php ENDPATH**/ ?>