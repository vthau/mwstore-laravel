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
            width: 450px;
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
            padding: 20px;
            margin: 20px 0 10px;
            background-color: rgba(218, 216, 216, 0.322);
            border-radius: 10px;
            text-align: center;
        }

        .confirm {
            color: #FFF;
            font-weight: bold;
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

        .code-title {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">MW Store</div>
        <div class="content">
            <b>MW Store</b> tặng bạn <b>{{$user->name}}</b> mã giảm giá áp
            dụng từ ngày <b>{{$coupon->start_coupon}}</b> đến ngày <b>{{$coupon->end_coupon}}</b>.
            <br />
            Hãy nhanh tay sử dụng, chỉ còn <b>{{$coupon->quantity}}</b> mã cuối cùng.
            <br />
            Mã giảm <b>{{$coupon->percent}}%</b> cho tất cả các sản phẩm trên hệ thống.
        </div>
        <div class="code-title">Mã của bạn là</div>
        <div class="footer">
            <div class="confirm">{{$coupon->code}}</div>
        </div>
    </div>
</body>

</html>
