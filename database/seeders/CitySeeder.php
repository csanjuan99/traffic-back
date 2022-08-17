<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $sql = "INSERT INTO `cities` (`id`, `name`, `longitude`, `latitude`, `department_id`)
                VALUES
                    (1, 'BUCARAMANGA', -500, -200, 1),
                    (2, 'BOGOTA', 100, -100, 3),
                    (3, 'MEDELLIN', 500, 100, 2),
                    (4, 'CALI', 200, 100, 4);
                ";
        DB::unprepared($sql);
    }
}
