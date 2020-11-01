-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-10-11 12:39:03
-- 伺服器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `dev`
--

-- --------------------------------------------------------

--
-- 資料表結構 `contact`
--

CREATE TABLE `contact` (
  `uid` int(11) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `fn` varchar(32) NOT NULL,
  `ln` varchar(32) NOT NULL,
  `cp` varchar(64) NOT NULL,
  `em` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `domains`
--

CREATE TABLE `domains` (
  `domain` varchar(128) NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `created` date DEFAULT '9999-12-31',
  `expires` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `domains_trans`
--

CREATE TABLE `domains_trans` (
  `domain` text NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `conn_id` int(10) UNSIGNED NOT NULL,
  `private` tinyint(1) NOT NULL,
  `status` text NOT NULL,
  `epp` text NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `do_del_log`
--

CREATE TABLE `do_del_log` (
  `domain` varchar(128) NOT NULL,
  `uid` int(11) NOT NULL,
  `del` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp(),
  `date_billed` datetime DEFAULT NULL,
  `date_due` date DEFAULT NULL,
  `status` enum('active','draft','void','paid','expired') NOT NULL,
  `total` int(11) NOT NULL,
  `paid` int(11) NOT NULL DEFAULT 0,
  `payment_fee` int(11) NOT NULL DEFAULT 0,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `invoices_lines`
--

CREATE TABLE `invoices_lines` (
  `id` int(11) UNSIGNED NOT NULL,
  `text` varchar(128) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `invoice_domain_temp`
--

CREATE TABLE `invoice_domain_temp` (
  `domain` text NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `invoice` int(10) UNSIGNED NOT NULL,
  `conn_id` int(10) UNSIGNED NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('register','transfer','renew') NOT NULL,
  `quantity` tinyint(1) NOT NULL,
  `epp` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `invoice_service_temp`
--

CREATE TABLE `invoice_service_temp` (
  `domain` text NOT NULL,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `plan` text NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `invoice` int(10) UNSIGNED NOT NULL,
  `status` enum('new','renew') NOT NULL,
  `cycle` tinyint(1) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `notice_data`
--

CREATE TABLE `notice_data` (
  `uid` int(11) UNSIGNED NOT NULL,
  `email` text NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `payment`
--

CREATE TABLE `payment` (
  `invoice_id` int(11) UNSIGNED NOT NULL,
  `uniTradeNo` varchar(20) NOT NULL,
  `ecTradeNo` varchar(20) DEFAULT NULL,
  `ecRtnMsg` text NOT NULL,
  `ecRtnCode` varchar(10) DEFAULT NULL,
  `ecPaymentNo` varchar(14) DEFAULT NULL,
  `ecBankCode` varchar(3) DEFAULT NULL,
  `ecvAccount` varchar(16) DEFAULT NULL,
  `ecExpireDate` varchar(20) DEFAULT NULL,
  `ecPayment` varchar(10) DEFAULT NULL,
  `ecChargeFee` int(11) NOT NULL,
  `ecTradeAmt` int(11) NOT NULL,
  `MerchantTradeDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `plan_group`
--

CREATE TABLE `plan_group` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` enum('webhost','certificate','vps','other') NOT NULL DEFAULT 'webhost',
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `plan_list`
--

CREATE TABLE `plan_list` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `server` int(11) DEFAULT NULL,
  `info` text NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `plan_group` int(11) NOT NULL,
  `price_1m` int(11) NOT NULL DEFAULT -1,
  `price_3m` int(11) NOT NULL DEFAULT -1,
  `price_12m` int(11) NOT NULL DEFAULT -1,
  `price_24m` int(11) NOT NULL DEFAULT -1,
  `cp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `profile`
--

CREATE TABLE `profile` (
  `uid` int(11) UNSIGNED NOT NULL,
  `email` text NOT NULL,
  `name` text NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `server_list`
--

CREATE TABLE `server_list` (
  `id` int(11) NOT NULL,
  `server` text NOT NULL,
  `login` text NOT NULL,
  `pwd` text NOT NULL,
  `default_ip` varchar(15) NOT NULL,
  `now_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `service_list`
--

CREATE TABLE `service_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `type` enum('webhost','certificate','other') NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expired` date DEFAULT NULL,
  `server` int(10) UNSIGNED DEFAULT NULL,
  `sys_id` text NOT NULL,
  `host_login_name` text NOT NULL,
  `plan_id` int(11) NOT NULL,
  `disable` tinyint(1) NOT NULL DEFAULT 0,
  `uid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `tld`
--

CREATE TABLE `tld` (
  `tld` varchar(20) NOT NULL,
  `registration` int(11) NOT NULL,
  `transfer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `uid` int(11) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `FA_key` varchar(32) DEFAULT NULL,
  `sys` varchar(5) DEFAULT NULL,
  `sys_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `uid` (`uid`);

--
-- 資料表索引 `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`domain`),
  ADD KEY `uid` (`uid`);

--
-- 資料表索引 `do_del_log`
--
ALTER TABLE `do_del_log`
  ADD PRIMARY KEY (`domain`);

--
-- 資料表索引 `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `invoices_lines`
--
ALTER TABLE `invoices_lines`
  ADD KEY `id` (`id`);

--
-- 資料表索引 `invoice_domain_temp`
--
ALTER TABLE `invoice_domain_temp`
  ADD KEY `uid` (`uid`,`invoice`),
  ADD KEY `conn_id` (`conn_id`);

--
-- 資料表索引 `invoice_service_temp`
--
ALTER TABLE `invoice_service_temp`
  ADD KEY `uid` (`uid`,`invoice`);

--
-- 資料表索引 `notice_data`
--
ALTER TABLE `notice_data`
  ADD PRIMARY KEY (`uid`);

--
-- 資料表索引 `payment`
--
ALTER TABLE `payment`
  ADD UNIQUE KEY `uniTradeNo` (`uniTradeNo`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- 資料表索引 `plan_group`
--
ALTER TABLE `plan_group`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `plan_list`
--
ALTER TABLE `plan_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`uid`);

--
-- 資料表索引 `server_list`
--
ALTER TABLE `server_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tld`
--
ALTER TABLE `tld`
  ADD PRIMARY KEY (`tld`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `plan_group`
--
ALTER TABLE `plan_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `plan_list`
--
ALTER TABLE `plan_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `server_list`
--
ALTER TABLE `server_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
