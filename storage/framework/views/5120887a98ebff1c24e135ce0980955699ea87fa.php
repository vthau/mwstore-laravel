<?php echo $__env->make('admin.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.inc.setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="app-main">
    <?php echo $__env->make('admin.inc.slidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-car icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        <div>
                            <?php echo $__env->yieldContent('title_page'); ?>
                            <div class="page-title-subheading">
                                <?php echo $__env->yieldContent('sub_title_page'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <?php echo $__env->yieldContent('content_page'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('admin.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\mwstore-laravel\resources\views/admin/layouts/master.blade.php ENDPATH**/ ?>