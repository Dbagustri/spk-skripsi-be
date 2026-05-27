<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [

            [
                'kode' => 'C1',
                'nama' => 'Minat Bidang',
                'bobot' => 0.25,
                'tipe' => 'benefit',
                'deskripsi' => 'Ketertarikan mahasiswa terhadap bidang topik'
            ],

            [
                'kode' => 'C2',
                'nama' => 'Skill Programming',
                'bobot' => 0.20,
                'tipe' => 'benefit',
                'deskripsi' => 'Kemampuan teknis pemrograman'
            ],

            [
                'kode' => 'C3',
                'nama' => 'Nilai Mata Kuliah',
                'bobot' => 0.20,
                'tipe' => 'benefit',
                'deskripsi' => 'Nilai mata kuliah terkait'
            ],

            [
                'kode' => 'C4',
                'nama' => 'Pengalaman Project',
                'bobot' => 0.15,
                'tipe' => 'benefit',
                'deskripsi' => 'Pengalaman proyek sebelumnya'
            ],

            [
                'kode' => 'C5',
                'nama' => 'Prospek Karir',
                'bobot' => 0.20,
                'tipe' => 'benefit',
                'deskripsi' => 'Kesesuaian dengan tujuan karir'
            ]
        ];

        foreach ($criteria as $item) {
            Criteria::create($item);
        }
    }
}
