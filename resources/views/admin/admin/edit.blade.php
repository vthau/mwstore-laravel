@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa admin')
@section('title_page', 'Chỉnh sửa admin')
@section('sub_title_page', 'Chỉnh sửa admin')

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
    <h5 class="card-title">Chỉnh sửa admin</h5>
    <form class="needs-validation" action="{{route('admin.update', $admin->id)}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Tên admin</label>
                <input type="text" class="form-control" id="validationTooltip01" name="name" placeholder="Tên admin" value="{{$admin->name}}" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('name'))
                <div class="">{{ $errors->first('name') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Tên admin</label>
                <input type="email" class="form-control" id="validationTooltip01" name="email" placeholder="Địa chỉ email" value="{{$admin->email}}" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('email'))
                <div class="">{{ $errors->first('email') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Mật khẩu</label>
                <input type="text" class="form-control" id="validationTooltip02" name="password" placeholder="Nhập mật khẩu" value="" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('password'))
                <div class="">{{ $errors->first('password') }}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="validationTooltip01">Mô tả</label>
                <input type="text" class="form-control" id="validationTooltip03" name="description" placeholder="Mô tả" value="{{$admin->description}}" required>
                <div class="invalid-feedback">Vui lòng nhập đầy đủ dữ liệu.</div>
                @if ($errors->has('description'))
                <div class="">{{ $errors->first('description')}}</div>
                @endif
                <div class="valid-feedback">Tuyệt vời!!!</div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="validationTooltip01">Vai trò</label>
                <select class="mb-2 form-control multi-select" name="role_id[]" multiple required>
                    @foreach($roles as $role)
                    <option {{$role_admin->contains('id', $role->id) ? 'selected' : '' }} value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
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
    $(".multi-select2").select2({
        placeholder: "Chọn vai trò",
    });
</script>
@endsection
