var ratedIndex = 0;

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#zoom-img").elevateZoom({
        scrollZoom: true,
    });

    function getBaseUrl() {
        var pathArray = location.href.split("/");
        var protocol = pathArray[0];
        var host = pathArray[2];
        var url = protocol + "//" + host + "/";

        return url;
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".hide-cart-info").addClass("show-cart-info");
        } else {
            $(".hide-cart-info").removeClass("show-cart-info");
        }
    });

    $("#edit-comment").on("click", function () {
        $(".box-edit").toggle();
    });

    $(".review-list > .review-list-li > i.fa").on("click", function () {
        ratedIndex = parseInt($(this).data("index"));
        resetStar();
        setStar(ratedIndex);
    });

    $(".review-submit").on("click", function (e) {
        e.preventDefault();
        sendReviewAjax("store");
    });

    $(".review-update").on("click", function (e) {
        e.preventDefault();
        sendReviewAjax("update");
    });

    $("#delete-comment").on("click", function (e) {
        e.preventDefault();
        const id = parseInt($(this).data("id"));
        $.ajax({
            url: getBaseUrl() + "comment/delete",
            method: "POST",
            data: { id },
            success: function (res) {
                toastr["success"]("Thành công !!!", "Thành công");
                location.reload();
            },
            error: function (error) {
                console.log(JSON.stringify(error));
            },
        });
    });

    function sendReviewAjax(type) {
        const product_id = $(".productID").val();
        const comment = $(".review-comment").val();

        $.ajax({
            url: getBaseUrl() + "comment/" + type,
            method: "POST",
            data: {
                product_id,
                comment,
                star: ratedIndex,
            },
            success: function (res) {
                toastr["success"]("Thành công !!!", "Thành công");
                location.reload();
            },
            error: function (error) {
                console.log(JSON.stringify(error));
            },
        });
    }

    function setStar(star) {
        for (var i = 0; i < star; i++) {
            $(
                ".review-list > .review-list-li > i.fa:eq(" + i + ")"
            ).removeClass("fa-star-o");
            $(".review-list > .review-list-li > i.fa:eq(" + i + ")").addClass(
                "fa-star"
            );
        }
    }

    function resetStar() {
        $(".review-list > .review-list-li > i.fa.fa-star")
            .removeClass("fa-star")
            .addClass("fa-star-o");
    }

    function sendChat() {
        const message = $(".message-content").val().trim();
        if (message == "") return;

        $.ajax({
            url: getBaseUrl() + "chat/send",
            method: "POST",
            data: { message },
            success: function (res) {
                $(".message-content").val("");
                getChat();
            },
            error: function (rep) {
                console.log("send that bai");
            },
        });
    }

    $(".message-content").keyup(function (e) {
        if (e.keyCode == 13 || e.which == 13) {
            sendChat();
        }
    });

    $(".footer-chat-send").on("click", function () {
        sendChat();
    });

    function getChat() {
        $.ajax({
            url: getBaseUrl() + "chat/get",
            method: "POST",
            data: {},
            success: function (res) {
                res = res.trim();
                $(".body-chat").html(res);

                let height = 0;

                $(".body-chat .box-mess").each(function (i, value) {
                    height += parseInt($(this).height());
                });

                height += "";
                $(".body-chat").animate({ scrollTop: height });
            },
            error: function (rep) {
                console.log("get that bai");
            },
        });
    }

    $("#btn-chat").click(function () {
        $("#btn-chat").toggle();
        $("#popup-chat").toggle();
        getChat();
        setInterval(() => {
            getChat();
        }, 2000);
    });

    $("#btn-close-chat").click(function () {
        $("#btn-chat").toggle();
        $("#popup-chat").toggle();
    });

    // $(".sign-email").focus(function () {
    //     $(".sign-fail").css({
    //         display: "none",
    //     });
    // });

    // $(".sign-password").focus(function () {
    //     $(".sign-fail").css({
    //         display: "none",
    //     });
    // });

    // function emailIsValid(email) {
    //     return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
    //         email
    //     );
    // }

    // function disableSignIn() {
    //     $(".sign-btn").attr("disabled", "disabled");
    //     $(".sign-btn").css({
    //         "background-color": "#ccc",
    //         cursor: "context-menu",
    //     });
    // }

    // function enableSignIn() {
    //     $(".sign-btn").removeAttr("disabled");
    //     $(".sign-btn").css({
    //         "background-color": "var(--primary)",
    //         cursor: "pointer",
    //     });
    // }

    // $(".sign-email").blur(function () {
    //     const email = $(".sign-email").val().trim();
    //     const checkEmail = emailIsValid(email);
    //     if (!checkEmail) {
    //         $(".sign-fail")
    //             .css({
    //                 display: "block",
    //             })
    //             .html("Địa chỉ Email không hợp lệ");
    //     }
    // });

    // $(".sign-password").blur(function () {
    //     const password = $(".sign-password").val().trim();
    //     if (password.length < 0) {
    //         $(".sign-fail")
    //             .css({
    //                 display: "block",
    //             })
    //             .html("Mật khẩu quá ngắn");
    //     }
    // });

    // $(".sign-btn").click(function () {
    //     const email = $(".sign-email").val().trim();
    //     const password = $(".sign-password").val().trim();

    //     if (email === "" || password === "") {
    //         $(".sign-fail")
    //             .css({
    //                 display: "block",
    //             })
    //             .html("Vui lòng nhập đủ dữ liệu");

    //         return;
    //     }
    //     if (password.length < 0) {
    //         $(".sign-fail")
    //             .css({
    //                 display: "block",
    //             })
    //             .html("Mật khẩu quá ngắn");
    //         return;
    //     }

    //     const checkEmail = emailIsValid(email);
    //     if (!checkEmail) {
    //         $(".sign-fail")
    //             .css({
    //                 display: "block",
    //             })
    //             .html("Địa chỉ Email không hợp lệ");

    //         return;
    //     }

    //     disableSignIn();

    //     $.ajax({
    //         url: "classes/request.php",
    //         method: "POST",
    //         data: {
    //             type: "SIGN_IN",
    //             email,
    //             password,
    //         },
    //         success: function (res) {
    //             switch (res.trim()) {
    //                 case "SIGN_SUCCESS":
    //                     toastr["success"](
    //                         "Đăng nhập thành công !!!",
    //                         "Thành công !!!"
    //                     );
    //                     window.location = `https://mwstoree.000webhostapp.com/index.php`;
    //                     enableSignIn();
    //                     break;

    //                 case "USER_BLOCK":
    //                     toastr["warning"](
    //                         "Tài khoản của bạn đã bị khóa :(",
    //                         "Thất bại !!!"
    //                     );
    //                     window.location = `https://mwstoree.000webhostapp.com/userblock.php`;
    //                     enableSignIn();
    //                     break;

    //                 case "RECONFIRM":
    //                     toastr["warning"](
    //                         "Vui lòng kích hoạt tài khoản :(",
    //                         "Thất bại !!!"
    //                     );
    //                     window.location = `https://mwstoree.000webhostapp.com/reconfirm.php`;
    //                     enableSignIn();
    //                     break;

    //                 case "INPUT_FILL":
    //                     $(".sign-fail")
    //                         .css({
    //                             display: "block",
    //                         })
    //                         .html("Hãy nhập đủ các trường dữ liệu");
    //                     enableSignIn();
    //                     break;

    //                 case "SIGN_FAIL":
    //                     $(".sign-fail")
    //                         .css({
    //                             display: "block",
    //                         })
    //                         .html("Email hoặc mật khẩu không đúng !!!");
    //                     toastr["error"](
    //                         "Email hoặc mật khẩu không đúng :(",
    //                         "Thất bại !!!"
    //                     );
    //                     enableSignIn();
    //                     break;

    //                 default:
    //                     break;
    //             }
    //         },
    //         error: function (rep) {
    //             console.log("FAIL");
    //         },
    //     });
    // });
    // //change password form

    // $(".old-password").focus(function () {
    //     $(".mess-old-password").css({
    //         visibility: "hidden",
    //     });
    //     $(".change-password-fail").css({
    //         visibility: "hidden",
    //     });
    // });
    // $(".pre-new-password").focus(function () {
    //     $(".mess-pre-new-password").css({
    //         visibility: "hidden",
    //     });
    // });
    // $(".new-password").focus(function () {
    //     $(".mess-new-password").css({
    //         visibility: "hidden",
    //     });
    // });

    // $(".old-password").blur(function () {
    //     const oldPassword = $(".old-password").val().trim();
    //     if (oldPassword === "") {
    //         $(".mess-old-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Nhập mật khẩu cũ");
    //         return;
    //     }
    //     if (oldPassword.length < 8) {
    //         $(".mess-old-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu phải từ 8 số trở lên");
    //         return;
    //     }
    // });
    // $(".new-password").blur(function () {
    //     const newPassword = $(".new-password").val().trim();
    //     if (newPassword === "") {
    //         $(".mess-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Nhập mật khẩu mới");
    //         return;
    //     }
    //     if (newPassword.length < 8) {
    //         $(".mess-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu phải từ 8 số trở lên");
    //         return;
    //     }
    // });
    // $(".pre-new-password").blur(function () {
    //     const newPassword = $(".new-password").val().trim();
    //     const reNewPassword = $(".pre-new-password").val().trim();
    //     if (reNewPassword === "") {
    //         $(".mess-pre-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Nhập lại mật khẩu mới");
    //         return;
    //     }
    //     if (reNewPassword.length < 8) {
    //         $(".mess-pre-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu phải từ 8 số trở lên");
    //         return;
    //     }
    //     if (newPassword !== reNewPassword) {
    //         $(".mess-pre-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu không khớp, kiểm tra lại");
    //         return;
    //     }
    // });

    // $(".btn-change-password").click(function () {
    //     var isTrue = true;

    //     const oldPassword = $(".old-password").val().trim();
    //     if (oldPassword === "") {
    //         $(".mess-old-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Nhập mật khẩu cũ");
    //         isTrue = false;
    //     }
    //     if (oldPassword.length < 8) {
    //         $(".mess-old-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu phải từ 8 số trở lên");
    //         isTrue = false;
    //     }
    //     const newPassword = $(".new-password").val().trim();
    //     const reNewPassword = $(".pre-new-password").val().trim();
    //     if (reNewPassword === "") {
    //         $(".mess-pre-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Nhập lại mật khẩu mới");
    //         isTrue = false;
    //     }
    //     if (reNewPassword.length < 8) {
    //         $(".mess-pre-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu phải từ 8 số trở lên");
    //         isTrue = false;
    //     }
    //     if (newPassword !== reNewPassword) {
    //         $(".mess-pre-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu không khớp, kiểm tra lại");
    //         isTrue = false;
    //     }

    //     if (newPassword === "") {
    //         $(".mess-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Nhập mật khẩu mới");
    //         return;
    //     }
    //     if (newPassword.length < 8) {
    //         $(".mess-new-password")
    //             .css({
    //                 visibility: "visible",
    //             })
    //             .html("Mật khẩu phải từ 8 số trở lên");
    //         isTrue = false;
    //     }
    //     if (isTrue) {
    //         $.ajax({
    //             url: "classes/request.php",
    //             method: "POST",
    //             data: {
    //                 type: "CHANGE_PASSWORD",
    //                 oldPassword,
    //                 newPassword,
    //             },
    //             success: function (res) {
    //                 switch (res.trim()) {
    //                     case "CHANGE_PASSWORD_SUCCESS":
    //                         $("#modal-change-password").modal("hide");
    //                         toastr["success"](
    //                             "Đổi mật khẩu thành công !!!",
    //                             "Thành công !!!"
    //                         );
    //                         break;

    //                     case "PASSWORD_WRONG":
    //                         toastr["error"](
    //                             "Mật khẩu hiện tại không đúng :(",
    //                             "Thất bại !!!"
    //                         );
    //                         $(".change-password-fail")
    //                             .css({
    //                                 visibility: "visible",
    //                             })
    //                             .html("Mật khẩu hiện tại không đúng");

    //                         break;

    //                     default:
    //                         break;
    //                 }
    //             },
    //             error: function (rep) {
    //                 console.log("FAIL");
    //             },
    //         });
    //     }
    // });

    //update cart
    $(".product-quantity-update").on("input", function () {
        const quantity = $(this).val();
        const product_id = parseInt($(this).data("id"));

        if (quantity < 1) return;
        $.ajax({
            url: getBaseUrl() + "cart/update",
            method: "POST",
            data: { product_id, quantity },
            success: function (res) {
                location.reload();
            },
            error: function (rep) {
                console.log("FAIL");
            },
        });
    });

    // del cart
    $(".del-cart").click(function () {
        const id = parseInt($(this).data("id"));

        $.ajax({
            url: getBaseUrl() + "cart/delete",
            method: "POST",
            data: { id },
            success: function (res) {
                toastr["success"](
                    "Xóa sản phẩm thành công !!!",
                    "Thành công !!!"
                );

                setTimeout(() => {
                    location.reload();
                }, 1 * 1000);
            },
            error: function (rep) {},
        });
    });

    $(".check-coupon").click(function () {
        const code = $(".coupon-code").val().trim();
        if (code == "") return;

        $.ajax({
            url: getBaseUrl() + "use-coupon",
            method: "POST",
            data: { code },
            success: function (res) {
                location.reload();
            },
            error: function (rep) {},
        });
    });

    $(".del-order").click(function () {
        const orderID = parseInt($(this).data("id"));

        $.ajax({
            url: "classes/request.php",
            method: "POST",
            data: {
                type: "DEL_ORDER",
                orderID,
            },
            success: function (res) {
                switch (res.trim()) {
                    case "DEL_SUCCESS":
                        location.reload();
                        break;
                    default:
                        break;
                }
            },
            error: function (rep) {},
        });
    });

    //choose city, province, village
    $(document).on("change", ".choose", function (e) {
        const action = $(this).attr("id");
        const code = $(this).val();
        const _token = $('input[name="_token"]').val();
        let result = "";

        if (action == "city") {
            result = "province";
        } else if (action == "province") {
            result = "village";
        }

        if (result != "") {
            $.ajax({
                url: "select-delivery",
                method: "POST",
                data: {
                    action,
                    code,
                    _token,
                },
                success: function (res) {
                    $("." + result).html(res);
                },
                error: function (rep) {},
            });
        }
    });

    $(".add-delivery").click(function () {
        const city_code = $(".city").val();
        const province_code = $(".province").val();
        const village_code = $(".village").val();

        $.ajax({
            url: "checkout/calc-feeship",
            method: "POST",
            data: {
                city_code,
                province_code,
                village_code,
            },
            success: function (res) {
                location.reload();
            },
            error: function (rep) {},
        });
    });

    //change paymenet
    $(document).on("change", ".ship_payment", function (e) {
        const payment = $(this).val();
        const form_info = $(".form-info");

        const bank = `<div class="form-group bank_code">
                        <label for="exampleInputEmail1">Chọn ngân hàng(nếu muốn)</label>
                        <select name="bank_code" id="bank_code" class="form-control mb-2">
                            <option value="">Không chọn</option>
                            <option value="NCB"> Ngân hàng NCB</option>
                            <option value="AGRIBANK"> Ngân hàng Agribank</option>
                            <option value="SCB"> Ngân hàng SCB</option>
                            <option value="SACOMBANK">Ngân hàng SacomBank</option>
                            <option value="EXIMBANK"> Ngân hàng EximBank</option>
                            <option value="MSBANK"> Ngân hàng MSBANK</option>
                            <option value="NAMABANK"> Ngân hàng NamABank</option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngân hàng Vietinbank</option>
                            <option value="VIETCOMBANK"> Ngân hàng VCB</option>
                            <option value="HDBANK">Ngân hàng HDBank</option>
                            <option value="DONGABANK"> Ngân hàng Dong A</option>
                            <option value="TPBANK"> Ngân hàng TPBank</option>
                            <option value="OJB"> Ngân hàng OceanBank</option>
                            <option value="BIDV"> Ngân hàng BIDV</option>
                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                            <option value="VPBANK"> Ngân hàng VPBank</option>
                            <option value="MBBANK"> Ngân hàng MBBank</option>
                            <option value="ACB"> Ngân hàng ACB</option>
                            <option value="OCB"> Ngân hàng OCB</option>
                            <option value="IVB"> Ngân hàng IVB</option>
                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                        </select>
                     </div>`;

        if (payment == 1) {
            form_info.append(bank);
        } else {
            $(".bank_code").remove();
        }
    });

    $("#keyword").keyup(function () {
        const keyword = $(this).val();

        if (keyword == "") {
            $("#search-live").fadeOut();
            return;
        }

        $.ajax({
            url: `${getBaseUrl()}search-live`,
            method: "POST",
            dataType: "json",
            data: {
                keyword,
            },
            success: function (res) {
                const products = JSON.parse(JSON.stringify(res));

                if (products.length) {
                    let result = `<div class="dropdown-menu dropdown-search">`;

                    products.forEach(function (product, key) {
                        result += `<li class="li_search_live"><a href="#"></a>${product.name}</li>`;
                    });

                    result += `</div>`;

                    $("#search-live").fadeIn();
                    $(".dropdown-search").remove();
                    $("#search-live").append(result);
                }
            },
            error: function (error) {},
        });
    });

    $(document).on("click", ".li_search_live", function () {
        $("#keyword").val($(this).text());
        $("#search-live").fadeOut();
        $("#form-search")[0].submit();
    });

    $(document).on("submit", "#order-form", function (e) {
        e.preventDefault();

        swal(
            {
                title: "Xác nhận đơn hàng",
                text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Mua hàng",
                cancelButtonText: "Không mua",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function (isConfirm) {
                if (isConfirm) {
                    swal.close();
                    $("#order-form")[0].submit();
                } else {
                    swal.close();
                }
            }
        );
    });
});

// window.addEventListener("load", function () {
//   const loginForm = document.querySelector(".login-form");
//   const showPasswordIcon =
//     loginForm && loginForm.querySelector(".show-password");
//   const inputPassword =
//     loginForm && loginForm.querySelector('input[type="password"');
//   showPasswordIcon.addEventListener("click", function () {
//     const inputPasswordType = inputPassword.getAttribute("type");
//     inputPasswordType === "password"
//       ? inputPassword.setAttribute("type", "text")
//       : inputPassword.setAttribute("type", "password");
//   });
// });
