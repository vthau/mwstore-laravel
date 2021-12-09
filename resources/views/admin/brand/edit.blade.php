@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa thương hiệu')
@section('title_page', 'Chỉnh sủa thương hiệu')
@section('sub_title_page', 'Chỉnh sủa thương hiệu sản phẩm')

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
    <h5 class="card-title">Chỉnh sửa thương hiệu</h5>
    <form class="needs-validation" action="{{route('brand.update', $brand->id)}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Tên thương hiệu</label>
                <input type="text" class="form-control" id="validationTooltip01" name="name" placeholder="Tên danh mục" value="{{$brand->name}}" required>
                <div class="invalid-feedback" style="font-size: 20px;">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Mô tả</label>
                <input type="text" class="form-control" id="validationTooltip01" name="description" placeholder="Mô tả" value="{{$brand->description}}" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>
        </div>

        <div class="form-row text-center">
            <div class="col-md-12 mb-3 mt-3">
                <button class="btn btn-success " style="padding-left: 35px; padding-right:35px ;" name="submit" type="submit">Cập nhập</button>
            </div>
        </div>
    </form>
</div>
@endsection
