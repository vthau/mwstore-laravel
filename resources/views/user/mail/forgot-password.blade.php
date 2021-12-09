<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MW Store</title>

    <style>
        * {
            font-family: Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            width: 300px;
            background-color: #eee;
            border-radius: 10px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
                rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        }

        .header {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
        }

        .content {
            text-align: center;
            padding: 20px 20px;
            margin: 20px 0;
            background-color: rgba(218, 216, 216, 0.322);
            border-radius: 10px;
        }

        .confirm {
            color: #FFF;
            text-align: center;
            display: block;
            margin: 0 auto;
            border-radius: 20px;
            outline: none;
            border: none;
            width: 150px;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px,
                rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            padding: 10px 35px;
            background-color: rgba(44, 44, 243, 0.863);
        }

        .confirm>a {
            color: #FFF;
            text-transform: uppercase;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">MW Store</div>
        <div class="content">
            Hi <b>{{$user->name}}</b> bạn vừa yêu cầu đặt lại mật khẩu tài khoản <b>MW Store</b> của mình, nếu đó là bạn vui lòng nhấn vào
            liên kết bên dưới để đặt lại mật khẩu.
            <br>
            <b>Lưu ý:</b> Liên kết chỉ có tác dụng trong <b>15 phút</b>.
        </div>
        <div class="footer">
            <div class="confirm">
                <a href="{{url('new-password/' . $forgot_password)}}">Đặt lại mật khẩu</a>
            </div>
        </div>
    </div>
</body>

</html>
