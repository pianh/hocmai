<?php
// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}

$id=$_SESSION['tv_tendangnhap_logged'];
include_once __DIR__ . '/../../dbconnect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$sql = "SELECT * FROM thanhvien WHERE tv_tendangnhap='$id';";

$result = mysqli_query($conn, $sql);

//4. Phân tách thành mảng array
$data = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = array (
        'tv_ten' => $row['tv_ten'],
        'tv_giaovien' => $row['tv_giaovien'],
        'tv_quantri' => $row['tv_quantri']
    );
    $giaovien=$row['tv_giaovien'];
    $quantri=$row['tv_quantri'];
}


if ($id!='admin' && $giaovien != '1' && $quantri != '1') {
    $message = "Bạn không phải là thành viên quản trị website!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo '<script>location.href = "/learnforever.xyz/index.php";</script>';
    }
else if ($id !='admin' && $giaovien == 1) {
    echo '<script>location.href = "/learnforever.xyz/backend/videokhoahoc/index.php";</script>';
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/../layouts/meta.php'; ?>

    <title>Trang chủ Backend</title>

    <?php include_once __DIR__ . '/../layouts/style.php'?>
    <style>

    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../layouts/partials/sidebar.php' ?>

            
            <div class="col-md-10">
            </br>
                <h1>Bản tin Dashboard</h1>
                </br>
                <!-- Block content -->
                <div class="container-fluid pd-bottom-dasboard">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Tổng số khóa học</div>
                                <div class="card-body">
                                   <div id="baocaoKhoaHoc_SoLuong"></div> 
                                </div>
                                <button type="button" class="btn btn-danger" id="btnRefeshKhoaHoc_SoLuong">
                                    Refesh dữ liệu
                                </button>
                            </div>                           
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Tổng số thành viên</div>
                                <div class="card-body">
                                   <div id="baocaoThanhVien_SoLuong"></div> 
                                </div>
                                <button type="button" class="btn btn-danger" id="btnRefeshThanhVien_SoLuong">
                                    Refesh dữ liệu
                                </button>
                            </div>     
                            
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Tổng số đơn thanh toán</div>
                                <div class="card-body">
                                   <div id="baocaoDonThanhToan_SoLuong"></div> 
                                </div>
                                <button type="button" class="btn btn-danger" id="btnRefeshDonThanhToan_SoLuong">
                                    Refesh dữ liệu
                                </button>
                            </div>    
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Tổng số góp ý</div>
                                <div class="card-body">
                                   <div id="baocaoGopY_SoLuong"></div> 
                                </div>
                                <button type="button" class="btn btn-danger" id="btnRefeshGopY_SoLuong">
                                    Refesh dữ liệu
                                </button>
                            </div>   
                        </div>


                        

                    </div>
                </br></br>
                <div class="row">
                    <div class="col-md-4 ">
                        <canvas id="chartOfobjChartThongKeNhomKhoaHoc"></canvas>
                        <button id="refreshThongKeNhomKhoaHoc" class="btn btn-primary">
                            Refresh biểu đồ nhóm khóa học
                        </button>
                    </div>

                    <div class="col-md-4">
                            <canvas id="chartOfobjChartThongKeBaigiangKhoaHoc"></canvas>
                            <button id="refreshThongKeBaigiangKhoaHoc" class="btn btn-primary">
                                Refresh biểu đồ thống kê bài giảng
                            </button>
                    </div>
                    <div class="col-md-4">
                            <canvas id="chartOfobjChartThongKeVideoKhoaHoc"></canvas>
                            <button id="refreshThongKeVideoKhoaHoc" class="btn btn-primary">
                                Refresh biểu đồ thống kê Video
                            </button>
                    </div>

                </div>
                </br>
                </div>
                <!-- End block content -->

            </div>
        
        </div>
    </div>

    
    <!-- Footer -->
    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
    <!-- Nhúng file quản lý phần SCRIP JAVASCRIP -->
    <?php include_once __DIR__ . '/../layouts/scripts.php' ?>
    <script src="/learnforever.xyz/assets/vendor/chart.js/chart.min.js"></script>
    <script>
        // Dùng jquery
        $(function() {
            $('#btnRefeshKhoaHoc_SoLuong').click(function() {
                //Nhờ AJAX gởi request đến APT
                $.ajax('/learnforever.xyz/backend/api/baocao-tongsokhoahoc.php', {
                    success: function(data) {
                        var dataObj = JSON.parse(data);
                        var htmlString = `<h1>${dataObj.SoLuong}</h1>`;
                        $('#baocaoKhoaHoc_SoLuong').html(htmlString);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var htmlString = '<h1>Không thể xử lý. Lỗi ${errorThrown}</h1>';
                        $('#baocaoKhoaHoc_SoLuong').html(htmlString);
                    }
                });
            });

            $('#btnRefeshThanhVien_SoLuong').click(function() {
                //Nhờ AJAX gởi request đến APT
                $.ajax('/learnforever.xyz/backend/api/baocao-tongsothanhvien.php', {
                    success: function(data) {
                        var dataObj = JSON.parse(data);
                        var htmlString = `<h1>${dataObj.SoLuong}</h1>`;
                        $('#baocaoThanhVien_SoLuong').html(htmlString);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var htmlString = '<h1>Không thể xử lý. Lỗi ${errorThrown}</h1>';
                        $('#baocaoThanhVien_SoLuong').html(htmlString);
                    }
                });
            });

            $('#btnRefeshDonThanhToan_SoLuong').click(function() {
                //Nhờ AJAX gởi request đến APT
                $.ajax('/learnforever.xyz/backend/api/baocao-tongsodonthanhtoan.php', {
                    success: function(data) {
                        var dataObj = JSON.parse(data);
                        var htmlString = `<h1>${dataObj.SoLuong}</h1>`;
                        $('#baocaoDonThanhToan_SoLuong').html(htmlString);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var htmlString = '<h1>Không thể xử lý. Lỗi ${errorThrown}</h1>';
                        $('#baocaoDonThanhToan_SoLuong').html(htmlString);
                    }
                });
            });


            $('#btnRefeshGopY_SoLuong').click(function() {
                //Nhờ AJAX gởi request đến APT
                $.ajax('/learnforever.xyz/backend/api/baocao-tongsogopy.php', {
                    success: function(data) {
                        var dataObj = JSON.parse(data);
                        var htmlString = `<h1>${dataObj.SoLuong}</h1>`;
                        $('#baocaoGopY_SoLuong').html(htmlString);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var htmlString = '<h1>Không thể xử lý. Lỗi ${errorThrown}</h1>';
                        $('#baocaoGopY_SoLuong').html(htmlString);
                    }
                });
            });

            //Vẽ biểu đồ thống kê Nhóm khóa học sử dụng ChartJS
            var $objChartThongKeNhomKhoaHoc;
            var $chartOfobjChartThongKeNhomKhoaHoc =
            document.getElementById("chartOfobjChartThongKeNhomKhoaHoc").getContext("2d");

                $('#refreshThongKeNhomKhoaHoc').click(function() {
                    $.ajax('/learnforever.xyz/backend/api/baocao-thongkenhomkhoahoc.php', {
                        success: function(response) {
                            var data = JSON.parse(response);
                            var myLabels = [];
                            var myData = [];
                            $(data).each(function() {
                                myLabels.push((this.TenNhomKhoaHoc));  // Giống dữ liệu API trả về
                                myData.push(this.SoLuong);
                            });
                            myData.push(0); // tạo dòng số liệu 0
                            if (typeof $objChartThongKeNhomKhoaHoc !== "undefined") {
                                $objChartThongKeNhomKhoaHoc.destroy();
                            }
                            $objChartThongKeNhomKhoaHoc = new Chart($chartOfobjChartThongKeNhomKhoaHoc, {
                            // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                            type: "bar",
                            data: {
                                labels: myLabels,
                                datasets: [{
                                data: myData,
                                borderColor: "#b99204",
                                backgroundColor: "#9bbb58",
                                borderWidth: 1
                                }]
                            },
                            // Cấu hình dành cho biểu đồ của ChartJS
                            options: {
                                legend: {
                                    display: false,
                                    text: "Tên nhóm khóa học"
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: "Thống kê nhóm khóa học"
                                    },
                                    subtitle: {
                                        display: true,
                                        text: "Biểu đồ thống kế nhóm khóa học tại learnforever.xyz"
                                    }
                                },
                                responsive: true
                            }
                            });


                        }
                    });
                });


             //Vẽ biểu đồ thống kê Nhóm khóa học sử dụng ChartJS
             var $objChartThongKeBaigiangKhoaHoc;
            var $chartOfobjChartThongKeBaigiangKhoaHoc =
            document.getElementById("chartOfobjChartThongKeBaigiangKhoaHoc").getContext("2d");

                $('#refreshThongKeBaigiangKhoaHoc').click(function() {
                    $.ajax('/learnforever.xyz/backend/api/baocao-thongkebaigiang.php', {
                        success: function(response) {
                            var data = JSON.parse(response);
                            var myLabels = [];
                            var myData = [];
                            $(data).each(function() {
                                myLabels.push((this.TenKhoaHoc));  // Giống dữ liệu API trả về
                                myData.push(this.SoLuong);
                            });
                            myData.push(0); // tạo dòng số liệu 0
                            if (typeof $objChartThongKeBaigiangKhoaHoc !== "undefined") {
                                $objChartThongKeBaigiangKhoaHoc.destroy();
                            }
                            $objChartThongKeBaigiangKhoaHoc = new Chart($chartOfobjChartThongKeBaigiangKhoaHoc, {
                            // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                            type: "bar",
                            data: {
                                labels: myLabels,
                                datasets: [{
                                data: myData,
                                borderColor: "#f1bf0b",
                                backgroundColor: "#f1bf0b",
                                borderWidth: 1
                                }]
                            },
                            // Cấu hình dành cho biểu đồ của ChartJS
                            options: {
                                legend: {
                                    display: false
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: "Thống kê nhóm khóa học"
                                    },
                                    subtitle: {
                                        display: true,
                                        text: "Biểu đồ thống kế nhóm khóa học tại LearnForever.xyz"
                                    }
                                },
                                responsive: true
                            }
                            });


                        }
                    });
                });


            //Vẽ biểu đồ thống kê Hình thức thanh toán sử dụng ChartJS
            var $objChartThongKeVideoKhoaHoc;
            var $chartOfobjChartThongKeVideoKhoaHoc =
            document.getElementById("chartOfobjChartThongKeVideoKhoaHoc").getContext("2d");

                $('#refreshThongKeVideoKhoaHoc').click(function() {
                    $.ajax('/learnforever.xyz/backend/api/baocao-thongkevideokhoahoc.php', {
                        success: function(data) {
                            var data = JSON.parse(data);
                            var myLabels = [];
                            var myData = [];
                            $(data).each(function() {
                                myLabels.push((this.TenKhoaHoc));  // Giống dữ liệu API trả về
                                myData.push(this.SoLuong);
                            });
                            myData.push(0); // tạo dòng số liệu 0
                            if (typeof $objChartThongKeVideoKhoaHoc !== "undefined") {
                                $objChartThongKeVideoKhoaHoc.destroy();
                            }
                            $objChartThongKeVideoKhoaHoc = new Chart($chartOfobjChartThongKeVideoKhoaHoc, {
                            // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                            type: "bar",
                            data: {
                                labels: myLabels,
                                datasets: [{
                                data: myData,
                                borderColor: "#9ad0f5",
                                backgroundColor: "#ed7e30",
                                borderWidth: 1
                                }]
                            },
                            // Cấu hình dành cho biểu đồ của ChartJS
                            options: {
                                legend: {
                                    display: false
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: "Thống kê video khóa học"
                                    },
                                    subtitle: {
                                        display: true,
                                        text: "Biểu đồ thống kế video khóa học"
                                    }
                                },
                                responsive: true
                            }
                            });


                        }
                    });
                }); 




        });


       


    </script>

</body>
</html>