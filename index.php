<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học trực tuyến - Hệ thống giáo dục Hocmai</title>
    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    
    <?php include_once(__DIR__ . '/frontend/layouts/style.php'); ?>
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "579167705764126");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0FZ6B7XBKG"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-0FZ6B7XBKG');
    </script>


    <style>
        .homepage-slider-img {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }
    </style>
</head>

<body class=" flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/frontend/layouts/partials/header.php'); ?>
    <!-- end header -->

    <main role="main " class="mb-2">
         <!-- Block content -->
         <?php
        // Hiển thị tất cả lỗi trong PHP
        // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
        // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Truy vấn database để lấy danh sách
        // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
        include_once(__DIR__ . '/dbconnect.php');

        // 2. Chuẩn bị câu truy vấn $sql
        $sqlDanhSachKhoaHoc = <<<EOT
        SELECT kh.kh_makhoahoc, kh.kh_tenkhoahoc, kh.kh_hocphi, kh.kh_hocphicu, kh.kh_mota_ngan, nkh.nkh_ten, MAX(hkh.hkh_tentaptin) AS hkh_tentaptin
        FROM `khoahoc` kh
        JOIN `nhomkhoahoc` nkh ON kh.nkh_ma = nkh.nkh_ma
        LEFT JOIN `hinhkhoahoc` hkh ON kh.kh_makhoahoc = hkh.kh_makhoahoc
        GROUP BY kh.kh_makhoahoc, kh.kh_tenkhoahoc, kh.kh_hocphi, kh.kh_hocphicu, kh.kh_mota_ngan, nkh.nkh_ten
EOT;

        // 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
        $result = mysqli_query($conn, $sqlDanhSachKhoaHoc);

        // 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
        // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
        // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
        $dataDanhSachKhoaHoc = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $dataDanhSachKhoaHoc[] = array(
                'kh_makhoahoc' => $row['kh_makhoahoc'],
                'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                'kh_hocphi' => number_format($row['kh_hocphi'], 2, ".", ",") . ' vnđ',
                'kh_hocphicu' => number_format($row['kh_hocphicu'], 2, ".", ",") . ' vnđ',
                'kh_mota_ngan' => $row['kh_mota_ngan'],
                'nkh_ten' => $row['nkh_ten'],
                'hkh_tentaptin' => $row['hkh_tentaptin'],
            );
        }
        // var_dump($dataDanhSachKhoaHoc);
        // die;
        ?>

        <!-- Carousel - Slider -->
        <div class="slider">
            <div class="row">
                <div class="col-md-3.5">
                    <nav class="category">
                        <h3 class="category__heading">
                            <i class="category__heading-icon fa-solid fa-list"></i>
                            Các khóa học
                        </h3>
                        <ul class="category-list">
                            <li class="category-item">
                                <a href="#thpt" class="category-item__link category-item-dh"><i class="fa fa-graduation-cap category-item-icon" aria-hidden="true"></i> Đại học - Cao đẳng</a>
                            </li>
                            <li class="category-item">
                                <a href="#thpt" class="category-item__link"><i class="fa fa-graduation-cap category-item-icon" aria-hidden="true"></i> Lớp 10 - Lớp 11 - Lớp 12</a>
                            </li>
                            <li class="category-item">
                                <a href="#thcs" class="category-item__link"><i class="fa fa-graduation-cap category-item-icon" aria-hidden="true"></i> Lớp 6 - Lớp 7 - Lớp 8 - Lớp 9</a>
                            </li>
                            <li class="category-item">
                                <a href="#thcs" class="category-item__link"><i class="fa fa-graduation-cap category-item-icon" aria-hidden="true"></i> Luyện thi vào lớp 6</a>
                            </li>
                            <li class="category-item">
                                <a href="#th" class="category-item__link"><i class="fa fa-graduation-cap category-item-icon" aria-hidden="true"></i> Lớp 1 - Lớp 2 - Lớp 3 - Lớp 4 - Lớp 5</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-6">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/learnforever.xyz/assets/frontend/img/slider/1.png" class="img-fluid homepage-slider-img" />
                                <div class="container">
                                    <div class="carousel-caption text-left">
                                        <!-- <h1>  - Nơi mua sắm tuyệt vời</h1> -->
            
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/learnforever.xyz/assets/frontend/img/slider/2.png" class="img-fluid homepage-slider-img" />
                                <div class="container">
                                    <div class="carousel-caption">
                                        <!-- <h1>Hàng triệu sản phẩm - Lựa chọn mỏi tay</h1> -->
            
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/learnforever.xyz/assets/frontend/img/slider/3.png" class="img-fluid homepage-slider-img" />
                                <div class="container">
                                    <div class="carousel-caption text-right">
                                        <!-- <h1>Chất lượng là Hàng đầu.</h1> -->
            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                
                </div>
                
                <div class="col-md-2.5">
                    <nav class="category-certification">
                        <img src="/learnforever.xyz/assets/frontend/img/slider/chungnhan.png" alt="chung nhan">
                    </nav>
                </div>

            </div>

        </div>

            <!-- Tính năng Marketing -->
            <div class="container marketing bg-color" style ="margin-top: 20px">
                <!-- Three columns of text below the carousel -->
                <div class="row">
                        <div class="col-lg-4 text-center">
                            <img class="bd-placeholder-img rounded-circle" width="100" height="100" src="/learnforever.xyz/assets/frontend/img/marketing/1.png" />
                            <h4>Tiết kiệm</h4>
                            <p>Mua một lần học mãi mãi</p>
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-4 text-center">
                            <img class="bd-placeholder-img rounded-circle" width="100" height="100" src="/learnforever.xyz/assets/frontend/img/marketing/2.png" />
                            <h4>Thời gian</h4>
                            <p>Học mọi lúc mọi nơi</p>
                        </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4 text-center">
                        <img class="bd-placeholder-img rounded-circle" width="100" height="100" src="/learnforever.xyz/assets/frontend/img/marketing/3.png" />
                        <h4>Chất lượng</h4>
                        <p>Chuyên gia giáo dục hàng đầu cả nước</p>
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div>

       <!-- Info trang -->
       <section class="wrap-statistics">
            <div class="container">
                <div class="row row no-mg">
                        <div class="statistics">
                        <div class="box-year d-flex">
                            <a href="/learnforever.xyz/index.php" target="_blank" class="stretched-link"></a>
                            <div class="box-img">
                                <img src="/learnforever.xyz/assets/frontend/img/ptt.png" alt="">
                            </div>
                            <div class="content-statistics">
                                    <div data-count="15" class="title-statistics syear">15 năm
                                    </div>
                                    <div class="info-statistics"> Giáo dục trực tuyến 
                                    </div>
                            </div>
                        </div>
                            <div class="box-user d-flex">
                                <div class="box-img">
                                    <img src="/learnforever.xyz/assets/frontend/img/member.png" alt="">
                                </div>
                                <div class="content-statistics">
                                    <div class="title-statistics user-counter">6.295
                                    </div>
                                    <div class="info-statistics"> Thành viên
                                    </div>
                                </div>
                            </div>
                            <div class="box-nt d-flex">
                                <div class="box-img">
                                    <img src="/learnforever.xyz/assets/frontend/img/nt.png" alt="">
                                </div>
                                <div class="content-statistics">
                                    <div class="info-statistics">   học trực tuyến
                                    </div>
                                    <div class="title-statistics">Số 1 Việt Nam
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    
         <!-- Danh sách khóa học -->
         <section class="jumbotron text-center bg-color">
            <div class="container">
                <h1 class="jumbotron-heading">Danh sách Khóa học</h1>
                <p class="lead text-muted">Các khóa học với chất lượng, uy tín, hàng đầu cả nước.</p>
            </div>
        </section>


        <section class="wrap-content">
            <div id="thpt" class="main-thpt">
                <div class="container">
                    <div class="row no-mg aos-init aos-animate " data-aos="fade-up">
                        <div class="box-title-thpt">Trung học phổ thông</div>
                    </div>
                    
                    <div class="row thpt-new">
                        <div class="col-md-4">
                            <div class="box-img hover-up">
                                <div class="box-img hover-up">
                                    <a href="#">
                                    <img class="lazy box-effect-img" src="/learnforever.xyz/assets/frontend/img/content/thpt/noti.png" alt="PENT10">
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-8 khoahoc-mt">
                            <!-- Khóa học thpt HOT -->
                        <!-- Giải thuật duyệt và render Danh sách sản phẩm theo dòng, cột của Bootstrap -->
                                <div class=" py-5 ">
                                        <div class="container">
                                            <div class="row row-cols-3 ">
                                           
                                                <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                  
                                                <?php if (($khoahoc['kh_makhoahoc'] =='1' || $khoahoc['kh_makhoahoc'] =='2' || $khoahoc['kh_makhoahoc'] =='3')) : ?>
                                                    <div class="col">
                                                        <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                            <div class="card-header">
                                                                    
                                                                <div class="ribbon-wrapper">
                                                                    <div class="ribbon-wrapper-pd-10"></div> <!-- padding10 -->
                                                                    <div class="home-product-item__hot">
                                                                        <i class="fas fa-check"></i>
                                                                        <span>HOT</span>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="home-product-item__sale-off">
                                                                    <span class="home-product-item__sale-off-percent"> -10%</span>
                                                                    <!-- <span class="home-product-item__sale-off-label">GIẢM</span> -->
                                                                </div>
                                                                
                                                                    <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                    <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>

                                                                        <div class="container-img">
                                                                            <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                                <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                            </a>
                                                                        </div>
                                                                        <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                    <?php else : ?>
                                                                        <div class="container-img">
                                                                            <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                                <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                                                            </a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="card-body">
                                                                    <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                        <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                    </a>
                                                                    <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                    <p class="card-text"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-sm btn-outline-secondary" href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Xem chi tiết</a>
                                                                        </div>
                                                                        <small class="text-muted text-right">
                                                                            <s><?= $khoahoc['kh_hocphicu'] ?></s>
                                                                            <b><?= $khoahoc['kh_hocphi'] ?></b>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
        
                            <!-- End block content -->


                        </div>
                    </div>

                    <div class="row thpt-hot">
                        <div class="col-md-12">
                            <!-- Khóa học thpt Mới -->

                                <div class=" py-5">
                                    <div class="container">
                                        <div class="row row-cols-5">
                                        
                                            <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                
                                            <?php if (($khoahoc['nkh_ten'] =='THPT') && (($khoahoc['kh_makhoahoc'] !=='1') && ($khoahoc['kh_makhoahoc'] !=='2') && ($khoahoc['kh_makhoahoc'] !=='3'))  ) : ?>
                                                <div class="col">
                                                    <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                        <div class="card-header">
                                                            <div class="ribbon-wrapper">
                                                                <div class="ribbon red ribbon-wrapper-pd-10"></div> <!-- padding10 -->
                                                                    <div class="home-product-item__new">
                                                                        <i class="fas fa-check"></i>
                                                                        <span>MỚI</span>
                                                                </div>

                                                                <!-- <div class="ribbon red">MỚI</div> -->
                                                            </div>
                                                            
                                                                <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                        </a>
                                                                    </div>
                                                                    <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                <?php else : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                                                        </a>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="card-body">
                                                                <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                    <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                </a>
                                                                <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                <p class="card-text"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-sm btn-outline-secondary" href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Xem chi tiết</a>
                                                                    </div>
                                                                    <small class="text-muted text-right">
                                                                        <s><?= $khoahoc['kh_hocphicu'] ?></s>
                                                                        <b><?= $khoahoc['kh_hocphi'] ?></b>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>



                        </div>
                    </div>

                </div> 
                

            </div>


        </section>







        <section class="wrap-content">
            <div id="thcs" class="main-thcs">
                <div class="container">
                    <div class="row no-mg aos-init aos-animate " data-aos="fade-up">
                        <div class="box-title-thcs">Trung học cơ sở</div>
                    </div>
                    
                    <div class="row thpt-new">
                        <div class="col-md-4">
                            <div class="box-img hover-up">
                                <div class="box-img hover-up">
                                    <a href="#">
                                    <img class="lazy box-effect-img" src="/learnforever.xyz/assets/frontend/img/content/thcs/noti.png" height="250px" alt="PENT10">
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-8 khoahoc-mt">
                            <!-- Khóa học thcs HOT -->
                        <!-- Giải thuật duyệt và render Danh sách sản phẩm theo dòng, cột của Bootstrap -->
                                <div class=" py-5">
                                        <div class="container">
                                            <div class="row row-cols-3 ">
                                           
                                                <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                  
                                                <?php if ( ($khoahoc['kh_makhoahoc'] =='9' || $khoahoc['kh_makhoahoc'] =='10' || $khoahoc['kh_makhoahoc'] =='11')) : ?>
                                                    <div class="col">
                                                        <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                            <div class="card-header">
                                                                <div class="ribbon-wrapper">
                                                                    <div class="ribbon-wrapper-pd-10"></div> <!-- padding10 -->
                                                                        <div class="home-product-item__hot">
                                                                            <i class="fas fa-check"></i>
                                                                            <span>HOT</span>
                                                                    </div>
                                                                    <!-- <div class="ribbon red">HOT</div> -->
                                                                </div>
                                                                
                                                                    <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                    <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>
                                                                        <div class="container-img">
                                                                            <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                                <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                            </a>
                                                                        </div>
                                                                        <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                    <?php else : ?>
                                                                        <div class="container-img">
                                                                            <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                                <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default.png" />
                                                                            </a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="card-body">
                                                                    <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                        <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                    </a>
                                                                    <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                    <p class="card-text card-mota"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-sm btn-outline-secondary" href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Xem chi tiết</a>
                                                                        </div>
                                                                        <small class="text-muted text-right">
                                                                            <s><?= $khoahoc['kh_hocphicu'] ?></s>
                                                                            <b><?= $khoahoc['kh_hocphi'] ?></b>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
        
                            <!-- End block content -->


                        </div>
                    </div>

                    <div class="row thpt-hot">
                        <div class="col-md-12">
                            <!-- Khóa học thcs Mới -->

                                <div class=" py-5">
                                    <div class="container">
                                        <div class="row row-cols-5">
                                        
                                            <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                
                                            <?php if (($khoahoc['nkh_ten'] =='THCS') && (($khoahoc['kh_makhoahoc'] !=='9') && ($khoahoc['kh_makhoahoc'] !=='10') && ($khoahoc['kh_makhoahoc'] !=='11'))  ) : ?>
                                                <div class="col">
                                                    <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                        <div class="card-header">
                                                            <div class="ribbon-wrapper">
                                                                <div class="ribbon red ribbon-wrapper-pd-10"></div> <!-- padding10 -->
                                                                    <div class="home-product-item__new">
                                                                        <i class="fas fa-check"></i>
                                                                        <span>MỚI</span>
                                                                </div>
                                                                <!-- <div class="ribbon red">MỚI</div> -->
                                                            </div>
                                                            
                                                                <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                        </a>
                                                                    </div>
                                                                    <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                <?php else : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                                                        </a>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="card-body">
                                                                <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                    <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                </a>
                                                                <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                <p class="card-text"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-sm btn-outline-secondary" href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Xem chi tiết</a>
                                                                    </div>
                                                                    <small class="text-muted text-right">
                                                                        <s><?= $khoahoc['kh_hocphicu'] ?></s>
                                                                        <b><?= $khoahoc['kh_hocphi'] ?></b>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>



                        </div>
                    </div>

                </div> 
                

            </div>


        </section>
        
   
    <!-- TIÊU HỌC -->
        <section class="wrap-content">
            <div id="th" class="main-thpt">
                <div class="container">
                    <div class="row no-mg aos-init aos-animate " data-aos="fade-up">
                        <div class="box-title-thpt"> Tiểu học</div>
                    </div>
                    
                    <div class="row thpt-new">
                        <div class="col-md-4">
                            <div class="box-img hover-up">
                                <div class="box-img hover-up">
                                    <a href="#">
                                    <img class="lazy box-effect-img" src="/learnforever.xyz/assets/frontend/img/content/tieuhoc/noti.png" height="250px" alt="PENT10">
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-8 khoahoc-mt">
                            <!-- Khóa học th HOT -->
                        <!-- Giải thuật duyệt và render Danh sách sản phẩm theo dòng, cột của Bootstrap -->
                                <div class=" py-5">
                                        <div class="container">
                                            <div class="row row-cols-3 ">
                                           
                                                <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                  
                                                <?php if (($khoahoc['kh_makhoahoc'] =='17' || $khoahoc['kh_makhoahoc'] =='18' || $khoahoc['kh_makhoahoc'] =='19')) : ?>
                                                    <div class="col">
                                                        <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                            <div class="card-header">
                                                                <div class="ribbon-wrapper">
                                                                    <div class="ribbon-wrapper-pd-10"></div> <!-- padding10 -->
                                                                        <div class="home-product-item__hot">
                                                                            <i class="fas fa-check"></i>
                                                                            <span>HOT</span>
                                                                    </div>

                                                                    <!-- <div class="ribbon red">HOT</div> -->
                                                                </div>
                                                                
                                                                    <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                    <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>
                                                                        <div class="container-img">
                                                                            <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                                <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                            </a>
                                                                        </div>
                                                                        <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                    <?php else : ?>
                                                                        <div class="container-img">
                                                                            <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                                <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                                                            </a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="card-body">
                                                                    <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                        <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                    </a>
                                                                    <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                    <p class="card-text"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-sm btn-outline-secondary" href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Xem chi tiết</a>
                                                                        </div>
                                                                        <small class="text-muted text-right">
                                                                            <s><?= $khoahoc['kh_hocphicu'] ?></s>
                                                                            <b><?= $khoahoc['kh_hocphi'] ?></b>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
        
                            <!-- End block content -->


                        </div>
                    </div>

                    <div class="row thpt-hot mg-bt-80">
                        <div class="col-md-12">
                            <!-- Khóa học th Mới -->

                                <div class=" py-5">
                                    <div class="container">
                                        <div class="row row-cols-5">
                                        
                                            <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                
                                            <?php if (($khoahoc['nkh_ten'] =='TH') && (($khoahoc['kh_makhoahoc'] !=='17') && ($khoahoc['kh_makhoahoc'] !=='18') && ($khoahoc['kh_makhoahoc'] !=='19'))  ) : ?>
                                                <div class="col">
                                                    <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                        <div class="card-header">
                                                            <div class="ribbon-wrapper">
                                                                <div class="ribbon red ribbon-wrapper-pd-10"></div> <!-- padding10 -->
                                                                    <div class="home-product-item__new">
                                                                        <i class="fas fa-check"></i>
                                                                        <span>MỚI</span>
                                                                </div>
                                                                <!-- <div class="ribbon red">MỚI</div> -->
                                                            </div>
                                                            
                                                                <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                        </a>
                                                                    </div>
                                                                    <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                <?php else : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                                                        </a>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="card-body">
                                                                <a href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                    <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                </a>
                                                                <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                <p class="card-text"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-sm btn-outline-secondary" href="/learnforever.xyz/frontend/khoahoc/detail.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Xem chi tiết</a>
                                                                    </div>
                                                                    <small class="text-muted text-right">
                                                                        <s><?= $khoahoc['kh_hocphicu'] ?></s>
                                                                        <b><?= $khoahoc['kh_hocphi'] ?></b>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>



                        </div>
                    </div>

                </div> 
                

            </div>


        </section>
    




    
    </main>

    <!-- TOp bottom -->
    <div class="row footer-top grid__row">
       
            <div class="col-md-2">
                    <h3 class="footer__heading">Chăm sóc khách hàng</h3>
                    <ul class="footer-list">
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Trung tâm trợ giúp</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Hocmai community</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Hướng dẫn đăng ký học</a>
                        </li>
                    </ul>

            </div>
        
            <div class="col-md-2">
                    <h3 class="footer__heading">Giới thiệu</h3>
                    <ul class="footer-list">
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Giới thiệu</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Tuyển dụng</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Điều khoản</a>
                        </li>
                    </ul>

            
            </div> 

            <div class="col-md-2">
                <h3 class="footer__heading">Danh mục</h3>
                    <ul class="footer-list">
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Trung học phổ thông</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Trung học cơ sở</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Tiểu học</a>
                        </li>
                    </ul>
                    </ul>
            </div> 

            <div class="col-md-2">
                    <h3 class="footer__heading">Theo dõi</h3>
                    <ul class="footer-list">
                        <li class="footer-item">
                            <a href="https://www.facebook.com/profile.php?id=100072003702797" class="footer-item__link">
                            <i class="footer-item__icon fa-brands fa-facebook"></i>
                            Facebook
                            </a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">
                                <i class="footer-item__icon fa-brands fa-instagram"></i>
                                Instagram
                            </a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">
                                <i class="footer-item__icon fa-brands fa-linkedin"></i>
                                Linkedin
                            </a>

                        </li>
                    </ul>
            </div> 



            <div class="col-md-2 mg-bt-13">
                <h3 class="footer__heading">Hỗ trợ học tập</h3>
                    <ul class="footer-list">
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Diễn đàn học tập</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Thư viện học liệu</a>
                        </li>
                        <li class="footer-item">
                            <a href="" class="footer-item__link">Thông tin tuyển sinh ĐH</a>
                        </li>
                    </ul>
                    </ul>
            </div> 
            





           
            <div class="col-md-2 ">
                    <h3 class="footer__heading">Học mãi trên ứng dụng</h3>
                    <div class="footer__download">
                        <img src="/learnforever.xyz/assets/frontend/img/qr/qr_code_app.png" alt="Download QR" class="footer__download-qr">
                        <div class="footer__download-apps">
                            <a href="" class="footer__download-apps-link">
                                <img src="/learnforever.xyz/assets/frontend/img/google_play.png" alt="Google Play" class="footer__download-app-img">
                            </a>
                            <a href="" class="footer__download-apps-link">
                                <img src="/learnforever.xyz/assets/frontend/img/app_store.png" alt="App Store" class="footer__download-app-img">
                            </a>

                        </div>
                    </div>
            </div> 
        </div>    


            
    
        
    </div>




    <!-- footer -->
    <?php include_once __DIR__ . '/frontend/layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/frontend/layouts/scripts.php' ?>
    <?php 
        if( isset ($_GET['search-btn']) ) {

            echo '<script>location.href = "/learnforever.xyz/frontend/khoahoc/search.php";</script>';
        }
        
    ?>

<?php
           
           // Khi người dùng bấm lưu thì xử lý
           if(isset($_POST['category-item-dh'])) {
            
               //4. Thông báo

               $message = "Các khóa học vẫn đang được cập nhật, hãy quay lại sớm nhé!";
               echo "<script type='text/javascript'>alert('$message');</script>";


           }

?>


    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
    <script>     
    </script>



</body>

</html>