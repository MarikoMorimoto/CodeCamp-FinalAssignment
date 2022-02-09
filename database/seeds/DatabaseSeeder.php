<?php

use Illuminate\Database\Seeder;
use App\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // データのクリア 外部キー制約により今回は不可
        // Category::truncate();
        
        // データ挿入
        Category::create([
            'name' => 'あ',
        ]);
        
        Category::create([
            'name' => 'い',
        ]);
        
        category::create([
            'name' => 'う',
        ]);
        
        category::create([
            'name' => 'え',
        ]);
        
        category::create([
            'name' => 'その他',
        ]);
    }
}
