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
<html>

<head>
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>

    <title>Thêm thanh toán</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include_once(__DIR__ . '/../layouts/partials/sidebar.php'); ?>
            <!-- end sidebar -->

            <main role="main" class="col-md-10 ml-sm-auto px-4 mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Thêm mới đơn thanh toán</h1>
                </div>

                <!-- Block content -->
                <?php
                // Hiển thị tất cả lỗi trong PHP
                // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
                // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                // Truy vấn database
                // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
                include_once(__DIR__ . '/../../dbconnect.php');

                /*  --- 
                --- 2.Truy vấn dữ liệu Hình thức Thanh toán
                --- 
                */
                // Chuẩn bị câu truy vấn
                $sqlHinhThucThanhToan = "select * from `hinhthucthanhtoan`";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultHinhThucThanhToan = mysqli_query($conn, $sqlHinhThucThanhToan);

                $dataHinhThucThanhToan = [];
                while ($rowHinhThucThanhToan = mysqli_fetch_array($resultHinhThucThanhToan, MYSQLI_ASSOC)) {
                    $dataHinhThucThanhToan[] = array(
                        'httt_ma' => $rowHinhThucThanhToan['httt_ma'],
                        'httt_ten' => $rowHinhThucThanhToan['httt_ten'],
                    );
                }
                /* --- End Truy vấn dữ liệu Hình thức Thanh toán --- */

                /*  --- 
                --- 3.Truy vấn dữ liệu Khách hàng
                --- 
                */
                // Chuẩn bị câu truy vấn
                $sqlThanhVien = "select * from `thanhvien`";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultThanhVien = mysqli_query($conn, $sqlThanhVien);

                $dataThanhVien = [];
                while ($rowThanhVien = mysqli_fetch_array($resultThanhVien, MYSQLI_ASSOC)) {
                    // Sử dụng hàm sprintf() để chuẩn bị mẫu câu với các giá trị truyền vào tương ứng từng vị trí placeholder
                    $tv_tomtat = sprintf(
                        "Họ tên %s, số điện thoại: %s",
                        $rowThanhVien['tv_ten'],
                        $rowThanhVien['tv_dienthoai'],
                    );

                    $dataThanhVien[] = array(
                        'tv_tendangnhap' => $rowThanhVien['tv_tendangnhap'],
                        'tv_tomtat' => $tv_tomtat,
                    );
                }
                /* --- End Truy vấn dữ liệu Hình thức Thanh toán --- */

                /*  --- 
                --- 4.Truy vấn dữ liệu sản phẩm 
                --- 
                */
                // Chuẩn bị câu truy vấn khóa học
                $sqlKhoaHoc = "select * from `khoahoc`";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultKhoaHoc = mysqli_query($conn, $sqlKhoaHoc);

                $dataKhoaHoc = [];
                while ($rowKhoaHoc = mysqli_fetch_array($resultKhoaHoc, MYSQLI_ASSOC)) {
                    $dataKhoaHoc[] = array(
                        'kh_makhoahoc' => $rowKhoaHoc['kh_makhoahoc'],
                        'kh_hocphi' => $rowKhoaHoc['kh_hocphi'],
                        'kh_tenkhoahoc' => $rowKhoaHoc['kh_tenkhoahoc'],
                    );
                }
                // var_dump($dataSanPham);die;
                /* --- End Truy vấn dữ liệu  --- */
                ?>

                <!-- Form cho phép người dùng upload file lên Server bắt buộc phải có thuộc tính enctype="multipart/form-data" -->
                <form name="frmhinhkhoahoc" id="frmhinhkhoahoc" method="post" action="" enctype="multipart/form-data">
                    <fieldset id="donHangContainer">
                        <legend>Thông tin Đơn hàng</legend>
                        <div class="form-row">

                            <div class="col">
                                <div class="form-group">
                                    <label>Thành viên</label>
                                    <select name="tv_tendangnhap" id="tv_tendangnhap" class="form-control">
                                        <option value="">Vui lòng chọn thành viên</option>
                                        <?php foreach ($dataThanhVien as $thanhvien) : ?>
                                            <option value="<?= $thanhvien['tv_tendangnhap'] ?>"><?= $thanhvien['tv_tomtat'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Ngày lập</label>
                                    <input type="datetime-local" name="dtt_ngaylap" id="dtt_ngaylap" class="form-control" />
                                    <!-- <input type="datetime-local" name="dtt_ngaylap" id="dtt_ngaylap" class="form-control"/> -->
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Trạng thái thanh toán</label><br />
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="dtt_trangthai" id="dtt_trangthaithanhtoan-1" class="custom-control-input" value="0" checked>
                                        <label class="custom-control-label" for="dtt_trangthaithanhtoan-1">Chưa thanh toán</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="dtt_trangthai" id="dtt_trangthaithanhtoan-2" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="dtt_trangthaithanhtoan-2">Đã thanh toán</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Hình thức thanh toán</label>
                                    <select name="httt_ma" id="httt_ma" class="form-control">
                                    <option value="">Vui lòng chọn Hình thức thanh toán</option>
                                        <?php foreach ($dataHinhThucThanhToan as $httt) : ?>
                                            <option value="<?= $httt['httt_ma'] ?>"><?= $httt['httt_ten'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset id="chiTietDonHangContainer">
                        <legend>Thông tin Chi tiết Đơn thanh toán</legend>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="kh_makhoahoc">Khóa học</label>
                                    <select class="form-control" id="kh_makhoahoc" name="kh_makhoahoc">
                                        <option value="">Vui lòng chọn Khóa học</option>
                                        <?php foreach ($dataKhoaHoc as $khoahoc) : ?>
                                            <option value="<?= $khoahoc['kh_makhoahoc'] ?>" data-kh_hocphi="<?= $khoahoc['kh_hocphi'] ?>"><?= $khoahoc['kh_tenkhoahoc'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Xử lý</label><br />
                                    <button type="button" id="btnThemKhoaHoc" class="btn btn-secondary">Thêm vào đơn thanh toán</button>
                                </div>
                            </div>
                        </div>

                        <table id="tblChiTietDonHang" class="table table-bordered">
                            <thead>
                                <th>Khóa học</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Hành động</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </fieldset>

                    <button class="btn btn-primary" name="btnSave">Lưu</button>
                    <a href="index.php" class="btn btn-outline-secondary" name="btnBack" id="btnBack">Quay về</a>
                </form>
                </br>
                <?php
                // Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh
                if (isset($_POST['btnSave'])) {
                    // 1. Phân tách lấy dữ liệu người dùng gởi từ REQUEST POST
                    // Thông tin đơn hàng
                    $tv_tendangnhap = $_POST['tv_tendangnhap'];
                    $dtt_ngaylap = $_POST['dtt_ngaylap'];
                    $dtt_trangthai = $_POST['dtt_trangthai'];
                    $httt_ma = $_POST['httt_ma'];

                    // Thông tin các dòng chi tiết đơn hàng
                    $arr_kh_makhoahoc = $_POST['kh_makhoahoc'];                   // mảng array do đặt tên name="sp_ma[]"
                    
                    $arr_kh_dtt_dongia = $_POST['kh_dtt_dongia'];     // mảng array do đặt tên name="sp_dh_dongia[]"
                    // var_dump($kh_makhoahoc);die;

                    // 2. Thực hiện câu lệnh Tạo mới (INSERT) Đơn hàng
                    // Câu lệnh INSERT
                    $sqlInsertDonThanhToan = "INSERT INTO `donthanhtoan` (`dtt_ngaylap`,  `dtt_trangthai`, `httt_ma`, `tv_tendangnhap`) VALUES ('$dtt_ngaylap',  '$dtt_trangthai', '$httt_ma', '$tv_tendangnhap')";
                    // print_r($sql); die;

                    // Thực thi INSERT Đơn hàng
                    mysqli_query($conn, $sqlInsertDonThanhToan);

                    // 3. Lấy ID Đơn hàng mới nhất vừa được thêm vào database
                    // Do ID là tự động tăng (PRIMARY KEY và AUTO INCREMENT), nên chúng ta không biết được ID đă tăng đến số bao nhiêu?
                    // Cần phải sử dụng biến `$conn->insert_id` để lấy về ID mới nhất
                    // Nếu thực thi câu lệnh INSERT thành công thì cần lấy ID mới nhất của Đơn hàng để làm khóa ngoại trong Chi tiết đơn hàng
                    $dtt_ma = $conn->insert_id;

                    // 4. Duyệt vòng lặp qua mảng các dòng Sản phẩm của chi tiết đơn hàng được gởi đến qua request POST
                    for($i = 0; $i < count($arr_kh_makhoahoc); $i++) {
                        // 4.1. Chuẩn bị dữ liệu cho câu lệnh INSERT vào table
                        $kh_makhoahoc = $arr_kh_makhoahoc[$i];
                        $kh_dtt_dongia = $arr_kh_dtt_dongia[$i];

                        // 4.2. Câu lệnh INSERT
                        $sqlInsertKhoaHocDonThanhToan = "INSERT INTO `khoahoc_donthanhtoan` (`kh_makhoahoc`, `dtt_ma`,  `kh_dtt_dongia`) VALUES ($kh_makhoahoc, $dtt_ma, $kh_dtt_dongia)";

                        // 4.3. Thực thi INSERT
                        mysqli_query($conn, $sqlInsertKhoaHocDonThanhToan);
                    }

                    // 5. Thực thi hoàn tất, điều hướng về trang Danh sách
                    echo '<script>location.href = "index.php";</script>';
                }
                ?>
                <!-- End block content -->
            </main>
        </div>
    </div>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
    <script>
        // Đăng ký sự kiện Click nút Thêm Sản phẩm
        $('#btnThemKhoaHoc').click(function() {
            // debugger;
            // Lấy thông tin Sản phẩm
            var kh_makhoahoc = $('#kh_makhoahoc').val();
            var kh_hocphi = $('#kh_makhoahoc option:selected').data('kh_hocphi');
            var kh_tenkhoahoc = $('#kh_makhoahoc option:selected').text();
            var thanhtien = (kh_hocphi);
            
            // Tạo mẫu giao diện HTML Table Row
            var htmlTemplate = '<tr>'; 
            htmlTemplate += '<td>' + kh_tenkhoahoc + '<input type="hidden" name="kh_makhoahoc[]" value="' + kh_makhoahoc + '"/></td>';
            htmlTemplate += '<td>' + kh_hocphi + '<input type="hidden" name="kh_dtt_dongia[]" value="' + kh_hocphi + '"/></td>';
            htmlTemplate += '<td>' + thanhtien + '</td>';
            htmlTemplate += '<td><button type="button" class="btn btn-danger btn-delete-row">Xóa</button></td>';
            htmlTemplate += '</tr>';

            // Thêm vào TABLE BODY
            $('#tblChiTietDonHang tbody').append(htmlTemplate);

            // Clear
            $('#kh_makhoahoc').val('');
            // $('#soluong').val('');
        });

        // Đăng ký sự kiện cho tất cả các nút XÓA có sử dụng class .btn-delete-row
        $('#chiTietDonHangContainer').on('click', '.btn-delete-row', function() {

            $(this).parent().parent()[0].remove();
        });
    </script>
</body>

</html>