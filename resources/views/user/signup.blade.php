<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{asset('users\img\favicon.ico')}}" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('users/css/auth.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('users/css/toastr.min.css')}}" rel="stylesheet">
    <title>Đăng ký</title>
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <form id="form-signup" action="{{route('user.signup_post')}}" method="POST" class="sign-up-form">
                    @csrf
                    <h2 class="title">Đăng ký</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Tên" />
                    </div>
                    <div class="input-field field-email">
                        <i class="fas fa-envelope"></i>
                        <input type="text" name="email" class="" placeholder="Email" />
                        @if ($errors->has('email'))
                        <label class="error error-phone"> {{ $errors->first('email') }} </label>
                        @endif
                    </div>
                    <div class="input-field field-phone">
                        <i class="fas fa-mobile"></i>
                        <input type="password" name="phone" class="input-phone" placeholder="Điện thoại" />
                        <div class="btn-get-code">Lấy mã</div>
                        @if ($errors->has('phone'))
                        <label class="error error-phone"> {{ $errors->first('phone') }} </label>
                        @endif
                    </div>
                    <div class="input-field field-code">
                        <i class="fas fa-user"></i>
                        <input type="number" class="input-code" name="code" placeholder="Mã xác thực" editable />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Mật khẩu" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" />
                    </div>
                    <div id="recaptcha-container"></div>

                    <input type="submit" class="btn" value="Đăng ký" />
                    <p class="social-text">Đăng nhập với các nền tảng khác</p>
                    <div class="social-media">
                        <a href="{{route('social.facebook')}}" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{route('social.google')}}" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="{{route('social.zalo')}}" class="social-icon">
                            <p>Z</p>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>MW Store</h3>
                    <p>
                        MW Store, hay đăng nhập tài khoản để trải nghiệm nhiều hơn dịch vụ của chúng tôi
                    </p>
                    <a href="{{route('user.signin_get')}}" class="btn transparent">
                        Đăng nhập
                    </a>
                </div>

                <img src="{{asset('users/img/register.svg')}}" class="image" alt="" />
            </div>
        </div>
    </div>
</body>
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-firestore.js"></script>
<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyCLVk3_op3BJf3WpRjjk0EBSGCY8gdASfQ",
        authDomain: "mw-store-14bbb.firebaseapp.com",
        projectId: "mw-store-14bbb",
        storageBucket: "mw-store-14bbb.appspot.com",
        messagingSenderId: "97600009055",
        appId: "1:97600009055:web:25baf0b48e82bb02b6fcea",
        measurementId: "G-VVWQ8VQD2Z"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    // Initialize Firebase
</script>

<script src="{{asset('users/js/jquery-3.2.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{asset('users/js/toastr.min.js')}}"></script>
<script src="{{asset('users/js/auth.js')}}"></script>

</html>
