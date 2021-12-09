$(document).ready(function () {
    //validate fomrm
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
    const form_signup = $("#form-signup");
    function emailIsValid(email) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            email
        );
    }

    $.validator.addMethod(
        "regEmail",
        function (value, element) {
            return emailIsValid(value);
        },
        "Đại chỉ email không hợp lệ"
    );

    $.validator.addMethod(
        "regPhone",
        function (value, element) {
            return /((09|03|07|08|05)+([0-9]{8})\b)/.test(value);
        },
        "Số điện thoại không hợp lệ"
    );

    form_signup.validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                regEmail: true,
            },
            phone: {
                required: true,
                regPhone: true,
            },
            code: {
                required: true,
                number: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password",
            },
        },

        messages: {
            name: {
                required: "Vui lòng nhập tên",
                minlength: "Tên phải từ 2 ký tự trở lên",
            },
            email: {
                required: "Vui lòng nhập địa chỉ email",
            },
            phone: {
                required: "Vui lòng nhập số điện thoại",
            },
            code: {
                required: "Vui lòng nhập mã xác thực",
                number: "Mã xác thực không hợp lệ",
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải từ 8 ký tự trở lên",
            },
            password_confirmation: {
                required: "Vui lòng nhập lại mật khẩu",
                minlength: "Mật khẩu phải từ 8 ký tự trở lên",
                equalTo: "Mật khẩu không khớp",
            },
        },

        // submitHandler: function (form) {
        //     // form.submit();
        // },
    });

    const input_code = $(".input-code");
    const field_code = $(".field-code");
    const get_code = $(".btn-get-code");

    //handel sumit form
    function render() {
        if (window.recaptchaVerifier) {
            window.recaptchaVerifier.clear();
        }

        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
            "recaptcha-container"
        );
    }

    function phoneAuth(phoneNumber) {
        render();
        firebase
            .auth()
            .signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
            .then(function (confirmationResult) {
                //s is in lowercase
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                toastr["success"](
                    "Đã gửi mã xác thực vào số điện thoại của bạn",
                    "Thành công!!!"
                );
                $(".field-phone").append(
                    `<label class="error error-phone">Gửi mã xác thực thành công.</label>`
                );
                get_code.text("Gửi lại");
                input_code.focus();
            })
            .catch(function (error) {
                console.log(error.message);
            });
    }

    $(".field-email").click(function () {
        $(".error-email").remove();
    });
    $(".field-phone").click(function () {
        $(".error-phone").remove();
    });
    field_code.click(function () {
        $(".error-code").remove();
    });
    $(".input-phone").click(function () {
        $("#phone-error").remove();
    });

    get_code.click(function () {
        let phone = $(".input-phone").val();
        if (phone == "") {
            $("#phone-error").remove();
            $(".field-phone").append(
                `<label id="phone-error" class="error">Vui lòng nhập số điện thoại</label>`
            );
            return;
        }
        get_code.text("Đang gửi...");
        phone = "+84" + phone;
        phoneAuth(phone);
    });

    $(document).on("submit", "#form-signup", function (e) {
        e.preventDefault();

        const code = input_code.val().trim();

        try {
            coderesult
                .confirm(code)
                .then(function (result) {
                    form_signup[0].submit();
                })
                .catch(function (error) {
                    field_code.append(
                        `<label class="error error-code">Mã xác thực không đúng, vui lòng lấy lại mã thử lại</label>`
                    );
                    toastr["error"](
                        "Mã xác nhận không đúng, vui lòng thử lại.",
                        "Thất bại!!!"
                    );
                });
        } catch (error) {
            field_code.append(
                `<label class="error error-code">Mã xác thực không đúng, vui lòng lấy lại mã thử lại</label>`
            );
        }

        // if (code == "26086229") {
        //     form_signup[0].submit();
        // } else {
        //     field_code.append(
        //         `<label class="error error-code">Mã xác thực không đúng, vui lòng lấy lại mã thử lại</label>`
        //     );
        // }
    });
});
