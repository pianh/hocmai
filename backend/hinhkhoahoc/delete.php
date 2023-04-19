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
<?php
// Hiển thị tất cả lỗi trong PHP
// Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
// Không nên hiển thị lỗi trên môi trường Triển khai (Production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Thu thập thông tin Request GET
$hkh_ma = $_GET['hkh_ma'];
//1. Mở kết nối database
include_once __DIR__ . '/../../dbconnect.php';
//2. Câu lệnh sql
$sqlSelectHSP = "
    SELECT *
    FROM hinhkhoahoc
    WHERE hkh_ma = $hkh_ma;
";
//3. Thực thi
$resultSelectHKH = mysqli_query($conn, $sqlSelectHSP);
//4. Phân tách thành mảng array
$rowHinhKhoaHocMuonXoa = mysqli_fetch_array($resultSelectHKH, MYSQLI_ASSOC);
//5. Xóa FILE ẢNH TRÁNH RÁC
$filePath = __DIR__ . '/../../assets/uploads/' .$rowHinhKhoaHocMuonXoa['hkh_tentaptin'];
unlink($filePath);
//6. Chuẩn bị câu lệnh DELETE
$sqlSelectHSP = "
    DELETE FROM hinhkhoahoc
    WHERE hkh_ma= $hkh_ma;
    ";
//7. Thực thi
mysqli_query($conn, $sqlSelectHSP);
//8. Sau khi FILE & xóa dòng dữ liệu DATABASE
//Điều hướng về trang index.php
echo '<script>location.href = "index.php";</script>'

?>