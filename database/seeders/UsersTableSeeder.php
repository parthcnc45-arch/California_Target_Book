<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseUser = factory(App\User::class, 1)
            ->states('admin')
            ->create([
                'email' => 'admin@example.com',
                'password' => bcrypt('admin'),
            ])
            ->first();
        
        $baseUser->settings()->create([
            'admin_notify_feedback' => true,
            'admin_notify_signup' => true,
        ]);

        $sub = factory(App\Subscription::class, 1)
            ->make(['account_id' => $baseUser->id])
            ->first();

        $baseUser->subscriptions()
            ->save($sub, ['role' => App\SubscriptionUser::SUBSCRIBER]);

        $cycle = $sub->cycles()
            ->create(['payment_method' => 'check']);
        $cycle->activate();

        $bookSubs = factory(App\BookSubscription::class, 2) ->make();
        $sub->book_subscriptions()
            ->saveMany($bookSubs);

        factory(App\User::class, 1)->make([ 'email' => 'test@example.com' ])
            ->each(function ($addon) use ($sub) {
                return $sub->users()
                    ->save($addon, ['role' => App\SubscriptionUser::ADDON]);
            });
    }
}
