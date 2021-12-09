<!DOCTYPE html>
<html>

<head>
    <title>MWStore | Đăng nhập trang quản trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?php echo e(asset('admins/img/favicon.ico')); ?>">
    <link href="<?php echo e(asset('admins/css/login-style.css')); ?>" rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
</head>

<body>
    <img class="wave" src="<?php echo e(asset('admins/img/login/wave.png')); ?>">
    <div class="container">
        <div class="img">
            <img src="<?php echo e(asset('admins/img/login/bg.svg')); ?>">
        </div>
        <div class="login-content">
            <form action="<?php echo e(route('admin.handle_signin')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <img src="<?php echo e(asset('admins/img/login/avatar.png')); ?>">

                <h2 class="title">Đăng Nhập</h2>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input id="input-user" type="email" class="input" name="email" value="<?php echo e(old('email')); ?>" required>
                    </div>
                </div>
                <h6 style="margin: 0px; font-size: 12px; color: red;" id="noti-user"></h6>

                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Mật khẩu</h5>
                        <input id="input-pass" type="password" class="input" name="password" value="<?php echo e(old('password')); ?>" required>
                    </div>
                </div>
                <h6 style="margin: 0px; font-size: 12px; color: red;" id="noti-pass"></h6>
                <h6 style="margin-top: 0px; font-size: 12px; color: red;" id="noti-all"></h6>

                <?php if($errors->has('wrong')): ?>
                <h6 style="margin-top: 0px; font-size: 12px; color: red;"><?php echo e($errors->first('wrong')); ?></h6>
                <?php endif; ?>
                <div class="form-group">
                    <?php echo NoCaptcha::renderJs(); ?>

                    <?php echo NoCaptcha::display(); ?>

                </div>
                <p class="error"><?php echo e($errors->first('g-recaptcha-response')); ?></p>
                <input type="submit" id="btn-submit" class="btn" value="Đăng nhập" name="login">
            </form>
        </div>
    </div>

</body>
<script type="text/javascript" src="<?php echo e(asset('admins/js/fontawesome.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('admins/js/login-script.js')); ?>"></script>

</html>
<?php /**PATH D:\mwstore-laravel\resources\views/admin/signin.blade.php ENDPATH**/ ?>