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
    <!-- Latest compiled and minified CSS -->

    <link href="/learnforever.xyz/assets/frontend/css/style.css" type="text/css" rel="stylesheet" />

    <style>
        .video-kh {
            max-height: 250px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }
        nav.col-md-2.d-none.d-md-block.sidebar {
            font-size: 1.6rem;
            margin-top: 15px;
        }
        a.btn.btn-success.view-btn {
            min-height: 30px;
            font-size: 1.4rem;
        }
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
            <!-- Block content -->
       

            <div class="col-md-12">
                    </br>
                    
                    <?php
                    
                    //1. Mở kết nối
                    include_once __DIR__ . '/../../dbconnect.php';
                    $tv_tendangnhap=$_SESSION['tv_tendangnhap_logged'];
                    $kh_makhoahoc = $_GET['kh_makhoahoc'];

                    //2. Chuẩn bị câu lệnh
                    $sql = "select tvkh.kh_makhoahoc, tvkh.tv_tendangnhap, vkh.video_ma, vkh.video_tenbai, vkh.video_bai, vkh.video_tentaptin, kh.kh_tenkhoahoc, bg.bg_tentaptin, kh.kh_tenkhoahoc
                    from thanhvien_khoahoc tvkh
                    join videokhoahoc vkh on vkh.kh_makhoahoc=tvkh.kh_makhoahoc
                    JOIN khoahoc kh ON vkh.kh_makhoahoc = kh.kh_makhoahoc
                    JOIN baigiang bg ON bg.kh_makhoahoc = kh.kh_makhoahoc
                    where (tvkh.tv_tendangnhap='$tv_tendangnhap' AND kh.kh_makhoahoc = $kh_makhoahoc)
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
                        );
                    }

                    //  var_dump($data);
                    //  die;
                    ?>

                    <?php foreach($data as $tenbai): ?>
                        <?php if ((!empty ($tenbai['kh_tenkhoahoc']))) ?>
                        <h2 style="text-align: center;">Danh sách video khóa <?= $tenbai['kh_tenkhoahoc'] ?> của bạn</h2>
                        <?php break; ?>
                    <?php endforeach; ?>
                
                    <br />
                    <br />
                    <table class="table table-bordered table-hover">
                        <thead class="table-info">
                            <tr style="text-align: center;" >
                                <th>Bài</th>
                                <th>Tên bài</th>
                                <th>Video</th>
                                <!-- <th>Bài giảng</th> -->
                            
                                
                            </tr>
                        </thead>
                        <?php foreach($data as $video): ?>
                            <tr>
                                <td><?= $video['video_bai'] ?></td>
                                <td><?= $video['video_tenbai'] ?></td>
                                <td>
                                    <!-- <button type="button" class="btn btn-success"> -->
                                        <a href="xembaigiang.php?video_ma=<?= $video['video_ma']?>" class="btn btn-success view-btn">Xem ngay</a>
                                    
                                <!-- </button> -->
                                </td>        

                            </tr>
                        <?php endforeach; ?>
                    </table>




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