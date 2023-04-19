<?php
include_once __DIR__ . '/../../../vendor/autoload.php';


/* Note: any element you append to a document must reside inside of a Section. */

//Lấy dữ liệu
//1. Mở kết nối
include_once __DIR__ . '/../../../dbconnect.php';
//2. Chuẩn bị câu lệnh
$sql = "SELECT * FROM donthanhtoan";

$result = mysqli_query($conn, $sql);
//4. Phân tách thành array PHP
$data= [] ;

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = array(
        'dtt_ma' => $row['dtt_ma'],
        'dtt_ngaylap' => $row['dtt_ngaylap'],
        'tv_tendangnhap' => $row['tv_tendangnhap'],
     );
 
 }   

 $html = "<table border='1' width='100%'>"
 . "<tr>"
     . "<th>Mã đơn</th>"
     . "<th>Ngày lập</th>"
     . "<th>Tài khoản</th>"
 . "</tr>";

foreach($data as $dtt) {
 $html .= "<tr>"
     . "<td>" . $dtt['dtt_ma'] . "</td>"
     . "<td>" . $dtt['dtt_ngaylap'] . "</td>"
     . "<td>" . $dtt['tv_tendangnhap']. "</td>"
     . "</tr>";
}

$html .= "</table>";



 $mpdf = new \Mpdf\Mpdf();
// $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
 $mpdf->WriteHTML('<h1 style="color: red; text-align: center;">Danh sách đơn thanh toán</h1>');
 $mpdf->WriteHTML($html);
 $mpdf->WriteHTML('<h3 style="text-align: center;">Hệ thống giáo dục trực tuyến học mãi</h3>');
 $mpdf->Output();