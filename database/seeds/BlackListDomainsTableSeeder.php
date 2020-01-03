<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlackListDomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains_blacklist')->insert([
            'domain' => 'black-domain.com',
            'updated_at' => time(),
            'created_at' => time(),
        ]);
    }
}
