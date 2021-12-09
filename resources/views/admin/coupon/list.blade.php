@extends('admin.layouts.master')
@section('title', 'Danh sách mã giảm giá')
@section('title_page', 'Danh sách mã giảm giá')
@section('sub_title_page', 'Danh sách mã giảm giá')

<div class="modal fade" id="modal-coupon" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content model-send-coupon" role="document">
            <div class="card-header d-flex justify-content-between align-items-center">Danh sách người dùng <div data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            <div class="table-responsive" style="padding-bottom: 10px;">
                @if(count($users))
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th class="text-center">Tên khách hàng</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Tính năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center text-muted">
                                <?php echo $i;
                                $i++;
                                ?>
                            </td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left <?php if ($user->isOnline()) {
                                                                                echo "user-on";
                                                                            } ?>" style="position: relative;">
                                                <img class="rounded-circle border-circle" src="{{asset('admins/uploads/avatars/'.$user->image)}}" alt="">
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">{{$user->name}}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-muted">{{$user->email}}</td>

                            <td class="text-center">
                                <button data-id="{{$user->id}}" class="btn btn-success btn-sm send-to-user">Gửi mã</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center text-noti">Không có người dùng nào để hiển thị</div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('content_page')

<div class="card-header">Danh sách mã giảm giá</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($coupons) > 0)
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên mã giảm giá</th>
                <th class="text-center">Mã mã giảm giá</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Phần trăm giảm giá</th>
                <th class="text-center">Ngày bắt đầu</th>
                <th class="text-center">Ngày kết thúc</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($coupons as $coupon)
            <tr>
                <td class="text-center text-muted">
                    <?php
                    echo $i;
                    $i++;
                    ?></td>
                <td class="text-center text-muted">{{$coupon->name}}</td>
                <td class="text-center text-muted">{{$coupon->code}}</td>
                <td class="text-center text-muted">{{$coupon->quantity}} Mã</td>
                <td class="text-center text-muted">{{$coupon->percent}}%</td>
                <td class="text-center text-muted">{{$coupon->start_coupon}}</td>
                <td class="text-center text-muted">{{$coupon->end_coupon}}</td>
                <td class="text-center text-muted">
                    @if($coupon->end_coupon >= $today)
                    Còn hạn
                    @else
                    Hết hạn
                    @endif
                </td>
                <td class="text-center">
                    <button data-toggle="modal" data-target="#modal-coupon" data-id="{{$coupon->code}}" class="btn btn-success btn-sm send-coupon">Gửi mã</button>
                    <a href="{{route('coupon.edit', $coupon->id)}}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                    <form action="{{route('coupon.destroy', $coupon->id)}}" class="form-delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không có mã giảm giá nào để hiển thị</div>
    @endif
</div>
@endsection
