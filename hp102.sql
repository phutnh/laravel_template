-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2018 at 01:58 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.6.38-1+ubuntu14.04.1+deb.sury.org+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hp102`
--

-- --------------------------------------------------------

--
-- Table structure for table `giaodich`
--

CREATE TABLE IF NOT EXISTS `giaodich` (
  `ma_gd` int(11) NOT NULL AUTO_INCREMENT,
  `nhanvien_id` int(11) NOT NULL,
  `ngayrut` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ngayduyet` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sotien` float NOT NULL,
  `trangthaiduyet` int(11) NOT NULL,
  `nguoiduyet` int(11) DEFAULT NULL,
  PRIMARY KEY (`ma_gd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `giaodich`
--

INSERT INTO `giaodich` (`ma_gd`, `nhanvien_id`, `ngayrut`, `ngayduyet`, `sotien`, `trangthaiduyet`, `nguoiduyet`) VALUES
(6, 1, '2018-10-12 07:31:25', '2018-10-12 12:38:00', 5000000, 1, 1),
(7, 1, '2018-10-10 07:31:59', '', 3000000, 0, 0),
(8, 1, '2018-10-11 07:32:10', '2018-10-12 12:27:04', 12000000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hoahong`
--

CREATE TABLE IF NOT EXISTS `hoahong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loaihoahong` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `giatri` float NOT NULL,
  `cayhoahong` text COLLATE utf8_unicode_ci NOT NULL,
  `hopdong_id` int(11) NOT NULL,
  `ngaytao` datetime NOT NULL,
  `ngaycapnhat` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hopdong`
--

CREATE TABLE IF NOT EXISTS `hopdong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nhanvien_id` int(11) NOT NULL,
  `sohopdong` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tenhopdong` text COLLATE utf8_unicode_ci NOT NULL,
  `giatri` float NOT NULL,
  `tenkhachhang` text COLLATE utf8_unicode_ci NOT NULL,
  `sodienthoai` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `diachi` text COLLATE utf8_unicode_ci NOT NULL,
  `dinhkem` text COLLATE utf8_unicode_ci,
  `trangthai` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngayduyet` datetime DEFAULT NULL,
  `nguoiduyet_id` int(11) DEFAULT NULL,
  `nguoikhoa_id` int(11) DEFAULT NULL,
  `ngaykhoa` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `hopdong`
--

INSERT INTO `hopdong` (`id`, `nhanvien_id`, `sohopdong`, `tenhopdong`, `giatri`, `tenkhachhang`, `sodienthoai`, `email`, `diachi`, `dinhkem`, `trangthai`, `ngayduyet`, `nguoiduyet_id`, `nguoikhoa_id`, `ngaykhoa`, `created_at`, `updated_at`) VALUES
(1, 18, 'HD98493', 'Hợp đồng buôn bán nhà', 10000, 'Nguyễn hoàng Phút', '01234567890', 'styput1@gmail.com', 'Cần Thơ', '', 'Đã duyệt', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-10-12 09:22:05'),
(2, 0, 'HD98494', 'Hợp đồng buôn bán nhà', 100000000, '1', '1', '1', '1', '1', 'Đã duyệt', '0000-00-00 00:00:00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 18, 'hhoho', 'Tênas', 2345680, 'Phút', '02345678908', 'styput@gmail.com', 'stypt', NULL, 'Gửi duyệt', NULL, NULL, NULL, NULL, NULL, '2018-10-12 06:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE IF NOT EXISTS `nhanvien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tennhanvien` varchar(255) DEFAULT NULL,
  `manhanvien` varchar(255) DEFAULT NULL,
  `taikhoan` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `phanquyen` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `email` text,
  `sodidong` int(11) DEFAULT NULL,
  `magioithieu` text,
  `cmnd` text,
  `gioitinh` int(11) DEFAULT NULL,
  `hinhanh` text,
  `diachi` text,
  `sotaikhoan` text,
  `tennganhang` text,
  `chinhanh` text,
  `soduthucte` bigint(20) NOT NULL DEFAULT '0',
  `hoahongtamtinh` bigint(20) NOT NULL DEFAULT '0',
  `trangthai` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `tennhanvien`, `manhanvien`, `taikhoan`, `password`, `remember_token`, `phanquyen`, `parent_id`, `email`, `sodidong`, `magioithieu`, `cmnd`, `gioitinh`, `hinhanh`, `diachi`, `sotaikhoan`, `tennganhang`, `chinhanh`, `soduthucte`, `hoahongtamtinh`, `trangthai`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '1234567890', 'admin', '$2y$10$IP98duZUYt4MUIISzLcN0uCMebtlxuqOXAY55BSgrMPpf70lsGPmS', 'Jys6nGebU90iUo7PulAlvjsjk0w5Pfnntmx1GhN8UW2hBaFySldmuAcfEwLk', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33000000, 0, 1, '2017-05-11 07:23:11', '2018-09-05 17:04:28'),
(17, 'IT-TEST', '1516088517', 'letrungut', '$2y$10$RS81A2a3/HPgNGfGwY.n0u/VS065wm03/1/RksoXfpo4BNJgIA9ey', 'xwERAnDOXB5kAsYqt4JoMESM4DB4NaI3zwM5OyJ7Bei1bEDLIAAvIpptxb7S', 1, NULL, 'letrungut@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000000, 0, 1, '2018-01-16 14:42:27', '2018-10-06 16:34:14'),
(18, 'Nguyễn Hoàng Phút', '110022', 'styput', '$2y$10$JM02HV9XDoBKL6ynp5BmTeo5kIGO96QLZA6FQZ//JGEBLTYf8dA3O', 'ufie5kFwwLZYjqJtqw9VZco2LQN7EZIoeCAiMLpsAcQHApAq1Eyzz1rk9oFM', 1, NULL, 'styput1995@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('styput1995@gmail.com', '$2y$10$dPNh.lctckxxYlTxI3PiVus9qtMpMmhhmY50nzcIu0Hl9y1uXCbYG', '2018-10-07 09:21:10'),
('letrungut@gmail.com', '$2y$10$UlquECx7fVf5YL5la9NPwOy5sgkusuNKMwEHOlqh4YxzsPqXYlkOy', '2018-10-08 01:08:55');

-- --------------------------------------------------------

--
-- Table structure for table `thamso`
--

CREATE TABLE IF NOT EXISTS `thamso` (
  `id` int(10) NOT NULL DEFAULT '0',
  `mathamso` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tenthamso` text COLLATE utf8_unicode_ci NOT NULL,
  `giatrithamso` float NOT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thamso`
--

INSERT INTO `thamso` (`id`, `mathamso`, `tenthamso`, `giatrithamso`, `mota`) VALUES
(1, 'k1', 'Phân trăm hao hồng trực tiếp1', 70, 'Người được thừa hưởng hoa hồng trực tiếp từ việc bán sản phẩm'),
(2, 'k2', 'Phần trăm hoa hồng gián tiếp', 50, 'Là người cấp trên của người bán sản phẩm, thừa hưởng hoa hồng kiếm được của cấp dưới');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
