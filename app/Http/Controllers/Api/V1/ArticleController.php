<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\ThemeRepository;
use App\Http\Requests\Api\V1\Article\ArticleStoreRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    public $articleRepository;
    public $themeRepository;

    public function __construct(ArticleRepository $articleRepository, ThemeRepository $themeRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->themeRepository = $themeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = $this->articleRepository->getArticlesWithPagination($request);
        return response($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request)
    {
        // Создание статьи
        $newArticle = new Article();
        $newArticle->title = $request->title;
        $newArticle->content = $request->content;
        $newArticle->author_id = auth('sanctum')->user()->id;
        $newArticle->publish_at = now();
        $newArticle->save();

        if ($request->filled('themes_id')) {
            $themesRequestArr = explode(',', $request->themes_id);
            $themesArr = [];
        
            foreach ($themesRequestArr as $theme_id) {
                if (!empty($this->themeRepository->getThemeById(($theme_id)))) {
                    $themesArr[] = $theme_id;
                }
            }

            if (count($themesArr)) {
                $newArticle->themes()->sync($themesArr);
            }
        }

        if ($request->hasFile('main_image')) {
            $newArticle->addMedia($request->file('main_image'))
                    ->toMediaCollection('main_image');
        }

        return response([
            'status' => true,
            'article_id' => $newArticle->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}