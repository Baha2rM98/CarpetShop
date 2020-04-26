<?php

namespace App\Policies;

use App\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given admin can manipulate routes
     *
     * @param  Admin  $admin
     * @return Response
     */
    public function manipulate(Admin $admin)
    {
        return $admin->super_admin === 1
            ? $this->allow()
            : $this->deny('! شما سطح دسترسی لازم برای این قسمت را ندارید', 403);
    }
}
