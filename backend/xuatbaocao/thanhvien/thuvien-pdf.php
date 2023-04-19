<?php
include_once __DIR__ . '/../../../vendor/autoload.php';


/* Note: any element you append to a document must reside inside of a Section. */

//Lấy dữ liệu
//1. Mở kết nối
include_once __DIR__ . '/../../../dbconnect.php';
//2. Chuẩn bị câu lệnh
$sql = "SELECT * FROM thanhvien";

$result = mysqli_query($conn, $sql);
//4. Phân tách thành array PHP
$data= [] ;

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = array(
         'tv_tendangnhap' => $row['tv_tendangnhap'],
         'tv_ten' => $row['tv_ten'],
         'tv_gioitinh' => $row['tv_gioitinh'],
         'tv_diachi' => $row['tv_diachi'],
         'tv_dienthoai' => $row['tv_dienthoai'],
         'tv_email' => $row['tv_email']
     );
 
 }   

 $html = "<table border='1' width='100%'>"
 . "<tr>"
     . "<th>Tên đăng nhập</th>"
     . "<th>Họ tên</th>"
     . "<th>Địa chỉ</th>"
     . "<th>Điện thoại</th>"
     . "<th>Email</th>"
 . "</tr>";

foreach($data as $tv) {
 $html .= "<tr>"
     . "<td>" . $tv['tv_tendangnhap'] . "</td>"
     . "<td>" . $tv['tv_ten'] . "</td>"
     . "<td>" . $tv['tv_diachi']. "</td>"
     . "<td>" . $tv['tv_dienthoai']. "</td>"
     . "<td>" . $tv['tv_email']. "</td>"
     . "</tr>";
}

$html .= "</table>";



//  $mpdf = new \Mpdf\Mpdf();
// $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
 $mpdf->WriteHTML('<h1 style="color: red; text-align: center;"> Danh sách thành viên </h1>');
 $mpdf->WriteHTML($html);
 $mpdf->WriteHTML('<h3 style="text-align: center;">Hệ thống giáo dục trực tuyến học mãi</h3>');
 $mpdf->Output();