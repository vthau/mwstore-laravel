$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    CKEDITOR.editorConfig = function (config) {
        config.extraPlugins = "autogrow,texttransform";
    };

    CKEDITOR.replace("ckeditor1");
    CKEDITOR.replace("ckeditor2");

    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "3000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    function getBaseUrl() {
        var pathArray = location.href.split("/");
        var protocol = pathArray[0];
        var host = pathArray[2];
        var url = protocol + "//" + host + "/";

        return url;
    }

    $(".del-user").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: getBaseUrl() + "admin/user/delete",
            method: "POST",
            data: { id },
            success: function (res) {
                window.location.href = getBaseUrl() + "admin/user";
            },
            error: function (rep) {},
        });
    });

    $(document).on("click", ".btn-add", function (e) {
        const brand_id = $(this).data("brand");
        const name = $(this).data("name");
        const price = $(this).data("price");
        const description = $(this).data("desc");
        const src = $(this).data("src");

        $.ajax({
            url: "add-product-crawl",
            method: "POST",
            data: {
                name,
                price,
                description,
                src,
                brand_id,
            },
            success: function (res) {
                toastr["success"]("Thêm sản phầm thành công !!!", "Thành công");
            },
            error: function (rep) {
                toastr["error"]("Có lỗi xảy ra :(", "Thất bại");
            },
        });
    });

    $(".get-data").click(function () {
        const brand = $(".select-brand").val();

        $.ajax({
            url: "get-product-crawl",
            method: "POST",
            data: { brand },
            success: function (res) {
                $(".product-list").html(res.trim());
                toastr["success"]("Lấy dữ liệu thành công !!!", "Thành công");
            },
            error: function (rep) {
                toastr["error"]("Lấy dữ liệu thất bại !!!", "Thất bại");
            },
        });
    });

    //delete brand
    $(".del-brand").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: "brand/destroy",
            method: "POST",
            data: { id },
            success: function (res) {
                location.reload();
                toastr["success"](
                    "Xóa thương hiệu thành công !!!",
                    "Thành công"
                );
            },
            error: function (rep) {},
        });
    });

    //delete product
    $(".del-product").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: "product/destroy",
            method: "POST",
            data: { id },
            success: function (res) {
                location.reload();
                toastr["success"]("Xóa sản phẩm thành công !!!", "Thành công");
            },
            error: function (rep) {},
        });
    });

    //delete slider
    $(".del-slider").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: "slider/destroy",
            method: "POST",
            data: { id },
            success: function (res) {
                location.reload();
                toastr["success"]("Xóa slider thành công !!!", "Thành công");
            },
            error: function (rep) {},
        });
    });

    //del coupon
    $(".del-coupon").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: "coupon/destroy",
            method: "POST",
            data: { id },
            success: function (res) {
                location.reload();
                toastr["success"](
                    "Xóa mã giảm giá thành công !!!",
                    "Thành công"
                );
            },
            error: function (rep) {},
        });
    });

    //del comment
    $(".del-comment").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: "comment/delete",
            method: "POST",
            data: { id },
            success: function (res) {
                location.reload();
            },
            error: function (rep) {},
        });
    });

    //add phi van chuyen
    $(".add-delivery").click(function () {
        const city_code = $(".city").val();
        const province_code = $(".province").val();
        const village_code = $(".village").val();
        const feeship = $(".feeship").val();

        $.ajax({
            url: "delivery/store",
            method: "POST",
            data: {
                city_code,
                province_code,
                village_code,
                feeship,
            },
            success: function (res) {
                toastr["success"](
                    "Thêm phí vận chuyển thành công !!!",
                    "Thành công"
                );
                showFeeship();
            },
            error: function (rep) {},
        });
    });

    //choose city, province, village
    $(".choose").on("change", function () {
        const action = $(this).attr("id");
        const code = $(this).val();
        const _token = $('input[name="_token"]').val();

        let result = "";

        if (action == "city") {
            result = "province";
        } else {
            result = "village";
        }

        $.ajax({
            url: "delivery/select",
            method: "POST",
            data: {
                action,
                code,
            },
            success: function (res) {
                $(`#${result}`).html(res);
            },
            error: function (rep) {},
        });
    });

    //get phi van chuyen
    showFeeship();
    function showFeeship() {
        $.ajax({
            url: getBaseUrl() + "admin/delivery/show",
            method: "POST",
            dataType: "json",
            data: {},
            success: function (res) {
                const feeships = JSON.parse(JSON.stringify(res));
                let result = `<div class="text-center text-noti">Không có phí vận chuyển nào để hiển thị</div>`;

                if (feeships.length) {
                    result = `<h5 class="card-title">Danh sách phí vận chuyển</h5>
                                    <div class="table-responsive" style="padding-bottom: 10px;">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">STT</th>
                                                    <th class="text-center">Tỉnh/Thành phố</th>
                                                    <th class="text-center">Quận/Huyện</th>
                                                    <th class="text-center">Xã/Phường</th>
                                                    <th class="text-center">Phí vận chuyển</th>
                                                    <th class="text-center">Tính năng</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                    feeships.forEach(function (feeship, index) {
                        result += ` <tr>
                                        <td class="text-center text-muted">${
                                            index + 1
                                        }</td>
                                        <td class="text-center text-muted">${
                                            feeship.city
                                        }</td>
                                        <td class="text-center text-muted">${
                                            feeship.province
                                        }</td>
                                        <td class="text-center text-muted">${
                                            feeship.village
                                        }</td>
                                        <td class="text-center text-muted">${
                                            feeship.feeship
                                        } VNĐ</td>
                                        <td class="text-center text-muted">
                                         <a data-id="${
                                             feeship.id
                                         }" class="btn btn-danger btn-sm del-coupon">Xóa</a>
                                        </td>

                                    </tr>`;
                    });

                    result += `         </tbody>
                                    </table>
                                </div>`;
                }

                $(".table-feeship").html(result);
            },
            error: function (rep) {},
        });
    }

    $(document).on("click", ".del-coupon", function () {
        const id = $(this).data("id");

        $.ajax({
            url: getBaseUrl() + "admin/delivery/delete",
            method: "POST",
            data: { id },
            success: function (res) {
                showFeeship();
            },
            error: function (res) {},
        });
    });

    //call ajax view user online
    function getUserStatus() {
        $.ajax({
            url: getBaseUrl() + "admin/user/online",
            method: "POST",
            dataType: "json",
            data: {},
            success: function (res) {
                const users = JSON.parse(JSON.stringify(res));
                let result = `<div class="text-center text-noti">Không có người dùng nào đang trực tuyến</div>`;

                if (users.length > 0) {
                    result = `
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Tên người dùng</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Điện thoại</th>
                                            <th class="text-center">Địa chỉ</th>
                                            <th class="text-center">Mô tả</th>
                                            <th class="text-center">Tính năng</th>
                                        </tr>
                                    </thead>
                                    <tbody> `;

                    users.forEach(function (user, index) {
                        const image = `${getBaseUrl()}admins/uploads/avatars/${
                            user.image
                        }`;

                        result += `
                        <tr>
                            <td class="text-center text-muted">${index}</td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div  class="widget-content-left user-on" style="position: relative;">
                                            <img class="rounded-circle border-circle" src="${image}" alt="">
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">${
                                                user.name
                                            }</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-muted">${
                                user.email
                            }</td>
                            <td class="text-center text-muted">${
                                user.phone
                            }</td>
                            <td class="text-center text-muted">${
                                user.address
                            }</td>
                            <td class="text-center text-muted">${
                                user.status
                            }</td>
                            <td class="text-center">
                                <a href="${getBaseUrl()}admin/user/more/${
                            user.id
                        }" class="btn btn-success btn-sm">Xem thêm</a>
                            </td>
                        </tr>`;
                    });

                    result += `</tbody> </table>`;
                }

                $("#user-online").html(result);
            },
            error: function (rep) {},
        });
    }

    getUserStatus();

    setInterval(function () {
        getUserStatus();
    }, 10000);

    //sort brand
    $("#brand-list").sortable({
        placeholder: "bg-move-admin",
        update: function (event, ui) {
            let page_id_array = [];
            $("#brand-list tr").each(function () {
                page_id_array.push($(this).attr("id"));
            });

            $.ajax({
                url: "brand/sort",
                method: "POST",
                data: {
                    page_id_array,
                },
                success: function (res) {},
            });
        },
    });

    $("#product-table").DataTable();
    $("#visitor-table").DataTable();

    //unblock user
    $(".card-device-title.unblock-user").click(function () {
        const id = $(this).data("id");

        $.ajax({
            url: getBaseUrl() + "admin/user/unblock",
            method: "POST",
            data: { id },
            success: function (res) {
                toastr["success"](
                    "Mở khóa tài khoản thành công !!!",
                    "Thành công"
                );
                location.reload();
            },
            error: function (rep) {},
        });
    });

    //block user
    $(".card-device-title.block-user").click(function () {
        const id = $(this).data("id");

        $.ajax({
            url: getBaseUrl() + "admin/user/block",
            method: "POST",
            data: { id },
            success: function (res) {
                toastr["success"](
                    "Khóa tài khoản thành công !!!",
                    "Thành công"
                );
                location.reload();
            },
            error: function (rep) {},
        });
    });

    $("#start_coupon").datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: [
            "Thứ 2",
            "Thứ 3",
            "Thứ 4",
            "Thứ 5",
            "Thứ 6",
            "Thứ 7",
            "Chủ nhật",
        ],
        duration: "slow",
    });

    $("#end_coupon").datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: [
            "Thứ 2",
            "Thứ 3",
            "Thứ 4",
            "Thứ 5",
            "Thứ 6",
            "Thứ 7",
            "Chủ nhật",
        ],
        duration: "slow",
    });

    let coupon_code;
    let user_id;

    $(".send-coupon").click(function () {
        coupon_code = $(this).data("id");
    });

    $(".send-to-user").click(function () {
        user_id = $(this).data("id");
        let button = $(this);
        button.html("Đang gửi...");

        $.ajax({
            url: "send-coupon",
            method: "POST",
            data: { coupon_code, user_id },
            success: function (res) {
                button.html("Đã gửi");
                toastr["success"](
                    "Gửi mã giảm giá thành công !!!",
                    "Thành công"
                );
            },
            error: function (rep) {},
        });
    });

    $(".footer-chat-send").on("click", function () {
        sendChat();
    });

    $(".message-content").keyup(function (e) {
        if (e.keyCode == 13 || e.which == 13) {
            sendChat();
        }
    });

    function getChat() {
        const user_id = parseInt($(".footer-chat-send").data("userid"));

        $.ajax({
            url: getBaseUrl() + "admin/chat/get",
            method: "POST",
            data: { user_id },
            success: function (res) {
                res = res.trim();
                $(".body-chat").html(res);

                let height = 0;

                $(".body-chat .box-mess").each(function (i, value) {
                    height += parseInt($(this).height());
                });

                height += "";
                $(".body-chat").animate({
                    scrollTop: height + 1,
                });

                const img = $(".img-user-header").attr("src");
                $(".img-user").attr("src", img);
            },
            error: function (rep) {
                console.log("get fial");
            },
        });
    }

    function sendChat() {
        const message = $(".message-content").val();
        const user_id = parseInt($(".footer-chat-send").data("userid"));

        if (message == "") return;

        $.ajax({
            url: getBaseUrl() + "admin/chat/send",
            method: "POST",
            data: {
                user_id,
                message,
            },
            success: function (res) {
                $(".message-content").val("");
                getChat();
            },
            error: function (rep) {
                console.log("send fial");
            },
        });
    }

    $("#btn-chat-show").click(function () {
        $("#popup-chat").toggle();
        getChat();
        setInterval(() => {
            getChat();
        }, 2000);
    });

    $("#btn-close-chat").click(function () {
        $("#popup-chat").toggle();
    });
});
