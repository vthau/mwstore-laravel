@extends('admin.layouts.master')
@section('title', 'Danh sách bài viết')
@section('title_page', 'Danh sách bài viết')
@section('sub_title_page', 'Danh sách bài viết')

@section('content_page')
<div class="card-header">Danh sách bài viết</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($posts))
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tiêu đề</th>
                <th class="text-center">Mô tả</th>
                <th class="text-center">Nội dung</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($posts as $post)
            <tr>
                <td class="text-center text-muted">
                    <?php
                    echo $i;
                    $i++;
                    ?>
                </td>

                <td class="text-center text-muted">{{$post->product->name}}</td>
                <td class="text-center text-muted">{{ Str::limit($post->title, 50) }} </td>
                <td class="text-center text-muted">{{ Str::limit($post->content, 50) }}</td>
                <td class="text-center">
                    <a href="{{route('post.edit', $post->id)}}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                    <form action="{{route('post.destroy', $post->id)}}" class="form-delete" method="POST">
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
    <div class="text-center text-noti">Không có bài viết nào để hiển thị</div>
    @endif
</div>
@endsection
