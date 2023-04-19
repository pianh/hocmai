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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> -->
    <?php include_once(__DIR__ . '/../layouts/style.php'); ?>


    <style>
        .homepage-slider-img {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    

    <main role="main" class="mb-2" style="padding-bottom: 100px;">
        <?php
            include_once(__DIR__ . '/../../dbconnect.php');


            
            $sqlSelectNhomKhoaHoc = <<<EOT
            SELECT nkh.nkh_ma, nkh.nkh_ten, COUNT(*) soluongkhoahoc
            FROM `nhomkhoahoc` nkh
            LEFT JOIN `khoahoc` kh ON nkh.nkh_ma = kh.nkh_ma
            GROUP BY nkh.nkh_ma, nkh.nkh_ten
EOT;
        
        // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record 
        $resultSelectNhomKhoaHoc = mysqli_query($conn, $sqlSelectNhomKhoaHoc);
        
        // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
        // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
        // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
        $nhomkhoahocData = [];
        while ($row = mysqli_fetch_array($resultSelectNhomKhoaHoc, MYSQLI_ASSOC)) {
            $loaisanphamData[] = array(
                'nkh_ma' => $row['nkh_ma'],
                'nkh_ten' => $row['nkh_ten'],
                'soluongkhoahoc' => $row['soluongkhoahoc'],
            );
        }


        /* --- 
           --- 4.Truy vấn dữ liệu Khuyến mãi
           --- 
        */
        $sqlSelectKhuyenMai = <<<EOT
            SELECT km.km_ma, km.km_ten, km_noidung, km_tungay, km_denngay, COUNT(*) soluongkhoahoc
            FROM `khuyenmai` km
            LEFT JOIN `khoahoc` kh ON km.km_ma = kh.km_ma
            GROUP BY km.km_ma, km.km_ten, km_noidung, km_tungay, km_denngay
EOT;
        
        // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record 
        $resultSelectKhuyenMai = mysqli_query($conn, $sqlSelectKhuyenMai);
        
        // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
        // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
        // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
        $khuyenmaiData = [];
        while ($row = mysqli_fetch_array($resultSelectKhuyenMai, MYSQLI_ASSOC)) {
            $khuyenmaiData[] = array(
                'km_ma' => $row['km_ma'],
                'km_ten' => $row['km_ten'],
                'km_noidung' => $row['km_noidung'],
                'km_tungay' => $row['km_tungay'],
                'km_denngay' => $row['km_denngay'],
                'soluongkhoahoc' => $row['soluongkhoahoc'],
            );
        }
        /* --- End Truy vấn dữ liệu Nhà sản xuất --- */
        
        /* --- 
           --- 5.Truy vấn dữ liệu Sản phẩm theo keyword tìm kiếm
           --- 
        */
        // Giữ lại keyword mà người dùng tìm kiếm
        $keyword_tenkhoahoc = isset($_GET['keyword_tenkhoahoc']) ? $_GET['keyword_tenkhoahoc'] : '';
        $keyword_nhomkhoahoc = isset($_GET['keyword_nhomkhoahoc']) ? $_GET['keyword_nhomkhoahoc'] : [];
        $keyword_khuyenmai = isset($_GET['keyword_khuyenmai']) ? $_GET['keyword_khuyenmai'] : [];
        $keyword_sotientu = isset($_GET['keyword_sotientu']) ? $_GET['keyword_sotientu'] : 0;
        $keyword_sotienden = isset($_GET['keyword_sotienden']) ? $_GET['keyword_sotienden'] : 50000000;
        
        // Câu lệnh query động tùy theo yêu cầu tìm kiếm của người dùng
        $sqlDanhSachKhoaHoc = <<<EOT
            SELECT kh.kh_makhoahoc, kh.kh_tenkhoahoc, kh.kh_hocphi, kh.kh_hocphicu, kh.kh_mota_ngan, nkh.nkh_ten, MAX(hkh.hkh_tentaptin) AS hkh_tentaptin
            FROM `khoahoc` kh
            JOIN `nhomkhoahoc` nkh ON kh.nkh_ma = nkh.nkh_ma
            LEFT JOIN `hinhkhoahoc` hkh ON kh.hkh_ma = hkh.hkh_ma
            LEFT JOIN `khuyenmai` km ON kh.km_ma = km.km_ma
        
EOT;
        
        // Tìm theo tên sản phẩm
        $sqlWhereArr = [];
        if (!empty($keyword_tensanpham)) {
            $sqlWhereArr[] = "kh.kh_tenkhoahoc LIKE '%$keyword_tenkhoahoc%'";
        }
        // Tìm theo loại sản phẩm
        if (!empty($keyword_nhomkhoahoc)) {
            $value = implode(',', $keyword_nhomkhoahoc);
            $sqlWhereArr[] = "nkh.nkh_ma IN ($value)";
        }
        // Tìm theo khuyến mãi
        if (!empty($keyword_khuyenmai)) {
            $value = implode(',', $keyword_khuyenmai);
            $sqlWhereArr[] = "km.km_ma IN ($value)";
        }
        // Tìm theo khoảng giá tiền
        if (!empty($keyword_sotientu) && !empty($keyword_sotienden)) {
            $sqlWhereArr[] = "kh.kh_hocphi BETWEEN $keyword_sotientu AND $keyword_sotienden";
        }
        
        // Câu lệnh cuối cùng
        if (count($sqlWhereArr) > 0) {
            $sqlWhere = "WHERE " . implode(' AND ', $sqlWhereArr);
            $sqlDanhSachKhoaHoc .= $sqlWhere;
        }
        $sqlDanhSachKhoaHoc .= <<<EOT

            GROUP BY kh.kh_makhoahoc, kh.kh_tenkhoahoc, kh.kh_hocphi, kh.kh_hocphicu, kh.kh_mota_ngan,  nkh.nkh_ten
EOT;
        
        // Thực thi câu truy vấn SQL để lấy về dữ liệu
        $result = mysqli_query($conn, $sqlDanhSachKhoaHoc);
        
        // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
        // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
        // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
        $dataDanhSachKhoaHoc = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $dataDanhSachKhoaHoc[] = array(
                    'kh_makhoahoc' => $row['kh_makhoahoc'],
                    'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                    'kh_hocphi' => number_format($row['kh_hocphi'], 2, ".", ",") . ' vnđ',
                    'kh_hocphicu' => number_format($row['kh_hocphicu'], 2, ".", ","),
                    'kh_mota_ngan' => $row['kh_mota_ngan'],
                    'nkh_ten' => $row['nkh_ten'],
                    'hkh_tentaptin' => $row['hkh_tentaptin'],
                );
            }
        // dd($sqlWhereArr, $sqlWhere, $sqlDanhSachSanPham, $dataDanhSachSanPham);
        
        // Yêu cầu `Twig` vẽ giao diện được viết trong file `frontend/product/search.html.twig`
        // echo $twig->render(
        //     'frontend/product/search.html.twig',
        //     [
        //         // Danh mục tiêu chí tìm kiếm
        //         'danhsachloaisanpham' => $loaisanphamData,
        //         'danhsachnhasanxuat' => $nhasanxuatData,
        //         'danhsachkhuyenmai' => $khuyenmaiData,
        //         'danhsachsanpham' => $dataDanhSachSanPham,
        
        //         // Keyword người dùng đã tìm kiếm
        //         'keyword_tensanpham' => $keyword_tensanpham,
        //         'keyword_loaisanpham' => $keyword_loaisanpham,
        //         'keyword_nhasanxuat' => $keyword_nhasanxuat,
        //         'keyword_khuyenmai' => $keyword_khuyenmai,
        //         'keyword_sotientu' => $keyword_sotientu,
        //         'keyword_sotienden' => $keyword_sotienden,
        //     ]
        // );


        ?>
    </main>

  





    <!-- footer -->
    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->




</body>

</html>