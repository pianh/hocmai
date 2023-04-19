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

    <title>Danh sách video khóa học</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
        .video-kh {
            max-height: 250px;
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10">
                </br>
                <h1>Danh sách video khóa học</h1>
                <?php
                // Hiển thị tất cả lỗi trong PHP
                // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                //1. Mở kết nối
                include_once __DIR__ . '/../../dbconnect.php';
                //2. Chuẩn bị câu lệnh
                $sql = "
                SELECT vkh.video_ma, vkh.video_bai, vkh.video_tentaptin, kh.kh_tenkhoahoc
                FROM videokhoahoc vkh
                JOIN khoahoc kh ON vkh.kh_makhoahoc = kh.kh_makhoahoc;";
                //3. Thuc thi
                $result = mysqli_query($conn, $sql);
                //4. Phân tách thành mảng array
                $data = [];
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $data[] = array (
                        'video_ma' => $row['video_ma'],
                        'video_tentaptin' => $row['video_tentaptin'],
                        'video_bai' => $row['video_bai'],
                        'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                    );
                }

                //  var_dump($data);
                //  die;
                ?>
                <a href="create.php" class="btn btn-success">Thêm video cho khóa học</a>
                <br />
                <br />
                <table class="table table-bordered table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>Mã video</th>
                            <th>Bài</th>
                            <th>Tập tin video</th>
                            <th>Video của khóa học</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <?php foreach($data as $video): ?>
                        <tr>
                            <td><?= $video['video_ma'] ?></td>
                            <td><?= $video['video_bai'] ?></td>
                            <td>
                                <video src="/learnforever.xyz/assets/uploadsvideo/<?= $video['video_tentaptin']?>" controls class="video-kh">  </video>

                            </td>
                            
                            <td><?= $video['kh_tenkhoahoc'] ?></td>
                            <td>
                                <a href="edit.php?video_ma=<?= $video['video_ma'] ?>" class="btn btn-warning">Sửa</a>
                                <!-- <a href="delete.php?video_ma=<?= $video['video_ma'] ?>" class="btn btn-danger">Xóa</a> -->
                                <button type="button" class="btn btn-danger btnDelete" data-video_ma="<?= $video['video_ma'] ?>">
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>




            </div>
        
        </div>
    </div>

    

    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>
           <!-- SweetAlert -->
           <script>
   
   // Cảnh báo khi xóa
   // 1. Đăng ký sự kiện click cho các phần tử (element) đang áp dụng class .btnDelete
   $('.btnDelete').click(function() {
       // Click hanlder
       // 2. Sử dụng thư viện SweetAlert để hiện cảnh báo khi bấm nút xóa
       swal({
               title: "Bạn có chắc chắn muốn xóa?",
               text: "Một khi đã xóa, không thể phục hồi....",
               icon: "warning",
               buttons: true,
               dangerMode: true,
           })
           .then((willDelete) => {
               if (willDelete) { // Nếu đồng ý xóa

                   // 3. Lấy giá trị của thuộc tính (custom attribute HTML) 'km_ma'
                   // var km_ma = $(this).attr('data-km_ma');
                   var video_ma = $(this).data('video_ma');
                   var url = "delete.php?video_ma=" + video_ma;

                   // Điều hướng qua trang xóa với REQUEST GET, có tham số km_ma=...
                   location.href = url;
               } else { // Nếu không đồng ý xóa
                   swal("Cẩn thận hơn nhé!");
               }
           });

   });

    </script>
</body>
</html>