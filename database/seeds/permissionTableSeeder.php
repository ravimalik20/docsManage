<?php

use Illuminate\Database\Seeder;

class permissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
          ["name"=>"view","description"=>"has permission to view"],
          ["name"=>"delete","description"=>"has permission to delete"],
          ["name"=>"print","description"=>"has permission to print"],
          ["name"=>"download","description"=>"has permission to download"]
      ];
      DB::table("permissions")->insert($data);
    }
}
