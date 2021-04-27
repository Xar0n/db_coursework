<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Http\Http415Exception;
use App\Exceptions\Model\ItemNotFoundException;

class DefaultController extends Controller
{
	protected function actionIndex()
	{
		$articles = Article::findAll();
		$this->view->articles = $articles;
		$this->view->display(__DIR__ . '/../../Templates/admin/default/index.php');
	}

	protected function actionAdd()
	{
		$authors = Author::findAll();
		if (isset($_POST['save'])) {
			$article = new Article();
			if (isset($_POST['author'])) {
				try {
					$author_id = filter_input(INPUT_POST, 'author', FILTER_VALIDATE_INT);
					$author = Author::findById($author_id);
					$article->author_id = $author->id;
				} catch (ItemNotFoundException $e) {
					throw new Http404Exception;
				}
			}
			$article->title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
			$article->lead = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_STRING);
			$article->save();
		}
		$this->view->authors = $authors;
		$this->view->display(__DIR__ . '/../../Templates/admin/default/add.php');
	}

	protected function actionEdit()
	{
		try {
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
			if (empty($id)) {
				throw new \InvalidArgumentException;
			}
			$article = Article::findById($id);
		} catch (ItemNotFoundException $e) {
			throw new Http404Exception;
		}
		if (isset($_POST['save'])) {
			$article->title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
			$article->lead = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_STRING);
			$article->save();
		}
		$this->view->article = $article;
		$this->view->display(__DIR__ . '/../../Templates/admin/default/edit.php');
	}

	protected function actionSave()
	{
		if(filter_has_var('id', INPUT_POST)) {
			$article = Article::findById($_POST['id']);
		} else {
			$article = new Article;
			$author = Author::findById($_POST['author']);
			$article->author_id = $author->id;
		}
		$article->title = $_POST['title'];
		$article->lead = $_POST['lead'];
		$article->save();
	}

	protected function actionDelete()
	{
		try {
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
			if (empty($id)) {
				throw new \InvalidArgumentException;
			}
			$article = Article::findById($id);
			$article->delete();
			header('Location:/admin/');
			exit();
		} catch (ItemNotFoundException $e) {
			throw new Http404Exception;
		} catch (\InvalidArgumentException $e) {
			throw new Http415Exception;
		}
	}
}
