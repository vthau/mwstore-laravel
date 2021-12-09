@extends('admin.layouts.master')
@section('title', 'Danh sách admin')
@section('title_page', 'Danh sách admin')
@section('sub_title_page', 'Danh sách admin')

@section('content_page')

<div class="card-header">Danh sách admin</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($admins))

    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Tên admin</th>
                <th class="text-center">Email</th>
                <th class="text-center">Vai trò</th>
                <th class="text-center">Mô tả</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($admins as $admin)
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
                                <div class="widget-content-left" style="position: relative;">
                                    <img class="rounded-circle border-circle" src="{{asset('admins/img/avatars/'.$admin->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$admin->name}}</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center text-muted">{{$admin->email}}</td>
                <td class="text-center text-muted">
                    @php $roles = $admin->roles; @endphp
                    @foreach($roles as $role)
                    {{$role->name}}
                    @endforeach
                </td>
                <td class="text-center text-muted">{{$admin->description}}</td>
                <td class="text-center">
                    <a href="{{route('admin.edit', $admin->id)}}" class="btn btn-success btn-sm">Chỉnh sửa</a>
                    <a href="{{route('admin.delete', $admin->id)}}" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không admin dùng nào để hiển thị</div>
    @endif
</div>
@endsection
