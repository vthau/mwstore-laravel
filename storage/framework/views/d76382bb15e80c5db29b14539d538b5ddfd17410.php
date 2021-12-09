<div class="app-sidebar sidebar-shadow">

    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>

    <!-- sidebar start -->
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">

                <li class="app-sidebar__heading">Trang chủ</li>
                <li>
                    <a href="<?php echo e(route('admin.index')); ?>" class="mm-active">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Trang chủ
                    </a>
                </li>

                <li class="app-sidebar__heading">Admin & Phân Quyền</li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ADMIN')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Admin
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('admin.add')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Thêm Admin
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.list')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách Admin
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ROLE')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Vai trò
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('role.create')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Thêm vai trò
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('role.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách vai trò
                            </a>
                        </li>

                    </ul>
                </li>
                <?php endif; ?>
                <li class="app-sidebar__heading">Tính Năng Quản Trị</li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BRAND')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Thương hiệu
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('brand.create')); ?>">
                                <i class="metismenu-icon"></i>
                                Thêm thương hiệu
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('brand.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách thương hiệu
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('PRODUCT')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Sản phẩm
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('product.create')); ?>">
                                <i class="metismenu-icon"></i>
                                Thêm sản phẩm
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('product.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách sản phẩm
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('product.reference')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Tham khảo sản phẩm
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('POST')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Bài viết
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('post.create')); ?>">
                                <i class="metismenu-icon"></i>
                                Thêm bài viết
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('post.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách bài viết
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('SLIDER')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Slider
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('slider.create')); ?>">
                                <i class="metismenu-icon"></i>
                                Thêm slider
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('slider.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách slider
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('COUPON')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Mã giảm giá
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('coupon.create')); ?>">
                                <i class="metismenu-icon"></i>
                                Thêm mã giảm giá
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('coupon.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách mã giảm giá
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ORDER')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Mua hàng
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('order.manage')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Danh sách mua hàng
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FEESHIP')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Vận chuyển
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('delivery.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Phí vận chuyển
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('USER')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Người dùng
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('user.online')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Người dùng đang trực tuyến
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('user.list')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Tất cả người dùng
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('COMMENT')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Bình luận
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('comment.not_confirm')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Bình luận chờ duyệt
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('comment.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Tât cả bình luận
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('INFO')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Thông tin
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('device.admin')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Thông tin thiết bị
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('visitor.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Thiết bị truy cập
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('STATISTIC')): ?>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Thống kê
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo e(route('static.index')); ?>">
                                <i class="metismenu-icon">
                                </i>
                                Tổng quan
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH D:\mwstore-laravel\resources\views/admin/inc/slidebar.blade.php ENDPATH**/ ?>