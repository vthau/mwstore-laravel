<?php echo $__env->make('user.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('content_page'); ?>
<?php echo $__env->make('user.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\mwstore-laravel\resources\views/user/layouts/master.blade.php ENDPATH**/ ?>