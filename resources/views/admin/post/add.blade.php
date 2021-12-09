@extends('admin.layouts.master')
@section('title', 'Thêm bài viết')
@section('title_page', 'Thêm bài viết')
@section('sub_title_page', 'Thêm bài viết cho sản phẩm')

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
    <h5 class="card-title">Thêm bài viết</h5>
    <form class="needs-validation" action="{{route('post.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Sản phẩm</label>
                <select class="mb-2 form-control" name="product_id">
                    @foreach($products as $product)
                    @if(!$product->post)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label for="validationTooltip01">Mô tả bài viết</label>
                <textarea style="resize: none" rows="3" class="form-control" name="title" id="ckeditor1" placeholder="Mô tả cho bài viết"></textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label for="validationTooltip01">Nôi dung bài viết</label>
                <textarea style="resize: none" rows="10" class="form-control" name="content" id="ckeditor2" placeholder="Nội dung cho bài viết"></textarea>
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
