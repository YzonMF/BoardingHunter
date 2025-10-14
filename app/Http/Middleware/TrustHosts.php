<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
<<<<<<< HEAD
     * @return array
     */
    public function hosts()
=======
     * @return array<int, string|null>
     */
    public function hosts(): array
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
