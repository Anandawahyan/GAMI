# GAMI

Proyek GAMI adalah sebuah website ecommerce thrift-shop. Tujuan proyek ini adalah untuk membuat sistem ecommerce yang dapat dipantau dan memudahkan owner membuat keputusan.

## Kontribusi

Kami sangat menyambut kontribusi dari para pengembang untuk meningkatkan proyek ini. Dalam dokumentasi ini, Anda akan menemukan langkah-langkah yang perlu diikuti untuk berkontribusi ke proyek ini.

## Panduan Kontribusi

Berikut adalah langkah-langkah untuk berkontribusi ke proyek GAMI:

1. **Fork** repositori ini ke akun GitHub Anda dengan mengeklik tombol "Fork" di atas halaman repositori.
2. **Clone** repositori yang telah Anda fork ke akun GitHub Anda ke komputer lokal Anda dengan menggunakan perintah berikut:

   ```bash
   git clone https://github.com/rizkisiraj/GAMI
   ```

   Gantilah `username` dengan nama pengguna GitHub Anda dan `nama-repositori` dengan nama repositori yang telah Anda fork.

3. **Buat branch** baru untuk melakukan perubahan. Gunakan nama branch yang deskriptif yang menggambarkan perubahan yang akan Anda lakukan. Misalnya:

   ```bash
   git checkout -b perbaikan-fitur
   ```

   Gantilah `perbaikan-fitur` dengan nama branch yang sesuai.

4. **Lakukan perubahan** pada kode sumber sesuai dengan kontribusi yang Anda inginkan.
5. **Commit** perubahan Anda dengan pesan yang jelas dan deskriptif. Contoh:

   ```bash
   git commit -m "Menambahkan fitur baru"
   ```

6. **Push** branch yang telah Anda buat ke repositori GitHub Anda:

   ```bash
   git push origin nama-branch
   ```

   Gantilah `nama-branch` dengan nama branch yang telah Anda buat.

7. Buat **Pull Request** (PR) dengan menjelaskan perubahan yang Anda lakukan. Pastikan untuk memberikan deskripsi yang jelas dan rinci mengenai kontribusi Anda.

Setelah Anda mengirimkan PR, tim pengembang akan meninjau kontribusi Anda. Jika ada perbaikan yang diperlukan atau perubahan tambahan yang dianjurkan, kami akan memberikan umpan balik dan bekerja sama dengan Anda untuk meningkatkan kontribusi Anda.

Terima kasih atas partisipasi Anda dalam proyek GAMI!

## Dokumentasi

Berikut adalah dokumentasi fungsi-fungsi yang membentuk aplikasi.

Daftar isi :
<ul>
<li>Executive Dashboard Controller</li>
<li>Admin Dashboard Controller</li>
</ul>

### `Executive_Dashboard_Controller`

### `index()`

Metode `index` pada kelas `Executive_Dashboard_Controller` bertugas untuk merender tampilan dashboard eksekutif dengan berbagai data statistik. Metode ini melakukan operasi-operasi berikut:

1. Mengambil tanggal saat ini dan tanggal sebelumnya menggunakan library Carbon.
2. Menghitung total penjualan pada hari sebelumnya, minggu sebelumnya, bulan sebelumnya, dan tahun sebelumnya dengan melakukan query pada model `Transaction`.
3. Menghitung jumlah penjualan pada hari ini, minggu ini, bulan ini, dan tahun ini menggunakan pendekatan yang sama seperti pada langkah 2.
4. Menghitung persentase perubahan penjualan untuk setiap periode dibandingkan dengan periode sebelumnya yang sesuai.
5. Menghitung total jumlah penjualan dari seluruh transaksi.
6. Menghitung nilai transaksi rata-rata dengan membagi total jumlah penjualan dengan jumlah transaksi.
7. Mengambil data rating dari tabel `reviews`.
8. Memanggil fungsi `calculateCustomerSatisfaction` untuk menghitung skor kepuasan pelanggan berdasarkan data rating.
9. Menyampaikan semua data yang dihitung dan variabel lain yang diperlukan ke tampilan `dashboard-general-dashboard` untuk dirender.

#### Tanda Metode

```php
public function index()
```

#### Parameter

Metode ini tidak menerima parameter apapun.

#### Nilai Kembalian

Metode ini mengembalikan sebuah instance dari kelas `Illuminate\View\View`, yang mewakili tampilan yang telah dirender.

#### Contoh Penggunaan

```php
$controller = new Executive_Dashboard_Controller();
$response = $controller->index();
```

Berikut adalah dokumentasi untuk fungsi `get_marketing_analysis()`:

### `get_marketing_analysis()`

Fungsi ini digunakan untuk memperoleh analisis pemasaran berdasarkan data transaksi dan data stok yang diberikan. Fungsi ini menggunakan API OpenAI untuk menghasilkan analisis pemasaran berdasarkan data yang diberikan.

#### Parameter

Fungsi ini tidak menerima parameter apa pun.

#### Hasil yang Dikembalikan

Fungsi ini mengembalikan respons dari API OpenAI yang berisi hasil analisis pemasaran yang dihasilkan.

Berikut adalah dokumentasi untuk fungsi `get_rfm_analysis()`:

### `get_rfm_analysis()`

Fungsi ini digunakan untuk melakukan analisis RFM (Recency, Frequency, Monetary) berdasarkan data transaksi yang ada. Fungsi ini menggunakan data transaksi untuk menghitung skor RFM, kemudian mengirimkan data tersebut ke API OpenAI untuk meminta analisis lebih lanjut.

#### Parameter

Fungsi ini tidak menerima parameter apa pun.

#### Hasil yang Dikembalikan

Fungsi ini mengembalikan respons dari API OpenAI yang berisi hasil analisis berdasarkan data RFM yang diberikan.

Berikut adalah dokumentasi untuk fungsi `get_review_analysis()`:

### `get_review_analysis()`

Fungsi ini digunakan untuk menganalisis data ulasan pelanggan yang tersedia dalam tabel `reviews`. Fungsi ini menggunakan data ulasan untuk menghasilkan kesimpulan tentang apa yang dipikirkan pelanggan mengenai produk-produk Anda. Fungsi ini mengirimkan data ulasan ke API OpenAI untuk meminta analisis lebih lanjut.

#### Parameter

Fungsi ini tidak menerima parameter apa pun.

#### Hasil yang Dikembalikan

Fungsi ini mengembalikan respons dari API OpenAI yang berisi hasil analisis berdasarkan data ulasan yang diberikan.