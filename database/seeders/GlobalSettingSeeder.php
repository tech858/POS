<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GlobalSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new GlobalSetting();
        $setting->name = 'TableTrack';
        $setting->theme_hex = '#A78BFA';
        $setting->theme_rgb = '167, 139, 250';
        $setting->installed_url = config('app.url');
        $setting->save();
    }

}
