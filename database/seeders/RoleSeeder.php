<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($restaurant): void
    {

        $branch = $restaurant->branches->first();

        $user = User::where('branch_id', $branch->id)->first();
        $user->assignRole('Waiter');
        
        $user = User::where('restaurant_id', $restaurant->id)->first();
        $user->assignRole('Admin');
        
    }

}
