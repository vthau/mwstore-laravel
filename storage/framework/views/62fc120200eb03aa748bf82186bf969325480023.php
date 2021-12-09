<?php $__env->startSection('title', 'Danh sách sản phẩm'); ?>
<?php $__env->startSection('title_page', 'Sản phẩm'); ?>
<?php $__env->startSection('sub_title_page', 'Danh sách sản phẩm'); ?>

<?php $__env->startSection('content_page'); ?>
<div class="card-header">Danh sách sản phẩm</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <?php if(count($products)): ?>
    <table id="product-table" class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên sản phẩm</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Thương hiệu</th>
                <th class="text-center">Nổi bật</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <img class="border-circle" src="<?php echo e(asset('admins/uploads/products/'.$product->image)); ?>" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading"><?php echo e($product->name); ?></div>
                                <div class="widget-subheading opacity-7"><?php echo e(Str::limit($product->description, 40)); ?></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center text-muted"><?php echo number_format($product->price, 0, '', '.')  .  ' VNĐ'; ?></td>
                <td class="text-center text-muted"><?php echo e($product->quantity); ?></td>
                <td class="text-center text-muted"><?php echo e($product->brand->name); ?></td>
                <td class="text-center text-muted">
                    <?php if($product->feather == 1): ?>
                    Nổi bật
                    <?php else: ?>
                    Không
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <a href="<?php echo e(route('product.edit', $product->id)); ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                    <a href="<?php echo e(route('product.gallery', $product->id)); ?>" class="btn btn-info btn-sm">Hình ảnh</a>
                    <form action="<?php echo e(route('product.destroy', $product->id)); ?>" class="form-delete" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="text-center text-noti">Không có sản phẩm nào để hiển thị</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mwstore-laravel\resources\views/admin/product/list.blade.php ENDPATH**/ ?>