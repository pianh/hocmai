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

    <title>Thêm mới video khóa học</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
        .hinh-sp {
            width: 120px;
            height: 120px;
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10 pd-bottom-250">
              <h1>Thêm mới video cho khóa học</h1>
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
                    $sqlSelectKhoahoc = "
                        SELECT *
                        FROM khoahoc;
                    ";
                    //Thực thi
                    $resultKhoahoc = mysqli_query($conn, $sqlSelectKhoahoc);
                    //Phan tách thành mảng array PHP
                    $dataKhoahoc = [];
                    while ($row = mysqli_fetch_array($resultKhoahoc, MYSQLI_ASSOC)) {
                        $dataKhoaHoc[] = array(
                            'kh_makhoahoc' => $row['kh_makhoahoc'],
                            'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                            'kh_hocphi' => $row['kh_hocphi'] 
                        );

                    } 
                    // var_dump($data);die;
                ?>

              <form name="frmCreate" id="frmCreate" method="post"  action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Khóa học</label>
                    <select name="kh_makhoahoc" id="kh_makhoahoc" class="form-control">
                        <?php foreach($dataKhoaHoc as $kh): ?>
                            <option value="<?= $kh['kh_makhoahoc'] ?>"><?= $kh['kh_tenkhoahoc'] ?></option>
                        <?php endforeach; ?>

                    </select>
                    

                </div>
                <div class="form-group">
                    Bài: (Vui lòng nhập: Bài "X")
                    <input type="text" name="video_bai" id="video_bai" class="form-control"/>
                    <br />

                    Tên bài:
                    <input type="text" name="video_tenbai" id="video_tenbai" class="form-control"/>
                    <br />

                    <label for="">Video khóa học</label>
                    <br />
                    <input type="file" name="video_tentaptin" id="video_tentaptin" />
                </div>
                <button name="btnLuu" class="btn btn-primary">Lưu dữ liệu</button>
              </form>

                <?php


                    //2.Chuẩn bị câu lệnh
                    if(isset($_POST['btnLuu'])) {
                        include_once __DIR__ . '/../../dbconnect.php';
                        $bai = ($_POST['video_bai']);
                        $tenbai = ($_POST['video_tenbai']);

                        $kh_ma = $_POST['kh_makhoahoc'];
                        



                        //3. Xử lý file
                        if( isset($_FILES['video_tentaptin'] )) {
                            // Đối với mỗi file, sẽ có các thuộc tính như sau:
                            $upload_dir = __DIR__ . "/../../assets/uploadsvideo/";
                            // 3.1. Chuyển file từ thư mục tạm vào thư mục Uploads
                            // Nếu file upload bị lỗi, tức là thuộc tính error > 0
                            if ($_FILES['video_tentaptin']['error'] > 0) {
                                echo 'File Upload Bị Lỗi'; die;
                            } else {
                                // Để tránh trường hợp có 2 người dùng cùng lúc upload tập tin trùng tên nhau
                                // Cách giải quyết đơn giản là chúng ta sẽ ghép thêm ngày giờ vào tên file
                                $video_tentaptin = $_FILES['video_tentaptin']['name'];
                                $tentaptin = date('YmdHis') . '_' . $video_tentaptin; //20200530154922_hoahong.jpg
                
                                // Tiến hành di chuyển file từ thư mục tạm trên server vào thư mục chúng ta muốn chứa các file uploads                
                                move_uploaded_file($_FILES['video_tentaptin']['tmp_name'], $upload_dir . $tentaptin);
                            }
                            $sql = "INSERT INTO videokhoahoc(video_tentaptin, video_bai, video_tenbai, kh_makhoahoc ) VALUES ('$tentaptin', '$bai', '$tenbai', $kh_ma);"; 
                            
                            // //4. Thực thi
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