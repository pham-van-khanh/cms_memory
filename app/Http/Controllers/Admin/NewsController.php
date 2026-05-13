<?php
namespace App\Http\Controllers\Admin;

class NewsController extends PostController
{
    protected string $type        = 'news';
    protected string $routePrefix = 'admin.news';
    protected string $viewPrefix  = 'admin.news';
}

