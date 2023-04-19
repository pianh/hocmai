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

    <title>Thêm mới khóa học</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>

</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row">
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
                    $sqlSelectNhomKhoahoc = "
                        SELECT *
                        FROM nhomkhoahoc;
                    ";
                    //Thực thi
                    $resultNhomKhoahoc = mysqli_query($conn, $sqlSelectNhomKhoahoc);
                    //Phan tách thành mảng array PHP
                    $dataNhomKhoaHoc = [];
                    while ($rowNhomKhoaHoc = mysqli_fetch_array($resultNhomKhoahoc, MYSQLI_ASSOC)) {
                        $dataNhomKhoaHoc[] = array(
                            'nkh_ma' => $rowNhomKhoaHoc['nkh_ma'],
                            'nkh_ten' => $rowNhomKhoaHoc['nkh_ten'],
                        );
                    }
  
                    // var_dump($data);die;
                ?>


            <div class="col-md-10">
                </br>
                <h1>Thêm mới khóa học</h1>
                <form name="frmCreate" id="frmCreate" method="post" action="">
                    Tên khóa học (*):
                    <br/>
                    <input type="text" name="kh_tenkhoahoc" id="kh_tenkhoahoc" class="form-control"/>
                    <br />

                    <label for="">Nhóm khóa học:</label>
                    <select name="nkh_ma" id="nkh_ma" class="form-control">
                        <option value="">Vui lòng chọn nhóm khóa học</option>
                        <?php foreach($dataNhomKhoaHoc as $nkh): ?>
                            <option value="<?= $nkh['nkh_ma'] ?>"><?= $nkh['nkh_ten'] ?></option>
                            <!-- <option value=""><?= $nkh['nkh_tomtat'] ?></option> -->
                        <?php endforeach; ?>

                    </select>

                    </br>
                    Học phí:
                    <input type="text" name="kh_hocphi" id="kh_hocphi" class="form-control"></input>
                    <br/>

                    Mô tả ngắn:
                    <textarea name="kh_mota_ngan" id="kh_mota_ngan" class="form-control"></textarea>
                    <br/>

                    Mô tả chi tiết:
                    <textarea name="kh_mota_chitiet" id="kh_mota_chitiet" class="form-control"></textarea>
                    <br/>
                    

                    Ngày cập nhật:
                    <input type="datetime-local" name="kh_ngaycapnhat" id="kh_ngaycapnhat" class="form-control"></input>
                    <br/>



                    <button name="btnSave" id="btnSave" class="btn btn-primary">
                    Lưu dữ liệu
                    </button>
                    <br/><br/>
                </form>
                <?php

                // Khi người dùng bấm lưu thì xử lý
                if(isset($_POST['btnSave'])) {
                    //1. Mở kết nối đến database
                    // include_once __DIR__ . '/../../dbconnect.php';
                    //2. chuẩn bị câu lệnh
                    $ten = htmlentities ($_POST['kh_tenkhoahoc']);
                    $manhom = ($_POST['nkh_ma']);
                    $hocphi = htmlentities ($_POST['kh_hocphi']);
                    $motangan = htmlentities ($_POST['kh_mota_ngan']);
                    $motachitiet = htmlentities ($_POST['kh_mota_chitiet']);
                    $ngaycapnhat = htmlentities ($_POST['kh_ngaycapnhat']);
                    $sql = "INSERT INTO khoahoc(kh_tenkhoahoc, nkh_ma, kh_hocphi, kh_mota_ngan, kh_mota_chitiet,kh_ngaycapnhat  ) VALUES ('$ten', $manhom, $hocphi, '$motangan', '$motachitiet', '$ngaycapnhat' );";
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