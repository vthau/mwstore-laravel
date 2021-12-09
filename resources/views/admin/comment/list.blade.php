@extends('admin.layouts.master')
@section('title', 'Bình luận')
@section('title_page', 'Bình luận')
@section('sub_title_page', 'Tất cả bình luận')

@section('content_page')
<div class="card-header">Danh sách tất cả bình luận</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($comments))
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên người dùng</th>
                <th>Bình luận</th>
                <th class="text-center">Sao</th>
                <th class="text-center">Thời gian</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach($comments as $comment)
            <tr>
                <td class="text-center text-muted">
                    <?php echo $i;
                    $i++; ?>
                </td>
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="rounded-circle border-circle" src="{{asset('admins/uploads/avatars/'.$comment->user->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$comment->user->name}}</div>
                                <div class="widget-subheading opacity-7"></div>
                            </div>
                        </div>
                    </div>
                </td>

                <td class=" text-muted">
                    {{$comment->comment}}
                </td>

                <td class="text-center text-muted">
                    <div class="list-star">
                        @php $star = $comment->star; @endphp
                        @for ($j = 0; $j < $star; $j++) <i class="fa fa-star" style="color: #f39c11;"></i>
                            @endfor
                            @for ($star; $star < 5; $star++) <i class="fa fa-star-o" style="color: #f39c11;"></i>
                                @endfor
                    </div>
                </td>
                <td class="text-center text-muted">{{$comment->time}}</td>
                <td class="text-center text-muted">
                    @if($comment->status == 1)
                    Đã xác nhận
                    @else
                    Chờ xác nhận
                    @endif
                </td>

                <td class="text-center">
                    @if ($comment->status == 0)
                    <a href="{{route('comment.confirm', $comment->id)}}" class="btn btn-success btn-sm">Xác nhận</a>
                    @endif
                    <a data-id="{{$comment->id}}" class="btn btn-danger btn-sm del-comment">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không có bình luận nào để hiển thị</div>
    @endif
</div>
@endsection
