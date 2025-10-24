<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
<<<<<<< HEAD
     * @var array
=======
     * @var array<int, string>
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
     */
    protected $except = [
        //
    ];
}
