// Abstract Class Mahasiswa
public abstract class Mahasiswa {

    // Atribut terenkapsulasi (protected)
    protected int id_mahasiswa;
    protected String nama_mahasiswa;
    protected String nim;
    protected int semester;
    protected double tarifUKTNominal;

    // Constructor
    public Mahasiswa(int id_mahasiswa, String nama_mahasiswa, String nim,
                     int semester, double tarifUKTNominal) {
        this.id_mahasiswa = id_mahasiswa;
        this.nama_mahasiswa = nama_mahasiswa;
        this.nim = nim;
        this.semester = semester;
        this.tarifUKTNominal = tarifUKTNominal;
    }

    // Getter dan Setter
    public int getId_mahasiswa() {
        return id_mahasiswa;
    }

    public void setId_mahasiswa(int id_mahasiswa) {
        this.id_mahasiswa = id_mahasiswa;
    }

    public String getNama_mahasiswa() {
        return nama_mahasiswa;
    }

    public void setNama_mahasiswa(String nama_mahasiswa) {
        this.nama_mahasiswa = nama_mahasiswa;
    }

    public String getNim() {
        return nim;
    }

    public void setNim(String nim) {
        this.nim = nim;
    }

    public int getSemester() {
        return semester;
    }

    public void setSemester(int semester) {
        this.semester = semester;
    }

    public double getTarifUKTNominal() {
        return tarifUKTNominal;
    }

    public void setTarifUKTNominal(double tarifUKTNominal) {
        this.tarifUKTNominal = tarifUKTNominal;
    }

    // Abstract Method
    public abstract double hitungTagihanSemester();

    public abstract void tampilSepesifikasiAkademik();
}