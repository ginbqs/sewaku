<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateUser::class);
        $this->call(CreateBuku::class);
        $this->call(CreateAppConfig::class);
        $this->call(CreateUserLevels::class);
    }
}
