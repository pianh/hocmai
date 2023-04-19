<?php
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'csdlkhoahoc') or die('Xin lỗi, kết nối không được');
    $conn->query("SET NAMES 'utf8mb4'");
    $conn->query("SET CHARACTER SET utf8mb4");
    $conn->query("SET SESSION collation_connection = 'utf8mb4_general_ci'");


?>