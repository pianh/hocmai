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

    <title>Sửa góp ý</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
    </style>
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
                    $sqlSelectCDGY = "
                        SELECT *
                        FROM chudegopy;
                    ";
                    //Thực thi
                    $resultCDGY = mysqli_query($conn, $sqlSelectCDGY);
                    //Phan tách thành mảng array PHP
                    $dataCDGY = [];
                    while ($rowCDGY = mysqli_fetch_array($resultCDGY, MYSQLI_ASSOC)) {
                        $dataCDGY[] = array(
                            'cdgy_ma' => $rowCDGY['cdgy_ma'],
                            'cdgy_ten' => $rowCDGY['cdgy_ten'],
                        );
                    }

                       
                    // var_dump($data);die;
                ?>

            <div class="col-md-10">
                </br>
                <h1>Sửa góp ý</h1>
                <?php
                    $gopYMuonSua = $_GET['gy_ma'];
                    //1. Mở kết nối
                    include_once __DIR__ . '/../../dbconnect.php';
                    //2. Chuẩn bị câu lệnh
                    $sqlSelect = <<<EOT
                    SELECT gy_ma, gy_hoten, gy_email, gy_dienthoai, gy_noidung, cdgy_ma
                    FROM gopy
                    WHERE gy_ma = $gopYMuonSua;
EOT;
                    //3. Thực thi
                    $result = mysqli_query($conn, $sqlSelect);
                    $dataDongMuonSua = mysqli_fetch_array($result, MYSQLI_ASSOC)
                ?>

                <form name="frmCreate" id="frmCreate" method="post" action="">
                        Mã góp ý (*):
                        <br/>
                        <input type="text" name="gy_ma" id="gy_ma" readonly
                            value="<?= $dataDongMuonSua['gy_ma']?>"
                        class="form-control"
                        />
                        <br />
                    
                        Tên thành viên góp ý:
                        <br/>
                        <input type="text" name="gy_hoten" id="gy_hoten"
                            value="<?= $dataDongMuonSua['gy_hoten'] ?>"
                        class="form-control"
                        />
                        <br />

                        Email:
                        <input type="text" name="gy_email" id="gy_email"
                            value="<?= $dataDongMuonSua['gy_email'] ?>"
                        class="form-control"
                        />
                        <br />

                        Số điện thoại:
                        <input type="text" name="gy_dienthoai" id="gy_dienthoai"
                            value="<?= $dataDongMuonSua['gy_dienthoai'] ?>"
                        class="form-control"
                        />
                        <br />

                        Nội dung:
                        <textarea name="gy_noidung" id="gy_noidung" class="form-control"><?= $dataDongMuonSua['gy_noidung'] ?></textarea>
                        </br>

                        <label for="">Chủ đề góp ý:</label>
                        <select name="cdgy_ma" id="cdgy_ma" class="form-control">
                            <option value="">Vui lòng chọn chủ đề góp ý</option>
                            <?php foreach($dataCDGY as $cdgy): ?>
                                <option value="<?= $cdgy['cdgy_ma'] ?>"><?= $cdgy['cdgy_ten'] ?></option>
                            
                            <?php endforeach; ?>

                        </select>
                        <br />
                        <button name="btnSave" id="btnSave" class="btn btn-primary">
                        Lưu dữ liệu
                        </button>
                        </br></br>
                </form>

                <?php
                    // Khi người dùng bấm lưu thì xử lý
                    if(isset($_POST['btnSave'])) {
                        //1. Mở kết nối
                        include_once __DIR__ . '/../../dbconnect.php';
                        //2. chuẩn bị câu lệnh
                        $ma = $_POST['gy_ma'];
                        $ten = $_POST['gy_hoten'];
                        $email = $_POST['gy_email'];
                        $dienthoai = $_POST['gy_dienthoai'];
                        $noidung = $_POST['gy_noidung'];
                        $chude = $_POST['cdgy_ma'];
                        //Heredoc
                        $sql = <<<EOT
                        UPDATE gopy
                        SET gy_hoten='$ten', gy_email='$email', gy_dienthoai='$dienthoai', gy_noidung='$noidung', cdgy_ma=$chude
                        WHERE gy_ma= $ma;
EOT;
                        //debug
                        // var_dump($sql);
                        // die;

                        //3. Thực thi
                        mysqli_query($conn, $sql);

                        //4. Điều hướng
                        echo '<script>location.href = "index.php";</script>';
                    }

                ?>

            </div>
        
        </div>
    </div>

    

    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>
</body>
</html>