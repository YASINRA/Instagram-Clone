<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelLike\Traits\Liker;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelFollow\Traits\Followable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Liker, Favoriter, Follower, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }


    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id')->orWhere('receiver_id', $this->id);
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }
}
