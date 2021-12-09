@extends('admin.layouts.master')
@section('title', 'Thông tin người dùng')
@section('title_page', 'Thông tin người dùng')
@section('sub_title_page', 'Thông tin người dùng')

@section('content_page')
<div class="card-body">
    <h5 class="card-title text-center mt-3 pb-4" style="font-size: 25px; border-bottom: 1px solid rgba(26,54,126,0.125);">
        <i class="fas fa-user-cog" style="font-size: 40px;"></i>
        <br>
        {{$user->name}}
    </h5>
    <div class="row mt-5 mb-4">
        <div class="col-md-3 text-center">
            <a href="{{route('device.user', $user->id)}}">
                <div class="card-device more-feature float-right">
                    <div class="card-device-title">
                        <i class="fas fa-mobile-alt" style="font-size: 25px;"></i>
                        <br />
                        Thông tin thiết bị
                    </div>
                </div>
            </a>
        </div>
        @if($user->block < 5) <div class="col-md-3 text-center">
            <div class="card-device more-feature">
                <div data-id="{{$user->id}}" class="card-device-title block-user">
                    <i class="fas fa-user-lock" style="font-size: 25px;"></i>
                    <br />
                    Khóa tài khoản
                </div>
            </div>
    </div>
    @else
    <div class="col-md-3 text-center">
        <div class="card-device more-feature">
            <div data-id="{{$user->id}}" class="card-device-title unblock-user">
                <i class="fas fa-unlock" style="font-size: 25px;"></i>
                <br />
                Mở khóa tài khoản
            </div>
        </div>
    </div>
    @endif

    <div class="col-md-3 text-center">
        <div class="card-device more-feature">
            <div class="card-device-title chat-user" id="btn-chat-show">
                <i class="fas fa-envelope" style="font-size: 25px;"></i>
                <br />
                Nhắn tin
            </div>
        </div>
    </div>

    <div class="col-md-3 text-center">
        <div class="card-device more-feature float-left">
            <div class="card-device-title del-user" data-id="{{$user->id}}">
                <i class="fa fa-trash " style="font-size: 25px;"></i>
                <br />
                Xóa
            </div>
        </div>
    </div>
    <input type="hidden" class="user-id" style="display: none;" value="{{$user->id}}" />
</div>
</div>

<div id="popup-chat">
    <div class="box-chat">
        <div class="header-chat">
            <div class="header-chat-avatar">
                <img class="img-user-header" src="{{asset('admins/uploads/avatars/'.$user->image)}}" alt="">
            </div>
            <div class="header-chat-info">
                <div class="name">{{$user->name}}<i class="fa fa-angle-down"></i></div>
                <div class="status">Khách hàng</div>
            </div>
            <div class="header-chat-feature">
                <svg role="presentation" height="50px" width="50px" viewBox="-5 -5 30 30">
                    <path d="M19.492 4.112a.972.972 0 00-1.01.063l-3.052 2.12a.998.998 0 00-.43.822v5.766a1 1 0 00.43.823l3.051 2.12a.978.978 0 001.011.063.936.936 0 00.508-.829V4.94a.936.936 0 00-.508-.828zM10.996 18A3.008 3.008 0 0014 14.996V5.004A3.008 3.008 0 0010.996 2H3.004A3.008 3.008 0 000 5.004v9.992A3.008 3.008 0 003.004 18h7.992z" fill="#bec2c9"></path>
                </svg>
                <svg role="presentation" height="26px" width="26px" viewBox="-5 -5 30 30">
                    <path d="M10.952 14.044c.074.044.147.086.22.125a.842.842 0 001.161-.367c.096-.195.167-.185.337-.42.204-.283.552-.689.91-.772.341-.078.686-.105.92-.11.435-.01 1.118.174 1.926.648a15.9 15.9 0 011.713 1.147c.224.175.37.43.393.711.042.494-.034 1.318-.754 2.137-1.135 1.291-2.859 1.772-4.942 1.088a17.47 17.47 0 01-6.855-4.212 17.485 17.485 0 01-4.213-6.855c-.683-2.083-.202-3.808 1.09-4.942.818-.72 1.642-.796 2.136-.754.282.023.536.17.711.392.25.32.663.89 1.146 1.714.475.808.681 1.491.65 1.926-.024.31-.026.647-.112.921-.11.35-.488.705-.77.91-.236.17-.226.24-.42.336a.841.841 0 00-.368 1.161c.04.072.081.146.125.22a14.012 14.012 0 004.996 4.996z" fill="#bec2c9"></path>
                    <path d="M10.952 14.044c.074.044.147.086.22.125a.842.842 0 001.161-.367c.096-.195.167-.185.337-.42.204-.283.552-.689.91-.772.341-.078.686-.105.92-.11.435-.01 1.118.174 1.926.648.824.484 1.394.898 1.713 1.147.224.175.37.43.393.711.042.494-.034 1.318-.754 2.137-1.135 1.291-2.859 1.772-4.942 1.088a17.47 17.47 0 01-6.855-4.212 17.485 17.485 0 01-4.213-6.855c-.683-2.083-.202-3.808 1.09-4.942.818-.72 1.642-.796 2.136-.754.282.023.536.17.711.392.25.32.663.89 1.146 1.714.475.808.681 1.491.65 1.926-.024.31-.026.647-.112.921-.11.35-.488.705-.77.91-.236.17-.226.24-.42.336a.841.841 0 00-.368 1.161c.04.072.081.146.125.22a14.012 14.012 0 004.996 4.996z" fill="none" stroke="#bec2c9"></path>
                </svg>

                <svg height="26px" id="btn-close-chat" width="26px" viewBox="-4 -4 24 24">
                    <line stroke="#bec2c9" stroke-linecap="round" stroke-width="2" x1="2" x2="14" y1="2" y2="14"></line>
                    <line stroke="#bec2c9" stroke-linecap="round" stroke-width="2" x1="2" x2="14" y1="14" y2="2"></line>
                </svg>
            </div>
        </div>

        <div class="body-chat">
        </div>

        <div class="footer-chat">
            <div class="footer-chat-more">
                <svg class="a8c37x1j ms05siws hr662l2t b7h9ocf4 crt8y2ji tftn3vyl" height="20px" width="20px" viewBox="0 0 24 24">
                    <g fill-rule="evenodd">
                        <polygon fill="none" points="-6,30 30,30 30,-6 -6,-6 "></polygon>
                        <path d="m18,11l-5,0l0,-5c0,-0.552 -0.448,-1 -1,-1c-0.5525,0 -1,0.448 -1,1l0,5l-5,0c-0.5525,0 -1,0.448 -1,1c0,0.552 0.4475,1 1,1l5,0l0,5c0,0.552 0.4475,1 1,1c0.552,0 1,-0.448 1,-1l0,-5l5,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1m-6,13c-6.6275,0 -12,-5.3725 -12,-12c0,-6.6275 5.3725,-12 12,-12c6.627,0 12,5.3725 12,12c0,6.6275 -5.373,12 -12,12"></path>
                    </g>
                </svg>
            </div>
            <div class="footer-chat-message">
                <input type="text" name="" class="message-content" id="" value="" placeholder="Nhập tin nhắn..."></input>
            </div>
            <div class="footer-chat-send" data-userid="{{$user->id}}" data-userimage="{$user->image}}">
                <svg class="crt8y2ji" height="20px" width="20px" viewBox="0 0 24 24">
                    <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 C22.8132856,11.0605983 22.3423792,10.4322088 21.714504,10.118014 L4.13399899,1.16346272 C3.34915502,0.9 2.40734225,1.00636533 1.77946707,1.4776575 C0.994623095,2.10604706 0.8376543,3.0486314 1.15159189,3.99121575 L3.03521743,10.4322088 C3.03521743,10.5893061 3.34915502,10.7464035 3.50612381,10.7464035 L16.6915026,11.5318905 C16.6915026,11.5318905 17.1624089,11.5318905 17.1624089,12.0031827 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z" fill-rule="evenodd" stroke="none"></path>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection
