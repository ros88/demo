<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Support\Facades\Schema;

class ArticleRepository implements ArticleRepositoryInterface {
    public function getArticlesWithPagination($request)
    {
        // Сколько записей показывать в пагинации 
        $count = $request->filled('count') ? $request->count : 15;

        if ($request->filled('fields')) {
            $fieldsArr = explode(',', $request->fields);
            $coulumnArr = Schema::getColumnListing('articles');
            $getCoulumns = [];
            
            foreach ($fieldsArr as $item) {
                if (in_array($item, $coulumnArr)) {
                    $getCoulumns[] = $item;
                }
            }

            if (empty($getCoulumns)) {
                $getCoulumns[] = 'id';
            }

            $articles = Article::select($getCoulumns)->paginate($count);
        } else {
            $articles = Article::select(['id', 'title', 'author_id', 'publish_at'])
            ->when(!$request->filled('sort_by'), function($query) {
                $query->orderBy('publish_at', 'DESC');
            })
            ->when($request->sort_by == 'rating', function($query) {
                $query->withCount('good_rating')->orderByDesc('good_rating_count');
            })
            ->when($request->filled('expand') && $request->expand == 'themes', function($query) {
                $query->with(['themes']);
            })
            ->when($request->filled('themes_id'), function($query) use ($request) {
                $themesArr = explode(',', $request->themes_id);
                $query->whereHas('themes', function($query) use ($themesArr) {
                    $query->whereIn('themes.id', $themesArr);
                });
            })
            ->paginate($count);
    
            $articles->each(function($article) {
                $article->getMedia();
                if (count($article['media'])) {
                    $article['main_image_url'] = $article['media'][0]->getUrl();
                } else {
                    $article['main_image_url'] = null;
                }
    
                unset($article['media']);
            });    
        }

 
        return $articles;
    }

    public function getArticleById(int $article_id)
    {
        $article = Article::where('id', $article_id)->with(['themes', 
            'author' => function($query) {
                $query->select(['id', 'first_name', 'last_name']);
            }
        ])
        ->first();
        
        if (!empty($article)) {
            $article->getMedia();
            if (count($article['media'])) {
                $article['main_image_url'] = $article['media'][0]->getUrl();
            } else {
                $article['main_image_url'] = null;
            }

            if (!empty($article['author'])) {
                $article['author']->getMedia();

                if (count($article['author']['media'])) {
                    $article['author']['usr_avatar_url'] = $article['author']['media'][0]->getUrl();
                } else {
                    $article['author']['usr_avatar_url'] = null;
                }
                unset($article['author']['media']);
            }

            unset($article['media']);
        }

        return $article;
    }
}