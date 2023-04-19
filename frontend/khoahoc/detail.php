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
<?php include_once __DIR__ . '/../layouts/meta.php'; ?>
    <title>Chi tiết khóa học| LearnForever.xyz</title>

    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <?php include_once __DIR__ . '/../layouts/style.php'?>

    <link href="/learnforever.xyz/frontend/css/style.css" type="text/css" rel="stylesheet" />

    <style>
        body {
            font-family: 'open sans';
            overflow-x: hidden;
        }

        img {
            max-width: 100%;
        }

        .preview {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        @media screen and (max-width: 996px) {
            .preview {
                margin-bottom: 20px;
            }
        }

        .preview-pic {
            -webkit-box-flex: 1;
            -webkit-flex-grow: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-height: 300px;
        }

        .preview-thumbnail.nav-tabs {
            border: none;
            margin-top: 15px;
        }

        .preview-thumbnail.nav-tabs li {
            width: 18%;
            margin-right: 2.5%;
        }

        .preview-thumbnail.nav-tabs li img {
            max-width: 100%;
            display: block;
        }

        .preview-thumbnail.nav-tabs li a {
            padding: 0;
            margin: 0;
        }

        .preview-thumbnail.nav-tabs li:last-of-type {
            margin-right: 0;
        }

        .tab-content {
            overflow: hidden;
        }

        .tab-content img {
            width: 100%;
            -webkit-animation-name: opacity;
            animation-name: opacity;
            -webkit-animation-duration: .3s;
            animation-duration: .3s;
        }

        .card {
            margin-top: 50px;
            background: #eee;
            padding: 3em;
            line-height: 1.5em;
        }

        @media screen and (min-width: 997px) {
            .wrapper {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
            }
        }

        .details {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .colors {
            -webkit-box-flex: 1;
            -webkit-flex-grow: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }

        .product-title,
        .price,
        .sizes,
        .colors {
            text-transform: UPPERCASE;
            font-weight: bold;
        }

        .checked,
        .price span {
            color: #ff9f1a;
        }

        .product-title,
        .rating,
        .product-description,
        .price,
        .vote,
        .sizes {
            margin-bottom: 15px;
        }

        .product-title {
            margin-top: 0;
        }

        .size {
            margin-right: 10px;
        }

        .size:first-of-type {
            margin-left: 40px;
        }

        .color {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
            height: 2em;
            width: 2em;
            border-radius: 2px;
        }

        .color:first-of-type {
            margin-left: 20px;
        }

        .add-to-cart,
        .like {
            background: #ff9f1a;
            padding: 1.2em 1.5em;
            border: none;
            text-transform: UPPERCASE;
            font-weight: bold;
            color: #fff;
            -webkit-transition: background .3s ease;
            transition: background .3s ease;
        }

        .add-to-cart:hover,
        .like:hover {
            background: #b36800;
            color: #fff;
        }

        .not-available {
            text-align: center;
            line-height: 2em;
        }

        .not-available:before {
            font-family: fontawesome;
            content: "\f00d";
            color: #fff;
        }

        .orange {
            background: #ff9f1a;
        }

        .green {
            background: #85ad00;
        }

        .blue {
            background: #0076ad;
        }

        .tooltip-inner {
            padding: 1.3em;
        }

        @-webkit-keyframes opacity {
            0% {
                opacity: 0;
                -webkit-transform: scale(3);
                transform: scale(3);
            }

            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

        @keyframes opacity {
            0% {
                opacity: 0;
                -webkit-transform: scale(3);
                transform: scale(3);
            }

            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    <main role="main" class="mb-2 bg-color" style="padding-bottom: 100px;">
        <!-- Block content -->
        <?php
        // Hiển thị tất cả lỗi trong PHP
        // Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
        // Không nên hiển thị lỗi trên môi trường Triển khai (Production)
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Truy vấn database
        // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
        include_once(__DIR__ . '/../../dbconnect.php');

        /* --- 
        --- 2.Truy vấn dữ liệu Sản phẩm 
        --- Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
        --- 
        */
        $kh_makhoahoc = $_GET['kh_makhoahoc'];
        $sqlSelectKhoaHoc = <<<EOT
            SELECT kh.kh_makhoahoc, kh.kh_tenkhoahoc, kh.kh_hocphi, kh.kh_hocphicu, kh.kh_mota_ngan, kh.kh_mota_chitiet, nkh.nkh_ten
            FROM `khoahoc` kh
            JOIN `nhomkhoahoc` nkh ON kh.nkh_ma = nkh.nkh_ma
            WHERE kh_makhoahoc = $kh_makhoahoc
EOT;

        // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record 
        $resultSelectKhoaHoc = mysqli_query($conn, $sqlSelectKhoaHoc);

        // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
        $khoahocRow;
        while ($row = mysqli_fetch_array($resultSelectKhoaHoc, MYSQLI_ASSOC)) {
            $khoahocRow = array(
                'kh_makhoahoc' => $row['kh_makhoahoc'],
                'kh_tenkhoahoc' => $row['kh_tenkhoahoc'],
                'kh_hocphi' => $row['kh_hocphi'],
                'kh_hocphi_formated' => number_format($row['kh_hocphi'], 2, ".", ",") . ' vnđ',
                'kh_hocphicu_formated' => number_format($row['kh_hocphicu'], 2, ".", ",") . ' vnđ',
                'kh_mota_ngan' => $row['kh_mota_ngan'],
                'kh_mota_chitiet' => $row['kh_mota_chitiet'],
                'nkh_ten' => $row['nkh_ten']
            );
        }
        /* --- End Truy vấn dữ liệu Sản phẩm --- */

        $sqlSelect = <<<EOT
            SELECT hkh.hkh_ma, hkh.hkh_tentaptin
            FROM `hinhkhoahoc` hkh
            WHERE hkh.kh_makhoahoc = $kh_makhoahoc
EOT;

        // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record 
        $result = mysqli_query($conn, $sqlSelect);

        $danhsachhinhanh = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $danhsachhinhanh[] = array(
                'hkh_ma' => $row['hkh_ma'],
                'hkh_tentaptin' => $row['hkh_tentaptin']
            );
        }
        /* --- End Truy vấn dữ liệu Hình ảnh khóa học --- */

        // Hiệu chỉnh dữ liệu theo cấu trúc để tiện xử lý
        $khoahocRow['danhsachhinhanh'] = $danhsachhinhanh;
        ?>

        <div class="container mt-4">
            <!-- Vùng ALERT hiển thị thông báo -->
            <div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
                <div id="thongbao">&nbsp;</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card">
                <div class="container-fliud">
                    <form name="frmkhoahocchitiet" id="frmkhoahocchitiet" method="post" action="">
                        <?php
                        $hinhkhoahocdautien = empty($khoahocRow['danhsachhinhanh'][0]) ? '' : $khoahocRow['danhsachhinhanh'][0];
                        ?>
                        <input type="hidden" name="kh_makhoahoc" id="kh_makhoahoc" value="<?= $khoahocRow['kh_makhoahoc'] ?>" />
                        <input type="hidden" name="kh_tenkhoahoc" id="kh_tenkhoahoc" value="<?= $khoahocRow['kh_tenkhoahoc'] ?>" />
                        <input type="hidden" name="kh_hocphi" id="kh_hocphi" value="<?= $khoahocRow['kh_hocphi'] ?>" />
                        <input type="hidden" name="hinhdaidien" id="hinhdaidien" value="<?= empty($hinhkhoahocdautien) ? '' : $hinhkhoahocdautien['hkh_tentaptin'] ?>" />

                        <div class="wrapper row">
                            <div class="preview col-md-6">
                                <!-- Nếu có hình khóa học nào => duyệt vòng lặp để hiển thị các hình ảnh -->
                                <?php if (count($khoahocRow['danhsachhinhanh']) > 0) : ?>
                                    <div class="preview-pic tab-content">
                                        <?php foreach ($khoahocRow['danhsachhinhanh'] as $hinhkhoahoc) : ?>
                                            <div class="tab-pane <?= ($hinhkhoahoc == $hinhkhoahocdautien) ? 'active' : '' ?>" id="pic-<?= $hinhkhoahoc['hkh_ma'] ?>">
                                                <img src="/learnforever.xyz/assets/uploads/<?= $hinhkhoahoc['hkh_tentaptin'] ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <ul class="preview-thumbnail nav nav-tabs">
                                        <?php foreach ($khoahocRow['danhsachhinhanh'] as $hinhkhoahoc) : ?>
                                            <li class="<?= ($hinhkhoahoc == $hinhkhoahocdautien) ? 'active' : '' ?>">
                                                <a data-target="#pic-<?= $hinhkhoahoc['hkh_ma'] ?>" data-toggle="tab">
                                                    <img src="/learnforever.xyz/assets/uploads/<?= $hinhkhoahoc['hkh_tentaptin'] ?>" />
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <!-- Không có hình khóa học nào => lấy ảnh mặc định -->
                                <?php else : ?>
                                    <div class="preview-pic tab-content">
                                        <div class="tab-pane active" id="pic-1">
                                            <img src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                        </div>
                                    </div>
                                    <ul class="preview-thumbnail nav nav-tabs">
                                        <li class="active">
                                            <a data-target="#pic-1" data-toggle="tab">
                                                <img src="/learnforever.xyz/assets/shared/img/default-image_600.png" />
                                            </a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="details col-md-6">
                                <h3 class="product-title"><?= $khoahocRow['kh_tenkhoahoc'] ?></h3>
                                <div class="rating">
                                    <div class="stars">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <span class="review-no">123 đánh giá</span>
                                </div>
                                <p class="product-description"><?= $khoahocRow['kh_mota_ngan'] ?></p>
                                <small class="text-muted">Giá cũ: <s><span><?= $khoahocRow['kh_hocphicu_formated'] ?></span></s></small>
                                <h4 class="price">Giá hiện tại: <span><?= $khoahocRow['kh_hocphi_formated'] ?></span></h4>
                                <!-- <p><?= $khoahocRow['kh_mota_ngan'] ?></p> -->
                                <p class="vote"><strong>100%</strong> Giảng dạy <strong>Chất lượng</strong>, đảm bảo <strong>Hiệu
                                        quả</strong>!</p>
                                
                                <div class="action">
                                    <a class="add-to-cart btn btn-default btn btn-warning" id="btnThemVaoGioHang">Đăng ký ngay</a>
                                    <a class="like btn btn-default btn btn-danger" href="#"><span class="fa fa-heart"></span></a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="container-fluid">
                <h3>Thông tin chi tiết về Khóa học</h3>
                <div class="row">
                    <div class="col course-detail">
                        <?= $khoahocRow['kh_mota_chitiet'] ?>
                    </div>
                </div>
            </div>
        </div>


        <?php
                    
                    //Chuẩn bị câu lệnh
                    $sqlSelectCDGY = "
                        SELECT *
                        FROM chudegopy;
                    ";
                    //Thực thi
                    $resultCDGY = mysqli_query($conn, $sqlSelectCDGY);
                    //Phan tách thành mảng array PHP
                    $dataCDGY = [];
                    while ($rowCDGY = mysqli_fetch_array($resultCDGY, MYSQLI_ASSOC)) {
                        $dataCDGY[] = array(
                            'cdgy_ma' => $rowCDGY['cdgy_ma'],
                            'cdgy_ten' => $rowCDGY['cdgy_ten'],
                        );
                    }

                       
                    // var_dump($data);die;
                ?>
        <div class="card">
            <form name="frmCreate" id="frmCreate" method="post" action="">
                <div class="container-fluid">
                    <h3>Bình luận</h3>
                    <h4>Email của bạn sẽ không được hiển thị công khai. </h4>
                    <div class="row form-comment">
                        <div class="col">
                        <!-- Họ tên: -->
                        <br/>
                        <input type="text" name="gy_hoten" id="gy_hoten" placeholder="Họ tên" class="form-control form_hoten-email" />
                        <br />
                        <!-- Email: -->
                        <input name="gy_email" id="gy_email" placeholder="Email" class="form-control form_hoten-email"></input>
                        <br/>
                        <!-- Nội dung: -->
                        <textarea name="gy_noidung" id="gy_noidung" class="form-control " placeholder="Nội dung" style="line-height: 50px; font-size: 1.6rem;"></textarea>
                        <br/>
                        <label for="">Chủ đề:</label>
                        <select name="cdgy_ma" id="cdgy_ma" style="font-size: 1.6rem;" class="form-control">
                            <option value="">Vui lòng chọn chủ đề</option>
                            <?php foreach($dataCDGY as $cdgy): ?>
                                <option value="<?= $cdgy['cdgy_ma'] ?>"><?= $cdgy['cdgy_ten'] ?></option>
                            
                            <?php endforeach; ?>

                        </select>
                        </br></br>
                        <button name="btnSave" id="btnSave" class="btn btn-primary btnSave" style="min-height: 35px; font-size: 1.5rem;">
                        Gửi bình luận
                        </button>


                        </div>
                    </div>
                </div>
            </form>
        </div>


        <?php
           

             

                    // Khi người dùng bấm lưu thì xử lý
                    if(isset($_POST['btnSave'])) {
                        if (!isset($_SESSION['tv_tendangnhap_logged'])){
                            $message = "Bạn cần phải đăng nhập mới có thể bình luận!";
                            echo "<script type='text/javascript'>alert('$message');</script>";
                            echo '<script>location.href = "/learnforever.xyz/frontend/auth/login.php";</script>';
                        } else {
                            //1. Mở kết nối đến database
                            // include_once __DIR__ . '/../../dbconnect.php';
                            //2. chuẩn bị câu lệnh
                            // $ten = htmlentities ($_POST['gy_hoten']);
                            $tv_tendangnhap=$_SESSION['tv_tendangnhap_logged'];
                            $ten = htmlentities ($_POST['gy_hoten']);
                            $email = htmlentities ($_POST['gy_email']);
                        
                            $noidung = htmlentities ($_POST['gy_noidung']);
                            $chude = htmlentities ($_POST['cdgy_ma']);
                            $sql = "INSERT INTO gopy(gy_hoten, gy_email, gy_noidung, cdgy_ma, tv_tendangnhap) VALUES ('$ten','$email', '$noidung', $chude, '$tv_tendangnhap' );";
                            // var_dump($sql);
                            // die;

                            //3. Thực thi
                            mysqli_query($conn, $sql);

                            //4. Thông báo

                            $message = "Cảm ơn đóng góp của bạn!";
                            echo "<script type='text/javascript'>alert('$message');</script>";
                            }



                        


                    }
                

           

?>

     <!-- End block content -->
    </main>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
    <script>
        function addKhoaHocVaoGioHang() {
            // Chuẩn bị dữ liệu gởi
            var dulieugoi = {
                kh_makhoahoc: $('#kh_makhoahoc').val(),
                kh_tenkhoahoc: $('#kh_tenkhoahoc').val(),
                kh_hocphi: $('#kh_hocphi').val(),
                hinhdaidien: $('#hinhdaidien').val(),
            };
            // console.log((dulieugoi));

            // Gọi AJAX đến API ở URL `/php/myhand/frontend/api/giohang-themsanpham.php`
            $.ajax({
                url: '/learnforever.xyz/frontend/api/giohang-themkhoahoc.php',
                method: "POST",
                dataType: 'json',
                data: dulieugoi,
                success: function(data) {
                    console.log(data);
                    var htmlString =
                        `Khóa học đã được đăng ký, chờ bạn thanh toán. <a href="/learnforever.xyz/frontend/thanhtoan/cart.php">Thanh toán ngay</a>.`;
                    $('#thongbao').html(htmlString);
                    // Hiện thông báo
                    $('.alert').removeClass('d-none').addClass('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#thongbao').html(htmlString);
                    // Hiện thông báo
                    $('.alert').removeClass('d-none').addClass('show');
                }
            });
        };

        // Đăng ký sự kiện cho nút Thêm vào giỏ hàng
        $('#btnThemVaoGioHang').click(function(event) {
            event.preventDefault();
            addKhoaHocVaoGioHang();
        });


      

   
          


      


    </script>
</body>

</html>