<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Panel\Config;

class CreateAppConfig extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'id'   => 'name_application',
            'value' => 'SEWAKU'
        ]);
        Config::create([
            'id'   => 'logo',
            'value' => 'images/logo.png'
        ]);
        Config::create([
            'id'   => 'alamat_pembuat',
            'value' => 'gin.bqs@gmail.com'
        ]);
        Config::create([
            'id'   => 'web_pembuat',
            'value' => 'next-in.id'
        ]);
        Config::create([
            'id'   => 'perhari_bayar',
            'value' => 0
        ]);
        Config::create([
            'id'   => 'perhari_denda',
            'value' => 0
        ]);
    }
}
