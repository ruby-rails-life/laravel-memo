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
        for($i=1;$i<=10;$i++){
        	$article = new \App\Article([
                'title' => '記事タイトル'.$i,
                'body' => '記事本文'.$i
            ]);
        	$article->save();
        }
    }
}
