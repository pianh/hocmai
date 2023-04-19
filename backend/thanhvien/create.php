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
<!-- Chỉ quản trị mới vào được -->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>

    <title>Thêm mới thành viên</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>

</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid ">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10 ">
                </br>
                <h1>Thêm mới thành viên</h1>
                <form name="frmCreate" id="frmCreate" method="post" action="">
                    Tên đăng nhập (*):
                    <br/>
                    <input type="text" name="tv_tendangnhap" id="tv_tendangnhap" class="form-control"/>
                    <br />

                    Tên thành viên:

                    <input type="text" name="tv_ten" id="tv_ten" class="form-control"/>
                    <br/>

                    Mật khẩu:
                    <input type="text" name="tv_matkhau" id="tv_matkhau" class="form-control"/>
                    <br/>


                    <label for="">Giới tính:</label>
                    <select name="tv_gioitinh" id="tv_gioitinh" class="form-control">
                        <option value="">Vui lòng chọn giới tính</option>
                            <option value="0">Nữ</option>
                            <option value="1">Nam</option>
                    </select>
                    </br>


                    <label for="">Trạng thái:</label>
                    <select name="tv_trangthai" id="tv_trangthai" class="form-control">
                        <option value="">Vui lòng chọn trạng thái cho tài khoản</option>
                            <option value="0">Kích hoạt</option>
                            <option value="1">Khóa</option>
                    </select>
                    </br>



                    <label for="">Vai trò:</label>
                    <select name="tv_giaovien" id="tv_giaovien" class="form-control">
                        <option value="">Vui lòng chọn vai trò cho tài khoản</option>
                            <option value="0">Học sinh</option>
                            <option value="1">Giáo viên</option>
                            
                    </select>
                    </br>


                    <button name="btnSave" id="btnSave" class="btn btn-primary">
                    Lưu dữ liệu
                    </button>
                    </br></br>
                </form>
                <?php
                // Hiển thị tất cả lỗi trong PHP
                // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                // Khi người dùng bấm lưu thì xử lý
                if(isset($_POST['btnSave'])) {
                    //1. Mở kết nối đến database
                    include_once __DIR__ . '/../../dbconnect.php';
                    //2. chuẩn bị câu lệnh
                    $tendangnhap = htmlentities ($_POST['tv_tendangnhap']);
                    $ten = htmlentities ($_POST['tv_ten']);
                    $matkhau = htmlentities ($_POST['tv_matkhau']);
                    $gioitinh = htmlentities ($_POST['tv_gioitinh']);
                    $trangthai = htmlentities ($_POST['tv_trangthai']);
                    $giaovien = htmlentities ($_POST['tv_giaovien']);
                    $sql = "INSERT INTO thanhvien(tv_tendangnhap, tv_ten, tv_matkhau, tv_gioitinh, tv_trangthai, tv_giaovien) VALUES ('$tendangnhap', '$ten', '$matkhau',  $gioitinh, $trangthai, $giaovien);";
                    //debug
                    // var_dump($sql);
                    // die;

                    //3. Thực thi
                    mysqli_query($conn, $sql);

                    //4. Điều hướng
                    //Điều hướng bằng JavaScrip
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