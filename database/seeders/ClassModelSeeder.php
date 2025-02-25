<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'PAUD',
            'SD Kelas 1 & 2',
            'SD Kelas 3 & 4',
            'SD Kelas 5 & 6',
            'SMP & SMA',
        ];

        foreach ($classes as $class) {
            ClassModel::create(['class' => $class]);
        }
    }
}
