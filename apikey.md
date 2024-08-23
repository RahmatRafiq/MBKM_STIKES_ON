


# Dokumentasi API Laravel dengan API Key

## 1. Rute API dengan API Key

Rute-rute yang memerlukan API Key harus menggunakan middleware ApiKeyMiddleware. Contoh implementasi rute dengan middleware adalah sebagai berikut:

```php
Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::get('/laporan-lengkap-peserta/json', [ApiController::class, 'getValidatedLaporanLengkap']);
    Route::get('/dosen-sisfo/json', [ApiController::class, 'getDataDosenSisfo']);
    Route::get('/mahasiswa-sisfo/json', [ApiController::class, 'getDataMahasiswaSisfo']);
    Route::get('/matakuliah-sisfo/json', [ApiController::class, 'getDataMatakuliahSisfo']);
});
```
Jika Anda ingin mengakses rute tanpa API Key, Anda dapat mengomentari middleware tersebut seperti berikut:

```php
// Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::get('/laporan-lengkap-peserta/json', [ApiController::class, 'getValidatedLaporanLengkap']);
    Route::get('/dosen-sisfo/json', [ApiController::class, 'getDataDosenSisfo']);
    Route::get('/mahasiswa-sisfo/json', [ApiController::class, 'getDataMahasiswaSisfo']);
    Route::get('/matakuliah-sisfo/json', [ApiController::class, 'getDataMataKuliahSisfo']);
// });
```
## 2. Membuat API Key

Untuk membuat API Key baru, jalankan perintah berikut di terminal. Dalam konteks MBKM, Anda bisa menggunakan Cmder atau terminal serupa.

Pertama, jalankan perintah berikut untuk masuk ke Laravel Tinker:

```bash
php artisan tinker
```
Kemudian, masukkan perintah berikut untuk menghasilkan API Key:

```bash
echo Hash::make('api-key-terbaru');
```
Salin API Key yang dihasilkan dan simpan dalam file .env Anda.

```env
X-API-KEY=api-key-yang-dihasilkan
```
Dengan langkah-langkah ini, API Key akan siap digunakan untuk mengamankan rute-rute API di aplikasi Laravel Anda.