<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use App\Subscription;
use App\SubscriptionUser;
use Illuminate\Console\Command;

\Stripe\Stripe::setApiKey(env("STRIPE_KEY"));

class ImportSpreadsheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import {spreadsheet}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a spreadsheet into the user database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start Import');
        $handle = fopen($this->argument('spreadsheet'), 'r');

        if (empty($handle)) {
            $this->error("Spreadsheet path not valid.");
            return;
        }

        $cols = [
            'email' => 7,
            'password' => 9,
            'name' => 1,
            'company' => 0,
            'phone_number' => 6,

            'end' => 8,

            'address_line1' => 2,
            'city' => 3,
            'state' => 4,
            'zip_code' => 5,
        ];

        // Get CSV data and group by company
        $data = []; 
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (empty($row[0])) continue;
            if (strrpos($row[0], 'Company') === 0) continue;

            $u = (object) array_map(function ($prop) use ($row) {
                return $row[$prop];
            }, $cols);

            $name = explode(' ', $u->name);
            $u->first_name = array_shift($name);
            $u->last_name = implode(' ', $name);

            if (!isset($data[$u->company])) {
                $u->addons = [];
                $data[$u->company] = $u;
            } else {
                array_push($data[$u->company]->addons, $u);
            }

        }
        $this->info('Creating...');

        foreach ($data as $company => $subscriber) {
            $this->info("Start creation for $company");

            try {
                $cust = \Stripe\Customer::create([
                    'description' => $company . ': ' . $subscriber->first_name . ' ' . $subscriber->last_name,
                    'email' => $subscriber->email,
                ]);
            } catch(\Stripe\Error\Base $e) {
                return $this->error($e);
            } 

            $u = User::create([
                'email' => $subscriber->email,
                'password' => bcrypt($subscriber->password),
                'first_name' => $subscriber->first_name,
                'last_name' => $subscriber->last_name,
                'company' => $company,
                'phone_number' => $subscriber->phone_number,
                'stripe_id' => $cust->id,
                'verified' => 1,
                'email_token' => base64_encode($subscriber->email),
            ]);

            // Initialize user settings
            $u->settings()->create([]);

            /**
             * Create Subscription record
             */
            $subscription = Subscription::make([
                'account_id' => $u->id,
                'frequency' => 12, 
            ]);

            $u->subscriptions()
                ->save($subscription, ['role' => SubscriptionUser::SUBSCRIBER]);

            $cycle = $subscription->cycles()->create([
                'payment_method' => 'check',
                'starts_on' => Carbon::now(),
                'ends_on' => new Carbon($subscriber->end),
            ]);

            $book_sub = $subscription->book_subscriptions()
                ->create([
                    'address_line1' => $subscriber->address_line1,
                    'city' => $subscriber->city,
                    'zip_code' => $subscriber->zip_code,
                    'state' => $subscriber->state,
                ]);
            
            $addons = collect($subscriber->addons)
                ->map(function ($addon) use ($subscription, $company) {
                    return $subscription->users()
                        ->save(
                            User::make([
                                'email' => $addon->email,
                                'password' => bcrypt($addon->password),
                                'first_name' => $addon->first_name,
                                'last_name' => $addon->last_name,
                                'email_token' => base64_encode($addon->email),
                                'company' => $company,
                                'verified' => 1,
                            ]),
                            ['role' => SubscriptionUser::ADDON]
                        );
                });

            $this->info("Done with $company");
        }


        fclose($handle);
    }
}
