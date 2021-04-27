<?php
require __DIR__ . '/../autoload.php';

use App\Models\Article;

$article = Article::findById(23);
debug($article->author);