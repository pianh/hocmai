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

    <title>Chỉnh sửa hình đại diện khóa học</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
        .hinh-kh {

            height: 200px;
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid" style="padding-bottom: 250px;">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10 ">
              <h1>Chỉnh sửa hình đại diện khóa học</h1> 
                <?php
                    // Hiển thị tất cả lỗi trong PHP
                    // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                    // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    //1. Mở kết nối
                    include_once __DIR__ . '/../../dbconnect.php';
                    //TRUY VẤN TÌM DỮ LIỆU CỦA DÒNG MUỐN SỬA
                    $hkh_ma = $_GET['hkh_ma'];
                    //Chuẩn bị câu lệnh
                    $sqlSelectHKH_MuonSua = "
                    SELECT *
                    FROM hinhkhoahoc
                    WHERE hkh_ma = $hkh_ma;
                    ";
                    //Thực thi câu lệnh
                    $resultHKH_Muonsua = mysqli_query($conn, $sqlSelectHKH_MuonSua);
                    //Phan tách dữ liệu thành array PHP
                    $dataHKH_MuonSua = mysqli_fetch_array($resultHKH_Muonsua, MYSQLI_ASSOC);



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
                    <label for="">Khóa học</label>
                    <select name="kh_makhoahoc" id="kh_makhoahoc" class="form-control">
                        <?php foreach($dataKhoaHoc as $kh): ?>
                            <?php if( $dataHKH_MuonSua['kh_makhoahoc'] == $kh['kh_makhoahoc']): ?>
                                <option selected value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>
                            <?php else: ?>
                                <option value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="form-group">
                    <label for="">Hình Khóa học</label>
                    <br />
                        <img src="/learnforever.xyz/assets/uploads/<?= $dataHKH_MuonSua['hkh_tentaptin'] ?>" class="img-fluid hinh-kh">
                    <br /><br />
                    <input type="file" name="hkh_tentaptin" id="hkh_tentaptin" />
                </div>
                <button name="btnLuu" class="btn btn-primary">Lưu dữ liệu</button>
              </form>

                <?php

   
                    //2.Chuẩn bị câu lệnh
                    if(isset($_POST['btnLuu'])) {
                        $kh_ma = $_POST['kh_makhoahoc'];
                        //3. Xử lý file
                        if( isset($_FILES['hkh_tentaptin'] )) {
                            $upload_dir = __DIR__ . "/../../assets/uploads/";
                            // 3.1. Chuyển file từ thư mục tạm vào thư mục Uploads
                            // Nếu file upload bị lỗi, tức là thuộc tính error > 0
                            if ($_FILES['hkh_tentaptin']['error'] > 0) {
                                echo 'File Upload Bị Lỗi'; die;
                            } else {
                                    //5. XÓA FILE ẢNH ĐỂ TRÁNH RÁC
                                    $filePath = __DIR__ . '/../../assets/uploads/' .$dataHKH_MuonSua['hkh_tentaptin'];
                                    unlink($filePath);
                                // Để tránh trường hợp có 2 người dùng cùng lúc upload tập tin trùng tên nhau
                                // Cách giải quyết đơn giản là chúng ta sẽ ghép thêm ngày giờ vào tên file
                                $hkh_tentaptin = $_FILES['hkh_tentaptin']['name'];
                                $tentaptin = date('YmdHis') . '_' . $hkh_tentaptin; //20200530154922_hoahong.jpg
                
                                // Tiến hành di chuyển file từ thư mục tạm trên server vào thư mục chúng ta muốn chứa các file uploads
                
                                move_uploaded_file($_FILES['hkh_tentaptin']['tmp_name'], $upload_dir . $tentaptin);
                            }
                            $sql = "
                            UPDATE hinhkhoahoc
                            SET hkh_tentaptin = '$tentaptin',
                                kh_makhoahoc = $kh_ma
                            WHERE hkh_ma = $hkh_ma;
                            "; 
                            //4. Thực thi
                            mysqli_query($conn, $sql);
                            //5. Điều hướng trang danh sách
                            echo '<script>location.href ="index.php";</script>';
                            
                        } 
                    }
                ?>

            </div>
        
        </div>
    </div>

    

    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>
</body>
</html>