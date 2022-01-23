<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTheme extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'articles_themes';

    protected $fillable = [
        'theme_id',
        'article_id',
    ];
}
