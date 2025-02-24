<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::where('email', 'superadmin@gmail.com')->first();

        $vendor = new Vendor();
        $vendor->banner = 'uploads/banner.jpg';
        $vendor->phone = '1234567890';
        $vendor->email = 'superadmin@gmail.com';
        $vendor->address = 'Sheffield, United Kingdom';
        $vendor->description = 'This is a super admin account';
        $vendor->user_id = $user->id;
        $vendor->save();
    }
}
