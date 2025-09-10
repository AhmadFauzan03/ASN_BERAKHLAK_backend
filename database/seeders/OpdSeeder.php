<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpdSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('opds')->insert([
            ['id' => 'OPD-001', 'nama_opd' => 'BADAN KEPEGAWAIAN DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-002', 'nama_opd' => 'BADAN KESATUAN BANGSA DAN POLITIK', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-003', 'nama_opd' => 'BADAN PENANGGULANGAN BENCANA DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-004', 'nama_opd' => 'BADAN PENDAPATAN DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-005', 'nama_opd' => 'BADAN PENELITIAN DAN PENGEMBANGAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-006', 'nama_opd' => 'BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-007', 'nama_opd' => 'BADAN PENGEMBANGAN SUMBER DAYA MANUSIA', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-008', 'nama_opd' => 'BADAN PENGHUBUNG', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-009', 'nama_opd' => 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-010', 'nama_opd' => 'DINAS ARSIP DAN PERPUSTAKAAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-011', 'nama_opd' => 'DINAS ENERGI DAN SUMBER DAYA MINERAL', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-012', 'nama_opd' => 'DINAS KEBUDAYAAN DAN PARIWISATA', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-013', 'nama_opd' => 'DINAS KEHUTANAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-014', 'nama_opd' => 'DINAS KESEHATAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-015', 'nama_opd' => 'DINAS KETAHANAN PANGAN DAN PETERNAKAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-016', 'nama_opd' => 'DINAS KOMUNIKASI, INFORMATIKA, STATISTIK DAN PERSANDIAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-017', 'nama_opd' => 'DINAS KOPERASI DAN USAHA KECIL DAN MENENGAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-018', 'nama_opd' => 'DINAS LINGKUNGAN HIDUP', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-019', 'nama_opd' => 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-020', 'nama_opd' => 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-021', 'nama_opd' => 'DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-022', 'nama_opd' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-023', 'nama_opd' => 'DINAS PENDIDIKAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-024', 'nama_opd' => 'DINAS PERDAGANGAN DAN PERINDUSTRIAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-025', 'nama_opd' => 'DINAS PERHUBUNGAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-026', 'nama_opd' => 'DINAS PERIKANAN DAN KELAUTAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-027', 'nama_opd' => 'DINAS PERKEBUNAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-028', 'nama_opd' => 'DINAS PERTANIAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-029', 'nama_opd' => 'DINAS SOSIAL', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-030', 'nama_opd' => 'DINAS TENAGA KERJA DAN TRANSMIGRASI', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-031', 'nama_opd' => 'DINAS TRANSMIGRASI DAN ENERGI', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-032', 'nama_opd' => 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-033', 'nama_opd' => 'INSPEKTORAT DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-034', 'nama_opd' => 'RUMAH SAKIT UMUM DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-035', 'nama_opd' => 'SATUAN POLISI PAMONG PRAJA', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-036', 'nama_opd' => 'SEKRETARIAT DPRD', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-037', 'nama_opd' => 'SEKRETARIAT DAERAH', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-038', 'nama_opd' => 'DINAS OLAHRAGA DAN PEMUDA', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-039', 'nama_opd' => 'DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-040', 'nama_opd' => 'DINAS KELAUTAN DAN PERIKANAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-041', 'nama_opd' => 'DINAS PANGAN DAN HORTIKULTURA', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-042', 'nama_opd' => 'DINAS PELAYANAN PUBLIK', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-043', 'nama_opd' => 'DINAS PERTANIAN TANAMAN PANGAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-044', 'nama_opd' => 'DINAS TATA RUANG DAN BANGUNAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-045', 'nama_opd' => 'DINAS TRANSPORTASI', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-046', 'nama_opd' => 'DINAS KEBERSIHAN DAN KEINDAHAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-047', 'nama_opd' => 'DINAS PENGELOLAAN SUMBER DAYA AIR', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-048', 'nama_opd' => 'DINAS PERIZINAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-049', 'nama_opd' => 'DINAS PERENCANAAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-050', 'nama_opd' => 'DINAS KEMASYARAKATAN', 'email_opd' => 'TES@GMAIL.COM'],
            ['id' => 'OPD-051', 'nama_opd' => 'DINAS TEKNOLOGI INFORMASI', 'email_opd' => 'TES@GMAIL.COM'],
        ]);
    }
}