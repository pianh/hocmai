<nav class="navbar navbar-expand-lg navbar-dark  shadow" style="background-color: #446084;">
  <a href="/learnforever.xyz/backend/pages/dashboard.php" class="">
    <img src="/learnforever.xyz/assets/backend/img/logo.png" alt="logo" style="max-height: 50px;">
  </a>
  <!-- <a class="navbar-brand" href="/learnforever.xyz/backend/pages/dashboard.php">Khóa Học</a> -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/learnforever.xyz/backend/pages/dashboard.php">Trang chủ Backend</a>
      </li>
    </ul>

    <ul class="navbar-nav px-3 ml-auto">
      <?php
      // Đã đăng nhập rồi -> hiển thị tên Người dùng và menu Đăng xuất
      if (isset($_SESSION['tv_tendangnhap_logged']) && !empty($_SESSION['tv_tendangnhap_logged'])) :
      ?>
        <li class="nav-item text-nowrap text-hover">
          <a class="nav-link text-white">Chào <?= $_SESSION['tv_tendangnhap_logged']; ?></a>
        </li>
        <li class="nav-item text-nowrap text-hover">
          <a class="nav-link text-white" href="/learnforever.xyz/backend/auth/logout.php">Đăng xuất</a>
        </li>
      <?php else : ?>
        <li class="nav-item text-nowrap text-hover">
          <a class="nav-link text-white" href="/learnforever.xyz/backend/auth/login.php">Đăng nhập</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>