@extends('admin.layouts.master')
@section('title', 'Danh sách thương hiệu sản phẩm')
@section('title_page', 'Thương hiệu')
@section('sub_title_page', 'Danh sách thương hiệu')

@section('content_page')
<div class="card-header">Danh sách thương hiệu</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($brands) > 0)
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên thương hiệu</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody id="brand-list">
            <?php $i = 1; ?>
            @foreach ($brands as $brand)
            <tr id="{{$brand->id}}">
                <td class="text-center text-muted">
                    <?php
                    echo $i;
                    $i++;
                    ?>
                </td>
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$brand->name}}</div>
                                <div class="widget-subheading opacity-7">{{$brand->description}}</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{route('brand.edit', $brand->id)}}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                    <form action="{{route('brand.destroy', $brand->id)}}" class="form-delete" method="POST">
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
    <div class="text-center text-noti">Không có thương hiệu nào để hiển thị</div>
    @endif
</div>
@endsection
