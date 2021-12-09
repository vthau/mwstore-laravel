<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo e(asset('users\img\favicon.ico')); ?>" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo e(asset('users/css/auth.css')); ?>" rel="stylesheet" />
    <title>Đăng nhập</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="<?php echo e(route('user.signin_post')); ?>" method="POST" class="sign-in-form">
                    <?php echo csrf_field(); ?>
                    <h2 class="title">Đăng nhập</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Nhập email..." required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" value="<?php echo e(old('password')); ?>" placeholder="Nhập password..." required />
                    </div>

                    <?php if($errors->has('email_or_pass')): ?>
                    <p class="error"><?php echo e($errors->first('email_or_pass')); ?></p>
                    <?php endif; ?>
                    <input type="submit" value="Đăng nhập" class="btn solid" />
                    <a href="<?php echo e(route('user.forgot_password')); ?>" class="forget-password">Quên mật khẩu ?</a>

                    <p class="social-text">Đăng nhập với các nền tảng khác</p>
                    <div class="social-media">
                        <a href="<?php echo e(route('social.facebook')); ?>" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="<?php echo e(route('social.google')); ?>" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="<?php echo e(route('social.zalo')); ?>" class="social-icon">
                            <p>Z</p>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>MW Store</h3>
                    <p>
                        MW Store, hay đăng ký tài khoản để trải nghiệm nhiều hơn dịch vụ của chúng tôi
                    </p>
                    <a href="<?php echo e(route('user.signup_get')); ?>" class="btn transparent">
                        Đăng ký
                    </a>
                </div>
                <img src="<?php echo e(asset('users/img/log.svg')); ?>" class="image" alt="" />
            </div>
        </div>
    </div>
</body>

</html>
<?php /**PATH D:\mwstore-laravel\resources\views/user/signin.blade.php ENDPATH**/ ?>