<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

<<<<<<< HEAD
Broadcast::channel('App.User.{id}', function ($user, $id) {
=======
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    return (int) $user->id === (int) $id;
});
