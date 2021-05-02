<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Model\ItemNotFoundException;
use App\Models\Kassa;


class KassaController extends ControllerTwig
{
    protected function actionIndex()
    {
        $kassas = Kassa::findAll();
        $this->view->display('kassa/index.twig', ['kassas' => $kassas]);
    }

    protected function actionAdd()
    {
        if (isset($_POST['save'])) {
            $kassa = new Kassa();
            $kassa->naselennyj_punkt = filter_input(INPUT_POST, 'naselennyj_punkt', FILTER_SANITIZE_STRING);
            $kassa->ulica = filter_input(INPUT_POST, 'ulica', FILTER_SANITIZE_STRING);
            $kassa->nomer_doma = filter_input(INPUT_POST, 'nomer_doma', FILTER_SANITIZE_STRING);
            $kassa->save();
        }
        $this->view->display('kassa/add.twig', []);
    }

    protected function actionEdit()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $kassa = Kassa::findById($id);
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        }
        if (isset($_POST['save'])) {
            $kassa->naselennyj_punkt = filter_input(INPUT_POST, 'naselennyj_punkt', FILTER_SANITIZE_STRING);
            $kassa->ulica = filter_input(INPUT_POST, 'ulica', FILTER_SANITIZE_STRING);
            $kassa->nomer_doma = filter_input(INPUT_POST, 'nomer_doma', FILTER_SANITIZE_STRING);
            $kassa->save();
            header('Location:/kassa/');
            exit();
        }
        $this->view->display('kassa/edit.twig', ['kassa' => $kassa]);
    }

    protected function actionDelete()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $kassa = Kassa::findById($id);
            $kassa->delete();
            header('Location:/kassa/');
            exit();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        } catch (\InvalidArgumentException $e) {
            throw new Http415Exception;
        }
    }
}