<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


// Artisan::command('email:send {user}', function () {
//     $name = $this->ask('What is your name?');
//     $password = $this->secret('What is the password?');
//     if ($this->confirm('Do you wish to continue?')) {
//         //
//     }

//     $name = $this->anticipate('What is your name?', ['Grace', 'Tom']);
//     $name = $this->choice('What is your name?', ['Grace', 'Tom'], 0);

// })->describe('Send e-mails to a user');
