<?php


namespace App;


use App\Views\Twig;
use App\Exceptions\Controller\ActionNotFound;
use App\Exceptions\Http\Http403Exception;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Model\ItemNotFoundException;

abstract class ControllerTwig extends Controller
{
    protected $view;
    public function __construct()
    {
        $this->view = new Twig;
    }
}