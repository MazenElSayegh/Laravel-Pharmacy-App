<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Admin';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->option("email");
        $password = $this->option("password");

        User::create([
            'name'=>'Admin',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password), // password
            'remember_token' => Str::random(10),
            'typeable_type'=>'Admin',
            'typeable_id'=>'1',
        ])
        ->each(function($user){
            $user->assignRole('admin'); 
        });

        $this->info("Admin Created Successfully");
    }
}
