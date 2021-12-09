<?php $__env->startSection('title', 'MW Store | Trang quản trị'); ?>
<?php $__env->startSection('title_page', 'Trang chủ'); ?>
<?php $__env->startSection('sub_title_page', 'Trang chủ quản trị'); ?>

<?php $__env->startSection('content_page'); ?>
<div class="row">
    <div class="col-12">
        <div class="index-home">
            <h3 class="text-center">Xin chào <b><?php echo e(Auth::guard('admin')->user()->name); ?></b> đến với trang quản trị của <b>MW Store</b></h3>
            <div class="index-icon">
                <img src="<?php echo e(asset('admins/img/logo.png')); ?>" alt="logo-image" style="width: 120px;" />
                <div width="42" class="avatar-center avatar-border rounded-circle">
                    <img width="42" class="rounded-circle" src="<?php echo e(asset('admins/img/avatars/' . Auth::guard('admin')->user()->image)); ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mwstore-laravel\resources\views/admin/index.blade.php ENDPATH**/ ?>