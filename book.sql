-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Mar 2021 pada 15.33
-- Versi server: 10.1.30-MariaDB
-- Versi PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id_book` bigint(20) UNSIGNED NOT NULL,
  `name_book` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_release` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages_book` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id_book`, `name_book`, `author`, `publisher`, `time_release`, `pages_book`, `created_at`, `updated_at`) VALUES
(1, 'Kumpulan Resep Jajanan Pasar', 'Sujidtah', 'Graha Caka Pustaka', '2015', '100', '2021-03-19 11:27:10', '2021-03-19 11:32:36'),
(2, 'Aljabar Matriks Linier Permulaan', 'Aji Said', 'Gramedia', '2018', '300', '2021-03-19 11:32:23', '2021-03-19 11:32:30'),
(3, 'Algoritma Dasar', 'Sutarman', 'Graha Caka Pustaka', '2010', '300', '2021-03-20 03:18:22', '2021-03-20 03:18:22'),
(4, 'Javascript untuk pemula', 'Ilham Amin', 'Gramedia', '2010', '155', '2021-03-20 10:30:39', '2021-03-20 10:30:39'),
(5, 'Pengenalan Kalkurus', 'Iwanto', 'Cipta Muda Bangsa', '2010', '220', '2021-03-20 12:52:40', '2021-03-20 12:52:40'),
(6, 'Pengenalan Pemrograman Web', 'Ridwan Kazami', 'Gramedia', '2017', '285', '2021-03-21 15:04:11', '2021-03-21 15:04:11'),
(7, 'Belajar Sistem Cerdas', 'Saucha Diwandari', 'Gramedia', '2018', '350', '2021-03-26 15:08:41', '2021-03-26 15:08:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_borrows`
--

CREATE TABLE `book_borrows` (
  `code_borrow` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `time_borrow` date NOT NULL,
  `time_return` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `book_borrows`
--

INSERT INTO `book_borrows` (`code_borrow`, `id_user`, `time_borrow`, `time_return`, `status`, `created_at`, `updated_at`) VALUES
('Ibgtw7M', 3, '2021-03-23', '2021-03-25', 'return', '2021-03-21 15:01:45', '2021-03-21 15:01:45'),
('m9zlz0U', 4, '2021-03-26', '2021-03-30', 'borrow', '2021-03-26 11:00:32', '2021-03-26 11:00:32'),
('mpQf0P5', 4, '2021-03-24', '2021-03-27', 'borrow', '2021-03-25 02:30:17', '2021-03-25 02:30:17'),
('Z9UWSGD', 2, '2021-03-22', '2021-03-26', 'return', '2021-03-21 13:58:25', '2021-03-21 13:58:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_requests`
--

CREATE TABLE `book_requests` (
  `code_request` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_book` bigint(20) UNSIGNED NOT NULL,
  `time_request` date NOT NULL,
  `status_request` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `book_requests`
--

INSERT INTO `book_requests` (`code_request`, `id_user`, `id_book`, `time_request`, `status_request`, `created_at`, `updated_at`) VALUES
('8fWRPWH', 5, 4, '2021-03-27', 'request accept', '2021-03-26 12:25:08', '2021-03-26 12:25:08'),
('cPG0lOJ', 4, 3, '2021-03-28', 'request pending', '2021-03-27 10:58:22', '2021-03-27 10:58:22'),
('pP5sCP9', 2, 7, '2021-03-28', 'request pending', '2021-03-26 15:14:55', '2021-03-26 15:14:55'),
('SiKxkds', 5, 6, '2021-03-27', 'request accept', '2021-03-26 11:30:05', '2021-03-26 11:30:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_book_loans`
--

CREATE TABLE `detail_book_loans` (
  `number_borrow` bigint(20) UNSIGNED NOT NULL,
  `code_borrow` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_book` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_book_loans`
--

INSERT INTO `detail_book_loans` (`number_borrow`, `code_borrow`, `id_book`, `created_at`, `updated_at`) VALUES
(1, 'Z9UWSGD', 1, '2021-03-21 13:58:25', '2021-03-21 13:58:25'),
(2, 'Z9UWSGD', 4, '2021-03-21 13:58:25', '2021-03-21 13:58:25'),
(3, 'Ibgtw7M', 2, '2021-03-21 15:01:45', '2021-03-21 15:01:45'),
(4, 'mpQf0P5', 6, '2021-03-25 02:30:17', '2021-03-25 02:30:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_03_18_144600_create_books_table', 1),
(5, '2021_03_18_163954_create_borrowed_books_table', 1),
(6, '2021_03_18_164027_create_detail_borrowed_books_table', 1),
(7, '2021_03_18_173914_add_stok_to_books_table', 2),
(8, '2021_03_19_064622_add_qty_to_detail_borrowed_books_table', 3),
(11, '2021_03_20_180611_create_book_borrows_table', 4),
(12, '2021_03_20_183634_create_detail_book_loans_table', 5),
(13, '2021_03_23_155541_create_book_returns_table', 6),
(14, '2021_03_24_073656_create_detail_book_enters_table', 7),
(16, '2021_03_25_112923_add_status_to_book_borrows_table', 8),
(17, '2021_03_25_114228_drop_book_enters_table', 9),
(18, '2021_03_25_114743_drop_detail_book_enters_table', 10),
(19, '2021_03_25_142529_add_time_retunr_to_book_borrows_table', 11),
(20, '2021_03_25_171650_remove_stok_from_books', 12),
(21, '2021_03_25_172044_remove_qty_from_detail_book_loans', 13),
(23, '2021_03_26_125334_add_book_requests_table', 14),
(24, '2021_03_26_173053_add_status_request_to_book_requests_table', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `email_verified_at`, `password`, `phone_number`, `address`, `gender`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rangga Wisnu AM', 'ranggajack77@gmail.com', NULL, '$2y$10$G10B2NRrnOweM.pZDZI0fObitEmxfCeM8kqfuVl1Aij0dcDQmnrQW', '082739353415', 'Jl Kaliurang Km 8', 'man', 'admin', NULL, '2021-03-19 10:40:06', '2021-03-19 10:40:06'),
(2, 'Wisnu Mahardika', 'w1sznuam@gmail.com', NULL, '$2y$10$2QtstSg/clm/VRyDsYm2kO5nwWc/mnTYHiWhcGgY9bVxZjHCPjcSe', '085337353914', 'Jl Magelang Km 8', 'man', 'user', NULL, '2021-03-19 10:41:21', '2021-03-19 10:41:21'),
(3, 'Putra Adibya', 'putr44@yahoo.com', NULL, '$2y$10$fmW94ijsj0ENnXHsvfoMA.BnL2gz9eXx6F.tz4U3/q.53kwmLgGNa', '082943363770', 'Jl Magelang Km 7', 'man', 'user', NULL, '2021-03-21 14:53:10', '2021-03-27 11:48:14'),
(4, 'Ariyanto AA', '4ryat0@ymail.com', NULL, '$2y$10$LXuvbqH3r8w3QoAdHJhwnukJ5soRygtx/NNxNnIFQjGMU6o2I2ItC', '082873943011', 'Jl Godean Km 4', 'man', 'user', NULL, '2021-03-25 02:29:15', '2021-03-27 10:58:07'),
(5, 'Friszch', 'fr1chz90@gmail.com', NULL, '$2y$10$oKISFnWZrEqBPnRIQOprHOgmjcbD8q4NteHlBeUj/XYO8z09n1lOu', '082453353279', 'Jl Godean Km 7', 'woman', 'user', NULL, '2021-03-26 11:22:46', '2021-03-26 11:22:46');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`);

--
-- Indeks untuk tabel `book_borrows`
--
ALTER TABLE `book_borrows`
  ADD PRIMARY KEY (`code_borrow`),
  ADD KEY `book_borrows_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `book_requests`
--
ALTER TABLE `book_requests`
  ADD PRIMARY KEY (`code_request`),
  ADD KEY `book_requests_id_user_foreign` (`id_user`),
  ADD KEY `id_book` (`id_book`);

--
-- Indeks untuk tabel `detail_book_loans`
--
ALTER TABLE `detail_book_loans`
  ADD PRIMARY KEY (`number_borrow`),
  ADD KEY `detail_book_loans_id_book_foreign` (`id_book`),
  ADD KEY `code_borrow` (`code_borrow`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id_book` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_book_loans`
--
ALTER TABLE `detail_book_loans`
  MODIFY `number_borrow` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `book_borrows`
--
ALTER TABLE `book_borrows`
  ADD CONSTRAINT `book_borrows_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `book_requests`
--
ALTER TABLE `book_requests`
  ADD CONSTRAINT `book_requests_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `detail_book_loans`
--
ALTER TABLE `detail_book_loans`
  ADD CONSTRAINT `detail_book_loans_id_book_foreign` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
