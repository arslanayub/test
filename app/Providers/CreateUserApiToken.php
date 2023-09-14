<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserApiToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = auth()->user();
        $token = $user->createToken('apiToken')->plainTextToken;
        request()->session()->put('api-token', $token);
    }
}
