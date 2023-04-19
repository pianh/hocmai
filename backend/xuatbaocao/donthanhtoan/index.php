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
include_once __DIR__ . '/../../../dbconnect.php';

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
    <?php include_once __DIR__ . '/../../layouts/meta.php'; ?>

    <title>Báo cáo đơn thanh toán</title>

    <?php include_once __DIR__ . '/../../layouts/style.php'?>
    <style>
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../../layouts/partials/header.php' ?>
    
    <div class="container-fluid" style="padding-bottom: 250px;">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/partials/sidebar.php' ?>


            <div class="col-md-10 pd-bottom-150">
                </br>
                <h1>XUẤT BÁO CÁO ĐƠN THANH TOÁN</h1>
                </br>
                <?php
                    // Hiển thị tất cả lỗi trong PHP
                    // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                    // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    //1. Mở kết nối đến database
                    include_once __DIR__ . '/../../../dbconnect.php';
                    //2. Chuan bi cau lenh
                ?>   
                <table class="table table-bordered table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>Xuất Word</th>
                                <th>Xuất PDF</th>

                            </tr>
                        </thead>

                        <tr>
                            <td> 
                                <a href="/learnforever.xyz/backend/xuatbaocao/donthanhtoan/thuvien-word.php" class="btn btn-success" target="_blank">Xuất Word</a>
                                </br></br>
                                <a href="/learnforever.xyz/assets/templates/word/danhsachdonthanhtoan.docx">Tải File Word đơn thanh toán</a>
                            </td>
                        
                            <td> 
                                <a href="/learnforever.xyz/backend/xuatbaocao/donthanhtoan/thuvien-pdf.php" class="btn btn-success" target="_blank">Xuất PDF</a>
                                </br></br>
                                <a href="/learnforever.xyz/backend/xuatbaocao/donthanhtoan/thuvien-pdf.php" target="_blank"> Tải File PDF đơn thanh toán</a>
                            </td>

                        </tr>

                    </table>    

            </div>
        
        </div>
    </div>

    

    <?php include_once __DIR__ . '/../../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../../layouts/scripts.php' ?>
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
                   var tv_kh_ma = $(this).data('tv_kh_ma');
                   var url = "delete.php?tv_kh_ma=" + tv_kh_ma;

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