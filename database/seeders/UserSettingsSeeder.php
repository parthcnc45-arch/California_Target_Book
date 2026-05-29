<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('role', User::ROLE_ADMIN)
            ->get()
            ->each(function ($admin) {
                $admin->settings()->create([
                    'admin_notify_feedback' => true,
                    'admin_notify_signup' => true,
                ]);
            });
    }
}
