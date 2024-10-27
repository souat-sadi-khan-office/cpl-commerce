<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

			// dummy one
			['name' => 'test-model.view'],
			['name' => 'test-model.create'],
			['name' => 'test-model.update'],
			['name' => 'test-model.delete'],

			// Zone
			['name' => 'zone.view'],
			['name' => 'zone.create'],
			['name' => 'zone.update'],
			['name' => 'zone.delete'],

			// Country
			['name' => 'country.view'],
			['name' => 'country.create'],
			['name' => 'country.update'],
			['name' => 'country.delete'],

			// City
			['name' => 'city.view'],
			['name' => 'city.create'],
			['name' => 'city.update'],
			['name' => 'city.delete'],

			// Stuff
			['name' => 'stuff.view'],
			['name' => 'stuff.create'],
			['name' => 'stuff.update'],
			['name' => 'stuff.delete'],

			// Roles & Permission
			['name' => 'roles.view'],
			['name' => 'roles.create'],
			['name' => 'roles.update'],
			['name' => 'roles.delete'],

            // System Status
			['name' => 'system-status.view'],
		];

		$insert_data = [];
		$time_stamp = Carbon::now();
		foreach ($data as $d) {
			$d['guard_name'] = 'admin';
			$d['created_at'] = $time_stamp;
			$insert_data[] = $d;
		}

		Permission::insert($insert_data);

    }
}
