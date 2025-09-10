<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormOpd;
use App\Models\FormOpdKriteria;
use App\Models\FormOpdKriteriaDetail;

class FormOpdSeeder extends Seeder
{
    public function run(): void
    {
        $form = FormOpd::create([
            'id_user' => 'USR-001',
            'id_status' => 'ST-001',
            'keterangan' => 'Testing seeder'
        ]);

        $krit = FormOpdKriteria::create([
            'form_opd_id' => $form->id,
            'nama_kriteria' => 'Pelayanan Publik',
        ]);

        FormOpdKriteriaDetail::create([
            'form_opd_kriteria_id' => $krit->id,
            'nilai_poin' => 80,
            'gambar' => 'gambar1.png',
            'link_video' => 'https://youtu.be/test'
        ]);
    }
}
