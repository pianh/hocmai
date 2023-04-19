<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
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
        .hinhdaidien {
            /* width: 100px; */
            height: 200px;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    <main role="main" class="mb-2" style="padding-bottom: 350px;">
        <!-- Block content -->
        <?php
        // Truy vấn database để lấy danh sách
        // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
        include_once(__DIR__ . '/../../dbconnect.php');

        // Kiểm tra dữ liệu trong session
        $giohangdata = [];
        if (isset($_SESSION['giohangdata'])) {
            $giohangdata = $_SESSION['giohangdata'];
        } else {
            $giohangdata = [];
        }
        ?>

        <div class="container mt-4">
            <!-- Vùng ALERT hiển thị thông báo -->
            <div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
                <div id="thongbao">&nbsp;</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h1 class="text-center">Danh sách khóa học đã đăng ký</h1>
            <div class="row">
                <div class="col col-md-12">
                    <?php if (!empty($giohangdata)) : ?>
                        <table id="tblGioHang" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Tên khóa học</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="datarow">
                                <?php $stt = 1; ?>
                                <?php foreach ($giohangdata as $khoahoc) : ?>
                                    <tr>
                                        <td><?= $stt++ ?></td>
                                        <td>
                                            <?php if (empty($khoahoc['hinhdaidien'])) : ?>
                                                <img src="/learnforever.xyz/assets/shared/img/default-image_600.png" class="img-fluid hinhdaidien" />
                                            <?php else : ?>
                                                <img src="/learnforever.xyz/assets/uploads/<?= $khoahoc['hinhdaidien'] ?>" class="img-fluid hinhdaidien" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $khoahoc['kh_tenkhoahoc'] ?></td>
                                        
                                        <td><?= number_format($khoahoc['hocphi'], 2, ".", ",")?> vnđ</td>
                                        <td><?= number_format($khoahoc['hocphi'], 2, ".", ",")?> vnđ</td>
                                        <td>
                                            <!-- Nút xóa, bấm vào sẽ xóa thông tin dựa vào khóa chính `sp_ma` -->
                                            <a id="delete_<?= $stt ?>" data-kh_makhoahoc="<?= $khoahoc['kh_makhoahoc'] ?>" class="btn btn-danger btn-delete-sanpham">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>Bạn chưa chọn khóa học nào, xem các khóa học hiện có tại Trang chủ nhé!!!</h2>
                    <?php endif; ?>
                    <a href="/learnforever.xyz/index.php" class="btn btn-warning btn-md"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay
                        về trang chủ</a>
                    <a href="/learnforever.xyz/frontend/thanhtoan/thanhtoan.php" class="btn btn-primary btn-md"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Thanh toán</a>
                </div>
            </div>
        </div>

        <!-- End block content -->
    </main>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
    <script>
        $(document).ready(function() {
            function removeSanPhamVaoGioHang(id) {
                // Dữ liệu gởi
                var dulieugoi = {
                    kh_makhoahoc: id
                };

                // AJAX đến API xóa sản phẩm khỏi Giỏ hàng trong Session
                $.ajax({
                    url: '/learnforever.xyz/frontend/api/giohang-xoakhoahoc.php',
                    method: "POST",
                    dataType: 'json',
                    data: dulieugoi,
                    success: function(data) {
                        // Refresh lại trang
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        var htmlString = `<h1>Không thể xử lý</h1>`;
                        $('#thongbao').html(htmlString);
                        // Hiện thông báo
                        $('.alert').removeClass('d-none').addClass('show');
                    }
                });
            };

            // Đăng ký sự kiện cho các nút đang sử dụng class .btn-delete-sanpham
            $('#tblGioHang').on('click', '.btn-delete-sanpham', function(event) {
                // debugger;
                event.preventDefault();
                var id = $(this).data('kh_makhoahoc');

                console.log(id);
                removeSanPhamVaoGioHang(id);
            });

            // Cập nhật số lượng trong Giỏ hảng
            function capnhatSanPhamTrongGioHang(id) {
                // Dữ liệu gởi
                var dulieugoi = {
                    kh_makhoahoc: id
                };

                $.ajax({
                    url: '/php/myhand/frontend/api/giohang-capnhatsanpham.php',
                    method: "POST",
                    dataType: 'json',
                    data: dulieugoi,
                    success: function(data) {
                        // Refresh lại trang
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        var htmlString = `<h1>Không thể xử lý</h1>`;
                        $('#thongbao').html(htmlString);
                        // Hiện thông báo
                        $('.alert').removeClass('d-none').addClass('show');
                    }
                });
            };
            $('#tblGioHang').on('click', '.btn-capnhat-soluong', function(event) {
                // debugger;
                event.preventDefault();
                var id = $(this).data('sp-ma');
                var soluongmoi = $('#soluong_' + id).val();
                capnhatSanPhamTrongGioHang(id, soluongmoi);
            });
        });
    </script>
</body>

</html>