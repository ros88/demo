<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Rating\RatingStoreRequest;
use App\Models\ArticleRating;
use App\Repositories\ArticleRepository;

class RatingController extends Controller
{
    public $articleRepository;
    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingStoreRequest $request)
    {
        if ((int) $request->mark === -1 || (int) $request->mark === 1) {
            if (empty($this->articleRepository->getArticleById($request->article_id))) {
                return response([
                    'status' => false,
                    'message' => 'Статья с данным ID не найдена'
                ], 404);
            }

    

            $authUser = auth()->user();
            $isRating = ArticleRating::where('user_id', $authUser->id)->where('article_id', $request->article_id)->where('mark', $request->mark)->first();

            if (!empty($isRating)) {
                return response([
                    'status' => false,
                    'message' => 'Пользователь уже поставил данную оценку'
                ], 400);
            }

            if (empty(ArticleRating::where('user_id', $authUser->id)->where('article_id', $request->article_id)->first())) {
                $newRating = new ArticleRating();
                $newRating->user_id = $authUser->id;
                $newRating->article_id = $request->article_id;
                $newRating->mark = $request->mark;
                $newRating->save();
            }

            ArticleRating::where('user_id', $authUser->id)->where('article_id', $request->article_id)->update(['mark' => $request->mark]);
            return response([
                'status' => true
            ]);

        } else {
            return response([
                'status' => false,
                'message' => 'Поставте валидню оценку'
            ], 500);
        }
      
    }
}