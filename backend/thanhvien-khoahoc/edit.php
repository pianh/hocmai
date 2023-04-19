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

    <title>Sửa khóa học cho thành viên</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid pd-bottom-100">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10 pd-bottom-100">
                </br>
                <h1>Sửa khóa học cho thành viên</h1>
                <?php
                    // Hiển thị tất cả lỗi trong PHP
                    // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                    // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    $tv_kh_maMuonSua = $_GET['tv_kh_ma'];
                    //1. Mở kết nối
                    include_once __DIR__ . '/../../dbconnect.php';
                    //2. Chuẩn bị câu lệnh
                    $sqlSelect =  "SELECT * FROM thanhvien_khoahoc tv_kh
                            JOIN khoahoc k ON  tv_kh.kh_makhoahoc = k.kh_makhoahoc
                            JOIN thanhvien tv ON tv.tv_tendangnhap = tv_kh.tv_tendangnhap
                            WHERE tv_kh_ma = $tv_kh_maMuonSua;" ;             
                    //3. Thực thi
                    //Thực thi câu lệnh
                    $resultTv_kh = mysqli_query($conn, $sqlSelect);
                    //Phan tách dữ liệu thành array PHP
                    $dataTV_KH_MuonSua = mysqli_fetch_array($resultTv_kh, MYSQLI_ASSOC);



                    //Chuẩn bị câu lệnh
                    $sqlSelectKhoaHoc = "
                        SELECT *
                        FROM khoahoc;
                    ";
                    //Thực thi
                    $resultKhoaHoc = mysqli_query($conn, $sqlSelectKhoaHoc);
                    //Phan tách thành mảng array PHP
                    $dataKhoaHoc = [];
                    while ($row = mysqli_fetch_array($resultKhoaHoc, MYSQLI_ASSOC)) {
                        $dataKhoaHoc[] = array(
                            'kh_makhoahoc' => $row['kh_makhoahoc'],
                            'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                            'kh_hocphi' => $row['kh_hocphi'] 
                        );

                    } 

                ?>

                <form name="frmCreate" id="frmCreate" method="post"  action="" enctype="multipart/form-data">
                    <div class="form-group">
                        Mã:
                        <br/>
                        <input type="text" name="tv_kh_ma" id="tv_kh_ma"
                            value="<?= $dataTV_KH_MuonSua['tv_kh_ma']?>"
                        class="form-control"
                        readonly/>
                        <br />
                    
                        Tên đăng nhập (*):
                        <br/>
                        <input type="text" name="tv_tendangnhap" id="tv_tendangnhap"
                            value="<?= $dataTV_KH_MuonSua['tv_tendangnhap'] ?>"
                        class="form-control" readonly
                        />
                        <br />
                
                        Tên đăng nhập (*):
                        <br/>
                        <input type="text" name="tv_tendangnhap" id="tv_tendangnhap"
                            value="<?= $dataTV_KH_MuonSua['tv_tendangnhap'] ?>"
                        class="form-control" readonly
                        />
                        <br />
                    </div>

                    <div class="form-group">
                        <label for="">Khóa học</label>
                        <select name="kh_makhoahoc" id="kh_makhoahoc" class="form-control">
                            <?php foreach($dataKhoaHoc as $kh): ?>
                                <?php if( $dataTV_KH_MuonSua['kh_makhoahoc'] == $kh['kh_makhoahoc']): ?>
                                    <option selected value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>
                                <?php else: ?>
                                    <option value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>

                                <?php endif; ?>
                            <?php endforeach; ?>

                        </select>

                    </div>
                
                <button name="btnLuu" class="btn btn-primary">Lưu dữ liệu</button>
                </form>
                    
                                    


                <?php
                    // Khi người dùng bấm lưu thì xử lý
                    if(isset($_POST['btnLuu'])) {
                        //1. Mở kết nối
                        include_once __DIR__ . '/../../dbconnect.php';
                        //2. chuẩn bị câu lệnh tv_kh_ma
                        $tv_kh_ma=$_POST['tv_kh_ma'];
                        $tendangnhap = $_POST['tv_tendangnhap'];
                        $makhoahoc = $_POST['kh_makhoahoc'];
                        //Heredoc
                        $sql ="
                        UPDATE thanhvien_khoahoc
                        SET tv_tendangnhap='$tendangnhap', kh_makhoahoc=$makhoahoc
                        WHERE tv_kh_ma = $tv_kh_ma";

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