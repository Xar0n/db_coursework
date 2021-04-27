<?php
require __DIR__ . '/../autoload.php';

use App\Models\Article;

$article1 = new Article();
$article1->title = 'Test title insert';
$article1->lead = 'Test lead  insert';
var_dump($article1->delete());

$article2 = Article::findById(1);
var_dump($article2->delete());