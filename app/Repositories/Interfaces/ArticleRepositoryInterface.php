<?php 
namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface {
    public function getArticlesWithPagination($request);
}