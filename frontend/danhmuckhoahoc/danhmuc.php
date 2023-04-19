<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}

if (!isset($_SESSION['tv_tendangnhap_logged'])){
    echo '<script>location.href = "/learnforever.xyz/index.php";</script>';
} 

$id=$_SESSION['tv_tendangnhap_logged'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học trực tuyến - Hệ thống giáo dục Hocmai</title>
    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <?php include_once(__DIR__ . '/../../frontend/layouts/style.php'); ?>
    


    <style>
        .homepage-slider-img {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/partials/header.php'); ?>
    <!-- end header -->

    <main role="main" class="mb-2">
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
        include_once(__DIR__ . '/../../dbconnect.php');

        // 2. Chuẩn bị câu truy vấn $sql
        $sqlDanhSachKhoaHoc = <<<EOT
        SELECT kh.kh_makhoahoc, kh.kh_tenkhoahoc, kh.kh_hocphi, kh.kh_hocphicu, kh.kh_mota_ngan, nkh.nkh_ten, MAX(hkh.hkh_tentaptin) AS hkh_tentaptin
        FROM `khoahoc` kh
        JOIN `nhomkhoahoc` nkh ON kh.nkh_ma = nkh.nkh_ma
        LEFT JOIN `hinhkhoahoc` hkh ON kh.kh_makhoahoc = hkh.kh_makhoahoc
        JOIN `thanhvien_khoahoc` tvkh ON tvkh.kh_makhoahoc = kh.kh_makhoahoc
        WHERE tv_tendangnhap = '$id'
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


         <!-- Danh sách khóa học -->
         <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Danh sách các khóa học hiện có của bạn</h1>
                <p class="lead text-muted">Chất lượng, uy tín, hàng đầu cả nước.</p>
            </div>
        </section>


        <section class="wrap-content">
            <div id="thpt" class="main-thpt">
                <div class="container">
                    <div class="row no-mg aos-init aos-animate " data-aos="fade-up">
                        <div class="box-title-thpt" style="margin-bottom: 70px; font-size: 2rem;">Học tại LearnForever để phát triển bản thân</div>
                    </div>
                    
                    
                    <div class="row thpt-hot">
                        <div class="col-md-12">
                            <!-- Khóa học thpt Mới -->

                                <div class=" py-5 bg-light">
                                    <div class="container">
                                        <div class="row row-cols-3">
                                        
                                            <?php foreach ($dataDanhSachKhoaHoc as $khoahoc) :  ?>
                                                
                                            
                                                <div class="col">
                                                    <div class="card mb-4 shadow-sm box-effect-item home-product-item">
                                                        <div class="card-header">
                                                            <div class="ribbon-wrapper">
                                                                <!-- <div class="ribbon red">Hocmai</div> -->
                                                            </div>
                                                            
                                                                <!-- Nếu có hình sản phẩm thì hiển thị -->
                                                                <?php if (!empty($khoahoc['hkh_tentaptin'])) : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/xemkhoahoc/xemkhoahoc.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hkh_tentaptin'] ?>" />
                                                                        </a>
                                                                    </div>
                                                                    <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                                                <?php else : ?>
                                                                    <div class="container-img">
                                                                        <a href="/learnforever.xyz/frontend/xemkhoahoc/xemkhoahoc.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                            <img class="bd-placeholder-img card-img-top img-fluid" width="100%" height="350" src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                                                        </a>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="card-body">
                                                                <a href="/learnforever.xyz/frontend/xemkhoahoc/xemkhoahoc.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">
                                                                    <h5><?= $khoahoc['kh_tenkhoahoc'] ?></h5>
                                                                </a>
                                                                <h6><?= $khoahoc['nkh_ten'] ?></h6>
                                                                <p class="card-text"><?= $khoahoc['kh_mota_ngan'] ?></p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-sm btn-outline-primary" style="min-height: 30px; font-size: 1.5rem;" href="/learnforever.xyz/frontend/xemkhoahoc/xemkhoahoc.php?kh_makhoahoc=<?= $khoahoc['kh_makhoahoc'] ?>">Học ngay</a>
                                                                    </div>
                                                                    <small class="text-muted text-right">
                                                                        <!-- <s><?= $khoahoc['kh_hocphicu'] ?></s> -->
                                                                        <!-- <b><?= $khoahoc['kh_hocphi'] ?></b> -->
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                                
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
    <?php include_once __DIR__ . '/../../frontend/layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../../frontend/layouts/scripts.php' ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->


</body>

</html>