<?php
//Truy vấn database để lấy danh sách
//1. Include file cấu hình kết nối database, khởi tạo kết nối $conn
include_once (__DIR__ . '/../../dbconnect.php');
//2. Chuẩn bị câu lệnh truy vấn $sql
$sqlSoLuongGopY = "select count(*) as SoLuong from `gopy`";
//3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sqlSoLuongGopY);
//4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
//Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được select
//Ta sẽ tạo 1 mảng array để chứ các dữ liệu được trả về
$dataSoLuongGopY = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $dataSoLuongGopY[] = array(
        'SoLuong' => $row['SoLuong']
    );
}
//5. Chuyển đổi dữ liệu về định dạng JSON
//Dữ liệu JSON, từ arry PHP ->JSON
echo json_encode($dataSoLuongGopY[0]);

