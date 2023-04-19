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
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>

    <title>Xóa đơn thanh toán</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10">
            <h1>Xóa đơn thanh toán</h1>
            <?php
            $maMuonXoa = $_GET['dtt_ma'];
            ?>


            <form name="frmCreate" id="frmCreate" method="post" action="">
                Mã đơn thanh toán (*):
                <br/>
                <input type="number" name="dtt_ma" id="dtt_ma"  class="form-control"
                value="<?= $maMuonXoa ?>"
                readonly/>
                <br />

                <button name="btnSave" id="btnSave" class="btn btn-danger">
                Xóa dữ liệu
                </button>
            </form>

            <?php
            // Khi người dùng bấm lưu thì xử lý
            if(isset($_POST['btnSave'])) {
                //1. Mở kết nối
                include_once __DIR__ . '/../../dbconnect.php';
                //2. chuẩn bị câu lệnh
                $ma = $_POST['dtt_ma'];
                $sql = "DELETE FROM donthanhtoan WHERE dtt_ma = $ma;";
                 // 3. Xóa các dòng con (chi tiết Đơn thanh toan) trước
                 $sqlDeleteChiTietDonThanhToan = "DELETE FROM `khoahoc_donthanhtoan` WHERE dtt_ma=" . $ma;

                 // 4 Thực thi câu lệnh DELETE Chi tiết Đơn thanh toan
                 $resultChiTietDonThanhToan = mysqli_query($conn, $sqlDeleteChiTietDonThanhToan);
 
                 // 4. Xóa dòng Đơn hàng
                 $sqlDeleteDonThanhToan = "DELETE FROM `donthanhtoan` WHERE dtt_ma=" . $ma;
 
                 // 3.1. Thực thi câu lệnh DELETE Chi tiết Đơn hàng
                 $resultDonThanhToan = mysqli_query($conn, $sqlDeleteDonThanhToan);
                //debug
                // var_dump($sql);
                // die;

                //3. Thực thi
                mysqli_query($conn, $sql);

                //4
                echo '<script>location.href = "index.php"; </script>';


            }

            ?>


            </div>
        
        </div>
    </div>

    

    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>
</body>
</html>