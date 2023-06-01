
function SaveData() {
    //lấy dữ liệu của product
    var proName = $("#name").val()
    var material = $("#material").val()
    var description = $("#description").val()
    var proCatId = $("#ProCatId").val()
    var importPrice = $("#importPrice").val()
    var price = $("#Price").val()
    //danh sách biến thể
    var listVariation = []
    var variationWrap = $(".table-create tbody tr")

    variationWrap.each((index, value) => {
        let colorId = $($(value).find(".colorOption")).attr("data-idColor")
        let variation = {
            ProId: null,
            ProColorID: colorId,
            ProSizeID: $($(value).find(".sizeOption")).attr("data-idSize"),
            Quantity: $($(value).find(".input-create")).val(),
            MinimumQuantity: $($(value).find(".input-minimumQuantity")).val()
        }
        listVariation.push(variation)
    })

    //Lấy list Color
    var listColorId = []
    let listSpanColor = $(".wrap-color").children("span")
    listSpanColor.each((index, value) => {
        listColorId.push($(value).attr("data-idColor"))
    })
    
    var product = {
        ProName: proName,
        Material: material,
        Description: description,
        ProCatId: proCatId,
        ImportPrice: importPrice,
        Price: price,
        listVariation : listVariation
    }

    var formData = new FormData();
    formData.append('_token', csrfToken); // Thêm CSRF token vào formData
    formData.append('product',JSON.stringify(product))

    //thêm sản phẩm và danh sách biến thể bằng ajax và lấy về idproduct mới
    $.ajax({
        url: "/admin/product/create",
        data: formData,
        type: "POST",
        contentType: false,
        processData: false,
        success: function (response) {
            for(let i=0;i<listColorId.length;i++){
                UploadImgToServer(listColorId[i],response.ProId)
            }
            $("#successToast .text-toast").text("Đã thêm sản phẩm thành công")
            $("#successToast").toast("show") //hiển thị thông báo thành công
        }
    })
}

function UploadImgToServer(idColor,proId) {
    //upload img
    //kiểm tra trình duyệt có hỗ trợ FormData oject không
    if (window.FormData != undefined) {
        //Lấy dữ liệu trên file upload
        //lấy thẻ input theo idcolor
        var imgItem = $(`.imgItem[data-idColor=${idColor}]`)
        var fileMain = $(imgItem).find('.input-file__main').get(0).files;
        var fileDetail1 = $(imgItem).find('.input-file__detail1').get(0).files;
        var fileDetail2 = $(imgItem).find('.input-file__detail2').get(0).files;
        var fileDetail3 = $(imgItem).find('.input-file__detail3').get(0).files;
        var fileDetail4 = $(imgItem).find('.input-file__detail4').get(0).files;
        var fileDetail5 = $(imgItem).find('.input-file__detail5').get(0).files;
        //Tạo đối trượng formData
        var formData = new FormData();
        formData.append('_token', csrfToken); // Thêm CSRF token vào formData
        //tạo các key,value cho data
        formData.append("ProId",proId)
        formData.append("ImageFile", fileMain[0])
        formData.append("DetailImage1File", fileDetail1[0])
        formData.append("DetailImage2File", fileDetail2[0])
        formData.append("DetailImage3File", fileDetail3[0])
        formData.append("DetailImage4File", fileDetail4[0])
        formData.append("DetailImage5File", fileDetail5[0])
        formData.append("ProColorID", idColor)
        $.ajax({
            async: true,
            type: 'POST',
            url: "/admin/product/uploadProImg",
            contentType: false, //Không có header
            processData: false, //không xử lý dữ liệu
            data: formData,
            success: function (urlImage) {
            },
            error: function (err) {
                alert('có lỗi khi upload: ' + err.statusText);
            }
        })
    }
}

$(".btn-create").click((e) => {

    var variationWrap = $(".table-create tbody tr")
    //kiểm tra xem đã thêm variation chưa
    if (variationWrap.length > 0) {
        if ($('#formProduct').valid()) {
            SaveData()
        }
    }
    else {
        $("#errorToast .text-toast").text("Bạn chưa thêm biến thể nào")
        $("#errorToast").toast("show")
    }
})