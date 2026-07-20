# Backend API tambahan

Semua endpoint baru memakai awalan `/api/v1`. Fitur ini tidak mengubah route, Blade, JavaScript, atau proses login web yang sudah ada. Tidak ada endpoint `DELETE`; koreksi dilakukan dengan `PUT`, sedangkan pembatalan pinjaman dicatat sebagai status `Dibatalkan`.

## Autentikasi API

`POST /api/v1/tokens` menerima `email`, `password`, dan opsional `name`. Respons memuat bearer token yang berlaku 30 hari. Endpoint lain memerlukan header `Authorization: Bearer <token>`.

## Endpoint utama

| Kebutuhan | Endpoint |
| --- | --- |
| Riwayat/setoran simpanan | `GET` / `POST /api/v1/simpanan` |
| Penarikan simpanan | `POST /api/v1/simpanan/penarikan` |
| Daftar dan edit pinjaman | `GET` / `PUT /api/v1/pinjaman/{pinjaman}` |
| Pembatalan tercatat | `PATCH /api/v1/pinjaman/{pinjaman}/batalkan` |
| Riwayat/bayar cicilan | `GET` / `POST /api/v1/pinjaman/{pinjaman}/cicilan` |
| Edit data non-nominal cicilan | `PUT /api/v1/cicilan/{pembayaran}` |
| Laporan periode | `GET /api/v1/laporan?dari=2026-01-01&sampai=2026-01-31` |
| Export | `GET /api/v1/laporan/export/{csv|excel|pdf}` |
| Bukti PDF | `GET /api/v1/bukti/{jurnal}` |

`excel` menghasilkan berkas `.xls` yang dapat dibuka langsung oleh Microsoft Excel. Filter `dari` dan `sampai` diterapkan di server; bila tidak diisi, periode berjalan digunakan.

## Penerapan

Jalankan `php artisan migrate` pada basis data aplikasi. Migrasi hanya menambah tabel/kolom: pembayaran cicilan, jurnal, audit log, token API, kolom keterangan/status pinjaman, dan arah transaksi simpanan.
