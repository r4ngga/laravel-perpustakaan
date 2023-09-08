<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'name_book' => 'Pengenalan baru',
            'isbn' => 9016,
            'author' => 'Suyatno',
            'publisher' => 'Gramedia',
            'time_release' => 2002,
            'pages_book' => 250,
            'language' => 'Bahasa Indonesia',
            'image_book' => ''
        ]);
    }
}
