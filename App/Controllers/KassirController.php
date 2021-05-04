<?php


namespace App\Controllers;

use App\ControllerTwig;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Http\Http415Exception;
use App\Exceptions\Model\ItemNotFoundException;
use App\Models\Kassa;
use App\Models\Kassir;

class KassirController extends ControllerTwig
{
    protected function actionIndex()
    {
        $kassirs = Kassir::findAllRelated();
        $this->view->display('kassir/index.twig', ['kassirs' => $kassirs]);
    }

    protected function actionAdd()
    {
        if (isset($_POST['save'])) {
            $kassir = new Kassir();
            $kassir->nomer_kassy = filter_input(INPUT_POST, 'nomer_kassy', FILTER_SANITIZE_NUMBER_INT);
            $kassir->familiya = filter_input(INPUT_POST, 'familiya', FILTER_SANITIZE_STRING);
            $kassir->imya = filter_input(INPUT_POST, 'imya', FILTER_SANITIZE_STRING);
            $kassir->otchestvo = filter_input(INPUT_POST, 'otchestvo', FILTER_SANITIZE_STRING);
            $kassir->save();
        }
        $kassas = Kassa::findAll();
        $this->view->display('kassir/add.twig', ['kassas'=>$kassas]);
    }

    protected function actionEdit()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $kassir = Kassir::findById($id);
            $kassas = Kassa::findAll();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        }
        if (isset($_POST['save'])) {
            $kassir->nomer_kassy = filter_input(INPUT_POST, 'nomer_kassy', FILTER_SANITIZE_NUMBER_INT);
            $kassir->familiya = filter_input(INPUT_POST, 'familiya', FILTER_SANITIZE_STRING);
            $kassir->imya = filter_input(INPUT_POST, 'imya', FILTER_SANITIZE_STRING);
            $kassir->otchestvo = filter_input(INPUT_POST, 'otchestvo', FILTER_SANITIZE_STRING);
            $kassir->save();
            header('Location:/kassir/');
            exit();
        }
        $this->view->display('kassir/edit.twig', ['kassir'=>$kassir, 'kassas'=>$kassas]);
    }

    protected function actionDelete()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $kassir = Kassir::findById($id);
            $kassir->delete();
            header('Location:/kassir/');
            exit();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        } catch (\InvalidArgumentException $e) {
            throw new Http415Exception;
        }
    }
}