<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'link_name' => '百度',
                'link_title' => '国内百度第一',
                'link_url' => 'http://www.baidu.com',
                'link_order' => '1',
            ],
            [
                'link_name' => '百度一号',
                'link_title' => '国内百度第一（first）',
                'link_url' => 'http://www.baidu.com',
                'link_order' => '2',
            ],
        ];
        DB::table('links')->insert($data);
    }
}
