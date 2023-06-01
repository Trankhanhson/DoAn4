//Register
function addError(id, textError) {
    //thay đổi thuộc tính của thẻ input
    const element = $(`#${id}`) //element input
    $(element).removeClass("valid")
    $(element).addClass("error")
    $(element).attr("aria-invalid", true)

    //thay đổi thẻ label error
    const erorrLabel = $(`#${id}-error`)
    $(erorrLabel).css("display", "inline-block")
    $(erorrLabel).text(textError)
} 

$.validator.addMethod('isEmail', function (value) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(value);
}, "Email không hợp lệ")

$.validator.addMethod('PhoneVN', function (value) {
    return /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/.test(value);
}, "Số điện thoại không hợp lệ")

$.validator.addMethod('letterOnly', function (value) {
    return /^[a-zA-Z0-9]*$/.test(value);
}, "Mật khẩu không được có dấu hoặc kí tự đặc biệt")

$(".account-setting-form").validate({
    rules: {
        name: {
            required: true
        },
        address: {
            required: true,
            maxlength: 100
        },
        phone: {
            required: true,
            PhoneVN: true
        }
    },
    messages: {
        name: {
            required: "Họ tên không được để trống",
        },
        address: {
            required: "Địa chỉ khổng được để trống",
            maxlength: "Địa chỉ khống quá 100 ký tự"
        },
        phone: {
            required: "Bạn cần nhập số điện thoại"
        }
    }
})

function UpdateInfo() {
    if ($(".account-setting-form").valid()) {
        const CusID = $(".account-setting-form").attr("data-idcustomer")
        const Name = $("#name").val()
        const Address = $("#address").val()
        const Phone = $("#phone").val().trim()

        var formData = new FormData();
        formData.append('_token', csrfToken); // Thêm CSRF token vào formData
        formData.append('CusID', CusID); // Thêm CSRF token vào formData
        formData.append('Name', Name); // Thêm CSRF token vào formData
        formData.append('Address', Address); // Thêm CSRF token vào formData
        formData.append('Phone', Phone); // Thêm CSRF token vào formData
        debugger
        $.ajax({
            url: "/client/infoaccount/updateInfoCustomer",
            type: "Post",
            contentType: false, //Không có header
            processData: false, //không xử lý dữ liệu
            data: formData,
            success: function (res) {
                if (res.message == "ExistPhone") {
                    addError("phone", "Số điện thoại này đã tồn tại")
                    $("#errorToast .text-toast").text("Số điện thoại này đã tồn tại")
                    $("#errorToast").toast("show")
                }
                else {
                    if (res.message == "success") {
                        location.reload()
                        $("#successToast .text-toast").text("Cập nhật thành công")
                        $("#successToast").toast("show")
                    }
                    else {
                        $("#errorToast .text-toast").text("Cập nhật thất bại")
                        $("#errorToast").toast("show")
                    }
                }
            }
        })
    }
}