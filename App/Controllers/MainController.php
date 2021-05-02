<?php



namespace App\Controllers;

use App\ControllerTwig;

class MainController extends ControllerTwig
{
    protected function actionIndex()
    {
        $this->view->display('main/index.twig', []);
    }
}