@extends('admin.layouts.master')
@section('title', 'Thêm thương hiệu')
@section('title_page', 'Thêm thương hiệu')
@section('sub_title_page', 'Thêm thương hiệu sản phẩm')

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
    <h5 class="card-title">Thêm thương hiệu</h5>
    <form class="needs-validation" action="{{route('brand.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Tên thương hiệu</label>
                <input type="text" class="form-control" id="validationTooltip01" name="name" placeholder="Tên thương hiệu" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('name'))
                <div class="">{{ $errors->first('name') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Mô tả</label>
                <input type="text" class="form-control" id="validationTooltip01" name="description" placeholder="Mô tả" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('description'))
                <div class="">{{ $errors->first('description') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
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
