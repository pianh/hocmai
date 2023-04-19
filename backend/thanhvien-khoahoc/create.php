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

    <title>Thêm khóa học cho thành viên</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>

</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row pd-bottom-250">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>
            <?php
                    // Hiển thị tất cả lỗi trong PHP
                    // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                    // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    //1. Mở kết nối
                    include_once __DIR__ . '/../../dbconnect.php';
                    //Chuẩn bị câu lệnh
                    $sqlKhoaHoc = "select * from `khoahoc`";

                    // Thực thi câu truy vấn SQL để lấy về dữ liệu
                    $resultKhoaHoc = mysqli_query($conn, $sqlKhoaHoc);
    
                    // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng

                    $dataKhoaHoc = [];
                    while ($rowKhoaHoc = mysqli_fetch_array($resultKhoaHoc, MYSQLI_ASSOC)) {
                        $dataKhoaHoc[] = array(
                            'kh_makhoahoc' => $rowKhoaHoc['kh_makhoahoc'],
                            'kh_hocphi' => $rowKhoaHoc['kh_hocphi'],
                            'kh_tenkhoahoc' => $rowKhoaHoc['kh_tenkhoahoc'],
                        );
                    }

                       

                    // var_dump($data);die;

                    $sqlThanhVien = "select * from `thanhvien`";

                    // Thực thi câu truy vấn SQL để lấy về dữ liệu
                    $resultThanhVien = mysqli_query($conn, $sqlThanhVien);
    
                    // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng

                    $dataThanhVien = [];
                    while ($rowThanhVien = mysqli_fetch_array($resultThanhVien, MYSQLI_ASSOC)) {
                        $dataThanhVien[] = array(
                            'tv_tendangnhap' => $rowThanhVien['tv_tendangnhap'],
                            'tv_ten' => $rowThanhVien['tv_ten']
                        );
                    }

// var_dump($data);die;
                ?>

            <div class="col-md-10">
                </br>
                <h1>Thêm khóa học cho thành viên</h1>
                <form name="frmCreate" id="frmCreate" method="post" action="">
                    <!-- Tên đăng nhập:
                    <br/>
                    <input type="text" name="tv_tendangnhap" id="tv_tendangnhap" class="form-control"/>
                    <br /> -->

                    <label for="tv_tendangnhap">Thành viên</label>
                    <select class="form-control" id="tv_tendangnhap" name="tv_tendangnhap">
                        <option value="">Vui lòng chọn thành viên cần cấp khóa học</option>
                        <?php foreach ($dataThanhVien as $thanhvien) : ?>
                            <option value="<?= $thanhvien['tv_tendangnhap'] ?>" ><?= 'Tên đăng nhập: ' .$thanhvien['tv_tendangnhap']. ' - ' . 'Họ tên: '. $thanhvien['tv_ten']  ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="kh_makhoahoc">Khóa học</label>
                    <select class="form-control" id="kh_makhoahoc" name="kh_makhoahoc">
                        <option value="">Vui lòng chọn Khóa học</option>
                        <?php foreach ($dataKhoaHoc as $khoahoc) : ?>
                            <option value="<?= $khoahoc['kh_makhoahoc'] ?>" data-kh="<?= $khoahoc['kh_hocphi'] ?>"><?= $khoahoc['kh_tenkhoahoc'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <br />
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
                    $makhoahoc = htmlentities ($_POST['kh_makhoahoc']);
                    $sql = "INSERT INTO thanhvien_khoahoc(tv_tendangnhap, kh_makhoahoc) VALUES ('$tendangnhap','$makhoahoc');";
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