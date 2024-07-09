<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = new Service();

        $service->name = "Preparatoria";

        $service->save();

        $service1 = new Service();

        $service1->name = "Universidad";

        $service1->save();

        $service2 = new Service();

        $service2->name = "Maestria";

        $service2->save();

        $service3 = new Service();

        $service3->name = "Doctorado";

        $service3->save();
    }
}
