<?php
include_once __DIR__ . '/../../../vendor/autoload.php';


/* Note: any element you append to a document must reside inside of a Section. */

//Lấy dữ liệu
//1. Mở kết nối
include_once __DIR__ . '/../../../dbconnect.php';
//2. Chuẩn bị câu lệnh
$sql = "";

$result = mysqli_query($conn, $sql);
//4. Phân tách thành array PHP
$data= [] ;

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = array(
         
     );
 
 }   

//  $mpdf = new \Mpdf\Mpdf();
//  $mpdf->WriteHTML('<h1>Hello world!</h1>');
//  $mpdf->Output();
 

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->setDefaultFont('Tahoma');
$dompdf->setOptions($options);



// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$dompdf->loadHtml('<h1 style="color: red;"> Danh sách</h1>');
$dompdf->loadHtml($html);
// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();


