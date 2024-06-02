   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background:#3A82D2;">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
  <div class="sidebar-brand-icon">
    <i class="fas fa-building"></i>
  </div>
  <div class="sidebar-brand-text mx-3">IE103 <sup>Apacare</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="dashboard.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Trang chủ</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Quản lý chung
</div>

<!-- Nav Item - Pages Collapse Menu -->

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
  <i class="fas fa-fw fa-user-tie"></i>
    <span>Nhân viên</span>
  </a>
  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Quản lý nhân viên</h6>
      <a class="collapse-item" href="nhanvien.php">Nhân viên</a>
      <a class="collapse-item" href="phutrach.php">Phân công phụ trách</a>
    </div>
  </div>
</li>


<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
  <i class="fas fa-fw fa-user-friends"></i>
    <span>Cư dân</span>
  </a>
  <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Quản lý cư dân</h6>
      <a class="collapse-item" href="hocudan.php">Hộ cư dân</a>
      <a class="collapse-item" href="cudan.php">Cư dân</a>
    </div>
  </div>
</li>

<li class="nav-item">
  <a class="nav-link" href="hoadon.php">
  <i class="fas fa-fw fa-file-invoice"></i>
    <span>Hóa đơn</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="dichvu.php">
  <i class="fas fa-fw fa-cogs"></i>
    <span>Dịch vụ</span></a>
</li>


<li class="nav-item">
  <a class="nav-link" href="thietbi.php">
  <i class="fas fa-fw fa-lightbulb"></i>
    <span>Thiết bị</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="phananh.php">
  <i class="fas fa-fw fa-comment-dots"></i>
    <span>Phản ánh</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="thongbao.php">
  <i class="fas fa-fw fa-bullhorn"></i>
    <span>Thông báo</span></a>
</li>


<li class="nav-item">
  <a class="nav-link" href="register.php">
  <i class="fas fa-fw fa-tasks"></i>
    <span>Tài khoản</span></a>
</li>



<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Báo cáo thống kê
</div>

<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
    <i class="fas fa-fw fa-folder"></i>
    <span>Pages</span>
  </a>
  <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Login Screens:</h6>
      <a class="collapse-item" href="login.html">Login</a>
      <a class="collapse-item" href="register.html">Register</a>
      <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
      <div class="collapse-divider"></div>
    </div>
  </div>
</li>-->

<!-- Nav Item - Charts -->
<li class="nav-item">
  <a class="nav-link" href="charts.html">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Thống kê</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
  <a class="nav-link" href="tables.html">
    <i class="fas fa-fw fa-table"></i>
    <span>Báo cáo</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">


<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search 
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm" aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>-->
          
          <!-- Topbar -->
          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <h1 class="h3 mb-0" style="color: #3A82D2; font-weight: bold;">Hệ thống quản lý chung cư</h1>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Cập nhật
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">31 tháng 5 2024</div>
                    <span class="font-weight-bold">Hộ cư dân 01 đã hoàn tất hóa đơn điện nước tháng 05</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">19 tháng 5 2024</div>
                    Cư dân CD0001 đã đăng ký dịch vụ giữ xe 
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">07 tháng 5 2024</div>
                    Thiết bị đã được lắp đặt tại tầng A01
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Xem tất cả</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Phản ánh cư dân
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://cdn.vntrip.vn/cam-nang/wp-content/uploads/2020/10/toi-nam-nay-hon-70-tuoi-1.jpg" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Phòng rác A06 chưa được dọn</div>
                    <div class="small text-gray-500">Trần Nhật Trường · 58 phút trước</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://th.bing.com/th/id/R.ea927f69d6358463ccd60862c318d98c?rik=5QpY1Jy5UbHOtA&pid=ImgRaw&r=0" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Hệ thống thang máy bị quá tải vào giờ cao điểm</div>
                    <div class="small text-gray-500">Hoàng Thanh Sơn · 1 ngày trước</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://xwatch.vn/upload_images/images/2023/05/22/anh-chen-text-2.jpg" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Hệ thống báo cháy bị lỗi</div>
                    <div class="small text-gray-500">Huỳnh Văn Thiệu · 2 ngày trước</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://th.bing.com/th/id/R.99a625040eef9725eae5e69bf6a892c8?rik=nYA%2faF1%2fPQYtMQ&pid=ImgRaw&r=0" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Bảo vệ tòa A có thái độ không đứng đắn, cư xử thô lỗ.....</div>
                    <div class="small text-gray-500">Trịnh Thị Phương Quỳnh · 2 tuần trước</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Xem tất cả</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  
               ADMIN
                  
                </span>
                <img class="img-profile rounded-circle" src="https://th.bing.com/th/id/R.ac1f81a4ed99c86c27da148fa6d636d5?rik=7nKdZSrP%2bq383Q&pid=ImgRaw&r=0">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Đăng xuất
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->


  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Đăng xuất</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Đăng xuất khỏi tài khoản</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>

          <form action="logout.php" method="POST"> 
          
            <button type="submit" name="logout_btn" class="btn btn-primary">Đăng xuất</button>

          </form>


        </div>
      </div>
    </div>
  </div>