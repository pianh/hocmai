<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}
require ('../../backend/mail/sendmail.php')
?>

<!DOCTYPE html>
<html>

<head>
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>
    <title>Đăng ký | LearnForever.xyz</title>

    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <?php include_once __DIR__ . '/../layouts/style.php'?>

</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    <!-- end header -->

    <div class="container" >
        <div class="row">

            <main role="main" class="col-md-12 ml-sm-auto px-4 mb-2 distance">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Đăng ký tài khoản tại LearForever.xyz để được hưởng nhiều quyền lợi</h1>
                </div>
                <!-- Block content -->
                <?php
                // Đã đăng nhập rồi -> điều hướng về trang chủ
                if (isset($_SESSION['tv_tendangnhap_logged']) && !empty($_SESSION['tv_tendangnhap_logged'])) :
                ?>
                    <h2>Bạn đã đăng nhập rồi. <a href="/learnforever.xyz/index.php">Bấm vào đây để quay về trang chủ.</a></h2>
                <?php else : ?>

                    <form name="frmdangky" id="frmdangky" method="post" action="/learnforever.xyz/frontend/auth/register.php">
                        <div class="container mt-4">
                            <div class="row justify-content-center">
                                <div class="col-md-7">
                                    <div class="card mx-4">
                                        <div class="card-body p-4">
                                            <h1>Đăng ký</h1>
                                            <p class="text-muted" style="font-size: 1.8rem;">Tạo tài khoản</p>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="text" placeholder="Tên tài khoản" name="tv_tendangnhap" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="password" placeholder="Mật khẩu" name="tv_matkhau" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="text" placeholder="Họ tên" name="tv_ten" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <select name="tv_gioitinh" class="form-control input-register-height">
                                                    <option value="0">Nam</option>
                                                    <option value="1">Nữ</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="text" placeholder="Địa chỉ" name="tv_diachi" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="text" placeholder="Điện thoại" name="tv_dienthoai" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="email" placeholder="Email" name="tv_email" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="text" placeholder="Ngày sinh" name="tv_ngaysinh" />
                                                <input class="form-control input-register-height" type="text" placeholder="Tháng sinh" name="tv_thangsinh" />
                                                <input class="form-control input-register-height" type="text" placeholder="Năm sinh" name="tv_namsinh" />
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend input-register-height">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control input-register-height" type="text" placeholder="CMND" name="tv_cmnd" />
                                            </div>
                                            <button class="btn btn-block btn-success input-register-height btn-register" name="btnDangKy">Tạo tài khoản</button>
                                        </div>
                                        <div class="card-footer p-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <center>Nếu bạn đã có Tài khoản, xin mời Đăng nhập</center>
                                                    <a class="btn btn-primary form-control input-register-height" href="/learnforever.xyz/frontend/auth/login.php">Đăng nhập</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                <?php
                    // Hiển thị tất cả lỗi trong PHP
                    // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                    // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);

                    // Truy vấn database
                    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
                    include_once(__DIR__ . '/../../dbconnect.php');

                    // Chưa đăng nhập -> Xử lý logic/nghiệp vụ kiểm tra Tài khoản và Mật khẩu trong database
                    if (isset($_POST['btnDangKy'])) {
                         // Xử lý đăng ký
                        // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
                        $tv_tendangnhap = htmlentities($_POST['tv_tendangnhap']);
                        $tv_matkhau = sha1($_POST['tv_matkhau']);
                        $tv_ten = htmlentities($_POST['tv_ten']);
                        $tv_gioitinh = htmlentities($_POST['tv_gioitinh']);
                        $tv_diachi = htmlentities($_POST['tv_diachi']);
                        $tv_dienthoai = htmlentities($_POST['tv_dienthoai']);
                        $tv_email = htmlentities($_POST['tv_email']);
                        $tv_ngaysinh = htmlentities($_POST['tv_ngaysinh']);
                        $tv_thangsinh = htmlentities($_POST['tv_thangsinh']);
                        $tv_namsinh = htmlentities($_POST['tv_namsinh']);
                        $tv_cmnd = htmlentities($_POST['tv_cmnd']);
                        $tv_makichhoat = 0;
                        $tv_trangthai = 0; // Mặc định khi đăng ký sẽ chưa kích hoạt tài khoản
                        $tv_quantri = 0; // Mặc định khi đăng ký sẽ không có quyền quản trị
                          // Câu lệnh INSERT
                        $sql = "INSERT INTO thanhvien(tv_tendangnhap, tv_matkhau, tv_ten, tv_gioitinh, tv_diachi, tv_dienthoai, tv_email, tv_ngaysinh, tv_thangsinh, tv_namsinh, tv_cmnd, tv_makichhoat, tv_trangthai, tv_quantri) VALUES ('$tv_tendangnhap', '$tv_matkhau', '$tv_ten', $tv_gioitinh, '$tv_diachi', '$tv_dienthoai', '$tv_email', $tv_ngaysinh, $tv_thangsinh, $tv_namsinh, '$tv_cmnd', '$tv_makichhoat', $tv_trangthai, $tv_quantri)";
 
                        // Thực thi SELECT
                        $result = mysqli_query($conn, $sql);

                        $tieude = "Đăng ký tài khoản LearnForever";
                        $noidung = "<p>Cảm ơn bạn ".$tv_ten." đã đăng ký tài khoản tại LearnForever</p>
                                    Thông tin tài khooản: </br>
                                    <ul>
                                        <li>Tên đăng nhập: ".$tv_tendangnhap."</li>
                                        <li>Mật khẩu:</li>
                                        <li>Email:  ".$tv_email."</li>
                                        <li>Địa chỉ:  ".$tv_diachi."</li>
                                        <li>Số điện thoại:  ".$tv_dienthoai."</li>
                                    </ul>
                                    </br>Chúc bạn học tập thật tốt tại LearnForever, đừng quên rủ bạn bè cùng vào học nhé!.
                            ";
                        $maildangky = $tv_email;
                        $mail = new Mailer;
                        $mail->dangkymail($tieude, $noidung, $maildangky);


                        // Luu Section
                        $_SESSION['tv_tendangnhap_logged'] = $tv_tendangnhap;

                        echo 'Đăng nhập thành công!';
                        // Điều hướng (redirect) về trang chủ
                        echo '<script>location.href = "/learnforever.xyz/index.php";</script>';
                    }
                    else {
                        
                    }
                endif;
                ?>
                <!-- End block content -->
            </main>
        </div>
    </div>

    <!-- footer -->
    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>

</body>

</html>