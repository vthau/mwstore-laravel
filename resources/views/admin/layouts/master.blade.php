@include('admin.inc.header')
@include('admin.inc.setting')

<div class="app-main">
    @include('admin.inc.slidebar')

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-car icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        <div>
                            @yield('title_page')
                            <div class="page-title-subheading">
                                @yield('sub_title_page')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        @yield('content_page')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.inc.footer')
