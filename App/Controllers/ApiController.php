<?php


namespace App\Controllers;

use App\ControllerTwig;
use App\Models\Kassir;

class ApiController extends ControllerTwig
{
    protected function actionKassirsToKassa()
    {
        if (isset($_POST['kassaSelected'])) {
            $idKassa = filter_input(INPUT_POST, 'kassaSelected', FILTER_SANITIZE_NUMBER_INT);
            print json_encode(Kassir::kassirsToKassa($idKassa),JSON_OBJECT_AS_ARRAY);
        }
    }
}