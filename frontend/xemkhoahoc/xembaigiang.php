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
   
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học trực tuyến - Hệ thống giáo dục Hocmai</title>
    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../layouts/style.php'); ?>

    <link href="/learnforever.xyz/assets/frontend/css/style.css" type="text/css" rel="stylesheet" />

    <style>

        

    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->
    <?php 
    ?>
    <main role="main" class="mb-2" style="padding-bottom: 350px;">
        <div class="row">

            <div class="col-md-12">
                    </br>
                    
                    <?php
                    
                    //1. Mở kết nối
                    include_once __DIR__ . '/../../dbconnect.php';
                    $tv_tendangnhap=$_SESSION['tv_tendangnhap_logged'];
                    $video_ma = $_GET['video_ma'];
                    

                    //2. Chuẩn bị câu lệnh
                    $sql = "select tvkh.kh_makhoahoc, bg.bg_bai, kh.kh_mota_ngan, vkh.video_bai, tvkh.tv_tendangnhap, vkh.video_ma, vkh.video_tenbai, vkh.video_bai, vkh.video_tentaptin, kh.kh_tenkhoahoc, bg.bg_tentaptin, kh.kh_tenkhoahoc
                    from thanhvien_khoahoc tvkh
                    join videokhoahoc vkh on vkh.kh_makhoahoc=tvkh.kh_makhoahoc
                    JOIN khoahoc kh ON vkh.kh_makhoahoc = kh.kh_makhoahoc
                    JOIN baigiang bg ON bg.kh_makhoahoc = kh.kh_makhoahoc
                    where (tvkh.tv_tendangnhap='$tv_tendangnhap' AND vkh.video_ma = $video_ma AND vkh.video_bai=bg.bg_bai )
                    group by vkh.video_bai
                    order by vkh.video_bai asc;";
                    

                    //3. Thuc thi
                    $result = mysqli_query($conn, $sql);
                    //4. Phân tách thành mảng array
                    $data = [];
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $data[] = array (
                            'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                            'video_bai' => $row['video_bai'],
                            'video_ma' => $row['video_ma'],
                            'video_tentaptin' => $row['video_tentaptin'],
                            'video_tenbai' => $row['video_tenbai'],
                            'bg_tentaptin' => $row['bg_tentaptin'],
                            'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                            'kh_mota_ngan' => $row['kh_mota_ngan'],
                        );
                    }

                    //  var_dump($data);
                    //  die;
                    ?>

                    <?php foreach($data as $tenbai): ?>
                        <?php if ((!empty ($tenbai['kh_tenkhoahoc']))) ?>
                        <h2 style="text-align: center;">Khóa học <?= $tenbai['kh_mota_ngan'] ?></h2>
                        <h3 style="text-align: center; margin-top: 10px;">Bài giảng <?= $tenbai['video_tenbai'] ?></h3>
                        
                        <?php break; ?>
                    <?php endforeach; ?>
                


                    <br />
                    <br />

                        <?php foreach($data as $video): ?>
                            <div class="box">
                                <video src="/learnforever.xyz/assets/uploadsvideo/<?= $video['video_tentaptin']?>" controls class="video-kh">  </video>
                                <iframe src="/learnforever.xyz/assets/uploadsbaigiang/<?= $video['bg_tentaptin']?>" width="480px" max-height="500px"></iframe>

                            </div>
                               
              
                        <?php endforeach; ?>
                    




                </div>

            <!-- End block content -->


        </div>
    </main>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->

</body>

</html>