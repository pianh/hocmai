<?php include_once __DIR__ . '/../style.php'?>
<nav class="col-md-2 d-none d-md-block sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <!-- #################### Menu các trang Quản lý #################### -->
      <li class="nav-item sidebar-heading"><span>Quản lý</span></li>
      <li class="nav-item">
        <a href="/learnforever.xyz/backend/pages/dashboard.php">Bảng tin <span class="sr-only">(current)</span></a>
      </li>
      <hr style="border: 1px solid red; width: 80%;" />
      <!-- #################### End Menu các trang Quản lý #################### -->

      <!-- #################### Menu chức năng Danh mục #################### -->
      <li class="nav-item sidebar-heading" style="padding-bottom: 10px; font-size: 1.8rem;">
        <span>Danh mục</span>
      </li>
      
          <!-- Menu Danh mục KHU VỰC QUẢN TRỊ VIÊN -->
      <li class="nav-item" >
        <a href="#qtvSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle btn btn-info">
          KHU VỰC QUẢN TRỊ
        </a>
        <ul class="collapse nav-item__category" id="qtvSubMenu" style="text-decoration: none;">
          <li class="nav-item btn btn-light" style="margin-top: 5px; margin-bottom: 3px;">
            <a href="/learnforever.xyz/backend/thanhvien-khoahoc/index.php" style="text-decoration: none;">Thêm khóa học cho TV</a>
          </li>
          <li class="nav-item btn btn-light ">
            <a href="/learnforever.xyz/backend/thanhvien/index.php" style="text-decoration: none;" >Danh mục Thành viên</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/khoahoc/index.php" style="text-decoration: none;">Danh mục Khóa học</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/nhomkhoahoc/index.php" style="text-decoration: none;">Danh mục Nhóm KH</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/hinhkhoahoc/index.php" style="text-decoration: none;">Danh mục Hình KH</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/videokhoahoc/index.php" style="text-decoration: none;">Danh mục Video KH</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/baigiang/index.php" style="text-decoration: none;">Danh mục Bài giảng</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/hinhthucthanhtoan/index.php" style="text-decoration: none;">Danh mục Hình thức TT</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/khuyenmai/index.php" style="text-decoration: none;">Danh mục Khuyến mãi</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/gopy/index.php" style="text-decoration: none;">Danh mục Góp ý</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/chudegopy/index.php" style="text-decoration: none;">Danh mục Chủ đề GY</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/donthanhtoan/index.php" style="text-decoration: none;">Đơn thanh toán</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/xuatbaocao/thanhvien/index.php" style="text-decoration: none;">Xuất báo cáo TV</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/xuatbaocao/donthanhtoan/index.php" style="text-decoration: none;">Xuất báo cáo ĐTT</a>
          </li>

        </ul>
      </li>
     
        <!-- Menu Danh mục KHU VỰC GIÁO VIÊN -->
      <li class="nav-item" style="margin-top:20px;">
        <a href="#gvSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle btn btn-info">
          KHU VỰC GIÁO VIÊN
        </a>
        <ul class="collapse nav-item__category" id="gvSubMenu" style="text-decoration: none;">
          <li class="nav-item btn btn-light" style="margin-top: 5px; margin-bottom: 3px;">
            <a href="/learnforever.xyz/backend/videokhoahoc/index.php" style="text-decoration: none;">Danh mục Video KH</a>
          </li>
          <li class="nav-item btn btn-light">
            <a href="/learnforever.xyz/backend/baigiang/index.php" style="text-decoration: none;">Danh mục Bài giảng</a>
          </li>
        </ul>
      </li>
     
 

      <!-- #################### End Menu chức năng Danh mục #################### -->
    </ul>
  </div>
</nav>