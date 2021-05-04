<?php


namespace App\Controllers;

use App\ControllerTwig;
use App\Models\Bilet;
use App\Models\Klient;
use App\Models\Kupon;

class KuponController extends ControllerTwig
{
    protected function actionIndex()
    {
        $kupon = Kupon::findAll();
        $this->view->display('kupon/index.twig', ['kupons' => $kupon]);
    }

    protected function actionAdd()
    {
        if (isset($_POST['save'])) {
            $kupon = new Kupon();
            $kupon->nomer_bileta = filter_input(INPUT_POST, 'nomer_bileta', FILTER_SANITIZE_NUMBER_INT);
            $kupon->nomer_i_seriya_pasporta_klienta = filter_input(INPUT_POST, 'nomer_i_seriya_pasporta_klienta', FILTER_SANITIZE_STRING);
            $kupon->nunkt_posadki = filter_input(INPUT_POST, 'nunkt_posadki', FILTER_SANITIZE_STRING);
            $kupon->nunkt_vysadki = filter_input(INPUT_POST, 'nunkt_vysadki', FILTER_SANITIZE_STRING);
            $kupon->tarif = filter_input(INPUT_POST, 'tarif', FILTER_SANITIZE_NUMBER_INT);
            $kupon->save();
        }
        $bilets = Bilet::findAllRelated();
        $klients = Klient::findAll();
        $this->view->display('kupon/add.twig', ['bilets' => $bilets, 'klients' => $klients]);
    }

    protected function actionEdit()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $kupon = Kupon::findById($id);
            $bilets = Bilet::findAllRelated();
            $klients = Klient::findAll();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        }
        if (isset($_POST['save'])) {
            $kupon->nomer_bileta = filter_input(INPUT_POST, 'nomer_bileta', FILTER_SANITIZE_NUMBER_INT);
            $kupon->nomer_i_seriya_pasporta_klienta = filter_input(INPUT_POST, 'nomer_i_seriya_pasporta_klienta', FILTER_SANITIZE_STRING);
            $kupon->nunkt_posadki = filter_input(INPUT_POST, 'nunkt_posadki', FILTER_SANITIZE_STRING);
            $kupon->nunkt_vysadki = filter_input(INPUT_POST, 'nunkt_vysadki', FILTER_SANITIZE_STRING);
            $kupon->tarif = filter_input(INPUT_POST, 'tarif', FILTER_SANITIZE_NUMBER_INT);
            $kupon->save();
            header('Location:/kupon/');
            exit();
        }
        $this->view->display('kupon/edit.twig', ['kupon' => $kupon, 'bilets' => $bilets, 'klients' => $klients]);
    }

    protected function actionDelete()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $kupon = Kupon::findById($id);
            $kupon->delete();
            header('Location:/kupon/');
            exit();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        } catch (\InvalidArgumentException $e) {
            throw new Http415Exception;
        }
    }
}