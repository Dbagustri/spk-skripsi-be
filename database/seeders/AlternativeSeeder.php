<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;

class AlternativeSeeder extends Seeder
{
    public function run(): void
    {
        $alternatives = [

            [
                'kode' => 'A1',
                'nama_topik' => 'Software Engineering & System Development',
                'kompetensi_lulusan' => 'Software Developer',
            ],

            [
                'kode' => 'A2',
                'nama_topik' => 'Web & Enterprise Application',
                'kompetensi_lulusan' => 'Web Developer',
            ],

            [
                'kode' => 'A3',
                'nama_topik' => 'Database & Data Engineering',
                'kompetensi_lulusan' => 'Database Administrator / Data Engineer',
            ],

            [
                'kode' => 'A4',
                'nama_topik' => 'Artificial Intelligence & Intelligent System',
                'kompetensi_lulusan' => 'AI Engineer',
            ],

            [
                'kode' => 'A5',
                'nama_topik' => 'System Analyst & Decision Support System',
                'kompetensi_lulusan' => 'System Analyst',
            ],

            [
                'kode' => 'A6',
                'nama_topik' => 'Data Science & Business Intelligence',
                'kompetensi_lulusan' => 'Data Analyst / Business Intelligence Analyst',
            ],

            [
                'kode' => 'A7',
                'nama_topik' => 'Mobile & Smart Application',
                'kompetensi_lulusan' => 'Mobile Application Developer',
            ],

            [
                'kode' => 'A8',
                'nama_topik' => 'Multimedia & Computer Vision',
                'kompetensi_lulusan' => 'Multimedia Engineer / Computer Vision Developer',
            ],
        ];

        foreach ($alternatives as $alternative) {
            Alternative::create($alternative);
        }
    }
}
