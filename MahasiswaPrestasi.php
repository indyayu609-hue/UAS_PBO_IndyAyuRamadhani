<?php

class MahasiswaPrestasi extends Mahasiswa {
    // Properti tambahan spesifik Prestasi
    private string $namaInstansiBeasiswa;
    private float $minimalIpkSyarat;

    public function __construct(int $id, string $nama, string $nim, int $semester, float $ukt, string $instansi, float $minIpk) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->namaInstansiBeasiswa = $instansi;
        $this->minimalIpkSyarat = $minIpk;
    }

    // Implementasi metode abstrak: Beasiswa prestasi memotong UKT sebesar 50% (contoh logika)
    public function hitungTagihanSemester(): float {
        return $this->tarifUKTNominal * 0.5;
    }

    // Implementasi metode abstrak: Menampilkan instansi pemberi beasiswa dan syarat IPK
    public function tampilSpesifikasiAkademik(): void {
        echo "Jenis Pembiayaan: Beasiswa Prestasi\n";
        echo "Instansi Pemberi Beasiswa: " . $this->namaInstansiBeasiswa . "\n";
        echo "Minimal IPK Syarat: " . $this->minimalIpkSyarat . "\n";
    }

    // Method Query: Mengambil mahasiswa prestasi berdasarkan nama instansi beasiswa tertentu
    public static function getByInstansiBeasiswa(PDO $db, string $instansi) {
        $sql = "SELECT id_mahasiswa, nim, semester, tarif_ukt_nominal, nama_instansi_beasiswa, minimal_ipk_syarat 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Prestasi' AND nama_instansi_beasiswa LIKE :instansi";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['instansi' => '%' . $instansi . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}