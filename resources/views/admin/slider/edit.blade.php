@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa Slider')
@section('title_page', 'Chỉnh sửa Slider')
@section('sub_title_page', 'Chỉnh sửa Slider cho sản phẩm')

@section('content_page')
<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<div class="card-body">
    <h5 class="card-title">Chỉnh sửa Slider</h5>
    <form class="needs-validation" action="{{route('slider.update', $slider->id)}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Tên slider</label>
                <input type="text" class="form-control" name="name" id="validationTooltip01" placeholder="Tên slider" value="{{$slider->name}}" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="">Sản phẩm</label>
                <select class="mb-2 form-control" name="product_id">
                    @foreach($products as $product)
                    <option @if($slider->product_id == $product->id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Ẩn/Hiện</label>
                <select class="mb-2 form-control" name="show_hide">
                    @if($slider->show_hide == 1)
                    <option selected value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                    @else
                    <option value="1">Hiển thị</option>
                    <option selected value="0">Ẩn</option>
                    @endif
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <div class="custom-file">
                    <label for="validationTooltip01">Hình ảnh</label>
                    <input type="file" class="form-control" name="image" id="validatedCustomFile" accept=".PNG, .JPEG, .JPG">
                    <div class="invalid-feedback">Vui lòng chọn một trong các định dạng ảnh: PNG, JPG, JPEG.</div>
                    <div class="valid-feedback">Tuyệt vời!!!</div>
                    @if ($errors->has('file_error'))
                    <div class="">{{ $errors->first('file_error')}}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-row text-center">
            <div class="col-12">
                <p class="text-noti">Logo sản phẩm hiện tại</p>
                <img class="rounded-circle border-circle" src="{{asset('admins/uploads/sliders/'.$slider->image)}}" alt="">
            </div>
        </div>

        <div class="form-row text-center">
            <div class="col-md-12 mb-3 mt-2">
                <button class="btn btn-success " name="submit" style="padding-left: 35px; padding-right:35px ;" type="submit">Cập nhật</button>
            </div>
        </div>

    </form>
</div>

@endsection
