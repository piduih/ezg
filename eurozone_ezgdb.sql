-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2016 at 11:08 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eurozone_ezgdb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`cpses_eue0ZhTQly`@`localhost` PROCEDURE `calBinary` ()  BEGIN

DECLARE v_finished int DEFAULT 0;
DECLARE v_user varchar(100) DEFAULT "";
DECLARE v_sp_left int DEFAULT 0;
DECLARE v_sp_right int DEFAULT 0;

-- dapatkan user id --
DECLARE cur_user CURSOR FOR 
SELECT DISTINCT usrname
FROM user;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;

OPEN cur_user;

get_user: LOOP
FETCH cur_user INTO v_user;

IF v_finished = 1 THEN
LEAVE get_user;
END IF;

-- try coding here --
-- dapatkan sum package base on user id utk left --
SELECT sum(bi_package) 
FROM binary_hdr
WHERE bi_no like concat('%',v_user,'%')
and bi_user not like concat('%',v_user,'%')
and bi_pos = 'L'
and bi_cal <> 'Y'
INTO v_sp_left;

-- kalau data tak null baru insert
IF v_sp_left IS NOT null THEN
	INSERT INTO binary_hdr_cal (bi_user, bi_pos, bi_date, bi_package)
	VALUES(v_user, 'L', now(), v_sp_left);
END IF;

-- dapatkan sum package base on user id utk right --
SELECT sum(bi_package) 
FROM binary_hdr
WHERE bi_no like concat('%',v_user,'%')
and bi_user not like concat('%',v_user,'%')
and bi_pos = 'R'
AND bi_cal <> 'Y'
INTO v_sp_right;

-- kalau data tak null baru insert
IF v_sp_right IS NOT null THEN
	INSERT INTO binary_hdr_cal (bi_user, bi_pos, bi_date, bi_package)
	VALUES(v_user, 'R', now(), v_sp_right);
END IF;
END LOOP get_user;

-- update selepas loop
-- untuk elak data berulang masuk ke binary_hdr_cal
UPDATE binary_hdr
SET bi_cal = 'Y'
WHERE bi_cal <> 'Y';

CLOSE cur_user;

END$$

CREATE DEFINER=`cpses_eue0ZhTQly`@`localhost` PROCEDURE `calBinary_s2` ()  BEGIN
-- 1st move ke history for display to end user
-- 2nd jadikan right/left hanya satu row per user

DECLARE v_finished int DEFAULT 0;
DECLARE v_user varchar(100) DEFAULT "";
DECLARE v_sp_left int DEFAULT 0;
DECLARE v_sp_right int DEFAULT 0;

-- dapatkan user id --
DECLARE cur_user CURSOR FOR 
SELECT DISTINCT bi_user
FROM binary_hdr_cal;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;

OPEN cur_user;

/**
INSERT INTO binary_hdr_hst (bi_user,bi_amount, bi_pos, bi_date, bi_package)
SELECT bi_user,bi_amount, bi_pos, bi_date, bi_package
FROM binary_hdr_cal;
*/

get_user: LOOP
FETCH cur_user INTO v_user;

IF v_finished = 1 THEN
LEAVE get_user;
END IF;

-- try coding here --
-- dapatkan sum package base on user id utk left --
SELECT sum(bi_package) 
FROM binary_hdr_cal
WHERE bi_user = v_user
and bi_pos = 'L'
INTO v_sp_left;

-- kalau data tak null baru insert
IF v_sp_left IS NOT null THEN
	DELETE FROM binary_hdr_cal 
    WHERE bi_user = v_user
    AND bi_pos = 'L';
    
	INSERT INTO binary_hdr_cal (bi_user, bi_pos, bi_date, bi_package)
	VALUES(v_user, 'L', now(), v_sp_left);
END IF;

-- dapatkan sum package base on user id utk right --
SELECT sum(bi_package) 
FROM binary_hdr_cal
WHERE bi_user = v_user
and bi_pos = 'R'
INTO v_sp_right;

-- kalau data tak null baru insert
IF v_sp_right IS NOT null THEN
	DELETE FROM binary_hdr_cal 
	WHERE bi_user = v_user
    AND bi_pos = 'R';
    
	INSERT INTO binary_hdr_cal (bi_user, bi_pos, bi_date, bi_package)
	VALUES(v_user, 'R', now(), v_sp_right);
END IF;

END LOOP get_user;

CLOSE cur_user;

END$$

CREATE DEFINER=`cpses_eue0ZhTQly`@`localhost` PROCEDURE `calBinary_s3` ()  BEGIN
-- kira dan update dlm bi_amount

DECLARE v_finished int DEFAULT 0;
DECLARE v_user varchar(100) DEFAULT "";
DECLARE v_package int DEFAULT 0;
DECLARE v_sp_left int DEFAULT 0;
DECLARE v_sp_right int DEFAULT 0;
DECLARE v_bonus int DEFAULT 0;

-- dapatkan user id --

DECLARE cur_user CURSOR FOR 
SELECT DISTINCT usrname, package_id
FROM user;
/**
SELECT DISTINCT bi_user
FROM binary_hdr_cal;
*/

DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;

OPEN cur_user;

get_user: LOOP
FETCH cur_user INTO v_user, v_package;

IF v_finished = 1 THEN
LEAVE get_user;
END IF;

-- try coding here --
-- dapatkan sum package base on user id utk left --
SELECT sum(bi_package) 
FROM binary_hdr_cal
WHERE bi_user = v_user
and bi_pos = 'L'
INTO v_sp_left;

-- dapatkan sum package base on user id utk right --
SELECT sum(bi_package) 
FROM binary_hdr_cal
WHERE bi_user = v_user
and bi_pos = 'R'
INTO v_sp_right;

-- if left and right <> 0
IF v_sp_left <> 0 && v_sp_right <> 0 THEN
	-- if left and right equal
	IF v_sp_left = v_sp_right THEN
		-- if left and right small from package
		IF v_sp_left <= v_package THEN
			UPDATE binary_hdr_cal
            SET bi_amount = v_bonus*(10/100), bi_package = 0
            WHERE bi_user = v_user;
		-- if package small from left and right
        ELSE
        	UPDATE binary_hdr_cal
            SET bi_amount = v_package*(10/100), bi_package = 0
            WHERE bi_user = v_user;
		END IF;
	-- if left small from right
	ELSEIF v_sp_left < v_sp_right THEN
		-- if left small from package
    	IF v_sp_left <= v_package THEN
        	UPDATE binary_hdr_cal
            SET bi_amount = v_sp_left*(10/100), bi_package = v_sp_right - v_sp_left
            WHERE bi_user = v_user
            AND bi_pos = 'R';
            
            update binary_hdr_cal
            set bi_amount = v_sp_left*(10/100), bi_package = 0
            where bi_user = v_user
            and bi_pos = 'L';
		-- if package small from left
        ELSE
        	UPDATE binary_hdr_cal
            SET bi_amount = v_package*(10/100), bi_package = v_sp_right - v_sp_left
            WHERE bi_user = v_user
            AND bi_pos = 'R';
            
            UPDATE binary_hdr_cal
            SET bi_amount = v_package*(10/100), bi_package = 0
            WHERE bi_user = v_user
            AND bi_pos = 'L';
        END IF;
	-- if right small from left        
    ELSE
		-- if right small from package
    	IF v_sp_right <= v_package THEN
        	UPDATE binary_hdr_cal
            SET bi_amount = v_sp_right*(10/100), bi_package = v_sp_left - v_sp_right
            WHERE bi_user = v_user
            AND bi_pos = 'L';
            
            UPDATE binary_hdr_cal
            SET bi_amount = v_sp_right*(10/100), bi_package = 0
            WHERE bi_user = v_user
            AND bi_pos = 'R';
            
        -- if package small from right
        ELSE
        	UPDATE binary_hdr_cal
            SET bi_amount = v_package*(10/100), bi_package = v_sp_left - v_sp_right
            WHERE bi_user = v_user
            AND bi_pos = 'L';
            
            UPDATE binary_hdr_cal
            SET bi_amount = v_package*(10/100), bi_package = 0
            WHERE bi_user = v_user
            AND bi_pos = 'R';
        END IF;
	END IF;
END IF;

END LOOP get_user;

INSERT INTO binary_hdr_hst (bi_user,bi_amount, bi_pos, bi_date, bi_package)
SELECT bi_user,bi_amount, bi_pos, bi_date, bi_package
FROM binary_hdr_cal;

CLOSE cur_user;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `binary_dtl`
--

CREATE TABLE `binary_dtl` (
  `bi_id` int(12) NOT NULL,
  `bi_userupline` varchar(100) NOT NULL,
  `bi_userdownline` varchar(100) NOT NULL,
  `bi_no` varchar(100) NOT NULL,
  `bi_amount` int(12) NOT NULL,
  `bi_jenis` varchar(100) NOT NULL,
  `bi_date` datetime NOT NULL,
  `bi_package` int(12) NOT NULL,
  `bi_from` varchar(100) NOT NULL,
  `bi_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `binary_hdr`
--

CREATE TABLE `binary_hdr` (
  `bi_id` int(12) NOT NULL,
  `bi_user` varchar(100) NOT NULL,
  `bi_userupline` varchar(100) NOT NULL,
  `bi_parent_id` int(12) NOT NULL,
  `bi_no` varchar(100) NOT NULL,
  `bi_amount` int(12) NOT NULL,
  `bi_pos` varchar(100) NOT NULL,
  `bi_date` datetime NOT NULL,
  `bi_package` int(12) NOT NULL,
  `bi_from` varchar(100) NOT NULL,
  `bi_to` varchar(100) NOT NULL,
  `bi_cal` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `binary_hdr`
--

INSERT INTO `binary_hdr` (`bi_id`, `bi_user`, `bi_userupline`, `bi_parent_id`, `bi_no`, `bi_amount`, `bi_pos`, `bi_date`, `bi_package`, `bi_from`, `bi_to`, `bi_cal`) VALUES
(27, 'praba', 'rosli', 0, 'rosli/praba', 0, 'L', '2016-11-15 01:38:39', 100, '', '', 'Y'),
(28, 'viki', 'rosli', 27, 'rosli/praba/viki', 0, 'L', '2016-11-15 01:39:19', 100, '', '', 'Y'),
(29, 'muthu', 'praba', 0, 'praba/muthu', 0, 'L', '2016-11-15 01:41:10', 100, '', '', 'Y'),
(30, 'yati', 'rosli', 0, 'rosli/yati', 0, 'R', '2016-11-15 01:48:40', 100, '', '', 'Y'),
(31, 'rosli', 'admin', 0, 'admin/rosli', 0, 'L', '0000-00-00 00:00:00', 100, '', '', 'Y'),
(33, 'lulu', 'praba', 29, 'praba/muthu/lulu', 0, 'L', '2016-11-17 12:22:50', 100, '', '', 'Y'),
(34, 'samy', 'praba', 0, 'praba/samy', 0, 'R', '2016-11-17 15:01:53', 100, '', '', 'Y'),
(35, 'munis', 'praba', 34, 'praba/samy/munis', 0, 'R', '2016-11-17 15:59:41', 100, '', '', 'Y'),
(36, 'tipah', 'rosli', 30, 'rosli/yati/tipah', 0, 'R', '2016-11-17 16:34:48', 100, '', '', 'Y'),
(37, 'sapi', 'rosli', 36, 'rosli/yati/tipah/sapi', 0, 'R', '2016-11-18 05:20:20', 1000, '', '', 'Y'),
(38, 'sukun', 'praba', 33, 'praba/muthu/lulu/sukun', 0, 'L', '2016-11-18 05:31:29', 1000, '', '', 'Y'),
(39, 'sabtu', 'rosli', 28, 'rosli/praba/viki/sabtu', 0, 'L', '2016-11-18 05:51:27', 1000, '', '', 'Y'),
(40, 'roslan', 'praba', 35, 'praba/samy/munis/roslan', 0, 'R', '2016-11-18 05:54:39', 1000, '', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `binary_hdr_cal`
--

CREATE TABLE `binary_hdr_cal` (
  `bi_id` int(12) NOT NULL,
  `bi_user` varchar(100) NOT NULL,
  `bi_userupline` varchar(100) NOT NULL,
  `bi_parent_id` int(12) NOT NULL,
  `bi_no` varchar(100) NOT NULL,
  `bi_amount` int(12) NOT NULL,
  `bi_pos` varchar(100) NOT NULL,
  `bi_date` datetime NOT NULL,
  `bi_package` int(12) DEFAULT NULL,
  `bi_from` varchar(100) NOT NULL,
  `bi_to` varchar(100) NOT NULL,
  `bi_cal` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `binary_hdr_cal`
--

INSERT INTO `binary_hdr_cal` (`bi_id`, `bi_user`, `bi_userupline`, `bi_parent_id`, `bi_no`, `bi_amount`, `bi_pos`, `bi_date`, `bi_package`, `bi_from`, `bi_to`, `bi_cal`) VALUES
(419, 'admin', '', 0, '', 0, 'L', '2016-11-18 05:56:00', 100, '', '', ''),
(420, 'muthu', '', 0, '', 0, 'L', '2016-11-18 05:56:00', 1100, '', '', ''),
(421, 'praba', '', 0, '', 10, 'L', '2016-11-18 05:56:00', 1100, '', '', ''),
(422, 'praba', '', 0, '', 10, 'R', '2016-11-18 05:56:00', 0, '', '', ''),
(423, 'rosli', '', 0, '', 0, 'L', '2016-11-18 05:56:01', 0, '', '', ''),
(424, 'rosli', '', 0, '', 0, 'R', '2016-11-18 05:56:01', 0, '', '', ''),
(425, 'samy', '', 0, '', 0, 'R', '2016-11-18 05:56:01', 1100, '', '', ''),
(426, 'yati', '', 0, '', 0, 'R', '2016-11-18 05:56:01', 1100, '', '', ''),
(427, 'tipah', '', 0, '', 0, 'R', '2016-11-18 05:56:01', 1000, '', '', ''),
(428, 'lulu', '', 0, '', 0, 'L', '2016-11-18 05:56:01', 1000, '', '', ''),
(429, 'viki', '', 0, '', 0, 'L', '2016-11-18 05:56:01', 1000, '', '', ''),
(430, 'munis', '', 0, '', 0, 'R', '2016-11-18 05:56:02', 1000, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `binary_hdr_hst`
--

CREATE TABLE `binary_hdr_hst` (
  `bi_id` int(12) NOT NULL,
  `bi_user` varchar(100) NOT NULL,
  `bi_userupline` varchar(100) NOT NULL,
  `bi_no` varchar(100) NOT NULL,
  `bi_amount` int(12) NOT NULL,
  `bi_pos` varchar(100) NOT NULL,
  `bi_date` datetime NOT NULL,
  `bi_package` int(12) DEFAULT NULL,
  `bi_from` varchar(100) NOT NULL,
  `bi_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `binary_hdr_hst`
--

INSERT INTO `binary_hdr_hst` (`bi_id`, `bi_user`, `bi_userupline`, `bi_no`, `bi_amount`, `bi_pos`, `bi_date`, `bi_package`, `bi_from`, `bi_to`) VALUES
(168, 'admin', '', '', 0, 'L', '2016-11-18 05:12:00', 100, '', ''),
(169, 'muthu', '', '', 0, 'L', '2016-11-18 05:12:00', 100, '', ''),
(170, 'praba', '', '', 10, 'L', '2016-11-18 05:12:00', 100, '', ''),
(171, 'praba', '', '', 0, 'R', '2016-11-18 05:12:01', 0, '', ''),
(172, 'rosli', '', '', 10, 'L', '2016-11-18 05:12:01', 0, '', ''),
(173, 'rosli', '', '', 10, 'R', '2016-11-18 05:12:01', 0, '', ''),
(174, 'samy', '', '', 0, 'R', '2016-11-18 05:12:01', 100, '', ''),
(175, 'yati', '', '', 0, 'R', '2016-11-18 05:12:01', 100, '', ''),
(183, 'admin', '', '', 0, 'L', '2016-11-18 05:18:00', 100, '', ''),
(184, 'muthu', '', '', 0, 'L', '2016-11-18 05:18:00', 100, '', ''),
(185, 'praba', '', '', 0, 'L', '2016-11-18 05:18:00', 100, '', ''),
(186, 'praba', '', '', 0, 'R', '2016-11-18 05:18:00', 0, '', ''),
(187, 'rosli', '', '', 0, 'L', '2016-11-18 05:18:01', 0, '', ''),
(188, 'rosli', '', '', 0, 'R', '2016-11-18 05:18:01', 0, '', ''),
(189, 'samy', '', '', 0, 'R', '2016-11-18 05:18:01', 100, '', ''),
(190, 'yati', '', '', 0, 'R', '2016-11-18 05:18:01', 100, '', ''),
(198, 'admin', '', '', 0, 'L', '2016-11-18 05:22:00', 100, '', ''),
(199, 'muthu', '', '', 0, 'L', '2016-11-18 05:22:00', 100, '', ''),
(200, 'praba', '', '', 0, 'L', '2016-11-18 05:22:00', 100, '', ''),
(201, 'praba', '', '', 0, 'R', '2016-11-18 05:22:00', 0, '', ''),
(202, 'rosli', '', '', 0, 'L', '2016-11-18 05:22:00', 0, '', ''),
(203, 'rosli', '', '', 0, 'R', '2016-11-18 05:22:01', 1000, '', ''),
(204, 'samy', '', '', 0, 'R', '2016-11-18 05:22:01', 100, '', ''),
(205, 'yati', '', '', 0, 'R', '2016-11-18 05:22:01', 1100, '', ''),
(206, 'tipah', '', '', 0, 'R', '2016-11-18 05:22:01', 1000, '', ''),
(213, 'admin', '', '', 0, 'L', '2016-11-18 05:29:00', 100, '', ''),
(214, 'muthu', '', '', 0, 'L', '2016-11-18 05:29:00', 100, '', ''),
(215, 'praba', '', '', 0, 'L', '2016-11-18 05:29:00', 100, '', ''),
(216, 'praba', '', '', 0, 'R', '2016-11-18 05:29:00', 0, '', ''),
(217, 'rosli', '', '', 0, 'L', '2016-11-18 05:29:00', 0, '', ''),
(218, 'rosli', '', '', 0, 'R', '2016-11-18 05:29:00', 1000, '', ''),
(219, 'samy', '', '', 0, 'R', '2016-11-18 05:29:01', 100, '', ''),
(220, 'yati', '', '', 0, 'R', '2016-11-18 05:29:01', 1100, '', ''),
(221, 'tipah', '', '', 0, 'R', '2016-11-18 05:29:01', 1000, '', ''),
(228, 'admin', '', '', 0, 'L', '2016-11-18 05:33:00', 100, '', ''),
(229, 'muthu', '', '', 0, 'L', '2016-11-18 05:33:00', 1100, '', ''),
(230, 'praba', '', '', 0, 'L', '2016-11-18 05:33:00', 1100, '', ''),
(231, 'praba', '', '', 0, 'R', '2016-11-18 05:33:01', 0, '', ''),
(232, 'rosli', '', '', 0, 'L', '2016-11-18 05:33:01', 0, '', ''),
(233, 'rosli', '', '', 0, 'R', '2016-11-18 05:33:01', 1000, '', ''),
(234, 'samy', '', '', 0, 'R', '2016-11-18 05:33:01', 100, '', ''),
(235, 'yati', '', '', 0, 'R', '2016-11-18 05:33:01', 1100, '', ''),
(236, 'tipah', '', '', 0, 'R', '2016-11-18 05:33:01', 1000, '', ''),
(237, 'lulu', '', '', 0, 'L', '2016-11-18 05:33:01', 1000, '', ''),
(243, 'admin', '', '', 0, 'L', '2016-11-18 05:52:00', 100, '', ''),
(244, 'muthu', '', '', 0, 'L', '2016-11-18 05:52:00', 1100, '', ''),
(245, 'praba', '', '', 0, 'L', '2016-11-18 05:52:00', 2100, '', ''),
(246, 'praba', '', '', 0, 'R', '2016-11-18 05:52:00', 0, '', ''),
(247, 'rosli', '', '', 10, 'L', '2016-11-18 05:52:00', 0, '', ''),
(248, 'rosli', '', '', 10, 'R', '2016-11-18 05:52:01', 0, '', ''),
(249, 'samy', '', '', 0, 'R', '2016-11-18 05:52:01', 100, '', ''),
(250, 'yati', '', '', 0, 'R', '2016-11-18 05:52:01', 1100, '', ''),
(251, 'tipah', '', '', 0, 'R', '2016-11-18 05:52:01', 1000, '', ''),
(252, 'lulu', '', '', 0, 'L', '2016-11-18 05:52:01', 1000, '', ''),
(253, 'viki', '', '', 0, 'L', '2016-11-18 05:52:01', 1000, '', ''),
(258, 'admin', '', '', 0, 'L', '2016-11-18 05:56:00', 100, '', ''),
(259, 'muthu', '', '', 0, 'L', '2016-11-18 05:56:00', 1100, '', ''),
(260, 'praba', '', '', 10, 'L', '2016-11-18 05:56:00', 1100, '', ''),
(261, 'praba', '', '', 10, 'R', '2016-11-18 05:56:00', 0, '', ''),
(262, 'rosli', '', '', 0, 'L', '2016-11-18 05:56:01', 0, '', ''),
(263, 'rosli', '', '', 0, 'R', '2016-11-18 05:56:01', 0, '', ''),
(264, 'samy', '', '', 0, 'R', '2016-11-18 05:56:01', 1100, '', ''),
(265, 'yati', '', '', 0, 'R', '2016-11-18 05:56:01', 1100, '', ''),
(266, 'tipah', '', '', 0, 'R', '2016-11-18 05:56:01', 1000, '', ''),
(267, 'lulu', '', '', 0, 'L', '2016-11-18 05:56:01', 1000, '', ''),
(268, 'viki', '', '', 0, 'L', '2016-11-18 05:56:01', 1000, '', ''),
(269, 'munis', '', '', 0, 'R', '2016-11-18 05:56:02', 1000, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `bonus_wallet_hdr`
--

CREATE TABLE `bonus_wallet_hdr` (
  `bns_id` int(12) NOT NULL,
  `bns_user` varchar(100) NOT NULL,
  `bns_no` varchar(100) NOT NULL,
  `bns_amount` int(12) NOT NULL,
  `bns_jenis` varchar(100) NOT NULL,
  `bns_date` datetime NOT NULL,
  `bns_package` int(12) NOT NULL,
  `bns_from` varchar(100) NOT NULL,
  `bns_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_wallet_hdr`
--

CREATE TABLE `cash_wallet_hdr` (
  `ch_id` int(12) NOT NULL,
  `ch_user` varchar(100) NOT NULL,
  `ch_no` varchar(100) NOT NULL,
  `ch_amount` int(12) NOT NULL,
  `ch_jenis` varchar(100) NOT NULL,
  `ch_date` datetime NOT NULL,
  `ch_package` int(12) NOT NULL,
  `ch_from` varchar(100) NOT NULL,
  `ch_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_wallet_hdr`
--

INSERT INTO `cash_wallet_hdr` (`ch_id`, `ch_user`, `ch_no`, `ch_amount`, `ch_jenis`, `ch_date`, `ch_package`, `ch_from`, `ch_to`) VALUES
(25, 'paymaster', 'paymaster161026', 90000, 'CW', '2016-10-26 10:34:50', 0, 'system', ''),
(152, 'admin', 'admin161114', 300, 'CW', '2016-11-14 15:29:38', 0, 'paymaster', 'admin'),
(153, 'paymaster', 'paymaster161114', -300, 'CW', '2016-11-14 15:29:38', 0, 'paymaster', 'admin'),
(154, 'admin', 'admin161114', -300, 'CW', '2016-11-14 15:36:13', 0, 'Reg for - rosli', ''),
(155, 'rosli', 'rosli161114', 3000, 'CW', '2016-11-14 15:36:52', 0, 'paymaster', 'rosli'),
(156, 'paymaster', 'paymaster161114', -3000, 'CW', '2016-11-14 15:36:52', 0, 'paymaster', 'rosli'),
(167, 'rosli', 'rosli161115', -30, 'CW', '2016-11-15 01:38:39', 0, 'Reg for - praba', ''),
(168, 'rosli', 'rosli161115', -30, 'CW', '2016-11-15 01:39:19', 0, 'Reg for - viki', ''),
(169, 'praba', 'praba161115', 3000, 'CW', '2016-11-15 01:40:08', 0, 'paymaster', 'praba'),
(170, 'paymaster', 'paymaster161115', -3000, 'CW', '2016-11-15 01:40:09', 0, 'paymaster', 'praba'),
(171, 'praba', 'praba161115', -30, 'CW', '2016-11-15 01:41:11', 0, 'Reg for - muthu', ''),
(172, 'rosli', 'rosli161115', -30, 'CW', '2016-11-15 01:48:40', 0, 'Reg for - yati', ''),
(173, 'praba', 'praba161117', -30, 'CW', '2016-11-17 12:22:50', 0, 'Reg for - lulu', ''),
(174, 'praba', 'praba161117', -30, 'CW', '2016-11-17 15:01:53', 0, 'Reg for - samy', ''),
(175, 'praba', 'praba161117', -30, 'CW', '2016-11-17 15:59:41', 0, 'Reg for - munis', ''),
(176, 'rosli', 'rosli161117', -30, 'CW', '2016-11-17 16:34:48', 0, 'Reg for - tipah', ''),
(177, 'rosli', 'rosli161118', -300, 'CW', '2016-11-18 05:20:20', 0, 'Reg for - sapi', ''),
(178, 'praba', 'praba161118', -300, 'CW', '2016-11-18 05:31:29', 0, 'Reg for - sukun', ''),
(179, 'rosli', 'rosli161118', -300, 'CW', '2016-11-18 05:51:27', 0, 'Reg for - sabtu', ''),
(180, 'praba', 'praba161118', -300, 'CW', '2016-11-18 05:54:39', 0, 'Reg for - roslan', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cycle`
--

CREATE TABLE `cycle` (
  `id_cycle` int(12) NOT NULL,
  `cycle_days` int(12) NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cycle`
--

INSERT INTO `cycle` (`id_cycle`, `cycle_days`, `update_by`, `update_date`) VALUES
(1, 30, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `euro_rate`
--

CREATE TABLE `euro_rate` (
  `id_rate` int(12) NOT NULL,
  `rate` decimal(11,2) NOT NULL,
  `rate_desc` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `euro_rate`
--

INSERT INTO `euro_rate` (`id_rate`, `rate`, `rate_desc`) VALUES
(1, '4.50', 'RM to Euro');

-- --------------------------------------------------------

--
-- Table structure for table `hibah`
--

CREATE TABLE `hibah` (
  `id_hibah` int(12) NOT NULL,
  `hibah_percent` int(12) NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hibah`
--

INSERT INTO `hibah` (`id_hibah`, `hibah_percent`, `update_by`, `update_date`) VALUES
(1, 25, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `created_at`) VALUES
(1, 'Test MySQL Event 1', '2016-10-28 15:40:15'),
(2, 'Test MySQL Event 2', '2016-10-28 15:43:18'),
(3, 'Test MySQL recurring Event', '2016-10-28 15:46:06'),
(4, 'Test MySQL recurring Event', '2016-10-28 15:47:06'),
(5, 'Test MySQL recurring Event', '2016-10-28 15:48:06'),
(6, 'Test MySQL recurring Event', '2016-10-28 15:49:06'),
(7, 'Test MySQL recurring Event', '2016-10-28 15:50:06'),
(8, 'Test MySQL recurring Event', '2016-10-28 15:51:06'),
(9, 'Test MySQL recurring Event', '2016-10-28 15:52:06'),
(10, 'Test MySQL recurring Event', '2016-10-28 15:53:06'),
(11, 'Test MySQL recurring Event', '2016-10-28 15:54:06'),
(12, 'Test MySQL recurring Event', '2016-10-28 15:55:06'),
(13, 'Test MySQL recurring Event', '2016-10-28 15:56:06'),
(14, 'Test MySQL recurring Event', '2016-10-28 15:57:06'),
(15, 'Test MySQL recurring Event', '2016-10-28 15:58:06'),
(16, 'Test MySQL recurring Event', '2016-10-28 15:59:06'),
(17, 'Test MySQL recurring Event', '2016-10-28 16:00:06'),
(18, 'Test MySQL recurring Event', '2016-10-28 16:01:06'),
(19, 'Test MySQL recurring Event', '2016-10-28 16:02:06'),
(20, 'Test MySQL recurring Event', '2016-10-28 16:03:06'),
(21, 'Test MySQL recurring Event', '2016-10-28 16:04:06'),
(22, 'Test MySQL recurring Event', '2016-10-28 16:05:06'),
(23, 'Test MySQL recurring Event', '2016-10-28 16:06:06'),
(24, 'Test MySQL recurring Event', '2016-10-28 16:07:06'),
(25, 'Test MySQL recurring Event', '2016-10-28 16:08:06'),
(26, 'Test MySQL recurring Event', '2016-10-28 16:09:06'),
(27, 'Test MySQL recurring Event', '2016-10-28 16:10:06'),
(28, 'Test MySQL recurring Event', '2016-10-28 16:11:06'),
(29, 'Test MySQL recurring Event', '2016-10-28 16:12:06'),
(30, 'Test MySQL recurring Event', '2016-10-28 16:13:06'),
(31, 'Test MySQL recurring Event', '2016-10-28 16:14:06'),
(32, 'Test MySQL recurring Event', '2016-10-28 16:15:06'),
(33, 'Test MySQL recurring Event', '2016-10-28 16:16:06'),
(34, 'Test MySQL recurring Event', '2016-10-28 16:17:06'),
(35, 'Test MySQL recurring Event', '2016-10-28 16:18:06'),
(36, 'Test MySQL recurring Event', '2016-10-28 16:19:06'),
(37, 'Test MySQL recurring Event', '2016-10-28 16:20:06'),
(38, 'Test MySQL recurring Event', '2016-10-28 16:21:06'),
(39, 'Test MySQL recurring Event', '2016-10-28 16:22:06'),
(40, 'Test MySQL recurring Event', '2016-10-28 16:23:06'),
(41, 'Test MySQL recurring Event', '2016-10-28 16:24:06'),
(42, 'Test MySQL recurring Event', '2016-10-28 16:25:06'),
(43, 'Test MySQL recurring Event', '2016-10-28 16:26:06'),
(44, 'Test MySQL recurring Event', '2016-10-28 16:27:06'),
(45, 'Test MySQL recurring Event', '2016-10-28 16:28:06'),
(46, 'Test MySQL recurring Event', '2016-10-28 16:29:06'),
(47, 'Test MySQL recurring Event', '2016-10-28 16:30:06'),
(48, 'Test MySQL recurring Event', '2016-10-28 16:31:06'),
(49, 'Test MySQL recurring Event', '2016-10-28 16:32:06'),
(50, 'Test MySQL recurring Event', '2016-10-28 16:33:06'),
(51, 'Test MySQL recurring Event', '2016-10-28 16:34:06'),
(52, 'Test MySQL recurring Event', '2016-10-28 16:35:06'),
(53, 'Test MySQL recurring Event', '2016-10-28 16:36:06'),
(54, 'Test MySQL recurring Event', '2016-10-28 16:37:06'),
(55, 'Test MySQL recurring Event', '2016-10-28 16:38:06'),
(56, 'Test MySQL recurring Event', '2016-10-28 16:39:06'),
(57, 'Test MySQL recurring Event', '2016-10-28 16:40:06'),
(58, 'Test MySQL recurring Event', '2016-10-28 16:41:06'),
(59, 'Test MySQL recurring Event', '2016-10-28 16:42:06'),
(60, 'Test MySQL recurring Event', '2016-10-28 16:43:06'),
(61, 'Test MySQL recurring Event', '2016-10-28 16:44:06'),
(62, 'Test MySQL recurring Event', '2016-10-28 16:45:06'),
(63, 'Test MySQL recurring Event', '2016-10-28 16:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id_package` int(12) NOT NULL,
  `package_code` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id_package`, `package_code`) VALUES
(1, 100),
(2, 300),
(3, 500),
(4, 750),
(5, 1000),
(6, 3000),
(7, 5000),
(8, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `product_wallet_hdr`
--

CREATE TABLE `product_wallet_hdr` (
  `pd_id` int(12) NOT NULL,
  `pd_user` varchar(100) NOT NULL,
  `pd_no` varchar(100) NOT NULL,
  `pd_amount` int(12) NOT NULL,
  `pd_jenis` varchar(100) NOT NULL,
  `pd_date` datetime NOT NULL,
  `pd_package` int(12) NOT NULL,
  `pd_from` varchar(100) NOT NULL,
  `pd_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reg_wallet_hdr`
--

CREATE TABLE `reg_wallet_hdr` (
  `reg_id` int(12) NOT NULL,
  `reg_user` varchar(100) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `reg_amount` int(12) NOT NULL,
  `reg_jenis` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL,
  `reg_package` int(12) NOT NULL,
  `reg_from` varchar(100) NOT NULL,
  `reg_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_wallet_hdr`
--

INSERT INTO `reg_wallet_hdr` (`reg_id`, `reg_user`, `reg_no`, `reg_amount`, `reg_jenis`, `reg_date`, `reg_package`, `reg_from`, `reg_to`) VALUES
(26, 'paymaster', 'paymaster161026', 210000, 'RW', '2016-10-26 10:34:50', 0, 'system', ''),
(155, 'admin', 'admin161114', 700, 'RW', '2016-11-14 15:29:33', 0, 'paymaster', 'admin'),
(156, 'paymaster', 'paymaster161114', -700, 'RW', '2016-11-14 15:29:33', 0, 'paymaster', 'admin'),
(157, 'admin', 'admin161114', -700, 'RW', '2016-11-14 15:36:13', 0, 'Reg for - rosli', ''),
(158, 'rosli', 'rosli161114', 7000, 'RW', '2016-11-14 15:36:47', 0, 'paymaster', 'rosli'),
(159, 'paymaster', 'paymaster161114', -7000, 'RW', '2016-11-14 15:36:47', 0, 'paymaster', 'rosli'),
(170, 'rosli', 'rosli161115', -70, 'RW', '2016-11-15 01:38:39', 0, 'Reg for - praba', ''),
(171, 'rosli', 'rosli161115', -70, 'RW', '2016-11-15 01:39:19', 0, 'Reg for - viki', ''),
(172, 'praba', 'praba161115', 7000, 'RW', '2016-11-15 01:40:02', 0, 'paymaster', 'praba'),
(173, 'paymaster', 'paymaster161115', -7000, 'RW', '2016-11-15 01:40:02', 0, 'paymaster', 'praba'),
(174, 'praba', 'praba161115', -70, 'RW', '2016-11-15 01:41:11', 0, 'Reg for - muthu', ''),
(175, 'rosli', 'rosli161115', -70, 'RW', '2016-11-15 01:48:40', 0, 'Reg for - yati', ''),
(176, 'praba', 'praba161117', -70, 'RW', '2016-11-17 12:22:50', 0, 'Reg for - lulu', ''),
(177, 'praba', 'praba161117', -70, 'RW', '2016-11-17 15:01:53', 0, 'Reg for - samy', ''),
(178, 'praba', 'praba161117', -70, 'RW', '2016-11-17 15:59:41', 0, 'Reg for - munis', ''),
(179, 'rosli', 'rosli161117', -70, 'RW', '2016-11-17 16:34:48', 0, 'Reg for - tipah', ''),
(180, 'rosli', 'rosli161118', -700, 'RW', '2016-11-18 05:20:20', 0, 'Reg for - sapi', ''),
(181, 'praba', 'praba161118', -700, 'RW', '2016-11-18 05:31:29', 0, 'Reg for - sukun', ''),
(182, 'rosli', 'rosli161118', -700, 'RW', '2016-11-18 05:51:27', 0, 'Reg for - sabtu', ''),
(183, 'praba', 'praba161118', -700, 'RW', '2016-11-18 05:54:39', 0, 'Reg for - roslan', '');

-- --------------------------------------------------------

--
-- Table structure for table `roi_dtl`
--

CREATE TABLE `roi_dtl` (
  `roi_id` int(12) NOT NULL,
  `roi_user` varchar(100) NOT NULL,
  `roi_no` varchar(100) NOT NULL,
  `roi_amount` int(12) NOT NULL,
  `roi_jenis` varchar(100) NOT NULL,
  `roi_date` datetime NOT NULL,
  `roi_package` int(12) NOT NULL,
  `roi_from` varchar(100) NOT NULL,
  `roi_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roi_dtl`
--

INSERT INTO `roi_dtl` (`roi_id`, `roi_user`, `roi_no`, `roi_amount`, `roi_jenis`, `roi_date`, `roi_package`, `roi_from`, `roi_to`) VALUES
(529, 'praba', 'praba161115', 0, 'ROI', '2016-12-15 00:00:00', 0, '', ''),
(530, 'praba', 'praba161115', 0, 'ROI', '2017-01-14 00:00:00', 0, '', ''),
(531, 'praba', 'praba161115', 0, 'ROI', '2017-02-13 00:00:00', 0, '', ''),
(532, 'praba', 'praba161115', 0, 'ROI', '2017-03-15 00:00:00', 0, '', ''),
(533, 'praba', 'praba161115', 0, 'ROI', '2017-04-14 00:00:00', 0, '', ''),
(534, 'praba', 'praba161115', 0, 'ROI', '2017-05-14 00:00:00', 0, '', ''),
(535, 'praba', 'praba161115', 0, 'ROI', '2017-06-13 00:00:00', 0, '', ''),
(536, 'praba', 'praba161115', 0, 'ROI', '2017-07-13 00:00:00', 0, '', ''),
(537, 'praba', 'praba161115', 0, 'ROI', '2017-08-12 00:00:00', 0, '', ''),
(538, 'praba', 'praba161115', 0, 'ROI', '2017-09-11 00:00:00', 0, '', ''),
(539, 'praba', 'praba161115', 0, 'ROI', '2017-10-11 00:00:00', 0, '', ''),
(540, 'praba', 'praba161115', 0, 'ROI', '2017-11-10 00:00:00', 0, '', ''),
(541, 'viki', 'viki161115', 0, 'ROI', '2016-12-15 00:00:00', 0, '', ''),
(542, 'viki', 'viki161115', 0, 'ROI', '2017-01-14 00:00:00', 0, '', ''),
(543, 'viki', 'viki161115', 0, 'ROI', '2017-02-13 00:00:00', 0, '', ''),
(544, 'viki', 'viki161115', 0, 'ROI', '2017-03-15 00:00:00', 0, '', ''),
(545, 'viki', 'viki161115', 0, 'ROI', '2017-04-14 00:00:00', 0, '', ''),
(546, 'viki', 'viki161115', 0, 'ROI', '2017-05-14 00:00:00', 0, '', ''),
(547, 'viki', 'viki161115', 0, 'ROI', '2017-06-13 00:00:00', 0, '', ''),
(548, 'viki', 'viki161115', 0, 'ROI', '2017-07-13 00:00:00', 0, '', ''),
(549, 'viki', 'viki161115', 0, 'ROI', '2017-08-12 00:00:00', 0, '', ''),
(550, 'viki', 'viki161115', 0, 'ROI', '2017-09-11 00:00:00', 0, '', ''),
(551, 'viki', 'viki161115', 0, 'ROI', '2017-10-11 00:00:00', 0, '', ''),
(552, 'viki', 'viki161115', 0, 'ROI', '2017-11-10 00:00:00', 0, '', ''),
(553, 'muthu', 'muthu161115', 0, 'ROI', '2016-12-15 00:00:00', 0, '', ''),
(554, 'muthu', 'muthu161115', 0, 'ROI', '2017-01-14 00:00:00', 0, '', ''),
(555, 'muthu', 'muthu161115', 0, 'ROI', '2017-02-13 00:00:00', 0, '', ''),
(556, 'muthu', 'muthu161115', 0, 'ROI', '2017-03-15 00:00:00', 0, '', ''),
(557, 'muthu', 'muthu161115', 0, 'ROI', '2017-04-14 00:00:00', 0, '', ''),
(558, 'muthu', 'muthu161115', 0, 'ROI', '2017-05-14 00:00:00', 0, '', ''),
(559, 'muthu', 'muthu161115', 0, 'ROI', '2017-06-13 00:00:00', 0, '', ''),
(560, 'muthu', 'muthu161115', 0, 'ROI', '2017-07-13 00:00:00', 0, '', ''),
(561, 'muthu', 'muthu161115', 0, 'ROI', '2017-08-12 00:00:00', 0, '', ''),
(562, 'muthu', 'muthu161115', 0, 'ROI', '2017-09-11 00:00:00', 0, '', ''),
(563, 'muthu', 'muthu161115', 0, 'ROI', '2017-10-11 00:00:00', 0, '', ''),
(564, 'muthu', 'muthu161115', 0, 'ROI', '2017-11-10 00:00:00', 0, '', ''),
(565, 'yati', 'yati161115', 0, 'ROI', '2016-12-15 00:00:00', 0, '', ''),
(566, 'yati', 'yati161115', 0, 'ROI', '2017-01-14 00:00:00', 0, '', ''),
(567, 'yati', 'yati161115', 0, 'ROI', '2017-02-13 00:00:00', 0, '', ''),
(568, 'yati', 'yati161115', 0, 'ROI', '2017-03-15 00:00:00', 0, '', ''),
(569, 'yati', 'yati161115', 0, 'ROI', '2017-04-14 00:00:00', 0, '', ''),
(570, 'yati', 'yati161115', 0, 'ROI', '2017-05-14 00:00:00', 0, '', ''),
(571, 'yati', 'yati161115', 0, 'ROI', '2017-06-13 00:00:00', 0, '', ''),
(572, 'yati', 'yati161115', 0, 'ROI', '2017-07-13 00:00:00', 0, '', ''),
(573, 'yati', 'yati161115', 0, 'ROI', '2017-08-12 00:00:00', 0, '', ''),
(574, 'yati', 'yati161115', 0, 'ROI', '2017-09-11 00:00:00', 0, '', ''),
(575, 'yati', 'yati161115', 0, 'ROI', '2017-10-11 00:00:00', 0, '', ''),
(576, 'yati', 'yati161115', 0, 'ROI', '2017-11-10 00:00:00', 0, '', ''),
(577, 'lulu', 'lulu161117', 0, 'ROI', '2016-12-17 00:00:00', 0, '', ''),
(578, 'lulu', 'lulu161117', 0, 'ROI', '2017-01-16 00:00:00', 0, '', ''),
(579, 'lulu', 'lulu161117', 0, 'ROI', '2017-02-15 00:00:00', 0, '', ''),
(580, 'lulu', 'lulu161117', 0, 'ROI', '2017-03-17 00:00:00', 0, '', ''),
(581, 'lulu', 'lulu161117', 0, 'ROI', '2017-04-16 00:00:00', 0, '', ''),
(582, 'lulu', 'lulu161117', 0, 'ROI', '2017-05-16 00:00:00', 0, '', ''),
(583, 'lulu', 'lulu161117', 0, 'ROI', '2017-06-15 00:00:00', 0, '', ''),
(584, 'lulu', 'lulu161117', 0, 'ROI', '2017-07-15 00:00:00', 0, '', ''),
(585, 'lulu', 'lulu161117', 0, 'ROI', '2017-08-14 00:00:00', 0, '', ''),
(586, 'lulu', 'lulu161117', 0, 'ROI', '2017-09-13 00:00:00', 0, '', ''),
(587, 'lulu', 'lulu161117', 0, 'ROI', '2017-10-13 00:00:00', 0, '', ''),
(588, 'lulu', 'lulu161117', 0, 'ROI', '2017-11-12 00:00:00', 0, '', ''),
(589, 'samy', 'samy161117', 0, 'ROI', '2016-12-17 00:00:00', 0, '', ''),
(590, 'samy', 'samy161117', 0, 'ROI', '2017-01-16 00:00:00', 0, '', ''),
(591, 'samy', 'samy161117', 0, 'ROI', '2017-02-15 00:00:00', 0, '', ''),
(592, 'samy', 'samy161117', 0, 'ROI', '2017-03-17 00:00:00', 0, '', ''),
(593, 'samy', 'samy161117', 0, 'ROI', '2017-04-16 00:00:00', 0, '', ''),
(594, 'samy', 'samy161117', 0, 'ROI', '2017-05-16 00:00:00', 0, '', ''),
(595, 'samy', 'samy161117', 0, 'ROI', '2017-06-15 00:00:00', 0, '', ''),
(596, 'samy', 'samy161117', 0, 'ROI', '2017-07-15 00:00:00', 0, '', ''),
(597, 'samy', 'samy161117', 0, 'ROI', '2017-08-14 00:00:00', 0, '', ''),
(598, 'samy', 'samy161117', 0, 'ROI', '2017-09-13 00:00:00', 0, '', ''),
(599, 'samy', 'samy161117', 0, 'ROI', '2017-10-13 00:00:00', 0, '', ''),
(600, 'samy', 'samy161117', 0, 'ROI', '2017-11-12 00:00:00', 0, '', ''),
(601, 'munis', 'munis161117', 0, 'ROI', '2016-12-17 00:00:00', 0, '', ''),
(602, 'munis', 'munis161117', 0, 'ROI', '2017-01-16 00:00:00', 0, '', ''),
(603, 'munis', 'munis161117', 0, 'ROI', '2017-02-15 00:00:00', 0, '', ''),
(604, 'munis', 'munis161117', 0, 'ROI', '2017-03-17 00:00:00', 0, '', ''),
(605, 'munis', 'munis161117', 0, 'ROI', '2017-04-16 00:00:00', 0, '', ''),
(606, 'munis', 'munis161117', 0, 'ROI', '2017-05-16 00:00:00', 0, '', ''),
(607, 'munis', 'munis161117', 0, 'ROI', '2017-06-15 00:00:00', 0, '', ''),
(608, 'munis', 'munis161117', 0, 'ROI', '2017-07-15 00:00:00', 0, '', ''),
(609, 'munis', 'munis161117', 0, 'ROI', '2017-08-14 00:00:00', 0, '', ''),
(610, 'munis', 'munis161117', 0, 'ROI', '2017-09-13 00:00:00', 0, '', ''),
(611, 'munis', 'munis161117', 0, 'ROI', '2017-10-13 00:00:00', 0, '', ''),
(612, 'munis', 'munis161117', 0, 'ROI', '2017-11-12 00:00:00', 0, '', ''),
(613, 'tipah', 'tipah161117', 0, 'ROI', '2016-12-17 00:00:00', 0, '', ''),
(614, 'tipah', 'tipah161117', 0, 'ROI', '2017-01-16 00:00:00', 0, '', ''),
(615, 'tipah', 'tipah161117', 0, 'ROI', '2017-02-15 00:00:00', 0, '', ''),
(616, 'tipah', 'tipah161117', 0, 'ROI', '2017-03-17 00:00:00', 0, '', ''),
(617, 'tipah', 'tipah161117', 0, 'ROI', '2017-04-16 00:00:00', 0, '', ''),
(618, 'tipah', 'tipah161117', 0, 'ROI', '2017-05-16 00:00:00', 0, '', ''),
(619, 'tipah', 'tipah161117', 0, 'ROI', '2017-06-15 00:00:00', 0, '', ''),
(620, 'tipah', 'tipah161117', 0, 'ROI', '2017-07-15 00:00:00', 0, '', ''),
(621, 'tipah', 'tipah161117', 0, 'ROI', '2017-08-14 00:00:00', 0, '', ''),
(622, 'tipah', 'tipah161117', 0, 'ROI', '2017-09-13 00:00:00', 0, '', ''),
(623, 'tipah', 'tipah161117', 0, 'ROI', '2017-10-13 00:00:00', 0, '', ''),
(624, 'tipah', 'tipah161117', 0, 'ROI', '2017-11-12 00:00:00', 0, '', ''),
(625, 'sapi', 'sapi161118', 0, 'ROI', '2016-12-18 00:00:00', 0, '', ''),
(626, 'sapi', 'sapi161118', 0, 'ROI', '2017-01-17 00:00:00', 0, '', ''),
(627, 'sapi', 'sapi161118', 0, 'ROI', '2017-02-16 00:00:00', 0, '', ''),
(628, 'sapi', 'sapi161118', 0, 'ROI', '2017-03-18 00:00:00', 0, '', ''),
(629, 'sapi', 'sapi161118', 0, 'ROI', '2017-04-17 00:00:00', 0, '', ''),
(630, 'sapi', 'sapi161118', 0, 'ROI', '2017-05-17 00:00:00', 0, '', ''),
(631, 'sapi', 'sapi161118', 0, 'ROI', '2017-06-16 00:00:00', 0, '', ''),
(632, 'sapi', 'sapi161118', 0, 'ROI', '2017-07-16 00:00:00', 0, '', ''),
(633, 'sapi', 'sapi161118', 0, 'ROI', '2017-08-15 00:00:00', 0, '', ''),
(634, 'sapi', 'sapi161118', 0, 'ROI', '2017-09-14 00:00:00', 0, '', ''),
(635, 'sapi', 'sapi161118', 0, 'ROI', '2017-10-14 00:00:00', 0, '', ''),
(636, 'sapi', 'sapi161118', 0, 'ROI', '2017-11-13 00:00:00', 0, '', ''),
(637, 'sukun', 'sukun161118', 0, 'ROI', '2016-12-18 00:00:00', 0, '', ''),
(638, 'sukun', 'sukun161118', 0, 'ROI', '2017-01-17 00:00:00', 0, '', ''),
(639, 'sukun', 'sukun161118', 0, 'ROI', '2017-02-16 00:00:00', 0, '', ''),
(640, 'sukun', 'sukun161118', 0, 'ROI', '2017-03-18 00:00:00', 0, '', ''),
(641, 'sukun', 'sukun161118', 0, 'ROI', '2017-04-17 00:00:00', 0, '', ''),
(642, 'sukun', 'sukun161118', 0, 'ROI', '2017-05-17 00:00:00', 0, '', ''),
(643, 'sukun', 'sukun161118', 0, 'ROI', '2017-06-16 00:00:00', 0, '', ''),
(644, 'sukun', 'sukun161118', 0, 'ROI', '2017-07-16 00:00:00', 0, '', ''),
(645, 'sukun', 'sukun161118', 0, 'ROI', '2017-08-15 00:00:00', 0, '', ''),
(646, 'sukun', 'sukun161118', 0, 'ROI', '2017-09-14 00:00:00', 0, '', ''),
(647, 'sukun', 'sukun161118', 0, 'ROI', '2017-10-14 00:00:00', 0, '', ''),
(648, 'sukun', 'sukun161118', 0, 'ROI', '2017-11-13 00:00:00', 0, '', ''),
(649, 'sabtu', 'sabtu161118', 0, 'ROI', '2016-12-18 00:00:00', 0, '', ''),
(650, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-01-17 00:00:00', 0, '', ''),
(651, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-02-16 00:00:00', 0, '', ''),
(652, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-03-18 00:00:00', 0, '', ''),
(653, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-04-17 00:00:00', 0, '', ''),
(654, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-05-17 00:00:00', 0, '', ''),
(655, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-06-16 00:00:00', 0, '', ''),
(656, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-07-16 00:00:00', 0, '', ''),
(657, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-08-15 00:00:00', 0, '', ''),
(658, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-09-14 00:00:00', 0, '', ''),
(659, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-10-14 00:00:00', 0, '', ''),
(660, 'sabtu', 'sabtu161118', 0, 'ROI', '2017-11-13 00:00:00', 0, '', ''),
(661, 'roslan', 'roslan161118', 0, 'ROI', '2016-12-18 00:00:00', 0, '', ''),
(662, 'roslan', 'roslan161118', 0, 'ROI', '2017-01-17 00:00:00', 0, '', ''),
(663, 'roslan', 'roslan161118', 0, 'ROI', '2017-02-16 00:00:00', 0, '', ''),
(664, 'roslan', 'roslan161118', 0, 'ROI', '2017-03-18 00:00:00', 0, '', ''),
(665, 'roslan', 'roslan161118', 0, 'ROI', '2017-04-17 00:00:00', 0, '', ''),
(666, 'roslan', 'roslan161118', 0, 'ROI', '2017-05-17 00:00:00', 0, '', ''),
(667, 'roslan', 'roslan161118', 0, 'ROI', '2017-06-16 00:00:00', 0, '', ''),
(668, 'roslan', 'roslan161118', 0, 'ROI', '2017-07-16 00:00:00', 0, '', ''),
(669, 'roslan', 'roslan161118', 0, 'ROI', '2017-08-15 00:00:00', 0, '', ''),
(670, 'roslan', 'roslan161118', 0, 'ROI', '2017-09-14 00:00:00', 0, '', ''),
(671, 'roslan', 'roslan161118', 0, 'ROI', '2017-10-14 00:00:00', 0, '', ''),
(672, 'roslan', 'roslan161118', 0, 'ROI', '2017-11-13 00:00:00', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `roi_hdr`
--

CREATE TABLE `roi_hdr` (
  `roi_id` int(12) NOT NULL,
  `roi_user` varchar(100) NOT NULL,
  `roi_upline` varchar(100) NOT NULL,
  `roi_no` varchar(100) NOT NULL,
  `roi_amount` int(12) NOT NULL,
  `roi_jenis` varchar(100) NOT NULL,
  `roi_date` datetime NOT NULL,
  `roi_package` int(12) NOT NULL,
  `roi_from` varchar(100) NOT NULL,
  `roi_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roi_hdr`
--

INSERT INTO `roi_hdr` (`roi_id`, `roi_user`, `roi_upline`, `roi_no`, `roi_amount`, `roi_jenis`, `roi_date`, `roi_package`, `roi_from`, `roi_to`) VALUES
(142, 'praba', 'rosli', 'praba161115', 25, 'ROI', '2016-11-15 01:38:38', 100, '', ''),
(143, 'viki', 'rosli', 'viki161115', 25, 'ROI', '2016-11-15 01:39:18', 100, '', ''),
(144, 'muthu', 'praba', 'muthu161115', 25, 'ROI', '2016-11-15 01:41:10', 100, '', ''),
(145, 'yati', 'rosli', 'yati161115', 25, 'ROI', '2016-11-15 01:48:39', 100, '', ''),
(146, 'lulu', 'praba', 'lulu161117', 25, 'ROI', '2016-11-17 12:22:49', 100, '', ''),
(147, 'samy', 'praba', 'samy161117', 25, 'ROI', '2016-11-17 15:01:51', 100, '', ''),
(148, 'munis', 'praba', 'munis161117', 25, 'ROI', '2016-11-17 15:59:40', 100, '', ''),
(149, 'tipah', 'rosli', 'tipah161117', 25, 'ROI', '2016-11-17 16:34:47', 100, '', ''),
(150, 'sapi', 'rosli', 'sapi161118', 250, 'ROI', '2016-11-18 05:20:19', 1000, '', ''),
(151, 'sukun', 'praba', 'sukun161118', 250, 'ROI', '2016-11-18 05:31:28', 1000, '', ''),
(152, 'sabtu', 'rosli', 'sabtu161118', 250, 'ROI', '2016-11-18 05:51:26', 1000, '', ''),
(153, 'roslan', 'praba', 'roslan161118', 250, 'ROI', '2016-11-18 05:54:38', 1000, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(10) NOT NULL,
  `role_desc` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_desc`) VALUES
(1, 'admin'),
(2, 'paymaster'),
(3, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_wallet_hdr`
--

CREATE TABLE `sponsor_wallet_hdr` (
  `sp_id` int(12) NOT NULL,
  `sp_user` varchar(100) NOT NULL,
  `sp_no` varchar(100) NOT NULL,
  `sp_amount` int(12) NOT NULL,
  `sp_jenis` varchar(100) NOT NULL,
  `sp_date` datetime NOT NULL,
  `sp_package` int(12) NOT NULL,
  `sp_from` varchar(100) NOT NULL,
  `sp_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsor_wallet_hdr`
--

INSERT INTO `sponsor_wallet_hdr` (`sp_id`, `sp_user`, `sp_no`, `sp_amount`, `sp_jenis`, `sp_date`, `sp_package`, `sp_from`, `sp_to`) VALUES
(126, 'rosli', 'praba161115', 10, 'SW', '2016-11-15 01:38:39', 0, '', ''),
(127, 'rosli', 'viki161115', 10, 'SW', '2016-11-15 01:39:19', 0, '', ''),
(128, 'praba', 'muthu161115', 10, 'SW', '2016-11-15 01:41:11', 0, '', ''),
(129, 'rosli', 'yati161115', 10, 'SW', '2016-11-15 01:48:40', 0, '', ''),
(130, 'praba', 'lulu161117', 10, 'SW', '2016-11-17 12:22:50', 0, '', ''),
(131, 'praba', 'samy161117', 10, 'SW', '2016-11-17 15:01:53', 0, '', ''),
(132, 'praba', 'munis161117', 10, 'SW', '2016-11-17 15:59:41', 0, '', ''),
(133, 'rosli', 'tipah161117', 10, 'SW', '2016-11-17 16:34:48', 0, '', ''),
(134, 'rosli', 'sapi161118', 100, 'SW', '2016-11-18 05:20:20', 0, '', ''),
(135, 'praba', 'sukun161118', 100, 'SW', '2016-11-18 05:31:29', 0, '', ''),
(136, 'rosli', 'sabtu161118', 100, 'SW', '2016-11-18 05:51:27', 0, '', ''),
(137, 'praba', 'roslan161118', 100, 'SW', '2016-11-18 05:54:39', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `user_id`, `created`) VALUES
(26, 'da4b465a1ea6ed9961efbd561b4d64', 1, '2016-10-04'),
(27, '8236c5326f649d5d57040ce44147fb', 1, '2016-10-04'),
(28, 'f92a1811f0675d1d64b29010a11ba0', 1, '2016-10-04'),
(29, '6d3663b981a2c315a136df14bb132b', 1, '2016-10-04'),
(30, 'eac6819d6e578da7ba6eed2a8df7ca', 1, '2016-10-04'),
(31, '35f4797a8c080364d827adfa7c9778', 1, '2016-10-04'),
(32, '0a874d58adab9b6ed43b683a9feb67', 1, '2016-10-04'),
(33, '3c29c087e2ad47b62faaefda2aca54', 1, '2016-10-04'),
(34, '403c6155cdc33e7cb519cd17c7d0a7', 1, '2016-10-04'),
(35, 'a6a79ef05957081175fd9956f5eca5', 1, '2016-10-04'),
(36, '43bf3eab06393fc445459d2e94a24e', 1, '2016-10-04'),
(37, '7f50933ceec66b1e3ab9cb51a423bf', 1, '2016-10-04'),
(38, '9680900a758cdd392a933284dc92f2', 1, '2016-10-04'),
(39, '1894044bed246387fe27024e1fca0d', 1, '2016-10-04'),
(40, '54afeac92597610995befc33577307', 1, '2016-10-04'),
(41, 'c4ad2b3afa4fc955cbedd85ca67d50', 1, '2016-10-04'),
(42, 'c87f2f0ae5081622c599ecf1268f1d', 1, '2016-10-04'),
(43, 'ace4fec7c99b7406906765d7a5feff', 1, '2016-10-04'),
(44, '3388fac9f1d05cb2ef93d8dd5f8dc2', 1, '2016-10-04'),
(45, '7d7a2c34894627cba4510150ce7b85', 1, '2016-10-04'),
(46, '767e793b042e9024fb27b6ccd36de3', 1, '2016-10-04'),
(47, 'b48fff1239efb41ea41a515d96f61b', 1, '2016-10-04'),
(48, 'ab463c942a4b450e798769e70efb67', 1, '2016-10-04'),
(49, '37aac6614a88d83962ccd3d0c9422b', 1, '2016-10-04'),
(50, 'b809f71eb5be0b98635a60978f63d0', 1, '2016-10-04'),
(51, 'f44be654ed35946f0fb614ef689ea1', 1, '2016-10-04'),
(52, 'e6ac1d137eefc3617db3e610d4990d', 3, '2016-10-04'),
(53, '84f6cc8b7c047c0db454167ece2b8a', 1, '2016-10-04'),
(54, '9b9a4409342aeacf0bfce1e42208cc', 1, '2016-10-11'),
(55, '156fb7fbf6c5f3e272976a3561fbd2', 3, '2016-10-12'),
(56, '451e2a2013f7180c1172e338446fe5', 1, '2016-10-12'),
(57, 'f95b0c6844a3c63ad382018de985c9', 3, '2016-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `trx_id` int(12) NOT NULL,
  `trx_user` varchar(100) NOT NULL,
  `trx_no` varchar(100) NOT NULL,
  `trx_amount` int(12) NOT NULL,
  `trx_jenis` varchar(100) NOT NULL,
  `trx_date` datetime NOT NULL,
  `trx_package` int(12) NOT NULL,
  `trx_from` varchar(100) NOT NULL,
  `trx_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `usrname` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `introducer_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `national_id` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `package_id` int(12) NOT NULL,
  `last_login` varchar(100) NOT NULL,
  `activ_metod` varchar(100) NOT NULL,
  `binary_pos` varchar(10) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `update_by` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL,
  `nominee_name` varchar(100) DEFAULT NULL,
  `nominee_contact` varchar(100) DEFAULT NULL,
  `declaration` varchar(12) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `acc_num` varchar(100) NOT NULL,
  `holder_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `usrname`, `fname`, `introducer_name`, `dob`, `gender`, `contact`, `email`, `national_id`, `address`, `password`, `status`, `role`, `package_id`, `last_login`, `activ_metod`, `binary_pos`, `created_by`, `created_date`, `update_by`, `update_date`, `nominee_name`, `nominee_contact`, `declaration`, `bank_name`, `acc_num`, `holder_name`) VALUES
(1, 'admin', 'admin', 'none', '0000-00-00', '', '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', '1', '1', 0, '2016-10-04 02:14:40 AM', '', '', '', '2016-10-04 02:14:40', '', '0000-00-00 00:00:00', '', '', '', '', '0', ''),
(88, 'paymaster', 'paymaster', '', '2016-10-26', 'Male', '999999999999', '', '999999999999', '', '1261b18ee81246a772f6877471c4d63a', '', '2', 0, '', 'RWCW', 'L', 'admin', '2016-10-26 10:34:50', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '0', ''),
(140, 'sapi', 'sapi', 'rosli', '2016-11-23', 'Male', '3216597', '', '321654987', '', 'f87f8f834b237ad853fb44cccaa18952', '', '3', 1000, '', 'RWCW', 'R', 'rosli', '2016-11-18 05:20:19', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(141, 'sukun', 'sukun', 'praba', '2016-11-02', 'Male', '321654987', '', '31654987', '', '490cda0cd1562ab5128d5ff271286b0b', '', '3', 1000, '', 'RWCW', 'L', 'praba', '2016-11-18 05:31:28', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(142, 'sabtu', 'sabtu', 'rosli', '2016-11-10', 'Male', '321654987', '', '321654897', '', 'fd08c0b3bd32f53670efcde2e7bc6ec1', '', '3', 1000, '', 'RWCW', 'L', 'rosli', '2016-11-18 05:51:26', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(143, 'roslan', 'roslan', 'praba', '2016-11-03', 'Male', '32165897', '', '32654987', '', '7480988da0d0806071b6a1966188fac3', '', '3', 1000, '', 'RWCW', 'R', 'praba', '2016-11-18 05:54:38', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(123, 'rosli', 'Rosli', 'admin', '2016-11-17', 'Male', '654654654', 'rosli@gmail.com', '987987987', 'KL', 'f11ae6deb12cfe5e9ec59d15a56682ad', '', '3', 100, '', 'RWCW', 'L', 'admin', '2016-11-14 15:36:13', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(132, 'praba', 'praba', 'rosli', '2016-11-17', 'Male', '65498721', '', '321654878', '', '66e47e9e49a0447b59c8de86f2044cd2', '', '3', 100, '', 'RWCW', 'L', 'rosli', '2016-11-15 01:38:38', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(133, 'viki', 'viki', 'rosli', '2016-11-10', 'Male', '987987987', '', '654654654', '', '5819825d46159ca06b3c54b0a0651a3e', '', '3', 100, '', 'RWCW', 'L', 'rosli', '2016-11-15 01:39:18', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(134, 'muthu', 'muthu', 'praba', '2016-11-25', 'Male', '654654654', '', '321321321', '', 'da7b5ec6aabbd9bf940844363b41cbb4', '', '3', 100, '', 'RWCW', 'L', 'praba', '2016-11-15 01:41:10', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(135, 'yati', 'yati', 'rosli', '2016-11-02', 'Female', '654987321', '', '321654987', '', '1a3de730b78358fdd87727f123245162', '', '3', 100, '', 'RWCW', 'R', 'rosli', '2016-11-15 01:48:39', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(136, 'lulu', 'luu', 'praba', '2016-11-23', 'Male', '654987321', '', '321654987', '', '654e4dc5b90b7478671fe6448cab3f32', '', '3', 100, '', 'RWCW', 'L', 'praba', '2016-11-17 12:22:49', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(137, 'samy', 'samy', 'praba', '2016-11-12', 'Male', '9876543', '', '321654987', '', 'da9414575226afc5410f794f728b50d9', '', '3', 100, '', 'RWCW', 'R', 'praba', '2016-11-17 15:01:51', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(138, 'munis', 'munis', 'praba', '2016-11-04', 'Female', '987654132', '', '321654987', '', '0caa1c24e2eda93cf7309e63959d0533', '', '3', 100, '', 'RWCW', 'R', 'praba', '2016-11-17 15:59:40', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', ''),
(139, 'tipah', 'tipah', 'rosli', '2016-11-02', 'Female', '654987', '', '54987897', '', '2274f8ea010bca706eaf9b858cb8180a', '', '3', 100, '', 'RWCW', 'R', 'rosli', '2016-11-17 16:34:47', '', '0000-00-00 00:00:00', '', '', 'Yes', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `binary_dtl`
--
ALTER TABLE `binary_dtl`
  ADD PRIMARY KEY (`bi_id`);

--
-- Indexes for table `binary_hdr`
--
ALTER TABLE `binary_hdr`
  ADD PRIMARY KEY (`bi_id`);

--
-- Indexes for table `binary_hdr_cal`
--
ALTER TABLE `binary_hdr_cal`
  ADD PRIMARY KEY (`bi_id`);

--
-- Indexes for table `binary_hdr_hst`
--
ALTER TABLE `binary_hdr_hst`
  ADD PRIMARY KEY (`bi_id`);

--
-- Indexes for table `bonus_wallet_hdr`
--
ALTER TABLE `bonus_wallet_hdr`
  ADD PRIMARY KEY (`bns_id`);

--
-- Indexes for table `cash_wallet_hdr`
--
ALTER TABLE `cash_wallet_hdr`
  ADD PRIMARY KEY (`ch_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `cycle`
--
ALTER TABLE `cycle`
  ADD PRIMARY KEY (`id_cycle`);

--
-- Indexes for table `euro_rate`
--
ALTER TABLE `euro_rate`
  ADD PRIMARY KEY (`id_rate`);

--
-- Indexes for table `hibah`
--
ALTER TABLE `hibah`
  ADD PRIMARY KEY (`id_hibah`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id_package`),
  ADD UNIQUE KEY `id_package` (`id_package`);

--
-- Indexes for table `product_wallet_hdr`
--
ALTER TABLE `product_wallet_hdr`
  ADD PRIMARY KEY (`pd_id`);

--
-- Indexes for table `reg_wallet_hdr`
--
ALTER TABLE `reg_wallet_hdr`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `roi_dtl`
--
ALTER TABLE `roi_dtl`
  ADD PRIMARY KEY (`roi_id`);

--
-- Indexes for table `roi_hdr`
--
ALTER TABLE `roi_hdr`
  ADD PRIMARY KEY (`roi_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD UNIQUE KEY `role_id` (`role_id`);

--
-- Indexes for table `sponsor_wallet_hdr`
--
ALTER TABLE `sponsor_wallet_hdr`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`trx_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usrname` (`usrname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `binary_dtl`
--
ALTER TABLE `binary_dtl`
  MODIFY `bi_id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `binary_hdr`
--
ALTER TABLE `binary_hdr`
  MODIFY `bi_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `binary_hdr_cal`
--
ALTER TABLE `binary_hdr_cal`
  MODIFY `bi_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;
--
-- AUTO_INCREMENT for table `binary_hdr_hst`
--
ALTER TABLE `binary_hdr_hst`
  MODIFY `bi_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;
--
-- AUTO_INCREMENT for table `bonus_wallet_hdr`
--
ALTER TABLE `bonus_wallet_hdr`
  MODIFY `bns_id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_wallet_hdr`
--
ALTER TABLE `cash_wallet_hdr`
  MODIFY `ch_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT for table `cycle`
--
ALTER TABLE `cycle`
  MODIFY `id_cycle` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `euro_rate`
--
ALTER TABLE `euro_rate`
  MODIFY `id_rate` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hibah`
--
ALTER TABLE `hibah`
  MODIFY `id_hibah` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id_package` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product_wallet_hdr`
--
ALTER TABLE `product_wallet_hdr`
  MODIFY `pd_id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reg_wallet_hdr`
--
ALTER TABLE `reg_wallet_hdr`
  MODIFY `reg_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
--
-- AUTO_INCREMENT for table `roi_dtl`
--
ALTER TABLE `roi_dtl`
  MODIFY `roi_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=673;
--
-- AUTO_INCREMENT for table `roi_hdr`
--
ALTER TABLE `roi_hdr`
  MODIFY `roi_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT for table `sponsor_wallet_hdr`
--
ALTER TABLE `sponsor_wallet_hdr`
  MODIFY `sp_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `trx_id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`cpses_eue0ZhTQly`@`localhost` EVENT `event_calBinary` ON SCHEDULE EVERY 1 DAY STARTS '2016-11-17 00:00:00' ON COMPLETION PRESERVE ENABLE DO BEGIN

CALL calBinary();
CALL calBinary_s2();
CALL calBinary_s3();

END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
