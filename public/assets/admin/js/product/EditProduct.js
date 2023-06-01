function SaveData() {

    //lấy dữ liệu của product
    var ProId = $("#main").attr("data-idPro")
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
        ProId: ProId,
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
        url: "/admin/product/update",
        data: formData,
        type: "POST",
        contentType: false,
        processData: false,
        success: function (response) {
            for (var i = 0; i < listColorId.length; i++) {
                UploadImgToServer(listColorId[i], ProId) //upload ảnh mới của product
            }
            $("#successToast .text-toast").text("Cập nhật thông tin thành công")
            $("#successToast").toast("show") //hiển thị thông báo thành công
        },
        error: function(response){
            $("#errorToast .text-toast").text("Cập nhật thông tin thất bại")
            $("#errorToast").toast("show") //hiển thị thông báo thành công
        }
    })
}

$('.file-upload-content').show();
$('.image-upload-wrap').hide();


function UploadImgToServer(idColor, ProId) {
    debugger
    //upload img
    //kiểm tra trình duyệt có hỗ trợ FormData oject không
    if (window.FormData != undefined) {
        //Lấy dữ liệu trên file upload
        //lấy thẻ input theo idcolor
        var imgItem = $(`.imgItem[data-idColor=${idColor}]`)
        var listImgElement = $(imgItem).find(".file-upload-image")

        //Lấy dữ liệu trên file upload
        //lấy thẻ input theo idcolor
        var imgItem = $(`.imgItem[data-idColor=${idColor}]`)
        var fileMain = $(imgItem).find('.input-file__main').get(0).files;
        var fileDetail1 = $(imgItem).find('.input-file__detail1').get(0).files;
        var fileDetail2 = $(imgItem).find('.input-file__detail2').get(0).files;
        var fileDetail3 = $(imgItem).find('.input-file__detail3').get(0).files;
        var fileDetail4 = $(imgItem).find('.input-file__detail4').get(0).files;
        var fileDetail5 = $(imgItem).find('.input-file__detail5').get(0).files;

        var Image = $(listImgElement[0]).attr("data-name") || null
        var DetailImage1 = $(listImgElement[1]).attr("data-name") || null
        var DetailImage2 = $(listImgElement[2]).attr("data-name") || null
        var DetailImage3 = $(listImgElement[3]).attr("data-name") || null
        var DetailImage4 = $(listImgElement[4]).attr("data-name") || null
        var DetailImage5 = $(listImgElement[5]).attr("data-name") || null
        var StatusImage = 0
        if(fileMain.length>0) StatusImage = 1 //add new image
        else if ($(listImgElement[0]).attr("src") === "" && Image!== undefined) StatusImage = 2  //delete oldImage

        var StatusDetailImage1 = 0
        if(fileDetail1.length>0) StatusDetailImage1 = 1 //add new image
        else if ($(listImgElement[1]).attr("src") === "" && DetailImage1!== undefined) StatusDetailImage1 = 2  //delete oldImage

        var StatusDetailImage2 = 0
        if(fileDetail2.length > 0) StatusDetailImage2 = 1 //add new image
        else if ($(listImgElement[2]).attr("src") === "" && DetailImage2!== undefined) StatusDetailImage2 = 2  //delete oldImage

        var StatusDetailImage3 = 0
        if(fileDetail3.length >0) StatusDetailImage3 = 1 //add new image
        else if ($(listImgElement[3]).attr("src") === "" && DetailImage3!== undefined) StatusDetailImage3 = 2  //delete oldImage

        var StatusDetailImage4 = 0
        if(fileDetail4.length >0) StatusDetailImage4 = 1 //add new image
        else if ($(listImgElement[4]).attr("src") === "" && DetailImage4!== undefined) StatusDetailImage4 = 2  //delete oldImage

        var StatusDetailImage5 = 0
        if(fileDetail5.length >0) StatusDetailImage5 = 1 //add new image
        else if ($(listImgElement[5]).attr("src") === "" && DetailImage5!== undefined) StatusDetailImage5 = 2  //delete oldImage
        //Tạo đối trượng formData
        var formData = new FormData();
        //tạo các key,value cho data
        formData.append('_token', csrfToken); // Thêm CSRF token vào formData
        formData.append("ProId",ProId)
        formData.append("ImageFile", fileMain[0])
        formData.append("DetailImage1File", fileDetail1[0])
        formData.append("DetailImage2File", fileDetail2[0])
        formData.append("DetailImage3File", fileDetail3[0])
        formData.append("DetailImage4File", fileDetail4[0])
        formData.append("DetailImage5File", fileDetail5[0])

        formData.append("Image", Image)
        formData.append("DetailImage1", DetailImage1)
        formData.append("DetailImage2", DetailImage2)
        formData.append("DetailImage3", DetailImage3)
        formData.append("DetailImage4", DetailImage4)
        formData.append("DetailImage5", DetailImage5)

        formData.append("StatusImage", StatusImage)
        formData.append("StatusDetailImage1", StatusDetailImage1)
        formData.append("StatusDetailImage2", StatusDetailImage2)
        formData.append("StatusDetailImage3", StatusDetailImage3)
        formData.append("StatusDetailImage4", StatusDetailImage4)
        formData.append("StatusDetailImage5", StatusDetailImage5)
        formData.append("ProColorID", idColor)

        if($(imgItem).attr("data-satus") == "old"){
            $.ajax({
                async: true,
                type: 'POST',
                url: "/admin/product/uploadUpdateProImg",
                contentType: false,
                processData: false,
                data: formData,
                success: function (urlImage) {
                },
                error: function (err) {
                    alert('có lỗi khi upload: ' + err.statusText);
                }
            })
        }
        else{
            $.ajax({
                async: true,
                type: 'POST',
                url: "/admin/product/uploadProImg",
                contentType: false,
                processData: false,
                data: formData,
                success: function (urlImage) {
                },
                error: function (err) {
                    alert('có lỗi khi upload: ' + err.statusText);
                }
            })
        }
    }
}

/**loại các size bị trung trên giao diện*/
/**cách dùng : đưa class filter-sameValue và thẻ bọc các size và class filter-value vào các thẻ có data-idSize*/
var parentSizes = $(".filter-sameValue") //danh sách các element chứa các size
parentSizes.each((index, wrapSize) => {
    let listSize = $(wrapSize).find(".filter-value") //danh sách size
    let newList = [] //chứa list idSize đã được filter
    listSize.each((index1, sizeElement) => {
        let idSize = $(sizeElement).attr("data-idSize")

        //nếu idSize chưa tồn tại trong newList
        if (newList.indexOf(idSize) == -1) {
            newList.push(idSize)
        }
        else {
            $(sizeElement).remove() //xóa phần element nếu đã tồn tại
        }
    })
}) 