<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $sql = "INSERT INTO `departments` (`id`, `name`)
                VALUES
                    (1, 'SANTANDER'),
                    (2, 'ANTIOQUIA'),
                    (3, 'CUNDINAMARCA'),
                    (4, 'VALLE DEL CAUCA');
                ";
        DB::unprepared($sql);
    }
}
