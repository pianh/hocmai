<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}

// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__ . '/../../dbconnect.php');

// 2. Lấy thông tin người dùng gởi đến
$kh_makhoahoc = $_POST['kh_makhoahoc'];
$kh_tenkhoahoc = $_POST['kh_tenkhoahoc'];
$hocphi = $_POST['kh_hocphi'];
$hinhdaidien = $_POST['hinhdaidien'];

// 3. Lưu trữ giỏ hàng trong session
// Nếu khách hàng đặt hàng cùng sản phẩm đã có trong giỏ hàng => cập nhật lại Số lượng, Thành tiền
if (isset($_SESSION['giohangdata'])) {
    $data = $_SESSION['giohangdata'];
    $data[$kh_makhoahoc] = array(
        'kh_makhoahoc' => $kh_makhoahoc,
        'kh_tenkhoahoc' => $kh_tenkhoahoc,
        'hocphi' => $hocphi,
        'thanhtien' => ($hocphi),
        'hinhdaidien' => $hinhdaidien
    );

    // lưu dữ liệu giỏ hàng vào session
    $_SESSION['giohangdata'] = $data;
} else { // Nếu khách hàng đặt hàng sản phẩm chưa có trong giỏ hàng => thêm vào
    $data[$kh_makhoahoc] = array(
        'kh_makhoahoc' => $kh_makhoahoc,
        'kh_tenkhoahoc' => $kh_tenkhoahoc,
        'hocphi' => $hocphi,
        'thanhtien' => ($soluong * $gia),
        'hinhdaidien' => $hinhdaidien
    );

    // lưu dữ liệu giỏ hàng vào session
    $_SESSION['giohangdata'] = $data;
}

// 4. Chuyển đổi dữ liệu về định dạng JSON
// Dữ liệu JSON, từ array PHP -> JSON 
echo json_encode($_SESSION['giohangdata']);