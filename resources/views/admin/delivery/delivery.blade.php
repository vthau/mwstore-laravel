@extends('admin.layouts.master')
@section('title', 'Phí vận chuyển')
@section('title_page', 'Phí vận chuyển')
@section('sub_title_page', 'Phí vận chuyển')

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
    <h5 class="card-title">Phí vận chuyển</h5>
    <form class="needs-validation" action="" method="POST" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Chọn thành phố</label>
                <select class="mb-2 form-control choose city" id="city" name="city">
                    @foreach($citys as $city)
                    <option value="{{$city->city_code}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Chọn huyện/quận</label>
                <select class="mb-2 form-control choose province" id="province" name="province">
                    @foreach($provinces as $province)
                    <option value="{{$province->province_code}}">{{$province->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Chọn xã phường</label>
                <select class="mb-2 form-control village" id="village" name="village">
                    @foreach($villages as $village)
                    <option value="{{$village->village_code}}">{{$village->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Phí vận chuyển/ VNĐ</label>
                <input type="number" class="form-control feeship" name="feeship" id="validationTooltip01" placeholder="Nhập phí vận chuyển" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

        </div>

        <div class="form-row text-center">
            <div class="col-md-12 mb-3 mt-2">
                <button class="btn btn-success add-delivery" name="add-delivery" style="padding-left: 35px; padding-right:35px ;" type="button">Thêm phí vận chuyển</button>
            </div>
        </div>
    </form>
    <div class="table-feeship">
    </div>
</div>

@endsection
