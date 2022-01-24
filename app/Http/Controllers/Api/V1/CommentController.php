<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CommentRepository;
use App\Repositories\ArticleRepository;
use App\Http\Requests\Api\V1\Comment\CommentIndexRequest;
use App\Http\Requests\Api\V1\Comment\CommentStoreRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public $commentRepository;
    public $articleRepository;

    public function __construct(CommentRepository $commentRepository, ArticleRepository $articleRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->articleRepository = $articleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentIndexRequest $request)
    {
        return response($this->commentRepository->getCommentsByArticleId($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = $this->commentRepository->getCommentById($id);

        if (!empty($comment)) {
            return response($comment);
        } else {
            return response([
                'status' => false 
            ], 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentStoreRequest $request)
    {
        if (!empty($this->articleRepository->getArticleById($request->article_id))) {
            $comment = new Comment();
            $comment->text = $request->text;
            $comment->author_id = auth('sanctum')->user()->id;
            $comment->article_id = $request->article_id;
            $comment->save();

            return response([
                'status' => true,
                'comment_id' => $comment->id 
            ], 201);
        } else {
            return response([
                'status' => false,
                'message' => 'Статьи с данным ID не найдено'
            ], 404);
        }
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
