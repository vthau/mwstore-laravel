@extends('admin.layouts.master')
@section('title', 'Thêm mã giảm giá')
@section('title_page', 'Thêm mã giảm giá')
@section('sub_title_page', 'Thêm mã giảm giá cho sản phẩm')

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
    <h5 class="card-title">Thêm mã giảm giá</h5>
    <form class="needs-validation" action="{{route('coupon.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Tên mã giảm giá</label>
                <input type="text" class="form-control" name="name" id="validationTooltip01" placeholder="Tên mã giảm giá" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Mã mã giảm giá</label>
                <input type="text" class="form-control" name="code" id="validationTooltip01" placeholder="Mã mã giảm giá" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Số lượng mã giảm giá</label>
                <input type="text" class="form-control" name="quantity" id="validationTooltip01" placeholder="Số lượng mã giảm giá" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Phần trăm giảm giá</label>
                <input type="number" class="form-control" name="percent" id="validationTooltip01" placeholder="Phần trăm giảm giá" min="1" max="100" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Ngày băt đầu</label>
                <input type="text" class="form-control" name="start_coupon" id="start_coupon" placeholder="Ngày băt đầu" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationTooltip01">Ngày kết thúc</label>
                <input type="text" class="form-control" name="end_coupon" id="end_coupon" placeholder="Ngày kết thúc" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>
        </div>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
        @endif
        <div class="form-row text-center">
            <div class="col-md-12 mb-3 mt-2">
                <button class="btn btn-success " name="submit" style="padding-left: 35px; padding-right:35px ;" type="submit">Thêm</button>
            </div>
        </div>


    </form>
</div>
@endsection
