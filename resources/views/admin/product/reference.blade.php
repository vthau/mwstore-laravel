@extends('admin.layouts.master')
@section('title', 'Danh sách sản phẩm')
@section('title_page', 'Sản phẩm')
@section('sub_title_page', 'Danh sách sản phẩm')

@section('content_page')
<div class="card-body">
    <h5 class="card-title"> Tham khảo sản phẩm</h5>
    <div class="form-row text-center">
        <div class="col-md-12 mb-3 mt-2">
            <label for="validationTooltip01">Chọn thương hiệu</label>
            <select class="mb-2 form-control w-50 select-brand" style="margin: 0 auto;" name="productBrand">
                <option value="nokia">Nokia</option>
                <option value="oppo">Oppo</option>
                <option value="realme">Realme</option>
                <option value="samsung">Samsung</option>
                <option value="vivo">Vivo</option>
                <option value="vsmart">Vsmart</option>
                <option value="xiaomi">Xiaomi</option>
            </select>
            <button class="btn btn-success get-data" style="padding-left: 35px; padding-right:35px ;" type="submit">Lấy dữ liệu</button>
        </div>
    </div>
    <div class="product-list">
    </div>
</div>
@endsection
