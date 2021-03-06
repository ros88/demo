<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, QueryCacheable;
    protected $cacheFor = 180; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'author_id ',
        'publish_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publish_at' => 'date',
    ];

    public $timestamps = false;

    public function themes()
    {
        return $this->belongsToMany(Theme::class, ArticleTheme::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function good_rating()
    {
        return $this->hasMany(ArticleRating::class)->where('mark', 1);
    }

    public function bad_rating()
    {
        return $this->hasMany(ArticleRating::class)->where('mark', -1);
    }
     
     // Создаем медиа-коллецию для главной картинки  
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')
        ->acceptsMimeTypes(['image/jpeg', 'image/png'])
        ->onlyKeepLatest(1);
    }
    
    
    // Определение медиа-конверсий
    public function registerMediaConversions(Media $media = null): void
    {
        // Конверсия картинки пользователя 50X50
        $this->addMediaConversion('thumb50')
            ->width(200)
            ->height(200);
    }
}
