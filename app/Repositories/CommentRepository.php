<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface {
    public function getCommentsByArticleId($request)
    {
        $count = $request->filled('count') ? $request->count : 15;
        $comment = Comment::where('article_id', $request->article_id)->with(['author' => function($query) {
            $query->select(['id', 'first_name', 'last_name']);
        }])
        ->paginate($count);

        $comment->each(function($comment) {
            if (!empty($comment['author'])) {
                $comment['author']->getMedia();
                if (count($comment['author']['media'])) {
                    $comment['author']['user_avatar_url'] = $comment['author']['media'][0]->getUrl();
                } else {
                    $comment['author']['user_avatar_url'] = null;
                }
                unset($comment['author']['media']);
            }
        });
        return $comment;
    }

    public function getCommentById($comment_id)
    {
        $comment = Comment::where('id', $comment_id)
        ->with(['author' => function($query) {
            $query->select(['id' ,'first_name', 'last_name']);
        }])
        ->first();

        if (!empty($comment['author'])) {
            $comment['author']->getMedia();
            if (count($comment['author']['media'])) {
                $comment['author']['user_avatar_url'] = $comment['author']['media'][0]->getUrl();
            } else {
                $comment['author']['user_avatar_url'] = null;
            }

            unset($comment['author']['media']);
        }

        return $comment;
    }
}