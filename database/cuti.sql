-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cuti
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bagian`
--

DROP TABLE IF EXISTS `bagian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bagian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bagian`
--

LOCK TABLES `bagian` WRITE;
/*!40000 ALTER TABLE `bagian` DISABLE KEYS */;
INSERT INTO `bagian` VALUES (1,'Sekretariat','2023-06-08 14:52:41',NULL,NULL),(2,'Bidang Tata Lingkungan dan Kebersihan','2023-06-08 14:52:41',NULL,NULL);
/*!40000 ALTER TABLE `bagian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catatan_cuti`
--

DROP TABLE IF EXISTS `catatan_cuti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catatan_cuti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `jumlah_cuti_tahunan` int(11) NOT NULL,
  `sisa_cuti_tahunan` int(11) NOT NULL,
  `cuti_tahunan_terpakai` int(11) NOT NULL,
  `jumlah_cuti_besar` int(11) NOT NULL,
  `jumlah_cuti_sakit` int(11) NOT NULL,
  `jumlah_alasan_penting` int(11) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `catatan_cuti_user_id_foreign` (`user_id`),
  CONSTRAINT `catatan_cuti_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catatan_cuti`
--

LOCK TABLES `catatan_cuti` WRITE;
/*!40000 ALTER TABLE `catatan_cuti` DISABLE KEYS */;
INSERT INTO `catatan_cuti` VALUES (2,4,12,6,6,2,5,7,2023,'2023-06-11 14:59:04','2023-06-13 20:03:02',NULL),(3,4,12,3,9,5,6,5,2022,'2023-06-11 14:59:04',NULL,NULL),(4,4,12,1,11,3,3,6,2021,'2023-06-11 14:59:04',NULL,NULL),(5,4,12,0,12,1,2,3,2020,'2023-06-11 14:59:04',NULL,NULL),(6,3,12,0,12,3,2,7,2020,'2023-06-12 01:13:25',NULL,NULL),(7,3,12,0,12,4,1,0,2021,'2023-06-12 01:13:25',NULL,NULL),(8,3,12,3,9,0,0,0,2022,'2023-06-12 01:13:25',NULL,NULL),(9,3,12,8,4,1,1,9,2023,'2023-06-12 01:13:25',NULL,NULL),(10,NULL,12,12,0,0,0,0,2023,NULL,NULL,NULL),(11,NULL,12,12,0,0,0,0,2023,NULL,NULL,NULL),(12,11,12,12,0,0,0,0,2023,'2023-06-12 01:13:25',NULL,NULL),(13,1,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(14,2,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(15,6,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(16,7,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(17,5,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(18,8,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(19,9,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL),(20,10,12,12,0,0,0,0,2023,'2023-06-15 02:37:07',NULL,NULL);
/*!40000 ALTER TABLE `catatan_cuti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabatan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rumpun_jabatan_id` bigint(20) unsigned DEFAULT NULL,
  `subbagian_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jabatan_rumpun_jabatan_id_foreign` (`rumpun_jabatan_id`),
  KEY `jabatan_subbagian_id_foreign` (`subbagian_id`),
  CONSTRAINT `jabatan_rumpun_jabatan_id_foreign` FOREIGN KEY (`rumpun_jabatan_id`) REFERENCES `rumpun_jabatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jabatan_subbagian_id_foreign` FOREIGN KEY (`subbagian_id`) REFERENCES `sub_bagian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatan`
--

LOCK TABLES `jabatan` WRITE;
/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` VALUES (1,'Kepala Dinas',10,8,'2023-06-08 15:09:15','2023-06-12 08:29:54',NULL),(2,'Wakil Kepala Dinas',10,8,'2023-06-08 15:09:15',NULL,NULL),(3,'Sekretaris Dinas',9,8,'2023-06-08 15:09:15',NULL,NULL),(4,'Kepala Subbagian Kepegawaian',6,4,'2023-06-08 15:09:15',NULL,NULL),(5,'Kepala Subbagian Keuangan',8,5,'2023-06-08 15:09:15',NULL,NULL),(6,'Kepala Subbagian Program dan Anggaran',6,6,'2023-06-08 15:09:15',NULL,NULL),(7,'Kepala Subbagian Umum',8,7,'2023-06-08 15:09:15',NULL,NULL),(8,'Analis Kepegawaian Ahli Muda',7,4,'2023-06-08 15:13:16',NULL,NULL),(9,'Analis Kepegawaian Ahli Pertama',7,4,'2023-06-08 15:13:16',NULL,NULL),(10,'Analis Kepegawaian Mahir',7,4,'2023-06-08 15:13:16',NULL,NULL),(11,'Analis Kepegawaian Terampil',7,4,'2023-06-08 15:13:16',NULL,NULL),(12,'Pengadministrasi Kepegawaian',11,4,'2023-06-08 15:17:07',NULL,NULL),(13,'Pengelola Kepegawaian ',1,4,'2023-06-08 15:17:07',NULL,NULL),(14,'Pengelola Kepegawaian ',2,4,'2023-06-08 15:17:07',NULL,NULL),(15,'Bendahara Pengeluaran',2,5,'2023-06-08 15:30:10',NULL,NULL),(16,'Bendahara Penerimaan',2,5,'2023-06-08 15:30:10',NULL,NULL),(17,'Pengadministrasi Keuangan',11,5,'2023-06-08 15:30:10',NULL,NULL),(19,'Pengolah Data Keuangan',1,4,'2023-06-08 15:30:10',NULL,NULL),(20,'Kepala Bidang Tata Lingkungan Dan Kebersihan',9,9,'2023-06-08 15:43:43',NULL,NULL),(21,'Kepala Seksi Mitigasi dan Adaptasi Perubahan Iklim',6,1,'2023-06-08 15:43:43',NULL,NULL),(23,'Pengendali Dampak Lingkungan Ahli Muda',7,2,'2023-06-08 15:43:43',NULL,NULL),(24,'Pengendali Dampak Lingkungan Ahli Pertama',7,2,'2023-06-08 15:43:43',NULL,NULL),(25,'Pengelola Mitigasi dan Adaptasi Perubahan Iklim',1,1,'2023-06-08 15:43:43',NULL,NULL),(26,'Pengelola Mitigasi dan Adaptasi Perubahan Iklim',2,1,'2023-06-08 15:43:43',NULL,NULL),(27,'Pengendali Dampak Lingkungan Ahli Madya',7,2,'2023-06-08 15:43:43',NULL,NULL),(29,'Coba dulu 1',1,1,'2023-06-12 08:25:22','2023-06-12 08:25:26','2023-06-12 08:25:26');
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_05_25_134034_create_perizinan_cutis_table',1),(6,'2023_06_05_174741_catatan_cuti',1),(7,'2023_06_05_175137_create_rumpun_jabatans_table',1),(8,'2023_06_05_175226_create_bagians_table',1),(9,'2023_06_05_175229_create_sub_bagians_table',1),(10,'2023_06_05_175302_create_jabatans_table',1),(11,'2023_06_07_155812_create_foreignkey_users_jabatan',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perizinan_cuti`
--

DROP TABLE IF EXISTS `perizinan_cuti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perizinan_cuti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `jenis_cuti_id` int(10) unsigned NOT NULL,
  `alasan_cuti` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_menjalankan_cuti` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `mulai_cuti` date NOT NULL,
  `akhir_cuti` date NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atasan_langsung_id` bigint(20) unsigned DEFAULT NULL,
  `status_persetujuan_atasan_langsung` int(11) DEFAULT NULL COMMENT 'Status yang dipertimbangkan oleh atasan langsung: Status 1. Disetujui, 2. Perubahan, 3. Ditangguhkan, 4. Tidak Disetujui',
  `alasan_persetujuan_atasan_langsung` text COLLATE utf8mb4_unicode_ci,
  `pejabat_berwenang_id` bigint(20) unsigned DEFAULT NULL,
  `status_keputusan_pejabat_berwenang` int(11) DEFAULT NULL COMMENT 'Status yang dipertimbangkan oleh pejabat yang berwenang: Status 1. Disetujui, 2. Perubahan, 3. Ditangguhkan, 4. Tidak Disetujui',
  `alasan_keputusan_pejabat_berwenang` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perizinan_cuti_user_id_foreign` (`user_id`),
  KEY `perizinan_cuti_atasan_langsung_id_foreign` (`atasan_langsung_id`),
  KEY `perizinan_cuti_pejabat_berwenang_id_foreign` (`pejabat_berwenang_id`),
  CONSTRAINT `perizinan_cuti_atasan_langsung_id_foreign` FOREIGN KEY (`atasan_langsung_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `perizinan_cuti_pejabat_berwenang_id_foreign` FOREIGN KEY (`pejabat_berwenang_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `perizinan_cuti_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perizinan_cuti`
--

LOCK TABLES `perizinan_cuti` WRITE;
/*!40000 ALTER TABLE `perizinan_cuti` DISABLE KEYS */;
INSERT INTO `perizinan_cuti` VALUES (1,4,1,'Mogok','Disni',1,'2023-03-02','2023-03-02','0851234564',NULL,3,1,'Oke Di acc 12-06',2,1,'Oke','2023-06-11 16:46:02','2023-06-13 09:03:24',NULL),(2,4,1,'Laptop Rusak','Disana',1,'2023-05-29','2023-05-30','0851235675',NULL,3,1,'Oke',2,1,'Oke','2023-06-11 16:56:02','2023-06-13 08:57:54',NULL),(3,4,1,'asdasd','asdasd',1,'2023-06-01','2023-06-02','0851235675',NULL,NULL,1,'Oke',NULL,1,'Disetujui pejabat','2023-06-12 14:51:48','2023-06-13 20:03:02',NULL),(4,3,1,'mn,,n,','Jl. Cipinang',1,'2023-06-23','2023-06-23','081280200290',NULL,2,1,'Oke',1,99,NULL,'2023-06-12 10:59:36','2023-06-13 20:02:02',NULL),(5,4,1,'cucti','Jl. Bedahan',1,'2023-06-07','2023-06-07','085772086872',NULL,3,NULL,NULL,2,NULL,NULL,'2023-06-13 18:09:56','2023-06-13 18:09:56',NULL),(6,11,1,'Benerin Laptop','Dongkal\r\nDepok',1,'2023-06-28','2023-06-28','085654234123',NULL,3,NULL,NULL,2,NULL,NULL,'2023-06-13 18:13:32','2023-06-13 18:13:32',NULL),(7,11,1,'1','Dongkal\r\nDepok',1,'2023-06-27','2023-06-27','085654234123',NULL,3,NULL,NULL,2,NULL,NULL,'2023-06-13 18:15:34','2023-06-13 18:15:34',NULL),(8,11,1,'test','Dongkal\r\nDepok',1,'2023-06-22','2023-06-22','085654234123',NULL,3,NULL,NULL,2,NULL,NULL,'2023-06-13 18:16:14','2023-06-13 18:16:14',NULL),(9,11,1,'asdsad','Dongkal\r\nDepok',1,'2023-06-22','2023-06-22','085654234123',NULL,3,NULL,NULL,2,NULL,NULL,'2023-06-13 18:17:25','2023-06-13 18:17:25',NULL),(10,4,1,'Benerin Laptop','Jl. Bedahan',1,'2023-06-21','2023-06-21','085772086872',NULL,3,NULL,NULL,2,NULL,NULL,'2023-06-13 20:01:00','2023-06-13 20:01:00',NULL),(11,5,2,'FF','Jl. Cikarang',22,'2023-07-06','2023-07-27','081296988778',NULL,3,99,NULL,1,NULL,NULL,'2023-06-14 20:51:20','2023-06-14 20:51:20',NULL);
/*!40000 ALTER TABLE `perizinan_cuti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rumpun_jabatan`
--

DROP TABLE IF EXISTS `rumpun_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rumpun_jabatan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rumpun_jabatan`
--

LOCK TABLES `rumpun_jabatan` WRITE;
/*!40000 ALTER TABLE `rumpun_jabatan` DISABLE KEYS */;
INSERT INTO `rumpun_jabatan` VALUES (1,'Teknis Tingkat Terampil',4,'2023-06-08 14:56:43',NULL),(2,'Teknis Tingkat Ahli',4,'2023-06-08 14:56:43',NULL),(3,'Pelayanan Tingkat Terampil',4,'2023-06-08 14:56:43',NULL),(4,'Pelayanan Tingkat Ahli',4,'2023-06-08 14:56:43',NULL),(5,'Operasional Tingkat Terampil',4,'2023-06-08 14:56:43',NULL),(6,'JFT SUBKOORDINATOR',3,'2023-06-08 14:56:43',NULL),(7,'JFT',4,'2023-06-08 14:56:43',NULL),(8,'Eselon IV',3,'2023-06-08 14:56:43',NULL),(9,'Eselon III',2,'2023-06-08 14:56:43',NULL),(10,'Eselon II',1,'2023-06-08 14:56:43',NULL),(11,'Administrasi Tingkat Terampil',4,'2023-06-08 14:56:43',NULL);
/*!40000 ALTER TABLE `rumpun_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_bagian`
--

DROP TABLE IF EXISTS `sub_bagian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_bagian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_bagian_bagian_id_foreign` (`bagian_id`),
  CONSTRAINT `sub_bagian_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_bagian`
--

LOCK TABLES `sub_bagian` WRITE;
/*!40000 ALTER TABLE `sub_bagian` DISABLE KEYS */;
INSERT INTO `sub_bagian` VALUES (1,'Seksi Mitigasi dan Adaptasi Perubahan Iklim',2,'2023-06-08 14:54:36',NULL,NULL),(2,'Seksi Pengembangan Teknis Lingkungan dan Kebersihan',2,'2023-06-08 14:54:36',NULL,NULL),(3,'Seksi Perencanaan Teknis Lingkungan Dan Kebersihan',2,'2023-06-08 14:54:36',NULL,NULL),(4,'Subbagian Kepegawaian',1,'2023-06-08 14:54:36',NULL,NULL),(5,'Subbagian Keuangan',1,'2023-06-08 14:54:36',NULL,NULL),(6,'Subbagian Perencanaan dan Anggaran',1,'2023-06-08 14:54:36',NULL,NULL),(7,'Subbagian Umum',1,'2023-06-08 14:54:36',NULL,NULL),(8,'Sekretariat',1,'2023-06-08 14:54:36',NULL,NULL),(9,'Bidang Tata Lingkungan Dan Kebersihan',2,'2023-06-08 14:54:36',NULL,NULL);
/*!40000 ALTER TABLE `sub_bagian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar_depan` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_belakang` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` bigint(20) unsigned DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` int(11) NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt_masuk` date NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nip_unique` (`nip`),
  UNIQUE KEY `users_nik_unique` (`nik`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_jabatan_id_foreign` (`jabatan_id`),
  CONSTRAINT `users_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'197309021998031006','3276010209730001','asepkuswanto@yahoo.com','Asep Kuswanto',NULL,'S.E, M.Si',1,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1973-02-09','Jakarta',1,'Jl. Depok','0811869709','1998-03-01',NULL,'2023-06-10 08:22:53',NULL,NULL),(2,'196510251985011003','3172022510650001','goldenmadania18@yahoo.com','Mahmuri',NULL,'S.E, M.M',3,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1965-10-25','Jakarta',1,'Jl. Depok','081389071669','1985-01-01',NULL,'2023-06-10 08:26:50',NULL,NULL),(3,'198411182010011019','3175031811840005','matt84@gmail.com','Mathew Musa Hamonangan',NULL,'S.T',4,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1984-11-18','Jakarta',1,'Jl. Cipinang','081280200290','2010-01-01',NULL,'2023-06-10 08:35:08',NULL,NULL),(4,'197806112014121004','3174091106780013','sangboyo39@gmail.com','Arif Suryo Birowo',NULL,'A.Md',13,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1978-11-06','Jakarta',1,'Jl. Bedahan','085772086872','2014-12-01',NULL,'2023-06-10 10:03:15',NULL,NULL),(5,'197711151998031003','3216091511770012','ary77prabowo@gmail.com','Ary Prabowo S',NULL,'S.Sos',14,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1977-11-15','Bekasi',1,'Jl. Cikarang','081296988778','1998-03-01',NULL,'2023-06-10 10:03:15','2023-06-12 06:44:16',NULL),(6,'197211291993031008','3172042911720004','dadangcahya@gmail.com','Dadang Cahya Rusdiana',NULL,'S.Sos., M.Si',7,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1972-11-29','Jakarta',1,'Jl. Sunter Jaya','081296988778','1993-01-03',NULL,'2023-06-10 14:03:31',NULL,NULL),(7,'197201071994032004','3275034701720030','nining_alvin@yahoo.com','Suryaningsih',NULL,NULL,12,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1972-01-07','Bekasi Utara',1,'Jl. Kalimalang','081296988778','1994-01-03',NULL,'2023-06-10 14:03:31','2023-06-12 07:10:31',NULL),(8,'199803312020122011','3275097103980007','ep_fitratunnisa@yahoo.com','Erni Pelita Fitratunnisa','Ir.','M.E',20,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1969-03-19','Jakarta',2,'Jl. Kalibata','081296988778','1993-01-03',NULL,'2023-06-10 14:03:31',NULL,NULL),(9,'198102152010011019','3674061502810005','darmawanadi@gmail.com','Adi Darmawan',NULL,'S.T',21,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1981-02-15','Metro',1,'Kec. Pamulang','081575063331','2010-01-01',NULL,'2023-06-10 14:03:31',NULL,NULL),(10,'198202232006042017','8171026302820008','rifaluv23@gmail.com','Syarifa Dewi Assagaff',NULL,'S.T, M.I.L',26,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1982-02-23','Ambon',2,'Kec. Ciputat','081575063331','2006-01-04',NULL,'2023-06-10 14:03:31',NULL,NULL),(11,'1234567890','142165437432','cahaya0698@gmail.com','Cahaya Lailla Ramadhani',NULL,'MM',13,'$2y$10$hM6r0MXV1hGEF/fmfqI9weQuDAAX.7DV22u64i1WSrIM651Nfmz8q','2000-12-24','Depok',1,'Dongkal\r\nDepok',NULL,'2023-05-24',NULL,'2023-06-13 18:10:52','2023-06-13 18:10:52',NULL),(12,'198609112011012023','3275035109860016','kenapatanya@gmail.com','Tannya Septiorami',NULL,'S.T',8,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1986-09-11','JAKARTA',2,'Kota Bekasi','081298744411','2011-01-01',NULL,'2023-06-15 03:09:09',NULL,NULL),(13,'196602021989071001','3174090202660007','kepeg.dinaskebersihan@yahoo.com','Ramlan',NULL,'S.E',9,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1966-02-02','CIAMIS',1,'Bekasi','082125656013','1989-07-01',NULL,'2023-06-15 03:09:09',NULL,NULL),(14,'198506282014122007','3172046806850015','roseminie36@gmail.com','Rusmini',NULL,NULL,10,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1985-06-28','JAKARTA',2,'Jakarta Utara','087768316352','2014-12-01',NULL,'2023-06-15 03:09:09',NULL,NULL),(15,'197902062014121004','3172040602790004','sandiretno@gmail.com','Sandi Retno',NULL,NULL,11,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1979-02-06','BREBES',1,'Jakarta Utara','081219983981','2014-12-01',NULL,'2023-06-15 03:09:09',NULL,NULL),(16,'197709022014121004','3306090209770001','verlixisnhudewanto@gmail.com','Verlix Isnhu Dewanto',NULL,NULL,12,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1977-09-02','PURWOREJO',1,'Jakarta Pusat','088210606944','2014-12-01',NULL,'2023-06-15 03:09:09',NULL,NULL),(17,'197312252010012005','3174026512730001','ii_rahma@yahoo.co.id','Euis Rahmayanti',NULL,'S.H',10,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','1973-12-25','JAKARTA',2,'Jakarta Selatan','081398580198','2010-01-01',NULL,'2023-06-15 03:09:09',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-09 11:03:21
