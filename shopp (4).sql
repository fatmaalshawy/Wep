-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30 يناير 2026 الساعة 13:39
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopp`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'Produceram@gmail.com', '88888888');

-- --------------------------------------------------------

--
-- بنية الجدول `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `price` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `image`, `quantity`) VALUES
(8, 2, 'عطور', '33', '2427_img5.jpg', '1'),
(13, 8, 'عطور', '33', '2427_img5.jpg', '1'),
(14, 8, 'إلكترونيات', '56', '4896_Screenshot_٢٠٢٦٠١٢٣_٢٠٠٦١٨_SHEIN.jpg', '1');

-- --------------------------------------------------------

--
-- بنية الجدول `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `order`
--

INSERT INTO `order` (`id`, `user_id`, `name`, `number`, `method`, `address`, `total_products`, `total_price`, `placed_on`) VALUES
(1, 0, 'mona abdulla muhamed', '7777555666', 'كاش', 'sanaa', ', عطور (1) ', 200, '23-Jan-2026'),
(2, 0, 'mona abdulla muhamed', '777665443', 'كاش', 'sanaa', ', مجوهرات (1) ', 4, '23-Jan-2026'),
(3, 1, 'batol mohmed', '7755433211', 'كاش', 'sanaa', ', ملابس (1) , اكسسوارات (1) , إلكترونيات (1) ', 494, '23-Jan-2026'),
(4, 5, 'layan ady alshawee', '66666666', 'كاش', 'sanaa', ', ملابس (1) , احذية (1) ', 99, '25-Jan-2026'),
(5, 6, 'hajerksghrjtl', '1234567890', 'بطاقة', 'hswkge uyrkw4h', ', عطور (3) , اكسسوارات (1) ', 106, '25-Jan-2026');

-- --------------------------------------------------------

--
-- بنية الجدول `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `product_price` varchar(200) NOT NULL,
  `product_section` varchar(200) NOT NULL,
  `product_desc` varchar(1000) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `product_available` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_image`, `product_price`, `product_section`, `product_desc`, `product_size`, `product_available`) VALUES
(8, 'عطور2', '2113_img1.jpg', '46', 'عطور', 'عطر بسعر مناسب', '', 0),
(9, 'عطور', '2427_img5.jpg', '100', 'عطور', 'الرائحة التي تدوم مثل الورد ', '', 0),
(10, 'ملابس', '2534_shopping12.jpg', '54', 'ملابس', 'ملابس بناتي ', 'S', 0),
(11, 'اكسسوارات', '1121_img11.jpg', '3', 'اكسسوارات', 'منتج فخم', '', 0),
(12, 'اكسسوارات', '1293_Screenshot_٢٠٢٦٠١٢٣_١٨٤٨١٤_SHEIN.jpg', '6', 'اكسسوارات', '', '', 0),
(13, 'اكسسوارات', '1272_Screenshot_٢٠٢٦٠١٢٣_١٨٤٨٤٣_SHEIN.jpg', '7', 'اكسسوارات', 'يناسب  جميع الاذواق', '', 0),
(15, 'احذية', '3464_Screenshot_٢٠٢٦٠١٢٣_١٩١١٥٦_SHEIN.jpg', '45', 'أحذية', 'جزمة جلد بناتي', '40', 0),
(16, 'إلكترونيات', '4896_Screenshot_٢٠٢٦٠١٢٣_٢٠٠٦١٨_SHEIN.jpg', '56', 'إلكترونيات', 'سعر مناسب للجميع', '', 0),
(17, 'إلكترونيات', '227_Screenshot_٢٠٢٦٠١٢٣_٢٠٠٨٤٩_SHEIN.jpg', '55', 'إلكترونيات', '', '', 0),
(18, 'ملابس', '3923_Screenshot_٢٠٢٦٠١٢٣_١٩٠٩٥٥_SHEIN.jpg', '7', 'ملابس', 'فستان بناتي من عمر 4 سنوات الى 9 سنوات', 'm', 0),
(19, 'ملابس', '3152_Screenshot_٢٠٢٦٠١٢٣_١٩١٠٢٨_SHEIN.jpg', '5', 'ملابس', 'فستان بناتي من عمر 4 سنوات الى 6 سنوات', 'xl', 0),
(20, 'إلكترونيات', '2537_Screenshot_٢٠٢٦٠١٢٣_٢٠٥٠٣٩_SHEIN.jpg', '434', 'الكترونيات', 'ايباد ايفون', '', 0),
(21, 'إلكترونيات', '198_Screenshot_٢٠٢٦٠١٢٣_٢٠٤٩١٠_SHEIN.jpg', '56', 'إلكترونيات', '', '', 0),
(22, 'إلكترونيات', '2229_Screenshot_٢٠٢٦٠١٢٣_٢٠٥٠١٧_SHEIN.jpg', '44', 'إلكترونيات', '', '', 0),
(23, 'احذية', '3587_Screenshot_٢٠٢٦٠١٢٣_١٩١١١٧_SHEIN.jpg', '6', 'أحذية', '', '', 0),
(24, 'عطور', '1791_shopping7.jpg', '22', 'عطور', 'هذا العطر عالي الجودة', '', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `Sectionname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `section`
--

INSERT INTO `section` (`id`, `Sectionname`) VALUES
(6, 'عطور'),
(7, 'اكسسوارات'),
(8, 'ملابس'),
(9, 'الكترونيات');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created-at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created-at`) VALUES
(1, 'batol', 'batolmohamed@gmail.com', '123456789', '2026-01-23 18:06:34'),
(2, 'mona', 'monaahmed33@giaml.com', '99887766', '2026-01-23 18:11:10'),
(3, 'ahmed', 'ahmedali11@gmail.com', '11223344', '2026-01-23 20:29:32'),
(4, 'hajar', 'sdfhjjk@gmail.com', '999999', '2026-01-25 06:02:51'),
(5, 'lyan', 'layanady@gmail.com', '555555', '2026-01-25 06:06:50'),
(6, 'hajer', 'hajerer12@gmail.com', '55555', '2026-01-25 06:13:12'),
(7, 'bethoo', 'bethoo@gmail.com', '33333', '2026-01-25 06:34:05'),
(8, 'bethoo', 'bethoo888@gmail.com', '99999', '2026-01-25 06:34:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
