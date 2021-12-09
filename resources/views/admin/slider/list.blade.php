@extends('admin.layouts.master')
@section('title', 'Danh sách slider')
@section('title_page', 'Danh sách slider')
@section('sub_title_page', 'Danh sách slider')

@section('content_page')
<div class="card-header">Danh sách slider</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($sliders) > 0)
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên slider</th>
                <th class="text-center">Hiện/ Ẩn</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($sliders as $slider)
            <tr>
                <td class="text-center text-muted">
                    <?php
                    echo $i;
                    $i++;
                    ?></td>
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="border-circle" src="{{asset('admins/uploads/sliders/'.$slider->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$slider->name}}</div>
                                <div class="widget-subheading opacity-7"></div>
                            </div>
                        </div>
                    </div>
                </td>

                <td class="text-center text-muted">
                    @if($slider->show_hide == 1)
                    Hiển thị
                    @else
                    Ẩn
                    @endif
                </td>

                <td class="text-center">
                    <a href="{{route('slider.edit', $slider->id)}}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                    <form action="{{route('slider.destroy', $slider->id)}}" class="form-delete" method="POST">
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
    <div class="text-center text-noti">Không có slider nào để hiển thị</div>
    @endif
</div>
@endsection
