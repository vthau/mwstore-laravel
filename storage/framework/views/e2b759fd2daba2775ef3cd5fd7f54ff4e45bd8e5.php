<?php $__env->startSection('title', 'Hình ảnh | ' . $product->name); ?>
<?php $__env->startSection('title_page', 'Hình ảnh'); ?>
<?php $__env->startSection('sub_title_page', 'Danh sách hình ảnh'); ?>

<?php $__env->startSection('content_page'); ?>
<div class="card-header">Danh sách hình ảnh của <?php echo e($product->name); ?></div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <div class="card-body">
        <form class="needs-validation" action="<?php echo e(route('product.gallery.store', $product->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
            <?php echo csrf_field(); ?>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="custom-file">
                        <label for="validationTooltip01">Chọn hình ảnh</label>
                        <input type="file" class="form-control" name="image[]" id="validatedCustomFile" accept=".PNG, .JPEG, .JPG" multiple required>
                        <div class="invalid-feedback">Vui lòng chọn một trong các định dạng ảnh: PNG, JPG, JPEG.</div>
                        <div class="valid-feedback">Tuyệt vời!!!</div>
                        <?php if($errors->has('file_error')): ?>
                        <?php echo e($errors->first('file_error')); ?>

                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="form-row text-center">
                <div class="col-md-12 mb-3 mt-2">
                    <button class="btn btn-success " name="submit" style="padding-left: 35px; padding-right:35px ;" type="submit">Thêm</button>
                </div>
            </div>

        </form>
    </div>
    <?php if(count($gallerys)): ?>
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên sản phẩm</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php $__currentLoopData = $gallerys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center text-muted">
                    <?php
                    echo $i;
                    $i++;
                    ?></td>
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="border-circle" src="<?php echo e(asset('admins/uploads/gallerys/'.$gallery->image)); ?>" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading"><?php echo e($product->name); ?></div>
                                <div class="widget-subheading opacity-7"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <a href="<?php echo e(route('product.gallery.delete', $gallery->id)); ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="text-center text-noti">Không có hình ảnh nào để hiển thị</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mwstore-laravel\resources\views/admin/product/gallery.blade.php ENDPATH**/ ?>