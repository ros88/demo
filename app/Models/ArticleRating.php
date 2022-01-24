<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleRating extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'articles_rating';

    protected $fillable = [
        'user_id',
        'article_id',
        'mark ',
    ];
}
