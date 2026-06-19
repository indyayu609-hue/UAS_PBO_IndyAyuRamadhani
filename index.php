<?php

// =========================================================================
// 1. ABSTRACT CLASS INDUK
// =========================================================================
abstract class Mahasiswa {
    // Atribut terenkapsulasi (protected) sesuai kolom database
    protected int $id_mahasiswa;
    protected string $nama_mahasiswa; 
    protected string $nim;
    protected int $semester;
    protected float $tarifUKTNominal; 

    // Constructor Induk
    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt) {
        $this->id_mahasiswa = $id;
        $this->nama_mahasiswa = $nama;
        $this->nim = $nim;
        $this->semester = $semester;
        $this->tarifUKTNominal = $ukt;
    }

    // Abstract Methods (Wajib di-override oleh kelas anak)
    abstract public function hitungTagihanSemester(): float;
    abstract public function tampilSpesifikasiAkademik(): void;

    // Getter untuk enkapsulasi data
    public function getNim(): string {
        return $this->nim;
    }
    public function getNamaMahasiswa(): string {
        return $this->nama_mahasiswa;
    }
}


// =========================================================================
// 2. SUBCLASS: MAHASISWA MANDIRI
// =========================================================================
class MahasiswaMandiri extends Mahasiswa {
    private string $golonganUkt;
    private string $namaWali;

    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt, string $golonganUkt, string $namaWali) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->golonganUkt = $golonganUkt;
        $this->namaWali = $namaWali;
    }

    // OVERRIDING: Tarif UKT + Biaya Operasional Flat Rp 100.000
    public function hitungTagihanSemester(): float {
        $biayaOperasional = 100000.00;
        return $this->tarifUKTNominal + $biayaOperasional;
    }

    public function tampilSpesifikasiAkademik(): void {
        echo "Jenis Pembiayaan : Mandiri\n";
        echo "Golongan UKT     : " . $this->golonganUkt . "\n";
        echo "Nama Wali        : " . $this->namaWali . "\n";
    }

    public static function getByGolonganUkt(PDO $db, string $golongan) {
        $sql = "SELECT id_mahasiswa, nim, semester, tarif_ukt_nominal, golongan_ukt, nama_wali 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Mandiri' AND golongan_ukt = :golongan";
        $stmt = $db->prepare($sql);
        $stmt->execute(['golongan' => $golongan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


// =========================================================================
// 3. SUBCLASS: MAHASISWA BIDIKMISI
// =========================================================================
class MahasiswaBidikmisi extends Mahasiswa {
    private string $nomorKipKuliah;
    private float $danaSakuSubsidi;

    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt, string $nomorKip, float $danaSaku) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->nomorKipKuliah = $nomorKip;
        $this->danaSakuSubsidi = $danaSaku;
    }

    // OVERRIDING: Digratiskan penuh oleh negara (Tagihan = 0)
    public function hitungTagihanSemester(): float {
        return 0.00;
    }

    public function tampilSpesifikasiAkademik(): void {
        echo "Jenis Pembiayaan : Bidikmisi / KIP-K\n";
        echo "Nomor KIP Kuliah : " . $this->nomorKipKuliah . "\n";
        echo "Dana Saku/Bulan  : Rp " . number_format($this->danaSakuSubsidi, 0, ',', '.') . "\n";
    }

    public static function getByMinimalDanaSaku(PDO $db, float $minDana) {
        $sql = "SELECT id_mahasiswa, nim, semester, tarif_ukt_nominal, nomor_kip_kuliah, dana_saku_subsidi 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Bidikmisi' AND dana_saku_subsidi >= :min_dana";
        $stmt = $db->prepare($sql);
        $stmt->execute(['min_dana' => $minDana]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


// =========================================================================
// 4. SUBCLASS: MAHASISWA PRESTASI
// =========================================================================
class MahasiswaPrestasi extends Mahasiswa {
    private string $namaInstansiBeasiswa;
    private float $minimalIpkSyarat;

    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt, string $instansi, float $minIpk) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->namaInstansiBeasiswa = $instansi;
        $this->minimalIpkSyarat = $minIpk;
    }

    // OVERRIDING: Potongan 75%, hanya membayar 25% dari tarif asli
    public function hitungTagihanSemester(): float {
        return $this->tarifUKTNominal * 0.25;
    }

    public function tampilSpesifikasiAkademik(): void {
        echo "Jenis Pembiayaan : Beasiswa Prestasi\n";
        echo "Pemberi Beasiswa : " . $this->namaInstansiBeasiswa . "\n";
        echo "Syarat Minimal IPK: " . $this->minimalIpkSyarat . "\n";
    }

    public static function getByInstansiBeasiswa(PDO $db, string $instansi) {
        $sql = "SELECT id_mahasiswa, nim, semester, tarif_ukt_nominal, nama_instansi_beasiswa, minimal_ipk_syarat 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Prestasi' AND nama_instansi_beasiswa LIKE :instansi";
        $stmt = $db->prepare($sql);
        $stmt->execute(['instansi' => '%' . $instansi . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


// =========================================================================
// 5. KONEKSI DATABASE & DEMO POLIMORFISME (RUNNER)
// =========================================================================
try {
    // Sesuaikan dbname, username, dan password MySQL Anda
    $db = new PDO("mysql:host=localhost;dbname=universitas_db", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Array penampung semua objek mahasiswa yang dicampur (Polimorfisme)
    $listMahasiswa = [];

    // A. Ambil Data Mandiri dari DB -> Jadikan Objek
    $dataMandiri = MahasiswaMandiri::getByGolonganUkt($db, 'Gol 4');
    foreach ($dataMandiri as $row) {
        $listMahasiswa[] = new MahasiswaMandiri(
            $row['id_mahasiswa'], "Andi (Mandiri)", $row['nim'], $row['semester'], 
            (float)$row['tarif_ukt_nominal'], $row['golongan_ukt'], $row['nama_wali']
        );
    }

    // B. Ambil Data Bidikmisi dari DB -> Jadikan Objek
    $dataBidikmisi = MahasiswaBidikmisi::getByMinimalDanaSaku($db, 900000);
    foreach ($dataBidikmisi as $row) {
        $listMahasiswa[] = new MahasiswaBidikmisi(
            $row['id_mahasiswa'], "Budi (Bidikmisi)", $row['nim'], $row['semester'], 
            (float)$row['tarif_ukt_nominal'], $row['nomor_kip_kuliah'], (float)$row['dana_saku_subsidi']
        );
    }

    // C. Ambil Data Prestasi dari DB -> Jadikan Objek
    $dataPrestasi = MahasiswaPrestasi::getByInstansiBeasiswa($db, 'Beasiswa');
    foreach ($dataPrestasi as $row) {
        $listMahasiswa[] = new MahasiswaPrestasi(
            $row['id_mahasiswa'], "Cici (Prestasi)", $row['nim'], $row['semester'], 
            (float)$row['tarif_ukt_nominal'], $row['nama_instansi_beasiswa'], (float)$row['minimal_ipk_syarat']
        );
    }

    // ========================================================
    // OUTPUT EKSEKUSI POLIMORFISME DATA MAHASISWA
    // ========================================================
    echo "<pre>"; // Agar output rapi saat dibuka di browser
    echo "=========================================================\n";
    echo "         LAPORAN REAL-TIME TAGIHAN SEMESTER MAHASISWA    \n";
    echo "=========================================================\n\n";

    foreach ($listMahasiswa as $mhs) {
        echo "NIM              : " . $mhs->getNim() . "\n";
        echo "Nama Dummy       : " . $mhs->getNamaMahasiswa() . "\n";
        
        // Panggilan Polimorfisme 1: Menampilkan info unik per kelas anak
        $mhs->tampilSpesifikasiAkademik(); 
        
        // Panggilan Polimorfisme 2: Menghitung tagihan berdasarkan formula overriding masing-masing
        echo "Total Tagihan    : Rp " . number_format($mhs->hitungTagihanSemester(), 2, ',', '.') . "\n";
        echo "---------------------------------------------------------\n";
    }
    
    echo "</pre>";

} catch (PDOException $e) {
    die("Koneksi atau Query Bermasalah: " . $e->getMessage());
}