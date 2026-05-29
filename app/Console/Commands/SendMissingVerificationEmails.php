<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Jobs\SendVerificationEmail;;

class SendMissingVerificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:send-verification-email {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Missing Verification Email for user';

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
        $user = User::find($this->argument('userId'));
        
        dispatch(new SendVerificationEmail($user));
    }
}
