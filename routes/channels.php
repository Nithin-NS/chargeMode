<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

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
//Authentication for Private Channels
// Broadcast::channel('user.{id}', function ($user, $id) {
//     return $user->id === $id;
// });

//Authentication for presence Channels
// Broadcast::channel('user.{userId}', function ($user, $userId) {
//     if ($user->id === $userId) {
//       return array('name' => $user->name);
//     }
//   });
// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
// Broadcast::channel('notification', function () {
//     return Auth::guard('admin');
// });




