<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::count()) {
            $this->command->info('Truncating Users\'s tables');
            $this->truncateUsersTable();
            $users = [
                [
                    'name' => 'Owner User',
                    'email' => 'owner@app.com',
                    'username' => generateUsername('owner'),
                    'user_code' => generateUserCode('owner'),
                    'roles' => ['owner', 'user'],
                    'email_verified_at' => Carbon::now(),
                    'phone_verified_at' => Carbon::now(),
                    'permissions' => [],
                    'password' => bcrypt('owner-user'),
                ],
                [
                    'name' => 'Admin User',
                    'email' => 'admin@app.com',
                    'username' => generateUsername('admin'),
                    'user_code' => generateUserCode('admin'),
                    'roles' => ['admin', 'user'],
                    'email_verified_at' => Carbon::now(),
                    'phone_verified_at' => Carbon::now(),
                    'permissions' => [],
                    'password' => bcrypt('admin-user'),
                ],
                [
                    'name' => 'App User',
                    'email' => 'user@app.com',
                    'username' => generateUsername('app-user'),
                    'user_code' => generateUserCode(),
                    'roles' => ['user'],
                    'email_verified_at' => Carbon::now(),
                    'phone_verified_at' => Carbon::now(),
                    'permissions' => [],
                    'password' => bcrypt('demo-user'),
                ]
            ];
            foreach ($users as $user) {
                $tempUser = User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'user_code' => $user['user_code'],
                    'password' => $user['password'],
                    'email_verified_at' => $user['email_verified_at'],
                ]);
                $tempUser->syncRoles($user['roles']);
                $tempUser->syncPermissions($user['permissions']);
            }
        }
    }

    /**
     * Truncates the users table
     * @return void
     */
    public function truncateUsersTable(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
