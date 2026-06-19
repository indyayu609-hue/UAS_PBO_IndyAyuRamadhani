<?php

abstract class Mahasiswa {
    // Properti terenkapsulasi (protected)
    // Dipetakan pas dari kolom tabel database MySQL sebelumnya
    protected int $id_mahasiswa;
    protected string $nama_mahasiswa; // Opsional: Tambahan nama untuk identitas objek
    protected string $nim;
    protected int $semester;
    protected float $tarifUKTNominal; // Menggunakan float/double untuk tipe DECIMAL di DB

    // Constructor untuk menginisialisasi nilai properti saat objek dibuat (pemetaan dari DB)
    public function __construct(int $id_mahasiswa, string $nama_mahasiswa, string $nim, int $semester, float $tarifUKTNominal) {
        $this->id_mahasiswa = $id_mahasiswa;
        $this->nama_mahasiswa = $nama_mahasiswa;
        $this->nim = $nim;
        $this->semester = $semester;
        $this->tarifUKTNominal = $tarifUKTNominal;
    }

    // --- ABSTRACT METHODS ---
    // Metode abstrak wajib diimplementasikan oleh kelas anak (Mandiri, Bidikmisi, Prestasi)
    
    /**
     * Menghitung total tagihan yang harus dibayar pada semester berjalan
     * (Misal: Mandiri bayar penuh, Bidikmisi Rp0, Prestasi mendapat potongan)
     */
    abstract public function hitungTagihanSemester(): float;

    /**
     * Menampilkan spesifikasi atau detail akademik yang unik berdasarkan jenis pembiayaan
     */
    abstract public function tampilSpesifikasiAkademik(): void;


    // --- GETTER & SETTER (Opsional namun direkomendasikan untuk properti protected) ---
    public function getIdMahasiswa(): int {
        return $this->id_mahasiswa;
    }

    public function getNim(): string {
        return $this->nim;
    }

    public function getSemester(): int {
        return $this->semester;
    }

    public function getTarifUKTNominal(): float {
        return $this->tarifUKTNominal;
    }
}