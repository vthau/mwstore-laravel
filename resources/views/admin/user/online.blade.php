@extends('admin.layouts.master')
@section('title', 'Người dùng')
@section('title_page', 'Người dùng')
@section('sub_title_page', 'Tất cả người dùng online')

@section('content_page')
<div class="main-card mb-3 card">
    <div class="card-header">Danh sách người dùng online</div>
    <div class="table-responsive" id="user-online" style="padding-bottom: 10px;">

    </div>
</div>
@endsection
