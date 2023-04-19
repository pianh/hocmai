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
    <title>  LearnForever.xyz</title>

    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../layouts/style.php'); ?>

    <link href="/php/myhand/assets/frontend/css/style.css" type="text/css" rel="stylesheet" />

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
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    <main role="main" class="mb-2" style="padding-bottom: 100px;">
        <!-- Block content -->
        <div class="container mt-2">
            <h1 class="text-center" style="margin-top:30px">Học trực tuyến - Hệ thống giáo dục Hocmai (LearnForever)</h1>
            <div class="row">
                <div class="col col-md-12">
                    <h5 class="text-center">Cung cấp kiến thức hệ thống giáo dục</h5>
                    <h5 class="text-center">Giúp các bạn có niềm tin, hành trang kiến thức vững vàng trên con đường học vấn của mình</h5>
                    <div class="text-center" style="margin-bottom: 30px;">
                        <a href="/learnforever.xyz/index.php" class="btn btn-primary btn-lg">Ghé thăm Học mãi <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col col-md-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.7235485722294!2d105.78061631523369!3d10.039656175103817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a062a768a8090b%3A0x4756d383949cafbb!2zMTMwIFjDtCBWaeG6v3QgTmdo4buHIFTEqW5oLCBBbiBI4buZaSwgTmluaCBLaeG7gXUsIEPhuqduIFRoxqEsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1556697525436!5m2!1svi!2s" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <!-- End block content -->
    </main>

    <!-- footer -->
    <!-- Top footer -->
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



    <?php include_once __DIR__ . '/../../frontend/layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../../frontend/layouts/scripts.php' ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->

</body>

</html>