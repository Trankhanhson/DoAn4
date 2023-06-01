<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed"
               data-bs-target="#product-nav"
               data-bs-toggle="collapse"
               href="#">
                <i class="bi bi-menu-button-wide"></i><span>Hàng hóa</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="product-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.Category') }}">
                        <i class="bi bi-circle"></i><span>Danh mục sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ProductCat') }}">
                        <i class="bi bi-circle"></i><span>Loại sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.Product') }}">
                        <i class="bi bi-circle"></i><span>Sản phẩm</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed"
               data-bs-target="#sell-nav"
               data-bs-toggle="collapse"
               href="#">
                <i class="bi bi-journal-text"></i><span>Đơn hàng</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="sell-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.WaitProcess') }}">
                        <i class="bi bi-circle"></i><span>Chờ xử lý</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.Tranfering') }}">
                        <i class="bi bi-circle"></i><span>Đang vận chuyển</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.Success') }}">
                        <i class="bi bi-circle"></i><span>Thành công</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.Canceled') }}">
                        <i class="bi bi-circle"></i><span>Đã hủy</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.Customer') }}">
                <i class="bi bi-person"></i><span>Khách hàng</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.Discount') }}">
                <i class="bi bi-journal-text"></i><span>Khuyến mại</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.ImportBill') }}">
                <i class="bi bi-journal-text"></i><span>Nhập hàng</span>
            </a>
        </li>
        <!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('users.index') }}">
                <i class="bi bi-person"></i><span>Nhân viên</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('roles.index') }}">
                <i class="bi bi-person"></i><span>Chức vụ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.feedback') }}">
                <i class="bi bi-grid"></i><span>Feedback</span>
            </a>
        </li>
        <!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.Post') }}">
                <i class="bi bi-layout-text-window-reverse"></i><span>Bài viết</span>
            </a>
        </li>
        <!-- End Charts Nav -->

        {{-- <li class="nav-item">
            <a class="nav-link collapsed"
               data-bs-target="#section-nav"
               data-bs-toggle="collapse"
               href="#">
                <i class="bi bi-journal-text"></i><span>Hiển thị</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="section-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/Admin/Slide/Index">
                        <i class="bi bi-circle"></i><span>Banner</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/Section/Index">
                        <i class="bi bi-circle"></i><span>Cấu hình trang</span>
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed"
               data-bs-target="#report-nav"
               data-bs-toggle="collapse"
               href="#">
                <i class="bi bi-bar-chart"></i><span>Báo cáo</span>
            </a>
            <ul id="report-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/admin/report">
                        <i class="bi bi-circle"></i><span>Doanh thu lợi nhuận</span>
                    </a>
                    
                </li>
                <li>
                    <a href="{{ route('admin.ReportProduct') }}">
                        <i class="bi bi-circle"></i><span>Thống kê sản phẩm</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Icons Nav -->
    </ul>
</aside>