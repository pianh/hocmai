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
    <?php include_once(__DIR__ . '/../layouts/style.php'); ?>

    <link href="/learnforever.xyz/assets/frontend/css/style.css" type="text/css" rel="stylesheet" />

    <style>
        .hinhdaidien {
            /* width: 100px; */
            height: 200px;
        }
        .qr_nhantien {
            display: flex;
            justify-content: center;
            margin-top: 55px;
        }
        .donthanhtoan-title {
            text-align: center;
            font-size: 1.9rem;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->
    </br>
    <main role="main" class="mb-2" style="padding-bottom: 350px;">
    <?php
// Hiển thị tất cả lỗi trong PHP
// Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
// Không nên hiển thị lỗi trên môi trường Triển khai (Production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load các thư viện (packages) do Composer quản lý vào chương trình
// require_once __DIR__ . '/../../vendor/autoload.php';


// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}

// Đã người dùng chưa đăng nhập -> hiển thị thông báo yêu cầu người dùng đăng nhập
if (!isset($_SESSION['tv_tendangnhap_logged']) || empty($_SESSION['tv_tendangnhap_logged'])) {
    echo 'Vui lòng Đăng nhập trước khi Thanh toán! <a href="/learnforever.xyz/frontend/auth/login.php">Click vào đây để đến trang Đăng nhập</a>';
    die;
} else {
    // Nếu giỏ hàng trong session rỗng, return
    if (!isset($_SESSION['giohangdata']) || empty($_SESSION['giohangdata'])) {
        echo 'Giỏ hàng rỗng. Vui lòng chọn Sản phẩm trước khi Thanh toán!';
        die;
    }

    // Nếu đã đăng nhập, tạo Đơn hàng
    // Truy vấn database
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__ . '/../../dbconnect.php');

    /* --- 
    --- 2.Truy vấn dữ liệu Khách hàng 
    --- Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
    --- 
    */
    $tv_tendangnhap = $_SESSION['tv_tendangnhap_logged'];
    // var_dump($kh_tendangnhap);die;
    $sqlSelectThanhVien = <<<EOT
        SELECT *
        FROM `thanhvien` tv
        WHERE tv.tv_tendangnhap = '$tv_tendangnhap'
EOT;
    // var_dump($sqlSelectKhachHang);die;

    // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record 
    $resultSelectThanhVien = mysqli_query($conn, $sqlSelectThanhVien);

    // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
    // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
    // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
    $thanhvienRow;
    while ($row = mysqli_fetch_array($resultSelectThanhVien, MYSQLI_ASSOC)) {
        $thanhvienRow = array(
            'tv_tendangnhap' => $row['tv_tendangnhap'],
            'tv_ten' => $row['tv_ten'],
            'tv_email' => $row['tv_email'],
            'tv_diachi' => $row['tv_diachi'],
        );
    }
    /* --- End Truy vấn dữ liệu Khách hàng --- */

    // Thông tin đơn hàng
    $dtt_ngaylap = date('Y-m-d'); // Lấy ngày hiện tại theo định dạng yyyy-mm-dd
    $dtt_trangthai = 0; // Mặc định là 0 chưa thanh toán
    $httt_ma = 1; // Mặc định là 1

    // 2. Thực hiện câu lệnh Tạo mới (INSERT) Đơn hàng
    // Câu lệnh INSERT
    $sqlInsertDonThanhToan = <<<EOT
    INSERT INTO `donthanhtoan` (`dtt_ngaylap`, `dtt_trangthai`, `httt_ma`, `tv_tendangnhap`) 
        VALUES ('$dtt_ngaylap', '$dtt_trangthai', '$httt_ma', '$tv_tendangnhap');
EOT;
    // print_r($sqlInsertDonHang); die;

    // Thực thi INSERT Đơn hàng
    mysqli_query($conn, $sqlInsertDonThanhToan);

    // 3. Lấy ID Đơn hàng mới nhất vừa được thêm vào database
    // Do ID là tự động tăng (PRIMARY KEY và AUTO INCREMENT), nên chúng ta không biết được ID đă tăng đến số bao nhiêu?
    // Cần phải sử dụng biến `$conn->insert_id` để lấy về ID mới nhất
    // Nếu thực thi câu lệnh INSERT thành công thì cần lấy ID mới nhất của Đơn hàng để làm khóa ngoại trong Chi tiết đơn hàng
    $dtt_ma = $conn->insert_id;
    // var_dump($dh_ma);die;

    // Thông tin các dòng chi tiết đơn hàng
    $giohangdata = $_SESSION['giohangdata'];

    // 4. Duyệt vòng lặp qua mảng các dòng Sản phẩm của chi tiết đơn hàng được gởi đến qua request POST
    foreach ($giohangdata as $item) {
        // 4.1. Chuẩn bị dữ liệu cho câu lệnh INSERT vào table `sanpham_dondathang`
        $kh_makhoahoc = $item['kh_makhoahoc'];
        $kh_dtt_dongia = $item['hocphi'];

        // 4.2. Câu lệnh INSERT
        $sqlInsertKhoaHocDonThanhToan = <<<EOT
        INSERT INTO `khoahoc_donthanhtoan` (`kh_makhoahoc`, `dtt_ma`,  `kh_dtt_dongia`) 
            VALUES ($kh_makhoahoc, $dtt_ma,  $kh_dtt_dongia);
EOT;

        // 4.3. Thực thi INSERT
        mysqli_query($conn, $sqlInsertKhoaHocDonThanhToan);
    }


    // 5. Thực thi hoàn tất, điều hướng về trang Danh sách
    // Hủy dữ liệu giỏ hàng trong session
    unset($_SESSION['giohangdata']);
}
?>

    <div class="donthanhtoan">
        <div class="donthanhtoan-title">
            <h2>Đăng ký học thành công</br></h1>
            <a href="/learnforever.xyz/index.php">Bấm vào đây để quay về trang chủ</a>
            <h2></br>Vui lòng thanh toán học phí:
            <?php
            foreach ($giohangdata as $item) {
                 // In ra giá
                echo "   ";
                echo number_format($item['hocphi'], 0, ".", ",") . ' vnđ';
                // echo $item['hocphi'] . ' qua tài khoản Sacombank 070117389403' . '</br>';
            }
            ?>
            <h2>Qua tài khoản Sacombank: 070117389403</h2>
            <h2>Hoặc thanh toán bằng cách quét mã QR MOMO sau!</h2>
        </div>
        <div class="qr_nhantien">
            <img src="/learnforever.xyz/assets/frontend/img/qr/qr_nhantien.jpg" alt="" style="max-height: 400px;">
        </div>


  
    </div>
        <!-- End block content -->
        

    </main>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->
    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->

</body>

</html>