<?php 
namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface {
    public function getArticlesWithPagination($request);
    public function getArticleById(int $article_id);
}