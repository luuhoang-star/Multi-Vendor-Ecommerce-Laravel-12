<?php
namespace Database\Seeders\Admin;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = 'SUPER ADMIN';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('1234');
        $admin->save();

        Role::create(['name' => 'Super Admin', 'guard' => 'admin']);

        $admin->assignRole('Super Admin');
    }
}
