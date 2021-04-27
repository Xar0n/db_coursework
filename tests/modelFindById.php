<?php
require __DIR__ . '/../autoload.php';

use App\Models\Article;

var_dump(Article::findById(2));
var_dump(Article::findById(14));
