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

// Dompdf, Mpdf or Tcpdf (as appropriate)
$className = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf::class;
IOFactory::registerWriter('Pdf', $className);



Settings::setChartRenderer(\PhpOffice\PhpSpreadsheet\Chart\Renderer\JpGraph::class); // to use jpgraph/jpgraph
//or
Settings::setChartRenderer(\PhpOffice\PhpSpreadsheet\Chart\Renderer\MtJpGraphRenderer::class); // to use mitoteam/jpgraph



