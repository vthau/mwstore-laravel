@extends('admin.layouts.master')
@section('title', 'Thêm Slider')
@section('title_page', 'Thêm Slider')
@section('sub_title_page', 'Thêm Slider cho sản phẩm')

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
    <h5 class="card-title">Thêm Slider</h5>
    <form class="needs-validation" action="{{route('slider.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Tên slider</label>
                <input type="text" class="form-control" name="name" id="validationTooltip01" placeholder="Tên slider" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="">Sản phẩm</label>
                <select class="mb-2 form-control" name="product_id">
                    @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Ẩn/Hiện</label>
                <select class="mb-2 form-control" name="show_hide">
                    <option value="1" selected>Hiện</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 mb-12">
                <div class="custom-file">
                    <label for="validationTooltip01">Hình ảnh</label>
                    <input type="file" class="form-control" name="image" id="validatedCustomFile" accept=".PNG, .JPEG, .JPG" required>
                    <div class="invalid-feedback">Vui lòng chọn một trong các định dạng ảnh: PNG, JPG, JPEG.</div>
                    <div class="valid-feedback">Tuyệt vời!!!</div>
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

