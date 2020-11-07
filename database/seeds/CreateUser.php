<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Panel\Level;

class CreateUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Level::create([
            'level'		=> 'petugas',
            'value' 	=> 'Petugas'
        ]);
        Level::create([
            'level'		=> 'peminjam',
            'value' 	=> 'peminjam'
        ]);
        User::create([
        	'id'		=> 'P'.time(),
	        'nama'		=> 'Petugas Ginanjar BQS',
	        'email' 	=> 'gin.bqs@gmail.com',
	        'password'	=> bcrypt('12345'),
	        'nis'		=> '10110615',
	        'ktp'		=> '101106151111111',
	        'jurusan'	=> 'IPA',
	        'kelamin'	=> 'l',
	        'agama'		=> 'islam',
	        'tempat_lahir' => 'Bandung',
	        'tanggal_lahir' => '2000-01-01',
	        'no_hp' 	=> '08982200915',
	        'provinsi' 	=> 'Jawa Barat',
	        'kota' 		=> 'Bandung Barat',
	        'kecamatan'	=> 'Cihampelas',
	        'desa' 		=> 'Kec. Mekarjaya',
	        'alamat' 	=> 'Kp, Cibalok',
	        'foto' 		=> 'users/gin.jpeg',
            'user_level_id' => 'petugas',
        ]);
        User::create([
        	'id'		=> 'S'.time(),
	        'nama'		=> 'Siswa Ginanjar BQS',
	        'email' 	=> 'gin_bqs@gmail.com',
	        'password'	=> bcrypt('12345'),
	        'nis'		=> '10110615',
	        'ktp'		=> '101106151111111',
	        'jurusan'	=> 'IPA',
	        'kelamin'	=> 'l',
	        'agama'		=> 'islam',
	        'tempat_lahir' => 'Bandung',
	        'tanggal_lahir' => '2000-01-01',
	        'no_hp' 	=> '08982200915',
	        'provinsi' 	=> 'Jawa Barat',
	        'kota' 		=> 'Bandung Barat',
	        'kecamatan'	=> 'Cihampelas',
	        'desa' 		=> 'Kec. Mekarjaya',
	        'alamat' 	=> 'Kp, Cibalok',
	        'foto' 		=> 'users/gin.jpeg',
            'user_level_id' => 'peminjam',
        ]);
    }
}
