@extends('admin.layout')
@section('scripts')
    <script src="/assets/framework/jquery.validate.min.js"></script>
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/framework/ng-file-upload-shim.min.js"></script>
    <script src="/assets/framework/ng-file-upload.min.js"></script>

    <script src="/assets/admin/js/product/product.js"></script>
    <script src="/assets/admin/js/product/EditProduct.js"></script>

    <script>
        var productApp = angular.module("ProductApp", ['ngFileUpload']);
    </script>
    <script src="/assets/admin/FileAngularjs/Product/LoadProcatEdit.js"></script>
    <script src="/assets/admin/FileAngularjs/Product/C_ProcatInProduct.js"></script>
    <script src="/assets/admin/FileAngularjs/Product/CRUD_Color.js"></script>
    <script src="/assets/admin/FileAngularjs/Product/CRUD_Size.js"></script>
@endsection
@section('styles')
    <link href="/assets/admin/css/Product.css" rel="stylesheet" />
@endsection
@section('content')
    <main id="main" class="main" data-idPro="{{ $product->ProId }}" data-idProCat="{{ $product->ProductCat->ProCatId }}" ng-app="ProductApp">
        <h4 class="fw-bold">Sửa sản phẩm</h4>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-4">
                            <form enctype="multipart/form-data" id="formProduct" ng-controller="ProductController">
                                <div class="d-flex mb-3">
                                    <label for="inputText" class=" col-form-label label-create">Tên sản phẩm</label>
                                    <div class=" flex-grow-1">
                                        <input type="text" name="name" value="{{ $product->ProName }}" id="name" class="form-control text-dark" autofocus>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="inputText" class="col-form-label label-create">Chất liệu</label>
                                    <div class="flex-grow-1 ">
                                        <input type="text" id="material" name="material" value="{{ $product->Material }}" class="form-control text-dark">
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="inputText" class="label-create col-form-label">Mô tả</label>
                                    <div class="flex-grow-1">
                                        <input type="text" id="description" name="description" value="{{ $product->Description }}" class="form-control text-dark">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex mb-4 col-6">
                                        <label class="label-create col-form-label">Đối tượng</label>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-content-center select-procat">
                                                <select class="form-select border-0 shadow-none" style="cursor:pointer;outline:none" ng-model="Oject" ng-change="TopMenu(Oject)">
                                                    <option value="Nam">Nam</option>
                                                    <option value="Nữ">Nữ</option>
                                                    <option value="Bé trai">Bé trai</option>
                                                    <option value="Bé gái">Bé gái</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-4 col-6">
                                        <label class="label-create col-form-label">Danh mục</label>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-content-center select-procat">
                                                <select class="form-select border-0 shadow-none" style="cursor:pointer;outline:none" ng-model="CategoryID" ng-change="renderProcat()">
                                                    <option ng-repeat="c in listCategoryByType" value="@{{c.CatID}}">@{{c.Name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-4 col-6">
                                        <label class="label-create col-form-label">Loại sản phẩm</label>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-content-center select-procat position-relative">
                                                <select class="form-select border-0 shadow-none" style="cursor:pointer;outline:none" name="ProCatId" id="ProCatId" ng-model="ProCaId">
                                                    <option ng-repeat="item in listProCatByCat" value="@{{item.ProCatId}}">@{{item.Name}}</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3 col-6">
                                        <label for="inputText" class="label-create col-form-label">Giá nhập</label>
                                        <div class="flex-grow-1">
                                            <input type="number" id="importPrice" name="importPrice" value="{{ $product->ImportPrice }}" class="form-control text-dark">
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3 col-6">
                                        <label for="inputText" class="label-create col-form-label">Giá bán</label>
                                        <div class="flex-grow-1">
                                            <input type="number" id="Price" name="Price" value="{{ $product->Price }}" class="form-control text-dark">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between px-3 py-2 mt-3 align-items-center text-dark font-weight-bold method-header" data-bs-toggle="collapse" href="#method" aria-expanded="false" aria-controls="method">
                                <span>Thuộc tính</span>
                                <span><i class="fa-solid fa-chevron-up"></i></span>
                            </div>
                            <div class="collapse method-content px-4 pt-4 p2-3" id="method">
                                <div class="d-flex align-items-center justify-content-between mb-4" ng-controller="ColorController">
                                    <label for="" class="text-dark mb-0 font-weight-bold">Màu sắc</label>
                                    <div class="flex-grow-1 wrap-color wrap-property d-flex">
                                        @foreach ($product->ProductImages as $item)
                                            <span data-idColor="{{ $item->ProductColor->ProColorID }}" class="method-values">{{ $item->ProductColor->NameColor }}<span class="method-remove"><i class="fa-solid fa-xmark"></i></span></span>
                                        @endforeach

                                        <div class="dropdown method-dropdown__wrap">
                                            <div class="btn dropdown-toggle method-dropdown" style="border: none;border-bottom: 2px solid rgb(202, 202, 202); border-radius: 0px;" id="dropdownColor" data-bs-toggle="dropdown" aria-expanded="false">
                                                <input type="text" ng-model="searchColor" class="border-0" style="outline: none; width: 97%" placeholder="Nhập để tìm kiếm" name="name" value="" />
                                            </div>
                                            <ul class="shadow dropdown-menu" style="flex-wrap: wrap" aria-labelledby="dropdownColor">
                                                <li class="" ng-repeat="item in ColorList | filter : searchColor"><a class="dropdown-item method-dropdown__item-link " ng-click="addValue($event)" data-idColor="@{{item.ProColorID}}"><img class="method-image-color" src="/storage/uploads/ProductColor/@{{ item.ImageColor }}"><p>@{{item.NameColor}}</p><div data-bs-toggle="modal" data-bs-target="#EditColor" ng-click="Edit(item,$index,$event)" class="method-edit"><i class="text-secondary m-auto fa-solid fa-pen"></i></div></a></li>
                                            </ul>
                                        </div>
                                        <div class="my-auto px-1" style="cursor:pointer" ng-click="Add()" data-bs-toggle="modal" data-bs-target="#AddColor"><i class="fa-solid fa-plus"></i></div>

                                    </div>

                                    <!--Thêm color-->
                                    <div class="modal fade" id="AddColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Thêm màu</h5>
                                                    <button type="button" class="btn-close btn-closeModel" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="createColorForm" novalidate>
                                                        <div class="form-horizontal">

                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-4 col-form-label">Màu</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="NameColor" ng-model="proColor.NameColor" required>
                                                                    <span ng-show="createColorForm.$submitted">
                                                                        <span class="error" ng-show="createColorForm.NameColor.$error.required">Bạn cần nhập tên màu</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="inputNumber" class="col-sm-4 col-form-label">Ảnh</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" type="file" onchange="angular.element(this).scope().setFile(this)">
                                                                    <span>
                                                                        <span class="error" ng-show="errorImage">Bạn cần chọn hình ảnh</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary" ng-click="SaveAdd()">Lưu</button>
                                                        </div>
                                                    </form>

                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <!--Sửa color-->
                                    <div class="modal fade" id="EditColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Sửa màu</h5>
                                                    <button type="button" class="btn-close btn-closeModel" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="editColorForm" novalidate>
                                                        <div class="form-horizontal">

                                                            <div class="row mb-3">
                                                                <p for="inputText" class="col-sm-3 col-form-label">Màu</p>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="NameColor" ng-model="proColor.NameColor" required>
                                                                    <span ng-show="editColorForm.$submitted ">
                                                                        <span class="error" ng-show="editColorForm.NameColor.$error.required">Bạn cần nhập tên màu</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <p for="inputNumber" class="col-sm-3 col-form-label">Ảnh</p>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" type="file" onchange="angular.element(this).scope().setFile(this)">
                                                                    <span>
                                                                        <span class="error" ng-show="errorImage">Bạn cần chọn hình ảnh</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary" ng-click="SaveEdit()">Lưu</button>
                                                            <div class="btn btn-primary bg-danger" ng-click="Delete(proColor)">Xóa</div>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wrap-imgItem">
                                    @foreach ($product->ProductImages as $item)
                                    <div class="d-flex justify-content-between mb-4 imgItem" data-idColor="{{ $item->ProColorID }}" data-satus="old">
                                        <div class="wrap-file-box" onclick="fileBoxClick(this)">
                                            <div class="image-upload-wrap">
                                                <input class="input-file__main input-file" type="file" accept="image/*" onchange="uploadImg(this)" />
                                                <div class="drag-text">
                                                    <p>Ảnh {{ $item->ProductColor->NameColor }}</p>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="/storage/uploads/Product/{{ $item->Image }}" alt="No Image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-file-box" onclick="fileBoxClick(this)">
                                            <div class="image-upload-wrap">
                                                <input class="input-file__detail1 input-file" type='file' accept="image/*" onchange="uploadImg(this)" />
                                                <div class="drag-text">
                                                    <p>Ảnh {{ $item->ProductColor->NameColor }}</p>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="/storage/uploads/Product/{{ $item->DetailImage1 }}" alt="No Image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-file-box" onclick="fileBoxClick(this)">
                                            <div class="image-upload-wrap">
                                                <input class="input-file__detail2 input-file" type='file' accept="image/*" onchange="uploadImg(this)" />
                                                <div class="drag-text">
                                                    <p>Ảnh {{ $item->ProductColor->NameColor }}</p>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="/storage/uploads/Product/{{ $item->DetailImage2 }}" alt="No Image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-file-box" onclick="fileBoxClick(this)">
                                            <div class="image-upload-wrap">
                                                <input class="input-file input-file__detail3" type='file' accept="image/*" onchange="uploadImg(this)" />
                                                <div class="drag-text">
                                                    <p>Ảnh {{ $item->ProductColor->NameColor }}</p>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="/storage/uploads/Product/{{ $item->DetailImage3 }}" alt="No Image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-file-box" onclick="fileBoxClick(this)">
                                            <div class="image-upload-wrap">
                                                <input class="input-file input-file__detail4" type='file' accept="image/*" onchange="uploadImg(this)" />
                                                <div class="drag-text">
                                                    <p>Ảnh {{ $item->ProductColor->NameColor }}</p>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="/storage/uploads/Product/{{ $item->DetailImage4 }}" alt="No Image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-file-box" onclick="fileBoxClick(this)">
                                            <div class="image-upload-wrap">
                                                <input class="input-file input-file__detail5" type='file' accept="image/*" onchange="uploadImg(this)" />
                                                <div class="drag-text">
                                                    <p>Ảnh {{ $item->ProductColor->NameColor }}</p>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="/storage/uploads/Product/{{ $item->DetailImage5 }}" alt="No Image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4 mt-5" ng-controller="SizeController">
                                    <label for="" class="text-dark mb-0 font-weight-bold">Kích thước</label>
                                    <div class="flex-grow-1 d-flex wrap-size wrap-property filter-sameValue">
                                        @foreach ($product->ProductVariations as $item)
                                            <span class="method-values filter-value" data-idSize="{{ $item->ProductSize->ProSizeID }}">{{ $item->ProductSize->NameSize }}<span class="method-remove"><i class="fa-solid fa-xmark"></i></span></span>
                                            
                                        @endforeach
                                        <div class="dropdown method-dropdown__wrap">
                                            <div class="btn dropdown-toggle method-dropdown " style="border: none;border-bottom: 2px solid rgb(202, 202, 202);border-radius:0px;" id="dropdownSize" data-bs-toggle="dropdown" aria-expanded="false">
                                                <input type="text" ng-model="searchSize" class="border-0" style="outline:none; width:97%" placeholder="Nhập để tìm kiếm" name="name" value="" />
                                            </div>
                                            <ul class="dropdown-menu shadow" style="flex-wrap: wrap" aria-labelledby="dropdownSize">
                                                <li class="method-dropdown__item" ng-repeat="item in ListSize | filter : searchSize"><a class="dropdown-item method-dropdown__item-link" ng-click="addValue($event)" data-idSize="@{{item.ProSizeID}}" href="#"><p>@{{item.NameSize}}</p><div data-bs-toggle="modal" data-bs-target="#EditSize" ng-click="Edit(item,$index,$event)" class="method-edit"><i class="text-secondary m-auto fa-solid fa-pen"></i></div></a></li>
                                            </ul>
                                        </div>
                                        <div class="my-auto px-1" style="cursor:pointer" ng-click="Add()" data-bs-toggle="modal" data-bs-target="#AddSize"><i class="fa-solid fa-plus"></i></div>
                                    </div>

                                    <!--Thêm Size-->
                                    <div class="modal fade" id="AddSize" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Thêm kích thước</h5>
                                                    <button type="button" class="btn-close btn-closeModel" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="createSizeForm" novalidate>
                                                        <div class="form-horizontal">

                                                            <div class="row mb-3">
                                                                <p for="inputText" class="col-sm-3 col-form-label">Kích thước</p>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="NameSize" ng-model="proSize.NameSize" required>
                                                                    <span ng-show="createSizeForm.$submitted">
                                                                        <span class="error" ng-show="createSizeForm.NameSize.$error.required">Bạn cần nhập tên kích thước</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary" ng-click="SaveAdd()">Lưu</button>
                                                        </div>
                                                    </form>

                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <!--Sửa Size-->
                                    <div class="modal fade" id="EditSize" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Sửa kích thước</h5>
                                                    <button type="button" class="btn-close btn-closeModel" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="editSizeForm" novalidate>
                                                        <div class="form-horizontal">

                                                            <div class="row mb-3">
                                                                <p for="inputText" class="col-sm-3 col-form-label">Kích thước</p>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="NameSize" ng-model="proSize.NameSize" required>
                                                                    <span ng-show="editSizeForm.$submitted || editSizeForm.NameSize.$dirty">
                                                                        <span class="error" ng-show="editSizeForm.NameSize.$error.required">Bạn cần nhập tên kích thước</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <div class="btn btn-primary" ng-click="SaveEdit()">Lưu</div>
                                                            <button type="submit" class="btn btn-primary bg-danger" ng-click="Delete(proSize)">Xóa</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="box-options mt-4 mb-4">
                                <div class=" px-3 py-2  text-dark font-weight-bold options-header">
                                    <span>Danh sách các hàng hóa cùng loại</span>
                                </div>
                                <div class="options-content px-4">
                                    <table class="table table-create table-borderless">
                                        <thead>
                                            <tr class="text-dark ">
                                                <th class="border-top-0 font-weight-heading" style="width:10%">Màu</th>
                                                <th class="border-top-0 font-weight-heading">Kích thước</th>
                                                <th class="border-top-0 font-weight-heading">Tồn kho</th>
                                                <th class="border-top-0 font-weight-heading">Mức cần nhập</th>
                                                <th class="border-top-0 "></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->ProductVariations as $item)
                                                <tr>
                                                    <td>
                                                        <p class="colorOption text-dark" data-idColor="{{ $item->ProColorID }}">{{ $item->ProductColor->NameColor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="sizeOption text-dark" data-idSize="{{ $item->ProSizeID }}">{{ $item->ProductSize->NameSize }}</p>
                                                    </td>
                                                    <td>
                                                        <div class=" d-flex">
                                                            <input type="number" name="Quantity" value="{{ $item->Quantity }}" class="input-create input-quantity text-dark" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-wrap d-flex">
                                                            <input type="number" value="{{ $item->MinimumQuantity }}"  class="input-create input-minimumQuantity text-dark" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0">
                                                        </div>
                                                    </td >
                                                    <td class="text-end"><span class="delete-option"><i class="fa-solid fa-trash-can"></i></span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><div class="text-end mb-4 pe-4"></div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="btn btn-primary me-3 btn-edit" onclick="SaveData()"><i class="fa-solid fa-floppy-disk"></i> Lưu</div>
                                <a class="btn btn-primary me-3" href="{{ route('admin.Product') }}"><i class="bi bi-arrow-return-left"></i>Quay lại</a>
                                <div class="btn-cancel btn bg-danger text-white" onclick="CancelClick()"><i class="fa-solid fa-delete-left"></i> Hủy</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Thêm loại sản phẩm-->
    </main>
@endsection