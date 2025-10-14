<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
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
