@extends('admin.layouts.master')
@section('title', 'Danh sách sản phẩm')
@section('title_page', 'Sản phẩm')
@section('sub_title_page', 'Danh sách sản phẩm')

@section('content_page')
<div class="card-header">Danh sách sản phẩm</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($products))
    <table id="product-table" class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên sản phẩm</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Thương hiệu</th>
                <th class="text-center">Nổi bật</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($products as $product)
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
                                    <img class="border-circle" src="{{asset('admins/uploads/products/'.$product->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$product->name}}</div>
                                <div class="widget-subheading opacity-7">{{ Str::limit($product->description, 40) }}</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center text-muted">@money($product->price)</td>
                <td class="text-center text-muted">{{$product->quantity}}</td>
                <td class="text-center text-muted">{{$product->brand->name}}</td>
                <td class="text-center text-muted">
                    @if($product->feather == 1)
                    Nổi bật
                    @else
                    Không
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{route('product.edit', $product->id)}}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                    <a href="{{route('product.gallery', $product->id)}}" class="btn btn-info btn-sm">Hình ảnh</a>
                    <form action="{{route('product.destroy', $product->id)}}" class="form-delete" method="POST">
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
    <div class="text-center text-noti">Không có sản phẩm nào để hiển thị</div>
    @endif
</div>
@endsection
