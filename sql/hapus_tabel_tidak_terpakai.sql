-- Script untuk menghapus tabel-tabel Laravel default yang tidak terpakai
-- Jalankan script ini di database KerjaKita

-- Drop tabel-tabel yang dibuat oleh migration Laravel default
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;

-- Tabel 'users' TIDAK dihapus karena mungkin masih digunakan
-- Jika ingin hapus juga, uncomment baris berikut:
-- DROP TABLE IF EXISTS `users`;

-- Tabel 'migrations' tetap ada untuk tracking migration
-- JANGAN dihapus!
