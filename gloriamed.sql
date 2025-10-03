-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 03, 2025 at 08:22 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gloriamed`
--

-- --------------------------------------------------------

--
-- Table structure for table `biochimia`
--

DROP TABLE IF EXISTS `biochimia`;
CREATE TABLE IF NOT EXISTS `biochimia` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` int(11) NOT NULL,
  `biochimia_checkbox` bit(1) DEFAULT b'0',
  `proba_biochimia_checkbox` bit(1) DEFAULT b'0',
  `rezultat_biochimia_file` varchar(255) DEFAULT NULL,
  `rezultat_biochimia_text` text,
  `colesterol_total_checkbox` bit(1) DEFAULT b'0',
  `hdl_colesterol_checkbox` bit(1) DEFAULT b'0',
  `ldl_colesterol_checkbox` bit(1) DEFAULT b'0',
  `trigliceride_checkbox` bit(1) DEFAULT b'0',
  `ureea_checkbox` bit(1) DEFAULT b'0',
  `creatina_checkbox` bit(1) DEFAULT b'0',
  `afp_checkbox` bit(1) DEFAULT b'0',
  `proba_afp_checkbox` bit(1) DEFAULT b'0',
  `glucoza_checkbox` bit(1) DEFAULT b'0',
  `alt_checkbox` bit(1) DEFAULT b'0',
  `ast_checkbox` bit(1) DEFAULT b'0',
  `alfa_amilaza_checkbox` bit(1) DEFAULT b'0',
  `fosfataza_alcalina_checkbox` bit(1) DEFAULT b'0',
  `ldh_lactat_dehidratat_checkbox` bit(1) DEFAULT b'0',
  `bilirubina_totala_checkbox` bit(1) DEFAULT b'0',
  `bilirubina_dreapta_checkbox` bit(1) DEFAULT b'0',
  `lipaza_checkbox` bit(1) DEFAULT b'0',
  `proteina_totala_checkbox` bit(1) DEFAULT b'0',
  `albumina_ser_checkbox` bit(1) DEFAULT b'0',
  `acid_uric_checkbox` bit(1) DEFAULT b'0',
  `ggt_checkbox` bit(1) DEFAULT b'0',
  `magneziu_checkbox` bit(1) DEFAULT b'0',
  `calciu_checkbox` bit(1) DEFAULT b'0',
  `ferum_checkbox` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cnam`
--

DROP TABLE IF EXISTS `cnam`;
CREATE TABLE IF NOT EXISTS `cnam` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numele` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenumele` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nasterii` date NOT NULL,
  `idnp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localitatea` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sectorul` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strada` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `casa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocul` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartamentul` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_info` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cnam_idnp_unique` (`idnp`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cnam`
--

INSERT INTO `cnam` (`id`, `numele`, `prenumele`, `data_nasterii`, `idnp`, `localitatea`, `sectorul`, `strada`, `casa`, `blocul`, `apartamentul`, `full_info`, `created_at`, `updated_at`) VALUES
(1, 'Sarbu', 'Dorin', '1990-05-12', '1234567890123', 'Chișinău', 'Centru', 'Ștefan cel Mare', '10', 'A', '15', 'Sarbu Dorin 1990-05-12', '2025-09-23 02:57:09', '2025-09-26 07:18:25'),
(2, 'Ionescu', 'Ioana', '1985-11-20', '9876543210987', 'Bălți', NULL, 'Independenței', '22', NULL, '5', 'Ionescu Ioana 1985-11-20', '2025-09-23 02:57:09', '2025-09-23 07:56:21'),
(4, 'Maxim', 'Viorel', '2000-02-16', '777777777777777', 'Chisinau', 'Ciocana', NULL, '7', '5', '25', 'Maxim Viorel 2000-02-16', '2025-09-26 07:19:52', '2025-09-26 07:19:52'),
(5, 'Sarbu', 'Mihai', '2005-06-01', '99999999999999999', 'criuleni', NULL, NULL, NULL, NULL, NULL, 'Sarbu Mihai 2005-06-01', '2025-09-29 07:29:47', '2025-09-29 07:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `cnam_laborator`
--

DROP TABLE IF EXISTS `cnam_laborator`;
CREATE TABLE IF NOT EXISTS `cnam_laborator` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` bigint(20) UNSIGNED NOT NULL,
  `laborator_id` bigint(20) UNSIGNED NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `categoria` varchar(255) NOT NULL,
  `proba` json NOT NULL,
  `rezultat_text` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cnam_laborator_cnam` (`cnam_id`),
  KEY `fk_cnam_laborator_laborator` (`laborator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cnam_laborator`
--

INSERT INTO `cnam_laborator` (`id`, `cnam_id`, `laborator_id`, `checked`, `categoria`, `proba`, `rezultat_text`, `created_at`, `updated_at`) VALUES
(129, 1, 40, 0, 'urograma', '\"{\\\"name\\\": \\\"Proba urograma\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(128, 1, 39, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba HbA1c\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(127, 1, 38, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba HBsAg\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(126, 1, 37, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba PSA\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(125, 1, 36, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba TSH\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(124, 1, 35, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba TT4\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(123, 1, 34, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba TT3\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(122, 1, 33, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba PCR\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(121, 1, 32, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba factor reumatic\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(120, 1, 31, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba Antistreptolizina-O\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(119, 1, 30, 0, 'imunologia', '\"{\\\"name\\\": \\\"Proba imunologia\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(118, 1, 5, 0, 'hiv', '\"{\\\"name\\\": \\\"Proba MRS HIV\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(117, 1, 4, 0, 'hemostaza', '\"{\\\"name\\\": \\\"Proba hemostaza\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(116, 1, 3, 0, 'hemograma', '\"{\\\"name\\\": \\\"Proba coagulograma\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(115, 1, 2, 0, 'hemograma', '\"{\\\"name\\\": \\\"Proba VSH\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(114, 1, 1, 0, 'hemograma', '\"{\\\"name\\\": \\\"Proba hemograma\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(113, 1, 43, 0, 'coprologia', '\"{\\\"name\\\": \\\"Proba sange ocult\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(112, 1, 42, 0, 'coprologia', '\"{\\\"name\\\": \\\"Proba helminti\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(111, 1, 41, 0, 'coprologia', '\"{\\\"name\\\": \\\"Proba coprologia\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(110, 1, 29, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba ferum\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(109, 1, 28, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba calciu\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(108, 1, 27, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba magneziu\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(107, 1, 26, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba GGT\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(106, 1, 25, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba acid uric\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(105, 1, 24, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba albumina (ser)\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(104, 1, 23, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba proteina totala\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(103, 1, 22, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba lipaza\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(102, 1, 21, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba bilirubina directa\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(101, 1, 20, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba bilirubina totala\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(100, 1, 19, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba LDH lactat dehidratat\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(99, 1, 18, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba fosfataza alcalina\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(98, 1, 17, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba alfa-amilaza\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(97, 1, 16, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba AST\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(96, 1, 15, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba ALT\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(95, 1, 14, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba glucoza\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(94, 1, 13, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba AFP\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(93, 1, 12, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba creatina\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(92, 1, 11, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba ureea\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(91, 1, 10, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba trigliceride\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(90, 1, 9, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba LDL-colesterol\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(89, 1, 8, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba HDL-colesterol\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(88, 1, 7, 1, 'biochimia', '\"{\\\"name\\\": \\\"Proba colesterol total\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36'),
(87, 1, 6, 0, 'biochimia', '\"{\\\"name\\\": \\\"Proba biochimia\\\"}\"', NULL, '2025-09-24 09:57:36', '2025-09-24 09:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `coprologia`
--

DROP TABLE IF EXISTS `coprologia`;
CREATE TABLE IF NOT EXISTS `coprologia` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` int(11) NOT NULL,
  `coprologia_checkbox` bit(1) DEFAULT b'0',
  `proba_coprologia_checkbox` bit(1) DEFAULT b'0',
  `rezultat_coprologia_file` varchar(255) DEFAULT NULL,
  `rezultat_coprologia_text` text,
  `helminti_checkbox` bit(1) DEFAULT b'0',
  `sange_ocult_checkbox` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fisiere`
--

DROP TABLE IF EXISTS `fisiere`;
CREATE TABLE IF NOT EXISTS `fisiere` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_laborator_id` bigint(20) UNSIGNED NOT NULL,
  `cale_fisier` varchar(255) NOT NULL,
  `tip` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fisiere_cnam_laborator` (`cnam_laborator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hemograma`
--

DROP TABLE IF EXISTS `hemograma`;
CREATE TABLE IF NOT EXISTS `hemograma` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` bigint(20) UNSIGNED NOT NULL,
  `hemograma_checkbox` tinyint(1) DEFAULT '0',
  `proba_hemograma_checkbox` tinyint(1) DEFAULT '0',
  `rezultat_hemograma_file` varchar(255) DEFAULT NULL,
  `rezultat_hemograma_text` text,
  `vsh_checkbox` tinyint(1) DEFAULT '0',
  `rezultat_vsh_file` varchar(255) DEFAULT NULL,
  `cuagolograma_checkbox` tinyint(1) DEFAULT '0',
  `rezultat_cuagolograma_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hemostaza`
--

DROP TABLE IF EXISTS `hemostaza`;
CREATE TABLE IF NOT EXISTS `hemostaza` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` int(11) NOT NULL,
  `hemostaza_checkbox` bit(1) DEFAULT b'0',
  `proba_hemostaza_checkbox` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hiv`
--

DROP TABLE IF EXISTS `hiv`;
CREATE TABLE IF NOT EXISTS `hiv` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` int(11) NOT NULL,
  `mrs_hiv_checkbox` bit(1) DEFAULT b'0',
  `proba_mrs_hiv_checkbox` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `imunologia`
--

DROP TABLE IF EXISTS `imunologia`;
CREATE TABLE IF NOT EXISTS `imunologia` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` int(11) NOT NULL,
  `imunologia_checkbox` bit(1) DEFAULT b'0',
  `proba_imunologia_checkbox` bit(1) DEFAULT b'0',
  `rezultat_imunologia_file` varchar(255) DEFAULT NULL,
  `rezultat_imunologia_text` text,
  `antistreptolizina_o_checkbox` bit(1) DEFAULT b'0',
  `factor_reumatic_checkbox` bit(1) DEFAULT b'0',
  `pcr_checkbox` bit(1) DEFAULT b'0',
  `tt3_checkbox` bit(1) DEFAULT b'0',
  `tt4_checkbox` bit(1) DEFAULT b'0',
  `tsh_checkbox` bit(1) DEFAULT b'0',
  `psa_checkbox` bit(1) DEFAULT b'0',
  `hbsag_checkbox` bit(1) DEFAULT b'0',
  `proba_hbsag_checkbox` bit(1) DEFAULT b'0',
  `hba1c_checkbox` bit(1) DEFAULT b'0',
  `proba_hba1c_checkbox` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `laborator`
--

DROP TABLE IF EXISTS `laborator`;
CREATE TABLE IF NOT EXISTS `laborator` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pacient_id` bigint(20) UNSIGNED NOT NULL,
  `hemograma` tinyint(1) DEFAULT '0',
  `proba_hemograma` tinyint(1) DEFAULT '0',
  `rezultat_hemograma_text` text,
  `vsh` tinyint(1) DEFAULT '0',
  `rezultat_vsh_text` text,
  `coagulograma` tinyint(1) DEFAULT '0',
  `rezultat_coagulograma_text` text,
  `hemostaza` tinyint(1) DEFAULT '0',
  `proba_hemostaza` tinyint(1) DEFAULT '0',
  `mrs_hiv` tinyint(1) DEFAULT '0',
  `proba_mrs_hiv` tinyint(1) DEFAULT '0',
  `biochimia` tinyint(1) DEFAULT '0',
  `proba_biochimia` tinyint(1) DEFAULT '0',
  `rezultat_biochimia_text` text,
  `colesterol_total` tinyint(1) DEFAULT '0',
  `hdl_colesterol` tinyint(1) DEFAULT '0',
  `ldl_colesterol` tinyint(1) DEFAULT '0',
  `trigliceride` tinyint(1) DEFAULT '0',
  `ureea` tinyint(1) DEFAULT '0',
  `creatina` tinyint(1) DEFAULT '0',
  `afp` tinyint(1) DEFAULT '0',
  `proba_afp` tinyint(1) DEFAULT '0',
  `glucoza` tinyint(1) DEFAULT '0',
  `alt` tinyint(1) DEFAULT '0',
  `ast` tinyint(1) DEFAULT '0',
  `alfa_amilaza` tinyint(1) DEFAULT '0',
  `fosfataza_alcalina` tinyint(1) DEFAULT '0',
  `ldh` tinyint(1) DEFAULT '0',
  `bilirubina_totala` tinyint(1) DEFAULT '0',
  `bilirubina_directa` tinyint(1) DEFAULT '0',
  `lipaza` tinyint(1) DEFAULT '0',
  `proteina_totala` tinyint(1) DEFAULT '0',
  `albumina` tinyint(1) DEFAULT '0',
  `acid_uric` tinyint(1) DEFAULT '0',
  `ggt` tinyint(1) DEFAULT '0',
  `magneziu` tinyint(1) DEFAULT '0',
  `calciu` tinyint(1) DEFAULT '0',
  `ferum` tinyint(1) DEFAULT '0',
  `imunologia` tinyint(1) DEFAULT '0',
  `proba_imunologia` tinyint(1) DEFAULT '0',
  `rezultat_imunologia_text` text,
  `antistreptolizina_o` tinyint(1) DEFAULT '0',
  `factor_reumatic` tinyint(1) DEFAULT '0',
  `pcr` tinyint(1) DEFAULT '0',
  `tt3` tinyint(1) DEFAULT '0',
  `tt4` tinyint(1) DEFAULT '0',
  `tsh` tinyint(1) DEFAULT '0',
  `psa` tinyint(1) DEFAULT '0',
  `hbsag` tinyint(1) DEFAULT '0',
  `proba_hbsag` tinyint(1) DEFAULT '0',
  `hba1c` tinyint(1) DEFAULT '0',
  `proba_hba1c` tinyint(1) DEFAULT '0',
  `urograma` tinyint(1) DEFAULT '0',
  `proba_urograma` tinyint(1) DEFAULT '0',
  `rezultat_urograma_text` text,
  `coprologia` tinyint(1) DEFAULT '0',
  `proba_coprologia` tinyint(1) DEFAULT '0',
  `rezultat_coprologia_text` text,
  `helminti` tinyint(1) DEFAULT '0',
  `sange_ocult` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_laborator_pacient` (`pacient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laborator`
--

INSERT INTO `laborator` (`id`, `pacient_id`, `hemograma`, `proba_hemograma`, `rezultat_hemograma_text`, `vsh`, `rezultat_vsh_text`, `coagulograma`, `rezultat_coagulograma_text`, `hemostaza`, `proba_hemostaza`, `mrs_hiv`, `proba_mrs_hiv`, `biochimia`, `proba_biochimia`, `rezultat_biochimia_text`, `colesterol_total`, `hdl_colesterol`, `ldl_colesterol`, `trigliceride`, `ureea`, `creatina`, `afp`, `proba_afp`, `glucoza`, `alt`, `ast`, `alfa_amilaza`, `fosfataza_alcalina`, `ldh`, `bilirubina_totala`, `bilirubina_directa`, `lipaza`, `proteina_totala`, `albumina`, `acid_uric`, `ggt`, `magneziu`, `calciu`, `ferum`, `imunologia`, `proba_imunologia`, `rezultat_imunologia_text`, `antistreptolizina_o`, `factor_reumatic`, `pcr`, `tt3`, `tt4`, `tsh`, `psa`, `hbsag`, `proba_hbsag`, `hba1c`, `proba_hba1c`, `urograma`, `proba_urograma`, `rezultat_urograma_text`, `coprologia`, `proba_coprologia`, `rezultat_coprologia_text`, `helminti`, `sange_ocult`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, NULL, 0, NULL, 0, NULL, 1, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, NULL, 0, 0, '2025-09-26 05:50:03', '2025-09-30 10:00:44'),
(2, 1, 0, 0, NULL, 0, NULL, 0, NULL, 1, 0, 1, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, NULL, 0, 0, '2025-09-26 05:51:20', '2025-09-30 10:07:15'),
(3, 4, 1, 0, NULL, 1, NULL, 0, NULL, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, 0, 0, '2025-09-26 07:21:42', '2025-09-26 07:21:42'),
(4, 5, 1, 0, NULL, 0, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, 0, 0, '2025-09-30 10:46:36', '2025-09-30 10:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `laborator_fisiere`
--

DROP TABLE IF EXISTS `laborator_fisiere`;
CREATE TABLE IF NOT EXISTS `laborator_fisiere` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `laborator_id` bigint(20) UNSIGNED NOT NULL,
  `tip_rezultat` varchar(50) NOT NULL,
  `fisier` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_laborator_fisiere` (`laborator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laborator_fisiere`
--

INSERT INTO `laborator_fisiere` (`id`, `laborator_id`, `tip_rezultat`, `fisier`, `created_at`, `updated_at`) VALUES
(5, 2, 'coprologia', 'analize/Dv9HCSyB3g3LBhCDC0tOmdzoIXwWoxTolBxXzFCS.pdf', '2025-09-26 07:05:29', '2025-09-26 07:05:29'),
(2, 1, 'hemograma', 'analize/DXOp0155QBgOFhi2nTBdYWEAQ3eCil8huMv3SSEl.pdf', '2025-09-26 05:50:59', '2025-09-26 05:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2025_09_23_054943_create_cnam_table', 1),
(11, '2025_09_23_114738_add_role_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proceduri`
--

DROP TABLE IF EXISTS `proceduri`;
CREATE TABLE IF NOT EXISTS `proceduri` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pacient_id` bigint(20) UNSIGNED NOT NULL,
  `data_procedurii` date DEFAULT NULL,
  `hemograma` tinyint(1) DEFAULT '0',
  `urograma` tinyint(1) DEFAULT '0',
  `biochimia` tinyint(1) DEFAULT '0',
  `imunologia` tinyint(1) DEFAULT '0',
  `hba1c` tinyint(1) DEFAULT '0',
  `hbsag` tinyint(1) DEFAULT '0',
  `mrs_hiv` tinyint(1) DEFAULT '0',
  `afp` tinyint(1) DEFAULT '0',
  `hemostaza` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proceduri_pacient_id_foreign` (`pacient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proceduri`
--

INSERT INTO `proceduri` (`id`, `pacient_id`, `data_procedurii`, `hemograma`, `urograma`, `biochimia`, `imunologia`, `hba1c`, `hbsag`, `mrs_hiv`, `afp`, `hemostaza`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-09-30', 1, 1, 1, 0, 0, 0, 0, 0, 1, '2025-09-30 07:06:36', '2025-09-30 10:00:44'),
(6, 1, NULL, 0, 1, 1, 0, 0, 0, 1, 0, 1, '2025-09-30 09:56:11', '2025-09-30 10:07:15'),
(8, 5, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-30 10:46:36', '2025-09-30 10:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `urograma`
--

DROP TABLE IF EXISTS `urograma`;
CREATE TABLE IF NOT EXISTS `urograma` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnam_id` int(11) NOT NULL,
  `urograma_checkbox` bit(1) DEFAULT b'0',
  `proba_urograma_checkbox` bit(1) DEFAULT b'0',
  `rezultat_urograma_file` varchar(255) DEFAULT NULL,
  `rezultat_urograma_text` text,
  PRIMARY KEY (`id`),
  KEY `cnam_id` (`cnam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('principal','secundar','vizualizare') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vizualizare',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 'vizualizare1', NULL, NULL, '$2y$12$ZH9FyyY5r825K2CZMmsvCuOs4nuQSlOOzP4GrymLxlyoqq8p8j22e', 'vizualizare', NULL, '2025-09-23 09:07:29', '2025-09-23 09:07:29'),
(8, 'secundar1', NULL, NULL, '$2y$12$TuHCAY1CZQscW1sWAGMoye1AGlZWvUHrWW2RrlJiCr.UhIJFaahvy', 'secundar', NULL, '2025-09-23 09:07:29', '2025-09-23 09:07:29'),
(7, 'admin', NULL, NULL, '$2y$12$oiAbYOexqvn6XLUh4j7W6uiuUhUDaOl1Mtl/xzZsv1Xuu9w1xya2O', 'principal', NULL, '2025-09-23 09:07:29', '2025-09-26 07:11:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
