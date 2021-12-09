@extends('admin.layouts.master')
@section('title', 'Thiết bị truy cập')
@section('title_page', 'Thiết bị truy cập')
@section('sub_title_page', 'Thiết bị truy cập')

@section('content_page')
<div class="card-header">Thiết bị truy cập</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($visitors) > 0)
    <table id="visitor-table" class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th>IP</th>
                <th class="text-center">Lần vào</th>
                <th class="text-center">Hệ điểu hành</th>
                <th class="text-center">Thiết bị</th>
                <th class="text-center">Trình duyệt</th>
                <th class="text-center">Thời gian</th>
                <th class="text-center">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($visitors as $visitor)
            <td class="text-center text-muted">
                <?php
                echo $i;
                $i++;
                ?>
            </td>
            <td class="text-center"><b>{{$visitor->ip}}</b></td>
            <td class="text-center">{{$visitor->visit}}</td>
            <td class="text-center">{{$visitor->os}}</td>
            <td class="text-center">{{$visitor->device}}</td>
            <td class="text-center">{{$visitor->browser}}</td>
            <td class="text-center">{{$visitor->time}}</td>
            <td class="text-center visitor-more" title="{{$visitor->more_info}}">{{Str::limit($visitor->more_info, 50)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không có thiết nào để hiển thị</div>
    @endif
</div>
@endsection
