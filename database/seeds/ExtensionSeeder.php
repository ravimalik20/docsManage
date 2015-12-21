<?php

use Illuminate\Database\Seeder;

class ExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["name" => "pdf"],
            ["name" => "txt"],
            ["name" => "csv"],
            ["name" => "raw"],
        ];

        DB::table("extensions")->insert($data);
    }
}
