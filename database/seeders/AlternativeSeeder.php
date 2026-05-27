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
                'nama_topik' => 'Artificial Intelligence',
                'bidang' => 'AI'
            ],

            [
                'kode' => 'A2',
                'nama_topik' => 'Web Development',
                'bidang' => 'Software Engineering'
            ],

            [
                'kode' => 'A3',
                'nama_topik' => 'Mobile Development',
                'bidang' => 'Software Engineering'
            ],

            [
                'kode' => 'A4',
                'nama_topik' => 'Cyber Security',
                'bidang' => 'Security'
            ],

            [
                'kode' => 'A5',
                'nama_topik' => 'Data Science',
                'bidang' => 'Data'
            ],

            [
                'kode' => 'A6',
                'nama_topik' => 'Internet of Things',
                'bidang' => 'IoT'
            ],

            [
                'kode' => 'A7',
                'nama_topik' => 'UI/UX',
                'bidang' => 'Design'
            ],

            [
                'kode' => 'A8',
                'nama_topik' => 'Networking',
                'bidang' => 'Network'
            ],
        ];

        foreach ($alternatives as $item) {
            Alternative::create($item);
        }
    }
}
