<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Jobs\SendPasswordReset;

class SendPasswordResetEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:send-password-reset {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send User an Email to Set their password';

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
	$reset = \DB::table('password_resets')->where('email', $user->email)->first();

	dispatch(new SendPasswordReset($user, $reset->token));
    }
}
