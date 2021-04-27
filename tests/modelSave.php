<?php
require __DIR__ . '/../autoload.php';

use App\Models\Article;

$article1 = new Article();
$article1->title = 'Test title insert';
$article1->lead = 'Test lead  insert';
$article1->save();

$article2 = Article::findById(1);
$article2->title = 'Test title update';
$article2->lead = 'Test lead  update';
$article2->save();

