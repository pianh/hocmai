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

    <title>Danh sách các đơn thanh toán</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?> 
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>
            <main role="main" class="col-md-10 ml-sm-auto px-4 mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Danh sách các đơn thanh toán</h1>
                </div>

                <!-- Block content -->
                <?php
                // Hiển thị tất cả lỗi trong PHP
                // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                // Truy vấn database để lấy danh sách
                // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
                include_once(__DIR__ . '/../../dbconnect.php');

                // 2. Chuẩn bị câu truy vấn $sql
                // Sử dụng HEREDOC của PHP để tạo câu truy vấn SQL với dạng dễ đọc, thân thiện với việc bảo trì code
                $sql = <<<EOT
        SELECT 
        dtt.dtt_ma,dtt.dtt_ngaylap,dtt.dtt_trangthai, httt.httt_ten, tv.tv_ten, tv.tv_dienthoai
        , SUM(khdtt.kh_dtt_dongia) AS TongThanhTien
    FROM `donthanhtoan` dtt
    JOIN `khoahoc_donthanhtoan` khdtt ON dtt.dtt_ma = khdtt.dtt_ma
    JOIN `thanhvien` tv ON dtt.tv_tendangnhap = tv.tv_tendangnhap
    JOIN `hinhthucthanhtoan` httt ON dtt.httt_ma = httt.httt_ma
    GROUP BY dtt.dtt_ma, dtt.dtt_ngaylap, dtt.dtt_trangthai, httt.httt_ten, tv.tv_ten, tv.tv_dienthoai
EOT;

                // 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
                $result = mysqli_query($conn, $sql);
//  var_dump($result);
//                      die;
                // 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
                $data = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $data[] = array(
                        'dtt_ma' => $row['dtt_ma'],
                        'dtt_ngaylap' => date('d/m/Y H:i:s', strtotime($row['dtt_ngaylap'])),
                        'dtt_trangthai' => $row['dtt_trangthai'],
                        'httt_ten' => $row['httt_ten'],
                        'tv_ten' => $row['tv_ten'],
                        'tv_dienthoai' => $row['tv_dienthoai'],
                        'TongThanhTien' => number_format($row['TongThanhTien'], 2, ".", ",") . ' vnđ',
                    );
                }
                ?>

                <!-- Nút thêm mới, bấm vào sẽ hiển thị form nhập thông tin Thêm mới -->
                <a href="create.php" class="btn btn-primary">
                    Thêm mới
                </a>
                </br> </br>
                <table id="tblDanhSach" class="table table-bordered table-hover table-sm table-responsive mt-2">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã đăng ký</th>
                            <th>Thành viên</th>
                            <th>Ngày lập</th>
                            <th>Hình thức thanh toán</th>
                            <th>Tổng thành tiền</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $dondathang) : ?>
                            <tr>
                                <td><?= $dondathang['dtt_ma'] ?></td>
                                <td><b><?= $dondathang['tv_ten'] ?></b><br />(<?= $dondathang['tv_dienthoai'] ?>)</td>
                                <td><?= $dondathang['dtt_ngaylap'] ?></td>
                                <td><span class="badge badge-primary"><?= $dondathang['httt_ten'] ?></span></td>
                                <td><?= $dondathang['TongThanhTien'] ?></td>
                                <td>
                                    <?php if ($dondathang['dtt_trangthai'] == 0) : ?>
                                        <span class="badge badge-danger">Chưa xử lý</span>
                                    <?php else : ?>
                                        <span class="badge badge-success">Đã kích hoạt khóa học</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Đơn hàng nào chưa thanh toán thì được phép phép Xóa, Sửa -->
                                    <?php if ($dondathang['dtt_trangthai'] == 0) : ?>
                                        <!-- Nút sửa, bấm vào sẽ hiển thị form hiệu chỉnh thông tin dựa vào khóa chính `dh_ma` -->
                                        <a href="edit.php?dtt_ma=<?= $dondathang['dtt_ma'] ?>" class="btn btn-warning">
                                            Sửa
                                        </a>
                                        </br></br>
                                        <!-- Nút xóa, bấm vào sẽ xóa thông tin dựa vào khóa chính `dh_ma` -->
                                        <button type="button" class="btn btn-danger btnDelete" data-dtt_ma="<?= $dondathang['dtt_ma'] ?>">
                                            Xóa
                                        </button>
                                    <?php else : ?>
                                        <!-- Đơn hàng nào đã thanh toán rồi thì không cho phép Xóa, Sửa (không hiển thị 2 nút này ra giao diện) 
                                        - Cho phép IN ấn ra giấy
                                        -->
                                        <!-- Nút in, bấm vào sẽ hiển thị mẫu in thông tin dựa vào khóa chính -->
                                        <a href="print.php?dtt_ma=<?= $dondathang['dtt_ma'] ?>" class="btn btn-success">
                                            In
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- End block content -->
            </main>
        </div>
    </div>         
  

    

    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>

    <!-- SweetAlert -->
    <!-- <script src="/learnforever.xyz/assets/vendor/sweetalert/sweetalert.js"></script> -->
    <script>
        $(document).ready(function() {
            // Yêu cầu DataTable quản lý datatable #tblDanhSach
            // $('#tblDanhSach').DataTable({
            //     dom: 'Blfrtip',
            //     buttons: [
            //         'copy', 'excel', 'pdf'
            //     ]
            // });

            $('#tblDanhSach').DataTable({
                dom: 'Blfrtip',
                "bProcessing": true,
                "bAutoWidth": false,
                "responsive": true,
                "buttons": [
                    'copy', 'excel', 'csv', 'pdf','print'
                ]  
            });

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

                            // 3. Lấy giá trị của thuộc tính (custom attribute HTML) 'dh_ma'
                            // var dh_ma = $(this).attr('data-dh_ma');
                            var dtt_ma = $(this).data('dtt_ma');
                            var url = "delete.php?dtt_ma=" + dtt_ma;

                            // Điều hướng qua trang xóa với REQUEST GET, có tham số dh_ma=...
                            location.href = url;
                        } else { // Nếu không đồng ý xóa
                            swal("Cẩn thận hơn nhé!");
                        }
                    });

            });
        });
    </script>
</body>
</html>