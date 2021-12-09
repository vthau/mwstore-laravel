@extends('admin.layouts.master')
@section('title', 'Người dùng')
@section('title_page', 'Người dùng')
@section('sub_title_page', 'Tất cả người dùng')

@section('content_page')

<div class="card-header">Danh sách người dùng</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($users))

    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Tên người dùng</th>
                <th class="text-center">Email</th>
                <th class="text-center">Điện thoại</th>
                <th class="text-center">Địa chỉ</th>
                <th class="text-center">Mô tả</th>
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
                <td class="text-center text-muted">{{ Str::limit($user->phone, 4)}}</td>
                <td class="text-center text-muted">{{$user->address}}</td>
                <td class="text-center text-muted">{{$user->status}}</td>
                <td class="text-center">
                    <a href="{{route('user.more', $user->id)}}" class="btn btn-success btn-sm">Xem thêm</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không có người dùng nào để hiển thị</div>
    @endif
</div>
@endsection
