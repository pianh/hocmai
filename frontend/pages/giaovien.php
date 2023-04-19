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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/style.php'); ?>
    

</head>

<body class=" flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/partials/header.php'); ?>
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
        include_once(__DIR__ . '/../../dbconnect.php');

    
        ?>

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
                                <a href="#" class="category-item__link"><i class="fa fa-graduation-cap category-item-icon" aria-hidden="true"></i> Đại học - Cao đẳng</a>
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



    <div class="row">

        <h1 class="gv-title">ĐỘI NGŨ GIÁO VIÊN TẠI HỌC MÃI</h1>
        <div class="gv_content">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/VanTrinhQuynhAn.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-plum">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Cô Văn Trịnh Quỳnh An</h2>
                                <p class="info__sub-heading">GV MÔN NGỮ VĂN</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Tiến sĩ
                                    <br><i class="icon-black fa-solid fa-phone"></i> 096 456 1306
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.anvtq@hocmai.edu.vn
                                </div>
                                <p class="info__detail">Cô Văn Trịnh Quỳnh An tốt nghiệp Đại học và Thạc sĩ tại trường Đại học Cần Thơ.
                                    <br>Hiện nay cô đang công tác tại Trường THPT Gia Định (TP.HCM) học trò hay gọi cô với cái tên thương mến là cô Ankipedia.
                                    <br>Trong suốt 10 năm theo đuổi nghề giáo của mình, cô đã xuất sắc giành được danh hiệu Nhà giáo trẻ tiêu biểu cấp Quận 2018, danh hiệu Chiến sĩ thi đua cấp cơ sở được ghi nhận trong 3 năm học liên tiếp từ năm 2016 đến năm 2019.
                                </p>

                </div>
            </div>

        </div> 
        
        <div class="gv_content">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/TranVanAnh.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-golden-brown">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Cô Trần Vân Anh</h2>
                                <p class="info__sub-heading">GV MÔN LỊCH SỬ</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Tiến sĩ
                                    <br><i class="icon-black fa-solid fa-phone"></i> 096 454 1206
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.anhtv@hocmai.edu.vn
                                </div>
                                <p class="info__detail">Cô Trần Vân Anh có học vị là một Tiến sĩ Lịch sử, cô gắn bó và có 17 năm kinh nghiệm trong nghề dạy học.
                                    <br>Quan điểm giảng dạy của cô: Người thầy tốt là người biết cách truyền cảm hứng cho học sinh. Với cô học môn Lịch sử phải biết kết nối hiện tại với quá khứ, cô dạy học trò cách tư duy lịch sử để môn học không nhàm chán. Lối dẫn dắt mạch lạc, kiến thức sâu rộng, và phong thái tự tin, bài giảng của cô đem lại niềm tin và cảm hứng học tập trong môn Lịch sử cho học trò.
                                    <br>Chủ biên bộ sách Kiểm tra đánh giá năng lực môn Lịch sử 6,7,8,9 nhà xuất bản Đại học Quốc gia Hà Nội 2018.
                                </p>
                </div>
            </div>

        </div> 

        <div class="gv_content">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/NguyenNgocAnh.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-plum">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Thầy Nguyễn Ngọc Anh</h2>
                                <p class="info__sub-heading">GV MÔN HÓA HỌC</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Cử nhân
                                    <br><i class="icon-black fa-solid fa-phone"></i> 096 454 1106
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.anhnn@hocmai.edu.vn
                                </div>
                                <p class="info__detail">Thầy Ngọc Anh tốt nghiệp trường Đại học Dược Hà Nội, thầy từng làm việc trong các tập đoàn dược phẩm nổi tiếng của Bỉ. Nhưng vì tình yêu và cái duyên đối với nghề giáo mà thầy đã gắn bó với việc dạy học trong hơn 10 năm qua.
                                    <br>Thầy được rất nhiều học sinh biết đến và yêu quý vì sự nhiệt tình và cởi mở trong giao tiếp, thầy luôn sẵn sàng chia sẻ và giúp đỡ khi học sinh cần. Trong công việc thầy là người tỉ mỉ và chỉn chu, bởi theo thầy để một bài giảng đạt hiệu quả và chất lượng thì bản thân giáo viên phải là người có sự chuẩn bị chu toàn và đặt toàn bộ cái tâm của mình vào trong từng bài giảng.
                                    <br>Đạt được 2 Huy chương vàng môn Hoá học trong cuộc thi Olympic Hóa Học do Australia tổ chức.
                                </p>
                </div>
            </div>

        </div> 

        <div class="gv_content">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/DangTuAnh.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-golden-brown">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Cô Đăng Tú Anh</h2>
                                <p class="info__sub-heading">GV MÔN TIẾNG ANH</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Cử nhân
                                    <br><i class="icon-black fa-solid fa-phone"></i> 096 454 1406
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.anhdt@hocmai.edu.vn
                                </div>
                                <p class="info__detail">Cô Trần Vân Anh Tốt nghiệp cử nhân chuyên ngành Giáo dục Tiểu học sư phạm Tiếng Anh của Đại học Sư phạm Hà Nội, từng đạt danh hiệu giáo viên dạy giỏi cấp trường.
                                    <br>Phương pháp giảng dạy diễn dịch, đi từ tổng hợp đến chi tiết, cô luôn chú trọng kĩ năng làm bài để kích thích khả năng tự học của học sinh, cô lồng ghép các trò chơi trong bài giảng để tăng khả năng tiếp thu và sự sáng tạo của học sinh.
                                    <br>Vui vẻ, trẻ trung, năng động, và hiện đại; ở mỗi bài giảng cô cẩn thận và đầu tư, cô luôn khao khát truyền cảm hứng cùng tình yêu ngôn ngữ tiếng anh đến các học trò.
                                </p>
                </div>
            </div>

        </div> 

        <div class="gv_content">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/VuVanCanh.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-plum">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Thầy Vũ Văn Cảnh</h2>
                                <p class="info__sub-heading">GV MÔN TIẾNG ANH</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Thạc sĩ
                                    <br><i class="icon-black fa-solid fa-phone"></i> 096 454 1506
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.canhvv@hocmai.edu.vn
                                </div>
                                <p class="info__detail">Ở thầy Vũ Văn Cảnh, học sinh không chỉ học các kiến thức Tiếng Anh mà còn học tập được sự kiên trì và quyết tâm trong cuộc sống.
                                    <br>Với kinh nghiệm biên soạn và giảng dạy các khóa học TOEIC, IELTS, Aptis, Tiếng Anh giao tiếp tại các tổ chức giáo dục uy tín tại Việt Nam, thầy nắm bắt tâm lý và phương pháp dạy học hiệu quả cho từng học sinh.
                                    <br>Năm 2019 - 2021: Học bổng toàn phần + sinh hoạt phí Chương trình thạc sỹ MBA tại Đại học YuanZe (Đài Loan). Năm 2021 - 2023: Học bổng toàn phần + sinh hoạt phí Chương trình nghiên cứu tại Queensland University of Technology (Úc).
                                </p>
                </div>
            </div>

        </div> 

        <div class="gv_content">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/HuongFiona.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-golden-brown">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Cô Hương Fiona</h2>
                                <p class="info__sub-heading">GV MÔN TIẾNG ANH</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Cử nhân
                                    <br><i class="icon-black fa-solid fa-phone"></i> 098 455 1506
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.huongnt@hocmai.edu.vn
                                </div>
                                <p class="info__detail">cô Hương Fiona rất mong muốn truyền tải những nét đẹp, nét hay của thứ ngôn ngữ toàn cầu này cho các thế hệ học trò. Điều này được thể hiện rõ thông qua quá trình tương tác với các em học sinh.
                                    <br>Với kinh nghiệm nhiều năm giảng dạy và ôn thi đại học môn tiếng anh, cô đưa ra những kiến thức trọng tâm, phù hợp với xu hướng ra đề thi.
                                    <br>Giáo viên uy tín tại Hà Nội với hơn 10 năm kinh nghiệm giảng dạy và luyện thi môn Tiếng Anh. Cô có nhiều học sinh thi đỗ vào các trường đại học nổi tiếng như Đại học Ngoại thương, Luật Hà Nội, Học viên Ngoại giao...
                                </p>
                </div>
            </div>

        </div> 

        <div class="gv_content" style="margin-bottom: 60px;">

            <div class="col-md-5 bg_giaovien_left">
                <div class="avatar">
                    <img src="/learnforever.xyz/assets/frontend/img/giaovien/LeBaTranPhuong.png" alt="" class="avatar-gv">
                </div>
            </div>

            <div class="col-md-7 bg_giaovien_right-plum">
                <div class="info">
                                <h2 id="duyanh" class="info__heading">Thầy Lê Bá Trần Phương</h2>
                                <p class="info__sub-heading">GV MÔN TOÁN</p>
                                <div class="info__description">
                                    <i class="icon-black fa-solid fa-graduation-cap"></i> Tiến sĩ
                                    <br><i class="icon-black fa-solid fa-phone"></i> 096 454 1606
                                    <br><i class="icon-black fa-solid fa-envelope"></i> gv.phuonglb@hocmai.edu.vn
                                </div>
                                <p class="info__detail">Tiến sĩ Lê Bá Trần Phương hiện đang là giảng viên chính Khoa học cơ bản tại trường Đại học Công nghiệp Hà Nội.
                                    <br>Trong hành trình gắn bó với nghề, thầy luôn quan niệm dạy học bằng cả trái tim, luôn nỗ lực học hỏi để trau dồi bản thân,xứng đáng là một người thầy giỏi không chỉ truyền kiến thức mà còn truyền cảm hứng học tập cho học sinh.
                                    <br>Hiện là Trưởng khoa Khoa học Cơ bản - Đại học Công nghiệp Hà Nội, có nhiều công trình khoa học được công bố trên các tạp chí giáo dục.
                                </p>
                </div>
            </div>

        </div> 


    </div>



    
        


        







        
   
    
    




    
    </main>

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




    <!-- footer -->
    <?php include_once __DIR__ . '/../../frontend/layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../../frontend/layouts/scripts.php' ?>
    <?php 
        if( isset ($_GET['search-btn']) ) {
            // echo "xin chao";
            // $noidung = $_GET['noidung-search'];
            // echo $noidung;
            echo '<script>location.href = "/learnforever.xyz/frontend/khoahoc/search.php";</script>';
        }
        
    ?>
    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
    <script>

        
    </script>



</body>

</html>