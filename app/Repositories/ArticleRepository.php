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
        }

        $articles = Article::select(['id', 'title', 'author_id', 'publish_at'])
        ->when(!$request->filled('sort_by'), function($query) {
            $query->orderBy('publish_at', 'DESC');
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

        return $articles;
    }
}