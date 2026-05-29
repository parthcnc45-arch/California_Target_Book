<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;

class CreateAddonAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:create-addon {subId} {addonEmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Addon account';

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
        $sub = Subscription::find($this->argument('subId'));
        $sub->addUser($this->argument('addonEmail'));
    }
}
