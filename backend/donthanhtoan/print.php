<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
  // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
  session_start();
}
if (!isset($_SESSION['tv_tendangnhap_logged'])){
    echo '<script>location.href = "/learnforever.xyz/backend/auth/login.php";</script>';
} 

$id=$_SESSION['tv_tendangnhap_logged'];
include_once __DIR__ . '/../../dbconnect.php';

$sql = "SELECT * FROM thanhvien WHERE tv_tendangnhap='$id';";

$result = mysqli_query($conn, $sql);

//4. Phân tách thành mảng array
$data = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = array (
        'tv_ten' => $row['tv_ten'],
        'tv_giaovien' => $row['tv_giaovien'],
        'tv_quantri' => $row['tv_quantri']
    );
    $giaovien=$row['tv_giaovien'];
    $quantri=$row['tv_quantri'];
}

if ($id!='admin' && $giaovien != '1' && $quantri != '1') {
    $message = "Bạn không phải là thành viên quản trị website!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo '<script>location.href = "/learnforever.xyz/index.php";</script>';
    }
else if ($id !='admin' && $quantri != 1) {
    $message = "Chỉ quản trị viên mới có quyền này!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo '<script>location.href = "/learnforever.xyz/backend/videokhoahoc/index.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Paper CSS -->
    <link rel="stylesheet" href="/php/myhand/assets/vendor/paper-css/paper.css" type="text/css" />

    <!-- Block title - Đục lỗ trên giao diện bố cục chung, đặt tên là `title` -->
    <title>In các đơn thanh toán</title>
    <!-- End block title -->

    <!-- Định khổ giấy: A5, A4 or A3 -->
    <style>
        @page {
            size: A4
        }
    </style>
</head>

<body class="A4">

    <?php
    // Truy vấn database
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__ . '/../../dbconnect.php');

    /* --- 
    --- 2. Truy vấn dữ liệu Đơn hàng theo khóa chính
    --- 
    */
    // Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
    // Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
    $dtt_ma = $_GET['dtt_ma'];

    // Câu lệnh SQL Query lấy thông tin Đơn hàng WHERE ddh.dh_ma=$dtt_ma
    $sqlSelectDonThanhToan = <<<EOT
    SELECT 
    dtt.dtt_ma,dtt.dtt_ngaylap,dtt.dtt_trangthai, httt.httt_ten, tv.tv_ten, tv.tv_dienthoai
     , SUM(khdtt.kh_dtt_dongia) AS TongThanhTien
 FROM `donthanhtoan` dtt
 JOIN `khoahoc_donthanhtoan` khdtt ON dtt.dtt_ma = khdtt.dtt_ma
 JOIN `thanhvien` tv ON dtt.tv_tendangnhap = tv.tv_tendangnhap
 JOIN `hinhthucthanhtoan` httt ON dtt.httt_ma = httt.httt_ma
 WHERE dtt.dtt_ma=$dtt_ma
 GROUP BY dtt.dtt_ma, dtt.dtt_ngaylap, dtt.dtt_trangthai, httt.httt_ten, tv.tv_ten, tv.tv_dienthoai
EOT;

    // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record
    $sqlSelectDonThanhToan = mysqli_query($conn, $sqlSelectDonThanhToan);
    $dataDonThanhToan;
    while ($row = mysqli_fetch_array($sqlSelectDonThanhToan, MYSQLI_ASSOC)) {
        $dataDonThanhToan = array(
            'dtt_ma' => $row['dtt_ma'],
            'dtt_ngaylap' => date('d/m/Y H:i:s', strtotime($row['dtt_ngaylap'])),
            'dtt_trangthai' => $row['dtt_trangthai'],
            'httt_ten' => $row['httt_ten'],
            'tv_ten' => $row['tv_ten'],
            'tv_dienthoai' => $row['tv_dienthoai'],
            'TongThanhTien' => number_format($row['TongThanhTien'], 2, ".", ",") . ' vnđ',
        );
    }
    /* --- End Truy vấn dữ liệu Đơn hàng --- */

    /* --- 
    --- 3. Truy vấn dữ liệu Chi tiết Đơn hàng theo khóa chính
    --- 
    */
    // Lấy dữ liệu
    $sqlSelectKhoaHoc = <<<EOT
    SELECT 
    kh.kh_makhoahoc, kh.kh_tenkhoahoc, khdtt.kh_dtt_dongia, khdtt.kh_dtt_dongia
    , nkh.nkh_ten
FROM `khoahoc_donthanhtoan` khdtt
JOIN `khoahoc` kh ON khdtt.kh_makhoahoc = kh.kh_makhoahoc
JOIN `nhomkhoahoc` nkh ON kh.nkh_ma = nkh.nkh_ma
WHERE khdtt.dtt_ma=$dtt_ma
EOT;

    // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
    $sqlSelectKhoaHoc = mysqli_query($conn, $sqlSelectKhoaHoc);
    $dataKhoaHoc = [];
    while ($row = mysqli_fetch_array($sqlSelectKhoaHoc, MYSQLI_ASSOC)) {
        $dataKhoaHoc[] = array(
            'kh_makhoahoc' => $row['kh_makhoahoc'],
            'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
            'kh_dtt_dongia' => $row['kh_dtt_dongia'],
            'nkh_ten' => $row['nkh_ten']
        );
    }
    /* --- End Truy vấn dữ liệu Chi tiết khoa hoc --- */

    // 4. Hiệu chỉnh dữ liệu theo cấu trúc để tiện xử lý
    $dataDonThanhToan['danhsachkhoahoc'] = $dataKhoaHoc;
    ?>

    <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
    <section class="sheet padding-10mm">
        <!-- Thông tin Cửa hàng -->
        <table border="0" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <td align="center"><img src="/learnforever.xyz/assets/shared/img/logo.png" width="100px" height="100px" /></td>
                    <td align="center">
                        <b style="font-size: 2em;">Học trực tuyến - Hệ thống giáo dục Hocmai</b><br />
                        <small>Cung cấp kiến thức</small><br />
                        <small>Giúp học viên có niềm tin, hành trang kiến thức vững vàng trên con đường giáo dục</small>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Thông tin đơn hàng -->
        <p><i><u>Thông tin Đơn thanh toán</u></i></p>
        <table border="0" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <td width="30%">Thành viên:</td>
                    <td><b><?= $dataDonThanhToan['tv_ten'] ?>
                            (<?= $dataDonThanhToan['tv_dienthoai'] ?>)</b></td>
                </tr>
                <tr>
                    <td>Ngày lập:</td>
                    <td><b><?= $dataDonThanhToan['dtt_ngaylap'] ?></b></td>
                </tr>
                <tr>
                    <td>Hình thức thanh toán:</td>
                    <td><b><?= $dataDonThanhToan['httt_ten'] ?></b></td>
                </tr>
                <tr>
                    <td>Tổng thành tiền:</td>
                    <td><b><?= $dataDonThanhToan['TongThanhTien'] ?></b></td>
                </tr>
            </tbody>
        </table>

        <!-- Thông tin sản phẩm -->
        <p><i><u>Chi tiết đơn hàng</u></i></p>
        <table border="1" width="100%" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                <?php foreach($dataDonThanhToan['danhsachkhoahoc'] as $khoahoc): ?>
                <tr>
                    <td align="center"><?= $stt; ?></td>
                    <td>
                        <b><?= $khoahoc['kh_tenkhoahoc'] ?></b><br />
                        <small><i><?= $khoahoc['nkh_ten'] ?></i></small><br />
                    </td>
                    <td align="right"><?= $khoahoc['kh_dtt_dongia'] ?></td>
                    <td align="right"><?= $khoahoc['kh_dtt_dongia'] ?></td>
                </tr>
                <?php $stt++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="right"><b>Tổng thành tiền</b></td>
                    <td align="right"><b><?= $dataDonThanhToan['TongThanhTien'] ?></b></td>
                </tr>
            </tfoot>
        </table>

        <!-- Thông tin Footer -->
        <br />
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <small>Xin cám ơn Quý khách đã ủng hộ Học mãi, Chúc Quý khách An Khang, Thịnh Vượng!</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- End block content -->
</body>

</html>