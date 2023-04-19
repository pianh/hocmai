<?php
//Truy vấn database để lấy danh sách
//1. Include file cấu hình kết nối database, khởi tạo kết nối $conn
include_once (__DIR__ . '/../../dbconnect.php');
//2. Chuẩn bị câu lệnh truy vấn $sql
$sql = <<<EOT
    SELECT httt.httt_ten, COUNT(*) AS SoLuong
    FROM `hinhthucthanhtoan` httt
    JOIN `donthanhtoan` dtt ON dtt.httt_ma = httt.httt_ma
    GROUP BY httt.httt_ma
EOT;
//3. Thực thi câu truy vấn SQL để lấy dữ liệu
$result = mysqli_query($conn, $sql);
//4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
//Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được select
//Ta sẽ tạo 1 mảng array để chứ các dữ liệu được trả về
$data  = [];
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $data[] = array (
        'TenHinhThucThanhToan' => $row['httt_ten'],
        'SoLuong' => $row['SoLuong']
    );
}
//5. Chuyển đổi dữ liệu về định dạng JSON
//Dữ liệu JSON, từ arry PHP ->JSON
echo json_encode($data);

