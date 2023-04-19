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

    <title>Danh sách các thành viên</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>


            <div class="col-md-10">
                </br>
                <h1>Danh sách các thành viên hiện có</h1>
                <?php
                    // Hiển thị tất cả lỗi trong PHP
                    // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                    // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    //1. Mở kết nối đến database
                    include_once __DIR__ . '/../../dbconnect.php';
                    //2. Chuan bi cau lenh
                    $sql = "SELECT * FROM thanhvien;";

                    //3. Thuc thi
                    $result = mysqli_query($conn, $sql);

                    //4. Phân tách thành mảng array
                    $data = [];
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $data[] = array (
                            'tv_tendangnhap' => $row['tv_tendangnhap'],
                            'tv_ten' => $row['tv_ten'],
                            'tv_gioitinh' => $row['tv_gioitinh'],
                            'tv_dienthoai' => $row['tv_dienthoai'],
                            'tv_cmnd' => $row['tv_cmnd'],
                            'tv_giaovien' => $row['tv_giaovien'],
                            'tv_quantri' => $row['tv_quantri']
                           
                        );
                    }

                    //  var_dump($data);
                    //  die;
                ?>
                
                <a href="create.php" class="btn btn-primary">Thêm mới</a>
                </br>
                </br>
                    <table class="table table-bordered table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>Tên đăng nhập</th>
                                <th>Tên Thành viên</th>
                                <th>Giới Tính</th>
                                <th>Số điện thoại</th>
                                <th>CMND</th>
                                <th>Giáo viên</th>
                                <th>Quản trị</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                    <?php foreach($data as $tv): ?>
                        <tr>
                            <td><?= $tv['tv_tendangnhap']  ?>  </td>
                            <td><?php echo $tv['tv_ten']  ?></td>
                            <td><?php 
                            if ($tv['tv_gioitinh'] == 1)
                                echo "Nam";
                            else 
                                echo "Nữ";
                           
                            ?></td>
                            <td><?php echo $tv['tv_dienthoai']  ?></td>
                            <td><?php echo $tv['tv_cmnd']  ?></td>
                            <td><?php 
                            if ($tv['tv_giaovien'] == 1)
                                echo "X";
                            else echo "";
                            ?></td>
                            <td><?php 
                            if ($tv['tv_quantri'] == 1)
                                echo "X";
                            else echo "";
                            ?></td>
                            <td>
                                <!-- Nút sửa -->
                                <a href="edit.php?tv_tendangnhap=<?= $tv['tv_tendangnhap']?>" class="btn btn-warning">Sửa</a>
                                <!-- Nút xóa -->
                                <!-- <a href="delete.php?tv_tendangnhap=<?= $tv['tv_tendangnhap']?>" class="btn btn-danger">Xóa</a> -->
                                <button type="button" class="btn btn-danger btnDelete" data-tv_tendangnhap="<?= $tv['tv_tendangnhap'] ?>">
                                    Xóa
                                </button>
                                <div style="padding-top: 10px;"></div>


                                </form>
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
                   var tv_tendangnhap = $(this).data('tv_tendangnhap');
                   var url = "delete.php?tv_tendangnhap=" + tv_tendangnhap;

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