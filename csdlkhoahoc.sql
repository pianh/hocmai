-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221009.23995b3c73
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2022 at 08:02 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csdlkhoahoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `baigiang`
--

CREATE TABLE `baigiang` (
  `bg_ma` int(11) NOT NULL,
  `bg_bai` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bg_tenbai` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bg_tentaptin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kh_makhoahoc` int(11) DEFAULT NULL,
  `video_bai` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `baigiang`
--

INSERT INTO `baigiang` (`bg_ma`, `bg_bai`, `bg_tenbai`, `bg_tentaptin`, `kh_makhoahoc`, `video_bai`) VALUES
(12, 'Bài 1', NULL, '20221204190310_DE.pdf', 1, NULL),
(14, 'Bài 2', NULL, '20221204190319_DE.pdf', 1, NULL),
(15, 'Bài 3', NULL, '20221204190328_DE.pdf', 1, NULL),
(16, 'Bài 4', NULL, '20221204190400_DE11.2.pdf', 1, NULL),
(17, 'Bài 5', NULL, '20221204190733_DE.pdf', 1, NULL),
(18, 'Bài 1', NULL, '20221204191003_De_PEN_I_N3_so_10-_2021.pdf', 5, NULL),
(19, 'Bài 2', NULL, '20221204191010_De_PEN_I_N3_so_10-_2021.pdf', 5, NULL),
(20, 'Bài 3', NULL, '20221204191017_De_PEN_I_N3_so_10-_2021.pdf', 5, NULL),
(21, 'Bài 1', NULL, '20221204191221_DBG.pdf', 7, NULL),
(22, 'Bài 2', NULL, '20221204191236_NST.pdf', 7, NULL),
(23, 'Bài 1', NULL, '20221204193820_DE1.pdf', 4, NULL),
(24, 'Bài 2', NULL, '20221204193834_DE5.pdf', 4, NULL),
(25, 'Bài 3', NULL, '20221204193844_DE3.pdf', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chudegopy`
--

CREATE TABLE `chudegopy` (
  `cdgy_ma` int(11) NOT NULL,
  `cdgy_ten` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chudegopy`
--

INSERT INTO `chudegopy` (`cdgy_ma`, `cdgy_ten`) VALUES
(1, 'Góp ý khoá học'),
(2, 'Góp ý giáo viên'),
(3, 'Góp ý cải thiện website'),
(4, 'Góp ý khác');

-- --------------------------------------------------------

--
-- Table structure for table `donthanhtoan`
--

CREATE TABLE `donthanhtoan` (
  `dtt_ma` int(11) NOT NULL,
  `dtt_ngaylap` datetime DEFAULT NULL,
  `dtt_trangthai` int(11) NOT NULL,
  `httt_ma` int(11) DEFAULT NULL,
  `tv_tendangnhap` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `donthanhtoan`
--

INSERT INTO `donthanhtoan` (`dtt_ma`, `dtt_ngaylap`, `dtt_trangthai`, `httt_ma`, `tv_tendangnhap`) VALUES
(4, '2022-11-13 00:00:00', 1, 1, 'admin'),
(5, '2022-11-14 00:00:00', 1, 1, 'test1'),
(6, '2022-11-14 00:00:00', 1, 3, 'test1'),
(7, '2022-11-14 00:00:00', 0, 1, 'test1'),
(8, '2022-11-14 00:00:00', 0, 2, 'admin'),
(9, '2022-11-14 00:00:00', 0, 1, 'admin'),
(10, '2022-11-14 00:00:00', 0, 1, 'admin'),
(11, '2022-11-14 00:00:00', 0, 1, 'admin'),
(12, '2022-11-14 00:00:00', 0, 2, 'admin'),
(15, '2022-11-14 00:00:00', 0, 2, 'admin'),
(16, '2022-11-14 00:00:00', 0, 2, 'admin'),
(17, '2022-11-14 00:00:00', 0, 1, 'admin'),
(18, '2022-11-14 00:00:00', 0, 1, 'admin'),
(19, '2022-11-14 00:00:00', 0, 2, 'admin'),
(20, '2022-11-14 00:00:00', 0, 2, 'admin'),
(21, '2022-11-14 00:00:00', 0, 2, 'admin'),
(22, '2022-11-14 00:00:00', 0, 1, 'admin'),
(23, '2022-11-14 00:00:00', 0, 1, 'admin'),
(24, '2022-11-14 00:00:00', 0, 3, 'admin'),
(25, '2022-11-14 00:00:00', 0, 3, 'admin'),
(26, '2022-11-14 00:00:00', 0, 2, 'admin'),
(27, '2022-11-14 00:00:00', 0, 1, 'admin'),
(28, '2022-11-14 00:00:00', 0, 3, 'admin'),
(29, '2022-11-14 00:00:00', 0, 1, 'admin'),
(30, '2022-11-14 00:00:00', 0, 1, 'admin'),
(31, '2022-11-14 00:00:00', 0, 2, 'admin'),
(32, '2022-11-14 00:00:00', 0, 3, 'admin'),
(33, '2022-11-14 00:00:00', 0, 1, 'admin'),
(34, '2022-11-14 00:00:00', 0, 1, 'admin'),
(35, '2022-11-14 00:00:00', 0, 1, 'admin'),
(36, '2022-11-14 00:00:00', 0, 3, 'admin'),
(37, '2022-11-14 00:00:00', 0, 1, 'admin'),
(38, '2022-11-14 00:00:00', 0, 1, 'admin'),
(39, '2022-11-14 00:00:00', 0, 3, 'admin'),
(40, '2022-11-14 00:00:00', 0, 2, 'admin'),
(41, '2022-11-14 00:00:00', 0, 1, 'admin'),
(42, '2022-11-14 00:00:00', 0, 1, 'admin'),
(43, '2022-11-14 00:00:00', 0, 1, 'admin'),
(44, '2022-11-14 00:00:00', 0, 3, 'admin'),
(45, '2022-11-14 00:00:00', 0, 2, 'admin'),
(46, '2022-11-14 00:00:00', 0, 1, 'admin'),
(47, '2022-11-14 00:00:00', 0, 1, 'admin'),
(48, '2022-11-14 00:00:00', 0, 1, 'admin'),
(49, '2022-11-14 00:00:00', 0, 3, 'admin'),
(50, '2022-11-14 00:00:00', 0, 1, 'admin'),
(51, '2022-11-14 00:00:00', 0, 2, 'admin'),
(52, '2022-11-15 00:00:00', 0, 3, 'admin'),
(53, '2022-11-15 00:00:00', 0, 1, 'admin'),
(54, '2022-11-17 00:00:00', 0, 3, 'admin'),
(55, '2022-11-19 00:00:00', 0, 1, 'test1'),
(56, '2022-11-23 03:14:00', 1, 5, 'lkm'),
(60, '2022-11-10 21:29:00', 0, 5, 'lkm'),
(61, '2022-11-10 21:29:00', 0, 5, 'lkm'),
(63, '2022-11-01 21:29:00', 0, 1, 'lkm'),
(64, '2022-11-11 21:32:00', 0, 5, 'lkm'),
(65, '2022-11-28 00:00:00', 0, 1, 'test1'),
(66, '2022-11-28 00:00:00', 0, 1, 'test1'),
(67, '2022-11-28 00:00:00', 0, 1, 'test1');

-- --------------------------------------------------------

--
-- Table structure for table `gopy`
--

CREATE TABLE `gopy` (
  `gy_ma` int(11) NOT NULL,
  `gy_hoten` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gy_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gy_dienthoai` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gy_noidung` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdgy_ma` int(11) NOT NULL,
  `tv_tendangnhap` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gopy`
--

INSERT INTO `gopy` (`gy_ma`, `gy_hoten`, `gy_email`, `gy_dienthoai`, `gy_noidung`, `cdgy_ma`, `tv_tendangnhap`) VALUES
(1, 'Nguyễn B', 'b@gmail.com', '0987654356', 'abcxyz', 2, 'admin'),
(4, 'Nguyễn B', 'b@gmail.com', '0987654356', 'Kh&oacute;a học rất hay', 1, 'admin'),
(5, 'Nguyễn B', 'b@gmail.com', '0987654356', 'khóa học rất hay', 1, 'admin'),
(6, 'Nguyễn B', 'c@gmail.com', '0987654356', 'khóa học tuyệt vời', 1, 'admin'),
(7, 'Nguyễn B', 'c@gmail.com', '0987654356', 'tuyệt vời', 1, 'admin'),
(8, 'Nguyễn B', 'c@gmail.com', '0987654356', 'tuyệt vời lắm', 1, 'admin'),
(9, 'Nguyễn Van C', 'b@gmail.com', '0987654356', 'tuyệt vời lắm nha', 1, 'admin'),
(10, 'Nguyễn B', 'c@gmail.com', '0987654356', 'tuyệt vời lắm nha', 1, 'admin'),
(11, 'admin', 'b@gmail.com', '0987654356', 'tuyệt vời lắm nha', 1, 'admin'),
(12, 'Nguyễn Van C', 'c@gmail.com', '0987654356', 'tuyệt vời lắm nha', 1, 'admin'),
(13, 'Nguyễn Van C', 'c@gmail.com', '0987654356', 'Rất hay', 1, 'admin'),
(14, 'Nguyễn Van C', 'c@gmail.com', '0987654356', 'Giao vien day rat hay', 2, 'admin'),
(15, 'Nguyễn Duy Anh', 'b@gmail.com', '0987654356', 'Hữu &iacute;ch', 1, 'admin'),
(16, 'Nguyễn Duy Anh', 'b@gmail.com', '0987654356', 'Tuyệt vời', 1, 'admin'),
(17, 'Nguyễn Duy Anh', 'b@gmail.com', '0987654356', 'Gi&aacute;o vi&ecirc;n giảng dạy rất c&oacute; t&acirc;m', 1, 'admin'),
(18, 'Nguyễn Duy Anh', 'b@gmail.com', '0987654356', 'Gi&aacute;o vi&ecirc;n giảng dạy rất c&oacute; t&acirc;m', 1, 'admin'),
(19, 'Nguyễn Duy Anh', 'b@gmail.com', '0987654356', 'Gi&aacute;o vi&ecirc;n giảng dạy rất c&oacute; t&acirc;m', 2, 'admin'),
(20, 'Nguyễn Duy Anh', 'b@gmail.com', '0987654356', 'Gi&aacute;o vi&ecirc;n giảng dạy rất c&oacute; t&acirc;m', 2, 'admin'),
(21, 'Nguyễn Duy Anh', 'b@gmail.com', NULL, 'Gi&aacute;o vi&ecirc;n nhiệt t&igrave;nh (5 th&aacute;ng 12)', 2, 'admin'),
(22, 'Nguyễn Duy Anh', 'b@gmail.com', NULL, 'Thầy dạy rất dễ hiểu', 2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `hinhkhoahoc`
--

CREATE TABLE `hinhkhoahoc` (
  `hkh_ma` int(11) NOT NULL,
  `hkh_tentaptin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kh_makhoahoc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hinhkhoahoc`
--

INSERT INTO `hinhkhoahoc` (`hkh_ma`, `hkh_tentaptin`, `kh_makhoahoc`) VALUES
(84, '20221119164625_Hoctot-Li.png', 2),
(85, '20221119164816_HoctotHoa.jpg', 3),
(86, '20221119164707_PecCtiengAnh.png', 4),
(87, '20221119164725_PenCLi.png', 5),
(88, '20221119164733_PenChoa.png', 6),
(89, '20221119164746_Pen C Sinh.png', 7),
(90, '20221119164753_PenCnguvan.png', 8),
(91, '20221119165530_Luyenthilop6png.png', 9),
(92, '20221119164850_Master_toan.png', 10),
(93, '20221119164903_Master_toan9.png', 11),
(94, '20221119164911_HocTot_lichsu9.png', 12),
(95, '20221119164918_HocTot_Tienganh9.png', 13),
(96, '20221119164927_HocTot_toan8.png', 14),
(97, '20221119164935_HocTot_Vatli9.png', 15),
(98, '20221119164946_HocTot_NguVan7.png', 16),
(99, '20221119165014_Nangcao_tiengViet5.png', 17),
(100, '20221119165023_Nangcao_toan5.png', 18),
(101, '20221119165039_TienTieuHoc.png', 19),
(102, '20221119165051_Nangcao_toan4.2.png', 20),
(103, '20221119165106_TrongTamtoan2.png', 21),
(104, '20221119165115_Bucphatienganh.png', 22),
(105, '20221119165125_khoidongtiengviet5.png', 23),
(106, '20221119165133_chinhphuctoan3.png', 24),
(108, '20221122175226_luuhuythuongtoan12.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hinhthucthanhtoan`
--

CREATE TABLE `hinhthucthanhtoan` (
  `httt_ma` int(11) NOT NULL,
  `httt_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hinhthucthanhtoan`
--

INSERT INTO `hinhthucthanhtoan` (`httt_ma`, `httt_ten`) VALUES
(1, 'Tiền Mặt'),
(2, 'Ví Momo'),
(3, 'Chuyển khoảng ngân hàng'),
(4, 'Paypal'),
(5, 'MasterCard'),
(6, 'Khác');

-- --------------------------------------------------------

--
-- Table structure for table `khoahoc`
--

CREATE TABLE `khoahoc` (
  `kh_makhoahoc` int(11) NOT NULL,
  `kh_tenkhoahoc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `kh_loaikhoahoc` int(11) DEFAULT 0,
  `kh_hocphi` decimal(12,2) DEFAULT NULL,
  `kh_hocphicu` decimal(12,2) DEFAULT NULL,
  `kh_mota_ngan` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kh_mota_chitiet` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `kh_ngaycapnhat` datetime DEFAULT NULL,
  `km_ma` int(11) DEFAULT NULL,
  `gy_ma` int(11) DEFAULT NULL,
  `hkh_ma` int(11) DEFAULT NULL,
  `nkh_ma` int(11) DEFAULT NULL,
  `video_ma` int(11) DEFAULT NULL,
  `bg_ma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khoahoc`
--

INSERT INTO `khoahoc` (`kh_makhoahoc`, `kh_tenkhoahoc`, `kh_loaikhoahoc`, `kh_hocphi`, `kh_hocphicu`, `kh_mota_ngan`, `kh_mota_chitiet`, `kh_ngaycapnhat`, `km_ma`, `gy_ma`, `hkh_ma`, `nkh_ma`, `video_ma`, `bg_ma`) VALUES
(1, 'Học tốt - Toán 12', 1, '1150000.00', '1250000.00', 'Hệ thống lí thuyết và công thức Toán khối 12', 'Việc hiểu kĩ các thuật ngữ toán học, các công thức, các định nghĩa là cơ sở vững chắc để các em phát triển năng lực giải toán trắc nghiệm. Thầy Lưu Huy Thưởng sẽ giúp các em hiểu thế nào là đạo hàm, hệ số góc của tiếp tuyến, các công thức lượng giác..... những thuật ngữ các em gặp thường xuyên trong môn Toán nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt Toán học 12.', '2022-10-25 00:43:11', NULL, NULL, NULL, 1, NULL, NULL),
(2, 'Học tốt - Lí 12', 1, '1150000.00', '1250000.00', 'Hệ thống lí thuyết và công thức Lí  khối 12', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-25 00:43:10', NULL, NULL, NULL, 1, NULL, NULL),
(3, 'Học tốt - Hóa 12', 1, '1150000.00', '1250000.00', 'Hệ thống lí thuyết và công thức Hóa khối 12', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-25 00:44:10', NULL, NULL, NULL, 1, NULL, NULL),
(4, 'Pen-C Tiếng Anh', 0, '899000.00', '1050000.00', 'Khóa luyện thi PEN-C Tiếng Anh', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-25 00:44:36', NULL, NULL, NULL, 1, NULL, NULL),
(5, 'Pen-C Lí', 0, '899000.00', '1050000.00', 'Khóa luyện thi PEN-C Vật Lí', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-25 00:45:01', NULL, NULL, NULL, 1, NULL, NULL),
(6, 'Pen-C Hóa', 0, '899000.00', '1050000.00', 'Khóa luyện thi PEN-C Hóa Học', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 1, NULL, NULL),
(7, 'Pen-C Sinh', 0, '899000.00', '1050000.00', 'Khóa luyện thi PEN-C Sinh Học', 'Nắm vững kiến thức Sinh học lớp 12 là bước đầu tiên trong chu trình ôn thi đại học môn sinh', '2022-10-31 18:24:00', NULL, NULL, NULL, 1, NULL, NULL),
(8, 'Pen-C Ngữ Văn', 0, '899000.00', '1050000.00', 'Khóa luyện thi PEN-C Ngữ Văn', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 1, NULL, NULL),
(9, 'Luyện thi vào lớp 6', 1, '999000.00', '1099000.00', 'Khóa học giúp luyện thi vào lớp 6', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(10, 'Master Toán 6', 1, '999000.00', '1099000.00', 'Giải pháp học tập toàn diện môn Toán 6', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(11, 'Master Toán 9', 1, '999000.00', '1099000.00', 'Giải pháp học tập toàn diện môn Toán 9', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '0000-00-00 00:00:00', NULL, NULL, NULL, 2, NULL, NULL),
(12, 'Học Tốt Lịch Sử 9', 0, '799000.00', '999000.00', 'Trang bị và củng cố kiến thức Lịch Sử 9', 'Tiếng việt lớp 1 d&agrave;nh cho học sinh tr&ecirc;n 5 tuổi', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(13, 'Học Tốt Tiếng Anh 9', 0, '799000.00', '999000.00', 'Trang bị và củng cố kiến thức Tiếng Anh 9', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(14, 'Học Tốt Toán 8', 0, '799000.00', '999000.00', 'Trang bị và củng cố kiến thức Toán 8', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(15, 'Học Tốt Vật Lí 9', 0, '799000.00', '999000.00', 'Trang bị và củng cố kiến thức Vật Lí 9', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(16, 'Học Tốt Ngữ Văn 7', 0, '799000.00', '999000.00', 'Trang bị và củng cố kiến thức Ngữ văn 7', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 2, NULL, NULL),
(17, 'Nâng cao Tiếng Việt 5', 0, '799000.00', '999000.00', 'Nắm vững kiến thức chương trình Tiếng Việt 5', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(18, 'Nâng cao Toán 5', 0, '799000.00', '999000.00', 'Nắm vững kiến thức chương trình Toán 5', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(19, 'Tiền Tiểu học', 0, '799000.00', '999000.00', 'Phát triển tư duy và hình thành thói quen cho trẻ', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(20, 'Nâng cao toán 4', 0, '699000.00', '999000.00', 'Phát triển tư duy và hình thành thói quen cho trẻ', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(21, 'Trọng tâm toán 2', 0, '699000.00', '799000.00', 'Phát triển tư duy và hình thành thói quen cho trẻ', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(22, 'Bức phá Tiếng Anh', 0, '699000.00', '799000.00', 'Phát triển tư duy và hình thành thói quen cho trẻ', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(23, 'Khởi động Tiếng Việt 5', 0, '699000.00', '799000.00', 'Phát triển tư duy và hình thành thói quen cho trẻ', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-10-31 18:24:00', NULL, NULL, NULL, 3, NULL, NULL),
(24, 'Chinh phục Toán 3', 0, '699000.00', '799000.00', 'Phát triển tư duy và hình thành thói quen cho trẻ', 'Việc hiểu kĩ các kiến thức, những thuật ngữ các em gặp thường xuyên trong môn này nhưng không phải bạn nào cũng hiểu chúng là gì, vì sao lại có công thức đó..., giúp các em nắm vững kiến thức và học tốt.', '2022-12-04 13:57:00', NULL, NULL, NULL, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `khoahoc_donthanhtoan`
--

CREATE TABLE `khoahoc_donthanhtoan` (
  `kh_makhoahoc` int(11) NOT NULL,
  `dtt_ma` int(11) NOT NULL,
  `kh_dtt_dongia` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khoahoc_donthanhtoan`
--

INSERT INTO `khoahoc_donthanhtoan` (`kh_makhoahoc`, `dtt_ma`, `kh_dtt_dongia`) VALUES
(1, 4, '1150000.00'),
(1, 5, '1150000.00'),
(1, 6, '1150000.00'),
(1, 8, '1150000.00'),
(1, 9, '1150000.00'),
(1, 10, '1150000.00'),
(1, 11, '1150000.00'),
(1, 12, '1150000.00'),
(1, 15, '1150000.00'),
(1, 16, '1150000.00'),
(1, 17, '1150000.00'),
(1, 18, '1150000.00'),
(1, 19, '1150000.00'),
(1, 20, '1150000.00'),
(1, 21, '1150000.00'),
(1, 22, '1150000.00'),
(1, 23, '1150000.00'),
(1, 24, '1150000.00'),
(1, 25, '1150000.00'),
(1, 26, '1150000.00'),
(1, 27, '1150000.00'),
(1, 28, '1150000.00'),
(1, 29, '1150000.00'),
(1, 30, '1150000.00'),
(1, 31, '1150000.00'),
(1, 32, '1150000.00'),
(1, 33, '1150000.00'),
(1, 34, '1150000.00'),
(1, 35, '1150000.00'),
(1, 36, '1150000.00'),
(1, 39, '1150000.00'),
(1, 41, '1150000.00'),
(1, 42, '1150000.00'),
(1, 43, '1150000.00'),
(1, 46, '1150000.00'),
(1, 47, '1150000.00'),
(1, 48, '1150000.00'),
(1, 49, '1150000.00'),
(1, 50, '1150000.00'),
(1, 51, '1150000.00'),
(1, 52, '1150000.00'),
(1, 53, '1150000.00'),
(1, 54, '1150000.00'),
(1, 55, '1150000.00'),
(1, 65, '1150000.00'),
(2, 4, '1150000.00'),
(2, 7, '1150000.00'),
(2, 39, '1150000.00'),
(2, 40, '1150000.00'),
(2, 46, '1150000.00'),
(2, 55, '1150000.00'),
(3, 6, '1150000.00'),
(3, 43, '1150000.00'),
(3, 44, '1150000.00'),
(3, 45, '1150000.00'),
(3, 53, '1150000.00'),
(6, 36, '899000.00'),
(6, 37, '899000.00'),
(6, 41, '899000.00'),
(6, 66, '899000.00'),
(6, 67, '899000.00'),
(7, 37, '899000.00'),
(7, 38, '899000.00'),
(15, 64, '799000.00');

-- --------------------------------------------------------

--
-- Table structure for table `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `km_ma` int(11) NOT NULL,
  `km_ten` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `km_noidung` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `km_tungay` date DEFAULT NULL,
  `km_denngay` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khuyenmai`
--

INSERT INTO `khuyenmai` (`km_ma`, `km_ten`, `km_noidung`, `km_tungay`, `km_denngay`) VALUES
(1, 'Km ngay 10', 'km 10%', '2022-11-04', '2022-11-05'),
(4, 'km ngày 11', 'km 20%', '2022-11-02', '2022-11-06'),
(5, 'km ngay 14', 'km 14%', '2022-11-09', '2022-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `nhomkhoahoc`
--

CREATE TABLE `nhomkhoahoc` (
  `nkh_ma` int(11) NOT NULL,
  `nkh_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nkh_mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhomkhoahoc`
--

INSERT INTO `nhomkhoahoc` (`nkh_ma`, `nkh_ten`, `nkh_mota`) VALUES
(1, 'THPT', 'Khóa học dành cho học sinh lớp 10 - 11 - 12'),
(2, 'THCS', 'Khóa học dành cho học sinh lớp 6 - 7 - 8 - 9'),
(3, 'TH', 'Khóa học dành cho học sinh lớp 1 - 2 - 3 - 4 - 5'),
(4, 'DH', 'Khóa học dành cho sinh viên'),
(5, 'K', 'Khác học khác');

-- --------------------------------------------------------

--
-- Table structure for table `thanhvien`
--

CREATE TABLE `thanhvien` (
  `tv_tendangnhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tv_matkhau` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tv_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tv_gioitinh` int(11) DEFAULT NULL,
  `tv_diachi` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tv_dienthoai` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tv_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tv_ngaysinh` int(11) DEFAULT NULL,
  `tv_thangsinh` int(11) DEFAULT NULL,
  `tv_namsinh` int(11) NOT NULL,
  `tv_cmnd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tv_makichhoat` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tv_trangthai` int(11) NOT NULL,
  `tv_giaovien` int(11) NOT NULL DEFAULT 0,
  `tv_quantri` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thanhvien`
--

INSERT INTO `thanhvien` (`tv_tendangnhap`, `tv_matkhau`, `tv_ten`, `tv_gioitinh`, `tv_diachi`, `tv_dienthoai`, `tv_email`, `tv_ngaysinh`, `tv_thangsinh`, `tv_namsinh`, `tv_cmnd`, `tv_makichhoat`, `tv_trangthai`, `tv_giaovien`, `tv_quantri`) VALUES
('admin', '123', 'quản trị', 1, 'Cần Thơ', '097345632', 'a@gmail.com', 12, 6, 1999, '2134567', '0', 0, 0, 1),
('dangvanlam', 'vanlam123', 'Đặng Văn L&acirc;m', 1, '', '', '', NULL, NULL, 0, NULL, NULL, 0, 0, 0),
('doanvanhau', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Đo&agrave;n Văn Hậu', 0, 'Cần Thơ', '0964561306', 'duyanhdm1@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('duyanh', '123', 'Duy Anh', 1, '', '09876534', 'bc@gmail.com', 12, 1, 1999, '2134567', '0', 0, 0, 0),
('duyanh2', '123', 'Duy Anh 2', 1, '', '09876534', 'bc@gmail.com', 12, 1, 1999, '2134567', '0', 0, 0, 0),
('giaovien', '123', 'Giáo Viên', 1, 'Cần Thơ', '097345632', 'giaovien@gmail.com', 12, 6, 1999, '2134567', '0', 0, 1, 0),
('hoaithuong', '37007093bd997baa817abdc9636b4e8bf6cc080f', 'Hoài Thương', 0, 'Cần Thơ', '09876534', 'bc@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('hocsinh', '123', 'Học Sinh', 1, 'Cần Thơ', '097345632', 'hocsinh@gmail.com', 12, 6, 1999, '2134567', '0', 0, 0, 0),
('lkm', 'e791e72c5fe4716c4450477217030a6517eefcbc', 'Hoài Bảo', 1, 'Cần Thơ', '09876534', 'A@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('luuhuythuong', '98', 'Lưu Huy Thưởng', 1, 'An Giang', '09876534', 'A@gmail.com', 12, 1, 1999, '12134567', '0', 0, 1, 0),
('nguyenngocanh', '986', 'Nguyễn Ngọc Anh', 0, 'An Giang', '09876534', 'bc@gmail.com', 12, 3, 1999, '12134567', '0', 0, 1, 0),
('nguyenthanhnam', '665', 'Nguyễn Thành Nam', 1, 'An Giang', '097345632', 'bc@gmail.com', 12, 4, 1999, '12134567', '0', 0, 1, 0),
('saaa', '322', 'Hùng', 1, 'Hậu Giang', '097345632', 'bc@gmail.com', 13, 5, 1999, '12134567', '0', 0, 1, 0),
('test1', '123', 'Văn Nam', 0, 'Sóc Trăng', '097345632', 'A@gmail.com', 14, 4, 2002, '12134567', '0', 0, 1, 0),
('test2', '123', 'Duy Anh', 0, 'Cần Thơ', '097345632', 'A@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('test3', '03d0649f03315f9e560713e2512affb3219971c0', 'Minh Nguyen', 0, 'Cần Thơ', '09876534', 'A@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('test4', 'd80a9e5ac1c9f4343d30f70f9f6c2be247cee375', 'Duy Phú', 1, 'Cần Thơ', '097345632', 'A@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('test5', '477c99067f4d80b5b1f850efe96285bcc17cbe07', 'Văn Đài', 0, 'Cần Thơ', '097345632', 'A@gmail.com', 12, 2, 1999, '12134567', '0', 0, 0, 0),
('thu', 'thu', 'Văn Minh', 0, 'Sóc Trăng', '09876534', 'A@gmail.com', 15, 5, 2001, '12134567', '0', 0, 1, 0),
('vantoan', '123', 'Nguyễn Văn To&agrave;n', 1, '', '', '', NULL, NULL, 0, NULL, NULL, 0, 1, 0),
('vb12', '87', 'Tá Lả', 1, 'Hậu Giang', '09876534', 'A@gmail.com', 16, 3, 1997, '12134567', '0', 0, 1, 0),
('vccc', '12345', 'Duy Tân', 1, 'Hậu Giang', '09876534', 'A@gmail.com', 17, 2, 1996, '12134567', '0', 0, 1, 0),
('vkn', '345', 'Minh Thắng', 1, 'Sóc Trăng', '09876534', 'A@gmail.com', 21, 1, 2003, '12134567', '0', 0, 1, 0),
('vukhacngoc', '12345', 'Vũ Khắc Ngọc', 1, 'Sóc Trăng', '09876534', 'A@gmail.com', 22, 1, 2004, '12134567', '0', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `thanhvien_khoahoc`
--

CREATE TABLE `thanhvien_khoahoc` (
  `tv_kh_ma` int(11) NOT NULL,
  `tv_tendangnhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kh_makhoahoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thanhvien_khoahoc`
--

INSERT INTO `thanhvien_khoahoc` (`tv_kh_ma`, `tv_tendangnhap`, `kh_makhoahoc`) VALUES
(1, 'admin', 1),
(2, 'test2', 12),
(3, 'test4', 20),
(6, 'admin', 5),
(7, 'admin', 7),
(8, 'admin', 10),
(9, 'admin', 4),
(10, 'hocsinh', 1),
(11, 'hocsinh', 5),
(12, 'giaovien', 12),
(13, 'hocsinh', 4),
(14, 'hocsinh', 7),
(15, 'hocsinh', 10);

-- --------------------------------------------------------

--
-- Table structure for table `videokhoahoc`
--

CREATE TABLE `videokhoahoc` (
  `video_ma` int(11) NOT NULL,
  `video_bai` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_tenbai` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_tentaptin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kh_makhoahoc` int(11) DEFAULT NULL,
  `bg_bai` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `videokhoahoc`
--

INSERT INTO `videokhoahoc` (`video_ma`, `video_bai`, `video_tenbai`, `video_tentaptin`, `kh_makhoahoc`, `bg_bai`) VALUES
(1, 'Bài 1', 'Tính đơn điệu của hàm số', '20221204182846_04.mp4', 1, NULL),
(2, 'Bài 2', 'Cực trị của hàm số', '20221204182922_02.mp4', 1, NULL),
(4, 'Bài 3', 'Giá trị lớn nhất và nhỏ nhất của hàm số', '20221204192012_04.mp4', 1, NULL),
(5, 'Bài 4', 'Tiếp tuyến của đồ thị hàm số', '20221204192027_03.mp4', 1, NULL),
(6, 'Bài 5', 'Nguyên hàm', '20221204190230_02.mp4', 1, NULL),
(7, 'Bài 1', 'Bài giảng chữa câu hỏi vận dụng', '20221204190846_01.mp4', 5, NULL),
(8, 'Bài 2', 'Bài giảng chữa câu hỏi vận dụng cao', '20221204190916_02.mp4', 5, NULL),
(9, 'Bài 3', 'Bài giảng chữa câu hỏi thông hiểu', '20221204190943_01.mp4', 5, NULL),
(10, 'Bài 1', 'Đột biến gen', '20221204191126_Dotbiengen.MP4', 7, NULL),
(11, 'Bài 2', 'Đột biến số lượng nhiễm sắc thể', '20221204191201_NST.MP4', 7, NULL),
(12, 'Bài 1', 'Chinh phục phát âm - nguyên âm', '20221204193701_01.mp4', 4, NULL),
(13, 'Bài 2', 'Vocabulary Education', '20221204193725_02.mp4', 4, NULL),
(14, 'Bài 3', 'Exercise - Pronunciation', '20221204193750_03.mp4', 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baigiang`
--
ALTER TABLE `baigiang`
  ADD PRIMARY KEY (`bg_ma`),
  ADD KEY `FK_baigiang_khoahoc` (`kh_makhoahoc`),
  ADD KEY `bg_bai` (`bg_bai`),
  ADD KEY `FK_baigiang_videokhoahoc` (`video_bai`);

--
-- Indexes for table `chudegopy`
--
ALTER TABLE `chudegopy`
  ADD PRIMARY KEY (`cdgy_ma`);

--
-- Indexes for table `donthanhtoan`
--
ALTER TABLE `donthanhtoan`
  ADD PRIMARY KEY (`dtt_ma`),
  ADD KEY `FK__hinhthucthanhtoan` (`httt_ma`),
  ADD KEY `FK__hocvien` (`tv_tendangnhap`) USING BTREE;

--
-- Indexes for table `gopy`
--
ALTER TABLE `gopy`
  ADD PRIMARY KEY (`gy_ma`),
  ADD KEY `FK_gopy_chudegopy` (`cdgy_ma`),
  ADD KEY `FK_gopy_thanhvien` (`tv_tendangnhap`);

--
-- Indexes for table `hinhkhoahoc`
--
ALTER TABLE `hinhkhoahoc`
  ADD PRIMARY KEY (`hkh_ma`),
  ADD KEY `FK_hinhkhoahoc_khoahoc` (`kh_makhoahoc`);

--
-- Indexes for table `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  ADD PRIMARY KEY (`httt_ma`);

--
-- Indexes for table `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`kh_makhoahoc`),
  ADD KEY `FK_khoahoc_gopy` (`gy_ma`),
  ADD KEY `FK_khoahoc_hinhkhoahoc` (`hkh_ma`),
  ADD KEY `FK_khoahoc_nhomkhoahoc` (`nkh_ma`),
  ADD KEY `FK_khoahoc_khuyenmai` (`km_ma`),
  ADD KEY `FK_khoahoc_videokhoahoc` (`video_ma`),
  ADD KEY `FK_khoahoc_baigiang` (`bg_ma`);

--
-- Indexes for table `khoahoc_donthanhtoan`
--
ALTER TABLE `khoahoc_donthanhtoan`
  ADD PRIMARY KEY (`kh_makhoahoc`,`dtt_ma`),
  ADD KEY `FK_khoahoc_donthanhtoan_donthanhtoan` (`dtt_ma`),
  ADD KEY `kh_makhoahoc` (`kh_makhoahoc`);

--
-- Indexes for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`km_ma`);

--
-- Indexes for table `nhomkhoahoc`
--
ALTER TABLE `nhomkhoahoc`
  ADD PRIMARY KEY (`nkh_ma`) USING BTREE;

--
-- Indexes for table `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD PRIMARY KEY (`tv_tendangnhap`) USING BTREE;

--
-- Indexes for table `thanhvien_khoahoc`
--
ALTER TABLE `thanhvien_khoahoc`
  ADD PRIMARY KEY (`tv_kh_ma`),
  ADD KEY `FK_thanhvien_khoahoc_thanhvien` (`tv_tendangnhap`),
  ADD KEY `FK_thanhvien_khoahoc_khoahoc` (`kh_makhoahoc`);

--
-- Indexes for table `videokhoahoc`
--
ALTER TABLE `videokhoahoc`
  ADD PRIMARY KEY (`video_ma`,`video_tentaptin`),
  ADD KEY `video_bai` (`video_bai`),
  ADD KEY `video_tenbai` (`video_tenbai`),
  ADD KEY `bg_bai` (`bg_bai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baigiang`
--
ALTER TABLE `baigiang`
  MODIFY `bg_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `chudegopy`
--
ALTER TABLE `chudegopy`
  MODIFY `cdgy_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donthanhtoan`
--
ALTER TABLE `donthanhtoan`
  MODIFY `dtt_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `gopy`
--
ALTER TABLE `gopy`
  MODIFY `gy_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `hinhkhoahoc`
--
ALTER TABLE `hinhkhoahoc`
  MODIFY `hkh_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  MODIFY `httt_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `kh_makhoahoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `km_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nhomkhoahoc`
--
ALTER TABLE `nhomkhoahoc`
  MODIFY `nkh_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `thanhvien_khoahoc`
--
ALTER TABLE `thanhvien_khoahoc`
  MODIFY `tv_kh_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `videokhoahoc`
--
ALTER TABLE `videokhoahoc`
  MODIFY `video_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baigiang`
--
ALTER TABLE `baigiang`
  ADD CONSTRAINT `FK_baigiang_khoahoc` FOREIGN KEY (`kh_makhoahoc`) REFERENCES `khoahoc` (`kh_makhoahoc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_baigiang_videokhoahoc` FOREIGN KEY (`video_bai`) REFERENCES `videokhoahoc` (`video_bai`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `donthanhtoan`
--
ALTER TABLE `donthanhtoan`
  ADD CONSTRAINT `FK__hinhthucthanhtoan` FOREIGN KEY (`httt_ma`) REFERENCES `hinhthucthanhtoan` (`httt_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_donthanhtoan_thanhvien` FOREIGN KEY (`tv_tendangnhap`) REFERENCES `thanhvien` (`tv_tendangnhap`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gopy`
--
ALTER TABLE `gopy`
  ADD CONSTRAINT `FK_gopy_chudegopy` FOREIGN KEY (`cdgy_ma`) REFERENCES `chudegopy` (`cdgy_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_gopy_thanhvien` FOREIGN KEY (`tv_tendangnhap`) REFERENCES `thanhvien` (`tv_tendangnhap`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hinhkhoahoc`
--
ALTER TABLE `hinhkhoahoc`
  ADD CONSTRAINT `FK_hinhkhoahoc_khoahoc` FOREIGN KEY (`kh_makhoahoc`) REFERENCES `khoahoc` (`kh_makhoahoc`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD CONSTRAINT `FK_khoahoc_baigiang` FOREIGN KEY (`bg_ma`) REFERENCES `baigiang` (`bg_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_khoahoc_gopy` FOREIGN KEY (`gy_ma`) REFERENCES `gopy` (`gy_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_khoahoc_hinhkhoahoc` FOREIGN KEY (`hkh_ma`) REFERENCES `hinhkhoahoc` (`hkh_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_khoahoc_khuyenmai` FOREIGN KEY (`km_ma`) REFERENCES `khuyenmai` (`km_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_khoahoc_nhomkhoahoc` FOREIGN KEY (`nkh_ma`) REFERENCES `nhomkhoahoc` (`nkh_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `khoahoc_donthanhtoan`
--
ALTER TABLE `khoahoc_donthanhtoan`
  ADD CONSTRAINT `FK_khoahoc_donthanhtoan_donthanhtoan` FOREIGN KEY (`dtt_ma`) REFERENCES `donthanhtoan` (`dtt_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_khoahoc_donthanhtoan_khoahoc` FOREIGN KEY (`kh_makhoahoc`) REFERENCES `khoahoc` (`kh_makhoahoc`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `thanhvien_khoahoc`
--
ALTER TABLE `thanhvien_khoahoc`
  ADD CONSTRAINT `FK_thanhvien_khoahoc_khoahoc` FOREIGN KEY (`kh_makhoahoc`) REFERENCES `khoahoc` (`kh_makhoahoc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_thanhvien_khoahoc_thanhvien` FOREIGN KEY (`tv_tendangnhap`) REFERENCES `thanhvien` (`tv_tendangnhap`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `videokhoahoc`
--
ALTER TABLE `videokhoahoc`
  ADD CONSTRAINT `FK_videokhoahoc_baigiang` FOREIGN KEY (`bg_bai`) REFERENCES `baigiang` (`bg_bai`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
