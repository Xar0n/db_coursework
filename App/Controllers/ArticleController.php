<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Article;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Http\Http415Exception;
use App\Exceptions\Model\ItemNotFoundException;
use App\Views\Twig;

class ArticleController extends Controller
{
	public function __construct()
	{
		$this->view = new Twig;
	}

	protected function actionIndex()
	{
		$articles = Article::findAllEach();
		$this->view->articles = $articles;
		$this->view->display('article/index.twig', ['articles' => $articles]);
	}

	protected function actionOne()
	{
		try {
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
			if (empty($id)) {
				throw new \InvalidArgumentException;
			}
			$article = Article::findById($id);
			$this->view->display('article/one.twig', ['article' => $article]);
		} catch (ItemNotFoundException $e) {
			throw new Http404Exception;
		} catch (\InvalidArgumentException $e) {
			throw new Http415Exception;
		}
	}
}
