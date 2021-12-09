<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MW Store</title>

    <style>
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
            font-family: Tahoma, Geneva, Verdana, sans-serif;
        }

        .content {
            font-family: Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 20px;
            margin: 20px 0;
            background-color: rgba(218, 216, 216, 0.322);
            border-radius: 10px;
        }

        .confirm {
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            display: block;
            margin: 0 auto;
            width: 100px;
            border-radius: 20px;
            outline: none;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px,
                rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            padding: 10px 35px;
            background-color: rgba(44, 44, 243, 0.863);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">MW Store</div>
        <div class="content">
            Có ai đó đã sử dụng địa chỉ Email của bạn để đăng ký tài khoản <b>MW Store</b>, nếu chính xác là bạn vui lòng nhấp
            vào nút xác nhận để kích hoạt tài khoản.
        </div>
        <div class="footer">
            <div class="confirm">{{$coupon->code}}</div>
        </div>
    </div>
</body>

</html>
