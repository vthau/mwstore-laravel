
<?php $__env->startSection('title', $product->name); ?>
<?php $__env->startSection('canonical', url()->current()); ?>
<?php $__env->startSection('meta_desc', $product->description); ?>

<?php $__env->startSection('title_og', $product->name); ?>
<?php $__env->startSection('desc_og', $product->description); ?>
<?php $__env->startSection('img_og', asset('admins/uploads/products/'.$product->image)); ?>

<?php $__env->startSection('content_page'); ?>
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="<?php echo e(route('home.index')); ?>"><?php echo app('translator')->get('lang.home'); ?></a></li>
                <li class="active"><a href=""><?php echo app('translator')->get('lang.product_detail'); ?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="main-product-thumbnail ptb-60 ptb-sm-60">
    <div class="container">
        <div class="thumb-bg">
            <div class="row">
                <?php if(count($gallerys)): ?>
                <div class="col-lg-5 mb-all-40">
                    <?php
                    $active = true; $i = 0;
                    ?>
                    <div class="tab-content">
                        <?php $__currentLoopData = $gallerys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $i++; ?>
                        <div id="thumb<?php echo e($i); ?>" class="tab-pane fade show <?php if ($active) {
                                                                            echo 'active';
                                                                            $active = false;
                                                                        } ?>">
                            <a data-fancybox="images" href="<?php echo e(asset('admins/uploads/gallerys/'.$gallery->image)); ?>"><img src="<?php echo e(asset('admins/uploads/gallerys/'.$gallery->image)); ?>" id="zoom-img" class="product-image" data-zoom-image="<?php echo e(asset('admins/uploads/gallerys/'.$gallery->image)); ?>" alt="<?php echo e($product->name); ?>"></a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- Thumbnail Large Image End -->
                    <!-- Thumbnail Image End -->
                    <?php
                    $active = true; $i = 0;
                    ?>
                    <div class="product-thumbnail mt-15">
                        <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                            <?php $__currentLoopData = $gallerys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $i++; ?>
                            <a class="<?php if ($active) {
                                            echo 'active';
                                            $active = false;
                                        } ?>" data-toggle="tab" href="#thumb<?php echo e($i); ?>"><img src="<?php echo e(asset('admins/uploads/gallerys/'.$gallery->image)); ?>" alt="<?php echo e($product->name); ?>"></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <!-- Thumbnail image end -->
                </div>
                <?php else: ?>
                <div class="col-lg-5 mb-all-40">
                    <div class="tab-content">
                        <div id="thumb1" class="tab-pane fade show active">
                            <img class="product-image" id="zoom-img" data-zoom-image="<?php echo e(asset('admins/uploads/products/'.$product->image)); ?>" src="<?php echo e(asset('admins/uploads/products/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>">
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="col-lg-7">
                    <div class="thubnail-desc fix">
                        <h3 class="product-header"><?php echo e($product->name); ?></h3>
                        <div class="d-flex">
                            <div class="fb-share-button" data-href="<?php echo e(url()->current()); ?>" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url()->current()); ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                            <div class="fb-like" data-href="<?php echo e(url()->current()); ?>" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                            <div class="zalo-share-button" data-href="<?php echo e(url()->current()); ?>" data-oaid="2905292136695329731" data-layout="1" data-color="blue" data-customize=false></div>
                            <div class="zalo-follow-only-button ml-2" data-oaid="2905292136695329731"></div>
                        </div>
                        <div class="rating-summary fix mtb-10">
                            <div class="rating">
                                <?php for($m = 0; $m < floor($product->star()); $m++): ?> <i class="fas fa-star"></i>
                                    <?php endfor; ?>

                                    <?php for($n = floor($product->star()); $n < 5; $n++): ?> <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                        <?php echo e(number_format((float)$product->star(), 1, '.', '')); ?> <i class="fas fa-eye"></i>
                                        <span class="visit"><?php echo e($product->visit); ?></span>
                            </div>
                            <div class="rating-feedback">
                                <p>
                                    <?php if(count($comments)): ?>
                                    <?php echo e(count($comments)); ?> <?php echo app('translator')->get('lang.product_review'); ?>
                                    <?php else: ?>
                                    <?php echo app('translator')->get('lang.no_review'); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="pro-price mtb-30">
                            <p class="d-flex align-items-center"><span class="prev-price"></span><span class="price"><?php echo number_format($product->price, 0, '', '.')  .  ' VNĐ'; ?></span><span class="saving-price" style="display: none;"></span></p>
                        </div>
                        <p class="mb-20 pro-desc-details"><?php echo e($product->description); ?></p>
                        <div class="box-quantity d-flex hot-product2">
                            <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div style="display: flex;">
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>" />
                                    <input class="quantity mr-15 custom-box-quantity" type="number" name="quantity" min="1" value="1" />
                                    <button class="btn btn-primary custom-btn-submit" type="submit"> <?php echo app('translator')->get('lang.add_cart'); ?></button>
                                    <div class="ml-md-2 pro-actions">
                                        <div class="ml-2 actions-secondary">
                                            <a href="" title="" data-original-title="WishList"><i class="fas fa-heartbeat" style="color: #FF006F;"></i>
                                                <span> <?php echo app('translator')->get('lang.add_wishlist'); ?></span></a>
                                            <a href="" title="" data-original-title="Compare"><i class="fas fa-sync-alt" style="color: #414DD1;"></i>
                                                <span> <?php echo app('translator')->get('lang.add_compare'); ?></span></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="pro-ref mt-20">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="thumnail-desc pb-100 pb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="main-thumb-desc nav tabs-area" role="tablist">
                    <li><a class="active" data-toggle="tab" href="#dtail"><?php echo app('translator')->get('lang.desc'); ?></a></li>
                    <li><a data-toggle="tab" href="#comment-fb"><?php echo app('translator')->get('lang.comment_fb'); ?></a></li>
                    <li><a data-toggle="tab" href="#all-review"><?php echo app('translator')->get('lang.review'); ?></a></li>
                    <?php if(auth()->guard()->check()): ?>
                    <li><a data-toggle="tab" href="#your-review"><?php echo app('translator')->get('lang.your_review'); ?></a></li>
                    <?php endif; ?>

                </ul>
                <div class="tab-content thumb-content border-default">

                    <div id="dtail" class="tab-pane fade show active">
                        <?php if(!$post): ?>
                        <p><?php echo e($product->description); ?></p>
                        <?php else: ?>
                        <div class="row" style="padding: 0 10px">
                            <h3 class="mb-4"> <?php echo $post->title; ?></h3>
                            <?php echo $post->content; ?>

                        </div>
                        <?php endif; ?>
                    </div>

                    <div id="comment-fb" class="tab-pane fade">
                        <div class="fb-comments" data-href="<?php echo e(url()->current()); ?>" data-width="800" data-numposts="20"></div>
                    </div>

                    <div id="all-review" class="tab-pane fade ">
                        <?php if(count($comments)): ?>
                        <?php $i = 1; ?>
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row d-flex <?php if ($i % 2 == 0) {
                                                    echo "justify-content-end";
                                                    $i++;
                                                } ?>">
                            <div class="row comment-box">
                                <div class="comment-box-image">
                                    <img class="avatar-comment" src="<?php echo e(asset('admins/uploads/avatars/'.$comment->user->image)); ?>">
                                </div>
                                <div class="ml-1 mr-2 col">
                                    <div class="row">
                                        <p><b><?php echo e($comment->user->name); ?></b></p>
                                    </div>
                                    <div class="row">
                                        <p class="break-word"><?php echo e($comment->comment); ?></p>
                                    </div>
                                    <div class="row">
                                        <div class="mr-2">
                                            <div class="list-star">
                                                <?php for($j = 0; $j < $comment->star; $j++): ?>
                                                    <i class="fas fa-star"></i>
                                                    <?php endfor; ?>

                                                    <?php for($k = $comment->star; $k < 5; $k++): ?> <i class="far fa-star"></i>
                                                        <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="time-comment">
                                                <?php echo e($comment->time); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <p><?php echo app('translator')->get('lang.no_review'); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if(auth()->guard()->check()): ?>
                    <div id="your-review" class="tab-pane fade">
                        <?php if(!$your_comment): ?>
                        <div class="review border-default universal-padding mt-30">
                            <h2 class="review-title mb-30">
                                <?php echo app('translator')->get('lang.product'); ?>: <br>
                                <span><?php echo e($product->name); ?></span>
                            </h2>
                            <p class="review-mini-title"><?php echo app('translator')->get('lang.review'); ?></p>
                            <ul class="review-list">
                                <li class="review-list-li">
                                    <i class="fa fa-star-o" data-index="1"></i>
                                    <i class="fa fa-star-o" data-index="2"></i>
                                    <i class="fa fa-star-o" data-index="3"></i>
                                    <i class="fa fa-star-o" data-index="4"></i>
                                    <i class="fa fa-star-o" data-index="5"></i>
                                </li>
                            </ul>
                            <div class="riview-field mt-40">
                                <form autocomplete="off" action="" id="form-review" method="POST">
                                    <div class="form-group">
                                        <label class="req" for="comments"><?php echo app('translator')->get('lang.review'); ?></label>
                                        <input type="hidden" class="productID" value="<?php echo e($product->id); ?>">
                                        <textarea class="form-control review-comment" rows="5" id="comment" name="review-comment" required="required"></textarea>
                                    </div>
                                    <div class="customer-btn review-submit"><?php echo app('translator')->get('lang.send'); ?></div>
                                </form>
                            </div>
                        </div>
                        <?php else: ?>
                        <h5 class="text-center mb-4"> <?php echo app('translator')->get('lang.reviewed'); ?></h5>
                        <div class="row d-flex justify-content-center">
                            <div class="row comment-box">
                                <div class="comment-box-image">
                                    <img class="avatar-comment" src="<?php echo e(asset('admins/uploads/avatars/'.Auth::user()->image)); ?>">
                                </div>
                                <div class="ml-1 col">
                                    <div class="row">
                                        <p><b><?php echo e(Auth::user()->name); ?></b></p>
                                    </div>
                                    <div class="row">
                                        <p class="break-word"><?php echo e($your_comment->comment); ?></p>
                                    </div>
                                    <div class="row">
                                        <div class="mr-2">
                                            <div class="list-star">
                                                <?php $star = floor($your_comment->star); ?>
                                                <?php for($j = 0; $j < $star; $j++): ?> <i class="fas fa-star"></i>
                                                    <?php endfor; ?>

                                                    <?php for($k = $star; $k < 5; $k++): ?> <i class="far fa-star"></i>
                                                        <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="time-comment">
                                                <?php echo e($your_comment->time); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mr-2 feature-review">
                                    <input type="hidden" class="productID" value="<?php echo e($product->id); ?>">
                                    <?php if($your_comment->status == 0): ?>
                                    <i class="fa fa-spinner" style="color: green;"></i>
                                    <?php else: ?>
                                    <i class="fa fa-check-circle-o" style="color: green;"></i>
                                    <?php endif; ?>
                                    <i class="fa fa-edit" id="edit-comment"></i>
                                    <i class="fas fa-trash" data-id="<?php echo e($your_comment->id); ?>" id="delete-comment"></i>
                                </div>
                            </div>
                        </div>

                        <div class="review border-default universal-padding mt-30 box-edit">
                            <h2 class="review-title mb-30 text-center">
                                <?php echo app('translator')->get('lang.edit_review'); ?>
                            </h2>
                            <p class="review-mini-title"><?php echo app('translator')->get('lang.review'); ?></p>
                            <ul class="review-list">
                                <li class="review-list-li">
                                    <?php for($k = 1; $k <= 5; $k++): ?> <i class="fa fa-star-o" data-index="<?php echo e($k); ?>"></i>
                                        <?php endfor; ?>
                                </li>
                            </ul>
                            <div class="riview-field mt-40">
                                <form autocomplete="off" action="" id="form-review" method="POST">
                                    <div class="form-group">
                                        <label class="req" for="comments"><?php echo app('translator')->get('lang.review'); ?></label>
                                        <input type="hidden" class="productID" value="<?php echo e($product->id); ?>">
                                        <textarea class="form-control review-comment" rows="5" id="comment" name="review-comment" required="required"><?php echo e($your_comment->comment); ?></textarea>
                                    </div>
                                    <div class="customer-btn review-update"><?php echo app('translator')->get('lang.review'); ?></div>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hot-deal-products pb-90 pb-sm-50">
    <div class="container">
        <div class="post-title pb-10">
            <h2><?php echo app('translator')->get('lang.product_related'); ?></h2>
        </div>
        <div class="hot-deal-active owl-carousel">
            <?php $__currentLoopData = $product_brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="single-product">
                <div class="pro-img">
                    <a href="<?php echo e($product_brand->slug); ?>">
                        <img class="primary-img lazy" style="height: 226px; object-fit: cover;" data-src="<?php echo e(asset('admins/uploads/products/'.$product_brand->image)); ?>" alt="<?php echo e($product_brand->name); ?>">
                    </a>
                    <p class="quick_view product-text-view" title="Lượt xem"> <i class="fas fa-eye"></i><?php echo e($product->visit); ?></p>
                </div>
                <div class="pro-content">
                    <div class="pro-info">
                        <h4><a href="<?php echo e($product_brand->id); ?>"><?php echo e($product_brand->name); ?></a></h4>
                        <p>
                            <span class="price"><?php echo number_format($product_brand->price, 0, '', '.')  .  ' VNĐ'; ?></span>
                        </p>
                        <div class="rating">
                            <?php for($m = 0; $m < floor($product_brand->star()); $m++): ?> <i class="fas fa-star"></i>
                                <?php endfor; ?>

                                <?php for($n = floor($product_brand->star()); $n < 5; $n++): ?> <i class="far fa-star"></i>
                                    <?php endfor; ?>
                        </div>
                    </div>
                    <div class="pro-actions">
                        <div class="actions-primary">
                            <a href="<?php echo e(route('product.detail', $product_brand->slug)); ?>" title="<?php echo app('translator')->get('lang.view_detail_more'); ?>"><?php echo app('translator')->get('lang.view_detail'); ?></a>
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mwstore-laravel\resources\views/user/product.blade.php ENDPATH**/ ?>