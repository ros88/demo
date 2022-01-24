<?php 
namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface {
    public function getCommentsByArticleId($request);
    public function getCommentById($comment_id);
}