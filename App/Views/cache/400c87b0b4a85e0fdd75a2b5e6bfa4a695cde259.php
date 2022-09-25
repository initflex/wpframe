

<?php $__env->startSection('content'); ?>

<h1>Welcome - <?php echo e($name); ?></h1>
<table width="500px" border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item->ID); ?></td>
            <td><?php echo e($item->user_login); ?></td>
            <td><?php echo e($item->user_email); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    </tbody>
</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\dev-wpframe\wp-content\plugins\wpframe\App\Views/index.blade.php ENDPATH**/ ?>