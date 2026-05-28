<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $connection = 'mongodb';

    protected $collection = 'users';

    protected $fillable = [
    'name',
    'email',
    'password',
    'role'
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function readNotifications()
    {
        return $this->notifications()->read();
    }

    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }
}