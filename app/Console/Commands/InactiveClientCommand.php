<?php

namespace App\Console\Commands;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InactiveClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:inactive-client-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an inactive notification to client';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $limit = Carbon::now()->subMonth();
        $inactive_user = Client::where('last_login', '<', $limit)->get();
        foreach ($inactive_user as $userClient) {
            $user = $userClient->type;
            $user->notifyClient();
        }
    }
}