@extends('admin.layouts.master')
@section('title', 'Thêm sản phẩm')
@section('title_page', 'Thêm sản phẩm')
@section('sub_title_page', 'Thêm sản phẩm')

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
    <h5 class="card-title">Thêm sản phẩm</h5>
    <form class="needs-validation" action="{{route('product.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Tên sản phẩm</label>
                <input type="text" class="form-control" name="name" id="validationTooltip01" placeholder="Tên sản phẩm" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Thương hiệu</label>
                <select class="mb-2 form-control" name="brand_id">
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Nổi bật</label>
                <select class="mb-2 form-control" name="feather">
                    <option value="1" selected>Sản phẩm nổi bật</option>
                    <option value="0">Sản phẩm không nổi bật</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Giá sản phẩm</label>
                <input type="number" class="form-control" name="price" id="validationTooltip01" placeholder="Giá sản phẩm" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Số lượng</label>
                <input type="number" class="form-control" name="quantity" id="validationTooltip01" placeholder="Số lượng" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Mô tả sản phẩm</label>
                <input type="text" class="form-control" name="description" id="validationTooltip01" placeholder="Mô tả" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="custom-file">
                    <label for="validationTooltip01">Hình ảnh</label>
                    <input type="file" class="form-control" name="image" id="validatedCustomFile" accept=".PNG, .JPEG, .JPG" required>
                    <div class="invalid-feedback">Vui lòng chọn một trong các định dạng ảnh: PNG, JPG, JPEG.</div>
                    <div class="valid-feedback">Tuyệt vời!!!</div>
                    @if ($errors->has('file_error'))
                    <div class="">{{ $errors->first('file_error')}}</div>
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
@endsection
