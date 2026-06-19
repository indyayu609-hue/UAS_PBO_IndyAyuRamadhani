<?php

class MahasiswaBidikmisi extends Mahasiswa {
    // Properti tambahan spesifik Bidikmisi
    private string $nomorKipKuliah; // Disesuaikan dengan kolom database: nomor_kip_kuliah
    private float $danaSakuSubsidi;

    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt, string $nomorKip, float $danaSaku) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->nomorKipKuliah = $nomorKip;
        $this->danaSakuSubsidi = $danaSaku;
    }

    // Implementasi metode abstrak: Bidikmisi digratiskan (Tagihan = 0)
    public function hitungTagihanSemester(): float {
        return 0.0;
    }

    // Implementasi metode abstrak: Menampilkan info KIP dan subsidi dana saku
    public function tampilSpesifikasiAkademik(): void {
        echo "Jenis Pembiayaan: Bidikmisi / KIP-K\n";
        echo "Nomor KIP Kuliah: " . $this->nomorKipKuliah . "\n";
        echo "Dana Saku Subsidi/Bulan: Rp " . number_format($this->danaSakuSubsidi, 0, ',', '.') . "\n";
    }

    // Method Query: Mengambil mahasiswa bidikmisi yang menerima dana saku di atas nominal tertentu
    public static function getByMinimalDanaSaku(PDO $db, float $minDana) {
        $sql = "SELECT id_mahasiswa, nim, semester, nomor_kip_kuliah, dana_saku_subsidi 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Bidikmisi' AND dana_saku_subsidi >= :min_dana";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['min_dana' => $minDana]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}