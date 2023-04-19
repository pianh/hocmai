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

    <title>Sửa đơn thanh toán</title>

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
                    $sqlSelectHTTT = "
                        SELECT *
                        FROM hinhthucthanhtoan;
                    ";
                    //Thực thi
                    $resultHTTT = mysqli_query($conn, $sqlSelectHTTT);
                    //Phan tách thành mảng array PHP
                    $dataHTTT = [];
                    while ($rowHTTT = mysqli_fetch_array($resultHTTT, MYSQLI_ASSOC)) {
                        $dataHTTT[] = array(
                            'httt_ma' => $rowHTTT['httt_ma'],
                            'httt_ten' => $rowHTTT['httt_ten'],
                        );
                    }

                       
                    // var_dump($data);die;
                ?>

            <div class="col-md-10 pd-bottom-100">
                <h1>Sửa đơn thanh toán</h1>
                <?php
                    $donThanhToanMuonSua = $_GET['dtt_ma'];
                    //1. Mở kết nối
                    // include_once __DIR__ . '/../../dbconnect.php';
                    //2. Chuẩn bị câu lệnh
                    $sqlSelect = <<<EOT
                    SELECT dtt_ma, dtt_ngaylap, dtt_trangthai, httt_ma, tv_tendangnhap
                    FROM donthanhtoan
                    WHERE dtt_ma = $donThanhToanMuonSua;
EOT;
                    //3. Thực thi
                    $result = mysqli_query($conn, $sqlSelect);
                    $dataDongMuonSua = mysqli_fetch_array($result, MYSQLI_ASSOC)
                ?>

                <form name="frmCreate" id="frmCreate" method="post" action="">
                        Mã đơn (*):
                        <br/>
                        <input type="text" name="dtt_ma" id="dtt_ma"
                            value="<?= $dataDongMuonSua['dtt_ma']?>"
                        class="form-control" readonly
                        />
                        <br />
                    
                        Ngày lập:
                        <br/>
                        <input type="datetime-local" name="dtt_ngaylap" id="dtt_ngaylap"
                            value="<?= $dataDongMuonSua['dtt_ngaylap'] ?>"
                        class="form-control"
                        />
                        <br />

                        <label for="">Trạng thái:</label>
                        <select name="dtt_trangthai" id="dtt_trangthai" class="form-control">
                            <option value="">Chọn trạng thái cho đơn</option>
                                <option value="1">Thành công</option>
                                <option value="0">Chưa xử lý</option>
                        </select>
                        </br>

                        <label for="">Hình thức thanh toán:</label>
                        <select name="httt_ma" id="httt_ma" class="form-control">
                            <option value="">Vui lòng chọn hình thức thanh toán</option>
                            <?php foreach($dataHTTT as $httt): ?>
                                <option value="<?= $httt['httt_ma'] ?>"><?= $httt['httt_ten'] ?></option>
                               
                            <?php endforeach; ?>

                        </select>

                        </br>
                        Tài khoản thanh toán:
                        <input type="text" name="tv_tendangnhap" id="tv_tendangnhap"
                            value="<?= $dataDongMuonSua['tv_tendangnhap'] ?>"
                        class="form-control"
                        />

                        </br>
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
                        $ma = $_POST['dtt_ma'];
                        $ngaylap = $_POST['dtt_ngaylap'];
                        $trangthai = $_POST['dtt_trangthai'];
                        $hinhthucthanhtoan = $_POST['httt_ma'];
                        $taikhoan = $_POST['tv_tendangnhap'];
                        //Heredoc
                        $sql = <<<EOT
                        UPDATE donthanhtoan
                        SET dtt_ma= $ma, dtt_ngaylap='$ngaylap', dtt_trangthai= $trangthai, httt_ma='$hinhthucthanhtoan', tv_tendangnhap='$taikhoan'
                        WHERE dtt_ma= $ma;
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