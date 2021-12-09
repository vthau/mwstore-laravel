const inputs = document.querySelectorAll(".input");

function addcl() {
  let parent = this.parentNode.parentNode;
  parent.classList.add("focus");
}

function remcl() {
  let parent = this.parentNode.parentNode;
  if (this.value == "") {
    parent.classList.remove("focus");
  }
}

inputs.forEach((input) => {
  input.addEventListener("focus", addcl);
  input.addEventListener("blur", remcl);
});

var inputUser = document.getElementById("input-user");
var inputPass = document.getElementById("input-pass");
var notiUser = document.getElementById("noti-user");
var notiPass = document.getElementById("noti-pass");
var notiAll = document.getElementById("noti-all");
var btnSubmit = document.getElementById("btn-submit");

function checkInput() {
  inputUser.addEventListener("blur", function () {
    if (inputUser.value == "") {
      notiUser.innerHTML = "Bạn chưa nhập email.";
    } else {
      notiUser.remove();
    }
  });

  inputPass.addEventListener("blur", function () {
    if (inputPass.value == "") {
      notiPass.innerHTML = "Bạn chưa nhập mật khẩu.";
    } else {
      notiPass.remove();
    }
  });
}

checkInput();

btnSubmit.addEventListener("click", function (e) {
  if (inputUser.value == "" || inputPass.value == "") {
    e.preventDefault();
    notiAll.innerHTML = "Vui lòng nhập đầy đủ các trương dữ liệu";
  }
});
