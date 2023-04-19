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
         'tv_ten' => $row['tv_ten'],
         'tv_gioitinh' => $row['tv_gioitinh'],
         'tv_diachi' => $row['tv_diachi'],
         'tv_dienthoai' => $row['tv_dienthoai'],
         'tv_email' => $row['tv_email']
     );
 
 }   


// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->setDefaultFont('Tahoma');
$dompdf->setOptions($options);

$html = "<table border='1' width = '100%'>"
    . "<tr>"
        . "<th>Họ tên</th>"
        . "<th>Địa chỉ</th>"
        . "<th>Điện thoại</th>"
        . "<th>Email</th>"
    . "</tr>";

foreach($data as $tv) {
    $html .= "<tr>"
        . "<td>" . $tv['tv_ten'] . "</td>"
        . "<td>" . $tv['tv_diachi']. "</td>"
        . "<td>" . $tv['tv_dienthoai']. "</td>"
        . "<td>" . $tv['tv_email']. "</td>"
        . "</tr>";
}

$html .= "</table>";
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$dompdf->loadHtml('<h1 style="color: red;"> Danh sách thành viên </h1>');
$dompdf->loadHtml($html);
// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();


