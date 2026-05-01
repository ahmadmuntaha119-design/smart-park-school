# Laporan Analisis Kapasitas Lahan & Skenario Penataan Parkir PKS
**Lokasi:** SMKN 1 Kebumen
**Sistem:** Smart Park School

Dokumen ini disusun untuk menganalisis kelayakan dan tingkat efisiensi dari berbagai skenario penataan lahan parkir harian berdasarkan data fisik lahan (zona) dan *sample* data riil pelaporan siswa yang masuk melalui G-Form.

---

## 1. Fakta Fisik & Kapasitas Lahan PKS
Berdasarkan pengukuran langsung di lapangan, ketersediaan lahan parkir dipecah ke dalam **30 Baris/Jalur** dengan kapasitas total **1.868 kendaraan**.

*   **Zona A:** 5 Baris × 35 slot = 175 C
*   **Zona B:** 5 Baris (Baris 1&2 @60, Baris 3-5 @81) = 363 C
*   **Zona C:** 5 Baris × 35 slot = 175 C
*   **Zona D:** 5 Baris × 81 slot = 405 C
*   **Zona E (Kiri):** 5 Baris × 62 slot = 310 C
*   **Zona E (Kanan):** 5 Baris × 88 slot = 440 C
*   **TOTAL FISIK SEKOLAH: 30 BARIS (JALUR)**

## 2. Fakta Distribusi Kendaraan Siswa (Data Sementara)
Dari total data responden yang masuk (±700 motor sah), ditemukan rasio dan variasi sebagai berikut:
*   **Dominasi Matic:** ~93% (Honda Beat, Vario, Scoopy, Mio, NMax, dll)
*   **Motor Manual:** ~7% (Supra, Jupiter, Revo, dll)
*   **Ledakan Variasi Warna:** Terdapat fragmentasi data warna yang sangat parah. Tipe *Honda Beat* sendiri tercatat memiliki lebih dari **59 variasi corak warna**, dan *Honda Vario* memiiki **44 variasi corak warna** unik. Sebagian besar corak minoritas hanya dimiliki oleh 1-2 siswa (misal: *hitam corak hijau, biru doff, dll*).

---

## 3. Uji Skenario Pengelompokkan (*Stress Test*)

Berikut adalah simulasi matematika menggunakan tuntutan realisasi lapangan yang dihadapkan dengan 30 Baris tanah SMKN 1 Kebumen.

### SKENARIO A: Perfeksionisme Kuadrat (Aturan 1 Baris = 1 Jenis, Merek, Tipe & 1 Warna Persis)
*(Skenario ekspektasi di mana tata letak warna disamakan 100% per kolom).*

*   **Hitungan:**
    *   Honda Beat (59 warna) membutuhkan = **59 Baris Lahan**
    *   Honda Vario (44 warna) membutuhkan = **44 Baris Lahan**
    *   Scoopy (21 warna) membutuhkan = **21 Baris Lahan**
    *   Motor Manual Campuran = **~15 Baris Lahan**
*   **Total Kebutuhan Secara Fisik:** **> 139 Baris**.
*   **Fakta Lahan Kita:** Hanya ada **30 Baris**.
*   **Kesimpulan:** ❌ **MUSTAHIL DITERAPKAN**. Sistem akan kehabisan jalur aspal, membiarkan 80% slot lahan dibiarkan *kopong* karena 1 anak yang membawa *Beat Navy* membutuhkan 1 jalurnya sendiri, menyiksa sisa lahan lainnya yang kekurangan tempat.

### SKENARIO B: Kompromi Penyatuan (Memisahkan Matic/Manual, tapi 1 Baris boleh dicampur maksimal 2 - 3 Warna Berbeda)
*(Skenario apabila Kepala Sekolah mentoleransi penggabungan warna, tapi secara tegas melarang Merek/Tipe bersentuhan).*

*   **Hitungan:**
    *   Honda Beat (59 warna, digabung per-2 warna per-baris) = **Butuh 30 Baris**
    *   Honda Vario (44 warna, digabung per-2 warna per-baris) = **Butuh 22 Baris**
    *   Scoopy (21 warna, digabung) = **Butuh 11 Baris**
    *   Manual (Pemaksaan pembagian baris khusus manual) = **Butuh 13 Baris**
*   **Total Kebutuhan Secara Fisik:** **76 Baris**.
*   **Fakta Lahan Kita:** Hanya ada **30 Baris**.
*   **Kesimpulan:** ❌ **TIDAK RASIONAL**. Sekalipun standar *aesthetic* warna sudah diturunkan (dikompromikan), lahan aspal sekolah (30 Baris) **tetap tidak sanggup** menyerap fragmentasinya. Masih ada selisih tekor pembangunan 46 Baris baru jika kita memaksakan mengontrol warna motor siswa.

### SKENARIO C: KOMPROMI BEST-PRACTICE (Mengabaikan Warna, Fokus Mutlak Pada Tipe & Dimensi Bodi Motor)
*(Skenario di mana Warna Motor dicampur acak sepenuhnya secara natural, namun baris dipisahkan murni berdasarkan DIMENSI BODI MOTOR).*

*   **Alasan Pengelompokkan Ini:** Meminjam metode dealer/pelabuhan kargo mobil di mana kerapian susunan dipandang dari siluet dimensi barang, bukan pewarnaan.
*   **Hitungan Implementasi Zonasi (Sangat Efisien):**
    *   **Seluruh Honda Beat (~371 unit)** ➡️ Diletakkan di **Zona B** (Kapasitas: 363 motor). *Motor akan tertata sempurna lurus menyesuaikan tipe yang rata, nyaris memenuhi kapasitas 100% ke-5 baris Zona B.*
    *   **Seluruh Honda Vario (~145 unit)** ➡️ Diletakkan mendominasi **Zona A** (Kapasitas: 175 motor). Setara dengan mengambil porsi 4 baris aspal penuh. Sisa 1 baris bisa digunakan untuk Scoopy.
    *   **Seluruh Yamaha (Mio, Aerox, dll - ~104 unit)** ➡️ Diletakkan di **Zona C** baris depan (Setara dengan menyerap 3 baris lahan).
    *   **Seluruh Kendaraan Manual (Supra, dll - ~48 unit)** ➡️ Dinormalisasikan tanpa harus pisah antar warna manual, dijejerkan saling berasimilasi di Sisa 2 Baris terakhir **Zona C**.
*   **Total Kebutuhan Secara Fisik:** Hanya menghabiskan sekitar **14-16 Baris** Lahan Sekolah.
*   **Fakta Lahan Kita:** Kita memiliki **30 BarisL**.
*   **Kesimpulan:** ✅ **SANGAT DIREKOMENDASIKAN (BEST PRACTICE)**. Pemisahan per "Bentuk/Tipe" tanpa melihat "Warna" akan mengamankan daya serap lahan mencapai lebih dari **90% Slot Terutilisasi Penuh tanpa slot kopong**. 
Keuntungannya, sekolah masih memiliki cadangan lahan yang membentang sangat luas tak tersentuh di **Zona D** (5 Baris) dan **Zona E** (10 Baris) yang kelak dapat difokuskan untuk angkatan penerimaan siswa baru angkatan atas / tamu guru.

---

## 4. Perdebatan Eksekusi Sistem: AI Otomatis vs Semi-Manual (Filter Admin)

Selain urusan fisik lahan, terdapat wacana pengembangan di mana sistem "Sistem (AI) akan mengelompokkan secara otomatis membedakan warna, tipe, dll". Setelah dianalisa mendalam secara kaidah *Software Engineering* dan Operasional Lapangan, **penggunaan AI Otomasi beresiko sangat tinggi membawa efek distorsi (*Domino Effect*)**.

Kami mengusulkan konsep **Semi-Manual Bulk-Assign via Administrator** sebagai solusi mutlak perancangan *backend* aplikasi. Berikut adalah perbandingan ilmiahnya:

### Kasus: Terjadi Perubahan Data (Siswa Ganti Motor)
*   🤖 **Jika Menggunakan AI Kaku (Auto-Grouping):** AI telah menata taman *puzzle* dengan sempurna (Slot A-01 sampai A-35 murni Hitam). Lalu siswa di slot A-15 berganti motor menjadi Merah. AI akan memecat anak tersebut dan membongkar ulang algoritma ribuan data anak se-sekolah untuk mencari celah baru bagi motor merah tersebut. Sistem menjadi rentan "*Error/Bug*", dan 1 sekolah bisa bergeser slotnya secara kacau.
*   🧑‍💻 **Solusi Semi-Manual Filter (Saran Praktis):** Apabila si anak berganti motor, Pihak PKS (Admin) cukup membuka fitur tabel, menghapus slot anak tersebut, mencarikan slot 1 tersisa yang dekat, dan melakukan klik *Assign*. Data 1000 anak lain **tetap utuh dan tidak tergeser posisinya**.

### Kasus: Anomali Data Minoritas & Toleransi
*   🤖 **Jika Menggunakan AI Kaku (Auto-Grouping):** Sebuah robot tidak memiliki "Toleransi Visual". Apabila baris 35 slot tersisa 5 slot kosong, dan antrean motor yang warnanya sama sudah habis, robot akan me- *lock* (mengunci) 5 slot tersebut sebagai sisa terbuang.
*   🧑‍💻 **Solusi Semi-Manual Filter (Saran Praktis):** Admin PKS bertindak sebagai *Silent Curator*. Jika Admin di tabel aplikasi melihat kekurangan 5 slot di rombongan Beat Merah, Admin tinggal mem- *filter* pencarian untuk tipe motor warna "Merah Gelap / Pink" lalu secara manual mengirim ke-5 siswa itu untuk menambal kebocoran slot tersebut sehingga aspal lapangan padat terisi 100%.

---

## 5. Kesimpulan Final & Rekomendasi Eksekusi
Berdasarkan pembuktian matematis lahan (Hanya Limit 30 Baris) dan pencegahan resiko kegagalan operasional sistem AI, kami menyimpulkan bahwa Eksekusi Cerdas *(Best Practice Smart Park System)* meliputi 2 hal pilar fundamental:

1.  **Abaikan Algoritma Pewarnaan:** Menata kerapian parkir sebuah institusi besar bukan dari warna cat rodanya, melainkan dari **pencocokan Tipe/Dimensi Bodi Motornya** saja. Warna digabung, batas pemisahnya hanyalah batas antara "Grup Beat" dan "Grup Vario". Lahan parkiran akan terlihat lurus sempurna dan serapan daya lahan aman tidak bolong.
2.  **Gunakan Kontrol Admin (Filter Multi-Level):** Alih-alih merancang AI mahal yang rentan hancur jika ada input data aneh, buatkan Bapak/Ibu PKS sebuah **Fitur Tabel Canggih**. Fitur ini memungkinkan PKS memberikan filter, mencentang (ceklis) data anak-anak bermotor Beat, lalu secara klik massal (*Bulk Action*) memindahkannya serentak ke Zona B. Jika besok ada kejadian motor yang bentuknya dimodifikasi raksasa, admin dapat memberikan pengecualian secara sadar dengan memindahkannya ke Zona ujung.
