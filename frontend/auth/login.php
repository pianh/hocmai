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
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>
    <title>Đăng nhập Backend | LearnForever.xyz</title>

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
                    <h1 class="h2">Đăng nhập LearForever.xyz</h1>
                </div>
                <!-- Block content -->
                <?php
                // Đã đăng nhập rồi -> điều hướng về trang chủ
                if (isset($_SESSION['tv_tendangnhap_logged']) && !empty($_SESSION['tv_tendangnhap_logged'])) :
                ?>
                    <h2>Bạn đã đăng nhập rồi. <a href="/learnforever.xyz/index.php">Bấm vào đây để quay về trang chủ.</a></h2>
                <?php else : ?>

                    <form name="frmLogin" id="frmLogin" class="login-height" method="post" action="">
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                                <div class="card-group">
                                    <div class="card p-4">
                                        <div class="card-body">
                                            <h1>Đăng nhập</h1>
                                            <p class="text-muted">Nhập thông tin Tài khoản</p>
                                            <div class="form-group">
                                                <div class="input-group  input-height ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                    <input class="form-control  input-height text-form-login" type="text" name="tv_tendangnhap" placeholder="Tên đăng nhập">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-height">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-lock"></i>
                                                        </span>
                                                    </div>
                                                    <input class="form-control input-height text-form-login" type="password" name="tv_matkhau" placeholder="Mật khẩu">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button class="btn btn-primary px-10 btn-login-form text-form-login-btn" name="btnLogin">
                                                    <i class="fa fa-arrow-circle-right" aria-hidden="true" style= "color: yellow; font-size: 15px;"></i> Đăng nhập</button>
                                                </div>
                                                <div class="col-6 text-right input-group.input-height">
                                                    <a class="btn btn-link px-0 text-form-login" href="forgot-password.php" style="margin-top: 20px;">Quên mật khẩu?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                                        <div class="card-body text-center" >
                                            <div>
                                                <h2>Đăng ký</h2>
                                                <p class="register-title-detail">Đăng ký để làm thành viên viên của Trang khóa học. Bạn sẽ được một số quyền lợi nhất
                                                    định khi làm thành viên viên của Chúng tôi.</p>
                                                <a class="btn btn-success  mt-3 btn-register btn-login-form text-form-login-btn" href="register.php">Đăng
                                                    ký ngay!</a>
                                                    <!-- e7e34  active -->
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
                    if (isset($_POST['btnLogin'])) {
                        // Phân tách thông tin từ người dùng gởi đến qua Request POST
                        $tv_tendangnhap = addslashes($_POST['tv_tendangnhap']);
                        $tv_matkhau = addslashes($_POST['tv_matkhau']);

                        // Câu lệnh SELECT Kiểm tra đăng nhập...
                        $sqlSelect = <<<EOT
                        SELECT *
                        FROM thanhvien tv
                        WHERE tv.tv_tendangnhap = '$tv_tendangnhap' AND tv.tv_matkhau = '$tv_matkhau';
EOT;
                        // Thực thi SELECT
                        $result = mysqli_query($conn, $sqlSelect);

                        // Sử dụng hàm `mysqli_num_rows()` để đếm số dòng SELECT được
                        // Nếu có bất kỳ dòng dữ liệu nào SELECT được <-> Người dùng có tồn tại và đã đúng thông tin USERNAME, PASSWORD
                        if (mysqli_num_rows($result) > 0) {

                            // Lưu thông tin Tên tài khoản user đã đăng nhập
                            $_SESSION['tv_tendangnhap_logged'] = $tv_tendangnhap;

                            echo 'Đăng nhập thành công!';
                            // Điều hướng (redirect) về trang chủ
                            echo '<script>location.href = "/learnforever.xyz/index.php";</script>';
                        } else {
                            echo '<h2 style="color: red;">Đăng nhập thất bại!</h2>';
                        }
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