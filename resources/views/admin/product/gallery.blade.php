@extends('admin.layouts.master')
@section('title', 'Hình ảnh | ' . $product->name)
@section('title_page', 'Hình ảnh')
@section('sub_title_page', 'Danh sách hình ảnh')

@section('content_page')
<div class="card-header">Danh sách hình ảnh của {{ $product->name}}</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <div class="card-body">
        <form class="needs-validation" action="{{route('product.gallery.store', $product->id)}}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="custom-file">
                        <label for="validationTooltip01">Chọn hình ảnh</label>
                        <input type="file" class="form-control" name="image[]" id="validatedCustomFile" accept=".PNG, .JPEG, .JPG" multiple required>
                        <div class="invalid-feedback">Vui lòng chọn một trong các định dạng ảnh: PNG, JPG, JPEG.</div>
                        <div class="valid-feedback">Tuyệt vời!!!</div>
                        @if ($errors->has('file_error'))
                        {{ $errors->first('file_error')}}
                        @endif
                    </div>
                </div>

            </div>

            <div class="form-row text-center">
                <div class="col-md-12 mb-3 mt-2">
                    <button class="btn btn-success " name="submit" style="padding-left: 35px; padding-right:35px ;" type="submit">Thêm</button>
                </div>
            </div>

        </form>
    </div>
    @if(count($gallerys))
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>Tên sản phẩm</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($gallerys as $gallery)
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
                                    <img class="border-circle" src="{{asset('admins/uploads/gallerys/'.$gallery->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$product->name}}</div>
                                <div class="widget-subheading opacity-7"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{route('product.gallery.delete', $gallery->id)}}" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không có hình ảnh nào để hiển thị</div>
    @endif
</div>
@endsection
