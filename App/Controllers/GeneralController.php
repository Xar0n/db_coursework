<?php



namespace App\Controllers;

use App\Controller;
use App\Models\Article;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Http\Http415Exception;
use App\Exceptions\Model\ItemNotFoundException;
use App\Views\Twig;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->view = new Twig;
    }

    protected function actionIndex()
    {
        $this->view->display('main/index.twig', []);
    }
}