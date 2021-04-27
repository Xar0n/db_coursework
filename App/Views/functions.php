<?php
return [
	function (App\Models\Article $article) {
		return $article->id;
	},
	function (App\Models\Article $article) {
		return $article->title;
	},
	function (App\Models\Article $article) {
		if (empty($article->author)) {
			return 'Автора нет';
		}
		return $article->author->name;
	}
];