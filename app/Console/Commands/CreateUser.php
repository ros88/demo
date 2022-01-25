<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {first_name} {email} {password} {role_id} {last_name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

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
     * @return int
     */
    public function handle()
    {
        $firstName = $this->argument('first_name');
        $lastName = $this->argument('email');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $role_id = $this->argument('role_id');

        $validator = Validator::make([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id 
        ], [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['sometimes', 'string', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:14'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if ($validator->fails()) {
            $this->error('User not created. See error messages below:');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $newUser = new User();
        $newUser->first_name = $firstName;
        $newUser->last_name = $lastName;
        $newUser->email = $email;
        $newUser->role_id = $role_id;
        $newUser->password = bcrypt($password);
        $newUser->created_at = now();
        $newUser->save();
   
        $this->info('User created!');
    }
}
