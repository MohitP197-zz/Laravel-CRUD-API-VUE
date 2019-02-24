<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //for creating 30 dummy Articles
        factory(App\Article::class, 30)->create();
    }
}
