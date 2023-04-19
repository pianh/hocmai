<?php
include_once __DIR__ . '/../../../vendor/autoload.php';

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

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


// Adding an empty Section to the document...
$section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
$section->addText(
    'Danh sách đơn thanh toán',
    array('name' => 'Tahoma', 'size' => 16)
);

foreach($data as $dtt) {
    $section->addText(
        'Mã đơn: ' .$dtt['dtt_ma']
        . ' - Ngày lập đơn: ' .$dtt['dtt_ngaylap']
        . ' - Tài khoản: ' .$dtt['tv_tendangnhap']
    );
}

/*
 * Note: it's possible to customize font style of the Text element you add in three ways:
 * - inline;
 * - using named font style (new font style object will be implicitly created);
 * - using explicitly created font style object.
 */

// Adding Text element with font customized inline...
$section->addText(
    '"Kết thúc file đơn thanh toán"',
    array('name' => 'Tahoma', 'size' => 10)
);

// Adding Text element with font customized using named font style...
$fontStyleName = 'oneUserDefinedStyle';
$phpWord->addFontStyle(
    $fontStyleName,
    array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
);
// $section->addText(
//     '"The greatest accomplishment is not in never falling, '
//         . 'but in rising again after you fall." '
//         . '(Vince Lombardi)',
//     $fontStyleName
// );

// Adding Text element with font customized using explicitly created font style object...
$fontStyle = new \PhpOffice\PhpWord\Style\Font();
$fontStyle->setBold(true);
$fontStyle->setName('Tahoma');
$fontStyle->setSize(13);
$myTextElement = $section->addText('Hệ thống giáo dục trực tuyến Hocmai');
$myTextElement->setFontStyle($fontStyle);

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$filePath = __DIR__ . '/../../../assets/templates/word/danhsachdonthanhtoan.docx';
$objWriter->save($filePath);



/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */