<?php
namespace Database\Seeders;

use Database\Data\PageData;
use Database\Seeders\Ext\MainTestSeeder;

class PagesSeeder extends MainTestSeeder
{
    protected $table = 'pages';
    protected $dataClass = PageData::class;
}
