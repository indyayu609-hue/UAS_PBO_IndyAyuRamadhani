<?php

class MahasiswaMandiri extends Mahasiswa {
    // Properti tambahan spesifik Mandiri
    private string $golonganUkt;
    private string $namaWali;

    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt, string $golonganUkt, string $namaWali) {
        // Memanggil constructor dari abstract class induk
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->golonganUkt = $golonganUkt;
        $this->namaWali = $namaWali;
    }

    // Implementasi metode abstrak: Mandiri membayar UKT penuh
    public function hitungTagihanSemester(): float {
        return $this->tarifUKTNominal;
    }

    // Implementasi metode abstrak: Menampilkan info wali dan golongan
    public function tampilSpesifikasiAkademik(): void {
        echo "Jenis Pembiayaan: Mandiri\n";
        echo "Golongan UKT: " . $this->golonganUkt . "\n";
        echo "Nama Wali: " . $this->namaWali . "\n";
    }

    // Method Query: Mengambil semua mahasiswa mandiri berdasarkan golongan UKT tertentu
    public static function getByGolonganUkt(PDO $db, string $golongan) {
        $sql = "SELECT id_mahasiswa, nim, semester, tarif_ukt_nominal, golongan_ukt, nama_wali 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Mandiri' AND golongan_ukt = :golongan";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['golongan' => $golongan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}