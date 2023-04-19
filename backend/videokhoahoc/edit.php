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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>

    <title>Chỉnh sửa video khóa học</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
        .video-kh {
            height: 300px;
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid" style="padding-bottom: 250px;">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10">
              <h1>Chỉnh sửa video khóa học</h1> 
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
                    $video_ma = $_GET['video_ma'];
                    //Chuẩn bị câu lệnh
                    $sqlSelectVIDEO_MuonSua = "
                    SELECT *
                    FROM videokhoahoc
                    WHERE video_ma = $video_ma;
                    ";
                    //Thực thi câu lệnh
                    $resultVideo_Muonsua = mysqli_query($conn, $sqlSelectVIDEO_MuonSua);
                    //Phan tách dữ liệu thành array PHP
                    $dataVIDEO_MuonSua = mysqli_fetch_array($resultVideo_Muonsua, MYSQLI_ASSOC);



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
                            <?php if( $dataVIDEO_MuonSua['kh_makhoahoc'] == $kh['kh_makhoahoc']): ?>
                                <option selected value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>
                            <?php else: ?>
                                <option value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>

                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>

                </div>
                <div class="form-group">
                        Bài (*):
                        <br/>
                        <input type="text" name="video_bai" id="video_bai"
                            value="<?= $dataVIDEO_MuonSua['video_bai']?>"
                        class="form-control"/>
                        <br />
                    
                        Tên bài (*):
                        <br/>
                        <input type="text" name="video_tenbai" id="video_tenbai"
                            value="<?= $dataVIDEO_MuonSua['video_tenbai'] ?>"
                        class="form-control"
                        />
                        <br />

                
                    <label for="">Video Khóa học</label>
                    <br />
                        
                        <video src="/learnforever.xyz/assets/uploadsvideo/<?= $dataVIDEO_MuonSua['video_tentaptin']?>" controls class="video-kh">  </video>
                    <br /><br />
                    <input type="file" name="video_tentaptin" id="video_tentaptin" />
                </div>
                <button name="btnLuu" class="btn btn-primary">Lưu dữ liệu</button>
            </form>

                <?php

   
                    //2.Chuẩn bị câu lệnh
                    if(isset($_POST['btnLuu'])) {
                        $kh_ma = $_POST['kh_makhoahoc'];
                        $bai = $_POST['video_bai'];
                        $tenbai = $_POST['video_tenbai'];
                        //3. Xử lý file
                        if( isset($_FILES['video_tentaptin'] )) {

                            $upload_dir = __DIR__ . "/../../assets/uploadsvideo/";
                            // 3.1. Chuyển file từ thư mục tạm vào thư mục Uploads
                            // Nếu file upload bị lỗi, tức là thuộc tính error > 0
                            if ($_FILES['video_tentaptin']['error'] > 0) {
                                echo 'File Upload Bị Lỗi'; die;
                            } else {
                                    //5. XÓA FILE ẢNH ĐỂ TRÁNH RÁC
                                    $filePath = __DIR__ . '/../../assets/uploadsvideo/' .$dataVIDEO_MuonSua['video_tentaptin'];
                                    unlink($filePath);

                                $video_tentaptin = $_FILES['video_tentaptin']['name'];
                                $tentaptin = date('YmdHis') . '_' . $video_tentaptin; //20200530154922_hoahong.jpg
                
                                move_uploaded_file($_FILES['video_tentaptin']['tmp_name'], $upload_dir . $tentaptin);
                            }
                            $sql = "
                            UPDATE videokhoahoc
                            SET video_tentaptin = '$tentaptin', kh_makhoahoc = $kh_ma, video_bai='$bai', video_tenbai='$tenbai'
                            WHERE video_ma = $video_ma;
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