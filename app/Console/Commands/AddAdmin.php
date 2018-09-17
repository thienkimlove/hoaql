<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Command;
use Sentinel;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:admin {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin';

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
        $email = $this->option('email');
        if ($email) {
            $this->line('Create Admin with email='.$email);

            if (User::where('email', $email)->count() > 0) {
                $this->line('This email='.$email. ' existed in database!');
            } else {
                $user = User::create([
                    'email' => $email,
                    'name' => $email,
                    'password' => Hash::make(uniqid())
                ]);

                $role = Sentinel::findRoleByName('Admin');

                $role->users()->attach($user);

                $this->line('Done');
            }
        }
    }
}
