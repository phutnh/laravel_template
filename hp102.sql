-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2018 at 07:34 AM
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
-- Table structure for table `hoahong`
--

CREATE TABLE IF NOT EXISTS `hoahong` (
  `hoahong_id` int(11) NOT NULL AUTO_INCREMENT,
  `loaihoahong` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `giatri` float NOT NULL,
  `cayhoahong` text COLLATE utf8_unicode_ci NOT NULL,
  `hopdong_id` int(11) NOT NULL,
  `ngaytao` datetime NOT NULL,
  `ngaycapnhat` datetime NOT NULL,
  PRIMARY KEY (`hoahong_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hopdong`
--

CREATE TABLE IF NOT EXISTS `hopdong` (
  `hopdong_id` int(11) NOT NULL AUTO_INCREMENT,
  `sohopdong` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tenhopdong` text COLLATE utf8_unicode_ci NOT NULL,
  `giatri` float NOT NULL,
  `tenkhachhang` text COLLATE utf8_unicode_ci NOT NULL,
  `sodienthoai` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `diachi` text COLLATE utf8_unicode_ci NOT NULL,
  `dinhkem` text COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ngayduyet` datetime NOT NULL,
  `nguoiduyet` int(11) NOT NULL,
  `nguoikhoa_id` int(11) NOT NULL,
  `ngaykhoa` datetime NOT NULL,
  `ngaytao` datetime NOT NULL,
  `ngaycapnhat` datetime NOT NULL,
  PRIMARY KEY (`hopdong_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
(1, 'Admin', '1234567890', 'admin', '$2y$10$8RbG6g.GC4k5M14nNaW46.irFTAWlCRGbUlevFZielSM5iuwAPjCa', 'jZTqTiAiVos17uQ4qtKpldHfbYtWW4uePtIscsLWeiPgYz783D8pxnezqK4z', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2017-05-11 07:23:11', '2018-09-05 17:04:28'),
(17, 'IT-TEST', '1516088517', 'letrungut', '$2y$10$0vQXdGQqkuJhouTQ2a7ArudyyzmvGQ5Se.pC6OB0Wy1e3K9DczpQu', 'iOdIF9JljciwKjTvJgbk6tgO1TLAuLxcJatuAaoR6CupwyIzEjJhasLrbiR4', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2018-01-16 14:42:27', '2018-10-06 16:34:14'),
(18, 'Nguyễn Hoàng Phút', '110022', 'styput', '$2y$10$JM02HV9XDoBKL6ynp5BmTeo5kIGO96QLZA6FQZ//JGEBLTYf8dA3O', '70LL1wiWIJKkEFzCttdnZJucWD9BYaD1y0Vyrl2UeNk2Ab8gB9MgaIsQVZXB', 1, NULL, 'styput1995@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL);

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
('styput1995@gmail.com', '$2y$10$U40/rIBtMrAMqs7KBJqSmOVkUSLYdA6KQLW60kGivjfbLCK4DEHOW', '2018-10-07 07:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `thamso`
--

CREATE TABLE IF NOT EXISTS `thamso` (
  `thamso_id` int(11) NOT NULL AUTO_INCREMENT,
  `mathamso` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tenthamso` text COLLATE utf8_unicode_ci NOT NULL,
  `giatrithamso` float NOT NULL,
  PRIMARY KEY (`thamso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `thamso`
--

INSERT INTO `thamso` (`thamso_id`, `mathamso`, `tenthamso`, `giatrithamso`) VALUES
(1, 'k1', 'Phân trăm hao hồng trực tiếp', 0.07),
(2, 'k2', 'Phần trăm hoa hồng gián tiếp', 0.5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
