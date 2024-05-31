<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            ['id' => 1, 'name' => 'U14', 'category' => 'U14', 'created_at' => '2024-02-28 13:38:19', 'updated_at' => '2024-04-01 11:03:51', 'color' => '#D20103'],
            ['id' => 2, 'name' => 'U15', 'category' => 'U15', 'created_at' => '2024-04-01 11:03:40', 'updated_at' => '2024-04-01 11:03:40', 'color' => '#7DDA58'],
            ['id' => 3, 'name' => 'U13', 'category' => 'U13', 'created_at' => '2024-04-02 06:05:19', 'updated_at' => '2024-04-02 06:07:19', 'color' => '#A61DD0'],
            ['id' => 4, 'name' => 'U11', 'category' => 'U11', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#F0A830'],
            ['id' => 5, 'name' => 'U17', 'category' => 'U17', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#F0D830'],
            ['id' => 6, 'name' => 'USenior', 'category' => 'USenior', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#B0A830'],
            ['id' => 7, 'name' => 'U18', 'category' => 'U18', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#80B830'],
            ['id' => 8, 'name' => 'U20', 'category' => 'U20', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#30B8B8'],
            ['id' => 9, 'name' => 'U18-B', 'category' => 'U18-B', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#7058A5'],
            ['id' => 10, 'name' => 'U15-F', 'category' => 'U15-F', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#505FA8'],
            ['id' => 11, 'name' => 'U18-C', 'category' => 'U18-C', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#507FA8'],
            ['id' => 12, 'name' => 'U13-B', 'category' => 'U13-B', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#207F58'],
            ['id' => 13, 'name' => 'U11-A', 'category' => 'U11-A', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#907FA8'],
            ['id' => 14, 'name' => 'U11-B', 'category' => 'U11-B', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#607F48'],
            ['id' => 15, 'name' => 'U11-C', 'category' => 'U11-C', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#707FC8'],
            ['id' => 16, 'name' => 'U11-D', 'category' => 'U11-D', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#707F58'],
            ['id' => 17, 'name' => 'U11-E', 'category' => 'U11-E', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#607FA8'],
            ['id' => 18, 'name' => 'U13-C', 'category' => 'U13-C', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#407FA8'],
            ['id' => 19, 'name' => 'U13-F', 'category' => 'U13-F', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#307FA8'],
            ['id' => 20, 'name' => 'U15-C', 'category' => 'U15-C', 'created_at' => '2024-05-02 16:48:56', 'updated_at' => '2024-05-02 16:48:56', 'color' => '#207FC8']
        ]);
    }
}
