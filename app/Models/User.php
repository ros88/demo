<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role_id',
        'password',
        'created_at',
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    // Создаем медиа-коллецию для картинки юзера
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user_avatar')
        ->acceptsMimeTypes(['image/jpeg', 'image/png'])
        ->onlyKeepLatest(1);
    }


    // Определение медиа-конверсий
    public function registerMediaConversions(Media $media = null): void
    {
        // Конверсия картинки пользователя 50X50
        $this->addMediaConversion('thumb50')
              ->width(50)
              ->height(50);
    }
}
