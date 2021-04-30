<?php


namespace App\Controllers;


use App\Controller;
use App\Views\Twig;

class CashboxController extends Controller
{
    public function __construct()
    {
        $this->view = new Twig;
    }

    protected function actionIndex()
    {
        $this->view->display('main/cashbox.twig', []);
    }
}