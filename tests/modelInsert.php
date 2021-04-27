<?php
require __DIR__ . '/../autoload.php';

$article = new App\Models\Article;
$article->title = 'Test title insert';
$article->lead = 'Test lead insert';
$article->save();