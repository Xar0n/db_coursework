<?php


namespace App\Controllers;
use App\ControllerTwig;
use App\Models\Klient;

class KlientController extends ControllerTwig
{
    protected function actionIndex()
    {
        $klient = Klient::findAll();
        $this->view->display('klient/index.twig', ['klients' => $klient]);
    }

    protected function actionAdd()
    {
        if (isset($_POST['save'])) {
            $klient = new Klient();
            $klient->nomer_i_seriya_pasporta = filter_input(INPUT_POST, 'nomer_i_seriya_pasporta', FILTER_SANITIZE_STRING);
            $klient->familiya = filter_input(INPUT_POST, 'familiya', FILTER_SANITIZE_STRING);
            $klient->imya = filter_input(INPUT_POST, 'imya', FILTER_SANITIZE_STRING);
            $klient->otchestvo = filter_input(INPUT_POST, 'otchestvo', FILTER_SANITIZE_STRING);
            $klient->save();
        }
        $this->view->display('klient/add.twig', []);
    }

    protected function actionEdit()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $klient = Klient::findById($id);
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        }
        if (isset($_POST['save'])) {
            $klient->nomer_i_seriya_pasporta = filter_input(INPUT_POST, 'nomer_i_seriya_pasporta', FILTER_SANITIZE_STRING);
            $klient->familiya = filter_input(INPUT_POST, 'familiya', FILTER_SANITIZE_STRING);
            $klient->imya = filter_input(INPUT_POST, 'imya', FILTER_SANITIZE_STRING);
            $klient->otchestvo = filter_input(INPUT_POST, 'otchestvo', FILTER_SANITIZE_STRING);
            $klient->save();
            header('Location:/klient/');
            exit();
        }
        $this->view->display('klient/edit.twig', ['klient'=>$klient]);
    }

    protected function actionDelete()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $klient = Klient::findById($id);
            $klient->delete();
            header('Location:/klient/');
            exit();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        } catch (\InvalidArgumentException $e) {
            throw new Http415Exception;
        }
    }
}