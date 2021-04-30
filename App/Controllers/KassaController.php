<?php


namespace App\Controllers;


use App\Controller;
use App\Views\Twig;

class KassaController extends Controller
{
    public function __construct()
    {
        $this->view = new Twig;
    }

    protected function actionIndex()
    {
        $this->view->display('kassa/index.twig', []);
    }

    protected function actionAdd()
    {
        $this->view->display('kassa/index.twig', []);
    }

    protected function actionEdit()
    {
        $this->view->display('kassa/index.twig', []);
    }

    protected function actionSave()
    {
        $this->view->display('kassa/index.twig', []);
    }

    protected function actionDelete()
    {
        $this->view->display('kassa/index.twig', []);
    }
}