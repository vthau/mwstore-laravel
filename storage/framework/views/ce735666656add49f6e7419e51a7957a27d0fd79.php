<?php $__env->startSection('title', 'MW Store | Thương mại điện tử'); ?>
<?php $__env->startSection('meta_desc', 'MW Store website thương mại điện tử.'); ?>

<?php $__env->startSection('content_page'); ?>
<?php if(count($sliders) > 0): ?>
<div class="slider_box">
    <div class="slider-wrapper theme-default">
        <div id="slider" class="nivoSlider">
            <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('product.detail', $slider->product->slug)); ?>"><img class="lazy" src="<?php echo e(asset('admins/uploads/sliders/'.$slider->image)); ?>" alt="<?php echo e($slider->product->name); ?>" /></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="trendig-product mt-70">
    <div class="container">
        <div class="trending-box">
            <div class="">
                <h2 class="title-name"><?php echo app('translator')->get('lang.feather'); ?></h2>
            </div>
            <div class="product-list-box">
                <div class="trending-pro-active owl-carousel">
                    <?php if(count(array($product_feathers)) > 0): ?>
                    <?php $__currentLoopData = $product_feathers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_feather): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="single-product">
                        <div class="pro-img">
                            <a href="<?php echo e(route('product.detail', $product_feather->slug)); ?>">
                                <img class="primary-img lazy" style="height: 226px; object-fit: cover;" data-src="<?php echo e(asset('admins/uploads/products/'.$product_feather->image)); ?>" alt="<?php echo e($product_feather->name); ?>">
                            </a>
                            <p class="quick_view product-text-view" title="Lượt xem"> <i class="fas fa-eye"></i><?php echo e($product_feather->visit); ?></p>
                        </div>
                        <div class="pro-content">
                            <div class="pro-info">
                                <h4><a href="<?php echo e(route('product.detail', $product_feather->slug)); ?>"><?php echo e($product_feather->name); ?></a></h4>
                                <p>
                                    <span class="price"><?php echo number_format($product_feather->price, 0, '', '.')  .  ' VNĐ'; ?></span>
                                </p>
                                <div class="rating">
                                    <?php for($m = 0; $m < floor($product_feather->star()); $m++): ?> <i class="fas fa-star"></i>
                                        <?php endfor; ?>

                                        <?php for($n = floor($product_feather->star()); $n < 5; $n++): ?> <i class="far fa-star"></i>
                                            <?php endfor; ?>
                                            <?php echo e(number_format((float)$product_feather->star(), 1, '.', '')); ?>

                                </div>
                            </div>
                            <div class="pro-actions">
                                <div class="actions-primary">
                                    <a href="<?php echo e(route('product.detail', $product_feather->slug)); ?>" title="<?php echo app('translator')->get('lang.view_detail_more'); ?>"><?php echo app('translator')->get('lang.view_detail'); ?></a>
                                </div>
                                <div class="actions-secondary">
                                    <a href="#" title="<?php echo app('translator')->get('lang.add_compare'); ?>"><i class="lnr lnr-sync"></i> <span><?php echo app('translator')->get('lang.add_compare'); ?></span></a>
                                    <a href="#" title="><?php echo app('translator')->get('lang.add_wishlist'); ?>"><i class="lnr lnr-heart"></i> <span><?php echo app('translator')->get('lang.add_wishlist'); ?></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="trendig-product mt-70">
    <div class="container">
        <div class="trending-box">
            <div class="">
                <h2 class="title-name"><?php echo app('translator')->get('lang.new_product'); ?></h2>
            </div>
            <div class="product-list-box">
                <div class="trending-pro-active owl-carousel">
                    <?php if(count(array($product_news)) > 0): ?>
                    <?php $__currentLoopData = $product_news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_new): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="single-product">
                        <div class="pro-img">
                            <a href="<?php echo e(route('product.detail', $product_new->slug)); ?>">
                                <img class="primary-img lazy" style="height: 226px; object-fit: cover;" data-src="<?php echo e(asset('admins/uploads/products/'.$product_new->image)); ?>" alt="<?php echo e($product_new->name); ?>">
                            </a>
                            <p class="quick_view product-text-view" title="Lượt xem"> <i class="fas fa-eye"></i><?php echo e($product_new->visit); ?></p>
                        </div>
                        <div class="pro-content">
                            <div class="pro-info">
                                <h4><a href="<?php echo e(route('product.detail', $product_new->slug)); ?>"><?php echo e($product_new->name); ?></a></h4>
                                <p>
                                    <span class="price"><?php echo number_format($product_new->price, 0, '', '.')  .  ' VNĐ'; ?></span>
                                </p>
                                <div class="rating">
                                    <?php for($m = 0; $m < floor($product_new->star()); $m++): ?> <i class="fas fa-star"></i>
                                        <?php endfor; ?>

                                        <?php for($n = floor($product_new->star()); $n < 5; $n++): ?> <i class="far fa-star"></i>
                                            <?php endfor; ?>
                                            <?php echo e(number_format((float)$product_new->star(), 1, '.', '')); ?>

                                </div>
                            </div>
                            <div class="pro-actions">
                                <div class="actions-primary">
                                    <a href="<?php echo e(route('product.detail', $product_new->slug)); ?>" title="<?php echo app('translator')->get('lang.view_detail_more'); ?>"><?php echo app('translator')->get('lang.view_detail'); ?></a>
                                </div>
                                <div class="actions-secondary">
                                    <a href="#" title="<?php echo app('translator')->get('lang.add_compare'); ?>"><i class="lnr lnr-sync"></i> <span><?php echo app('translator')->get('lang.add_compare'); ?></span></a>
                                    <a href="#" title="><?php echo app('translator')->get('lang.add_wishlist'); ?>"><i class="lnr lnr-heart"></i> <span><?php echo app('translator')->get('lang.add_wishlist'); ?></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="arrivals-product mt-70">
    <div class="container">
        <div class="main-product-tab-area">
            <div class="tab-menu mb-25">
                <div class="">
                    <h2 class="title-name"><?php echo app('translator')->get('lang.brand'); ?></h2>
                </div>
                <ul class="nav tabs-area" role="tablist">
                    <?php if(count($brands) > 0): ?>
                    <?php $is_active = true; ?>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($is_active) {
                                                echo 'active';
                                            }
                                            $is_active = false; ?>" data-toggle="tab" href="#brand<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="tab-content">
                <?php $is_active_brand = true; ?>
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="brand<?php echo e($brand->id); ?>" class="tab-pane fade <?php if ($is_active_brand) {
                                                                        echo "show active";
                                                                    };
                                                                    $is_active_brand = false; ?>">
                    <div class="electronics-pro-active owl-carousel">
                        <?php $products = $brand->products; ?>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="single-product">
                            <div class="pro-img">
                                <a href="<?php echo e(route('product.detail', $product->slug)); ?>">
                                    <img class="primary-img lazy" style="height: 381px; object-fit: cover;" data-src="<?php echo e(asset('admins/uploads/products/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>">
                                </a>
                                <p class="quick_view product-text-view" title="Lượt xem"> <i class="fas fa-eye"></i><?php echo e($product->visit); ?></p>
                            </div>
                            <div class="pro-content">
                                <div class="pro-info">
                                    <h4><a href="<?php echo e(route('product.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a></h4>
                                    <p><span class="price"><?php echo number_format($product->price, 0, '', '.')  .  ' VNĐ'; ?></span></p>
                                    <div class="rating">
                                        <?php for($m = 0; $m < floor($product->star()); $m++): ?> <i class="fas fa-star"></i>
                                            <?php endfor; ?>

                                            <?php for($n = floor($product->star()); $n < 5; $n++): ?> <i class="far fa-star"></i>
                                                <?php endfor; ?>
                                                <?php echo e(number_format((float)$product->star(), 1, '.', '')); ?>

                                    </div>
                                    <div class="label-product l_sale"><span class="symbol-percent"></span></div>
                                </div>
                                <div class="pro-actions">
                                    <div class="actions-primary">
                                        <a href="<?php echo e(route('product.detail', $product->slug)); ?>" ttitle="<?php echo app('translator')->get('lang.view_detail_more'); ?>"><?php echo app('translator')->get('lang.view_detail'); ?></a>
                                    </div>
                                    <div class="actions-secondary">
                                        <a href="#" title="<?php echo app('translator')->get('lang.add_compare'); ?>"><i class="lnr lnr-sync"></i> <span><?php echo app('translator')->get('lang.add_compare'); ?></span></a>
                                        <a href="#" title="><?php echo app('translator')->get('lang.add_wishlist'); ?>"><i class="lnr lnr-heart"></i> <span><?php echo app('translator')->get('lang.add_wishlist'); ?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mwstore-laravel\resources\views/user/index.blade.php ENDPATH**/ ?>