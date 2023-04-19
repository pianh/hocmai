
    <!-- <link href="/learnforever.xyz/assets/frontend/css/style.css" type="text/css" rel="stylesheet" /> -->
<div id="header">
  <a href="/learnforever.xyz/index.php" class="logo">
    <img src="/learnforever.xyz/assets/frontend/img/logo.png" alt="logo">
  </a>

  <div  class="navbar navbar-top navbar-expand-lg navbar-dark shadow logo" style="background-color: #fff; ">
    <!-- <a href="/"> -->
      <a href="/learnforever.xyz/index.php" class="logo">
        <img src="/learnforever.xyz/assets/frontend/img/logo.png" alt="logo">
      </a>
    <!-- </a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <form class="form-inline my-2 my-lg-0" action="/learnforever.xyz/frontend/khoahoc/search.php" method="get" style="margin-left: 120px; ">
            <input class="form-control mr-sm-2 search-form" name="noidungsearch" type="search" placeholder="Search" aria-label="Search" style="font-size: 1.6rem;">
            <button class="btn btn-outline-success my-2 my-sm-0 search-btn" name="search-btn" type="submit" style="font-size: 1.6rem;">
              Search</button>
          </form>
        </li>
      </ul>
      

      <ul class="navbar-nav px-3 ml-auto header__navbar-list" >
        <li class="nav-item text-nowrap text-hover header__course-has header__course-arrow">
          <a href="/learnforever.xyz/frontend/danhmuckhoahoc/danhmuc.php" class="nav-link text-dark" style="margin-right: 8px; font-size: 2rem;"><i class="fa-solid fa-chalkboard-user header__navbar-item-link" alt="Khóa học của tôi"></i>
          </a>
          <div class="header__course">
              <a href="/learnforever.xyz/frontend/danhmuckhoahoc/danhmuc.php" class="header__course-link">Xem khóa học của tôi</a>
          </div>
        </li>

        
        <?php
        if (isset($_SESSION['tv_tendangnhap_logged']) && !empty($_SESSION['tv_tendangnhap_logged'])) :
        ?>
          <li class="nav-item text-nowrap text-hover">
            <a class="nav-link text-dark">Chào <?= $_SESSION['tv_tendangnhap_logged']; ?></a>
          </li>
          <li class="nav-item text-nowrap text-hover">
            <a class="nav-link text-dark" href="/learnforever.xyz/frontend/auth/logout.php">Đăng xuất</a>
          </li>
        <?php else : ?>
          <li class="nav-item text-nowrap text-hover">
            <a class="btn btn-primary px-10 btn-auth-login" href="/learnforever.xyz/frontend/auth/login.php">Đăng nhập</a>
            <a class="btn btn-success px-10 btn-auth-register" href="/learnforever.xyz/frontend/auth/register.php">Đăng ký</a>
            
            
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

      <nav id="navbar" class="navbar-bottom" style="z-index: 8;">
      <nav class="navbar navbar-expand-lg navbar-light bg-color">
        <!-- <a class="navbar-brand" href="#">Navbar</a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/learnforever.xyz/index.php">Trang chủ<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/learnforever.xyz/frontend/pages/giaovien.php">Giáo viên</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
              Khóa học
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item dropdown-item-title" href="/learnforever.xyz/index.php#thpt">Đại học</a>
                <a class="dropdown-item dropdown-item-title" href="/learnforever.xyz/index.php#thpt">THPT</a>
                <a class="dropdown-item dropdown-item-title" href="/learnforever.xyz/index.php#thcs">THCS</a>
                <a class="dropdown-item dropdown-item-title" href="/learnforever.xyz/index.php#th">Tiểu học</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item dropdown-item-title" href="#">Đánh giá năng lực</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/learnforever.xyz/frontend/pages/about.php">Liên hệ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled">Điện thoại: 1900 6933</a>
            </li>
          </ul>

        </div>
      </nav>

      </nav>
</div>

