@extends('admin.layouts.master')
@section('title', 'Thêm vai trò')
@section('title_page', 'Thêm vai trò')
@section('sub_title_page', 'Thêm vai trò')

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
<style>
    input[type="checkbox"] {
        transform: translateY(1px);
    }
</style>

<div class="card-body">
    <h5 class="card-title">Thêm vai trò</h5>
    <form class="needs-validation" action="{{route('role.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Tên vai trò</label>
                <input type="text" class="form-control" id="validationTooltip01" name="name" placeholder="Tên vai trò" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('name'))
                <div class="">{{ $errors->first('name') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Mô tả</label>
                <input type="text" class="form-control" id="validationTooltip03" name="description" placeholder="Mô tả" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('description'))
                <div class="">{{ $errors->first('description') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12">
                <div class="card-body">
                    <h5 class="card-title">Danh sách tất cả quyền</h5>
                </div>
            </div>
            <div class="col-md-12">
                <h6 class="card-title">Đánh dấu tất cả <input type="checkbox" class="check-all" /></h6>
            </div>
            <div class="row">
                @foreach($permissions as $permission)
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">{{$permission->name}}</div>
                                    <div class="widget-subheading">{{$permission->description}}</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-success">
                                        <input type="checkbox" class="checkbox-childrent" name="permission_id[]" value="{{$permission->id}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-row text-center">
            <div class="col-md-12 mb-3 mt-2">
                <button class="btn btn-success " name="submit" style="padding-left: 35px; padding-right:35px ;" type="submit">Thêm</button>
            </div>
        </div>

    </form>
</div>
<script>
    $(".check-all").on("click", function() {
        $(this)
            .parents()
            .find(".checkbox-childrent")
            .prop("checked", $(this).prop("checked"));
    });
</script>
@endsection
