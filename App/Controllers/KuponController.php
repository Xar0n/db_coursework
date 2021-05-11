<?php


namespace App\Controllers;

use App\ControllerTwig;
use App\Models\Bilet;
use App\Models\Klient;
use App\Models\Kupon;
use App\Validators\KuponValidator;

class KuponController extends ControllerTwig
{
    protected $validator;
    public function __construct()
    {
        parent::__construct();
        $this->validator = new KuponValidator();
    }

    protected function actionIndex()
    {
        $kupon = Kupon::findAll();
        $this->view->display('kupon/index.twig', ['kupons' => $kupon]);
    }

    protected function actionAdd()
    {
        $errors = [];
        $overflow = false;
        if (isset($_POST['save'])) {
            $this->validator->inputRules();
            if(!$this->validator->getResultBool()) {
                $number = filter_input(INPUT_POST, 'nomer_bileta', FILTER_VALIDATE_INT);
                if(Kupon::countKupon($number) < 4) {
                    $kupon = new Kupon();
                    $kupon->nomer_bileta = $number;
                    $kupon->nomer_i_seriya_pasporta_klienta = filter_input(INPUT_POST, 'nomer_i_seriya_pasporta_klienta', FILTER_SANITIZE_STRING);
                    $kupon->nunkt_posadki = filter_input(INPUT_POST, 'nunkt_posadki', FILTER_SANITIZE_STRING);
                    $kupon->nunkt_vysadki = filter_input(INPUT_POST, 'nunkt_vysadki', FILTER_SANITIZE_STRING);
                    $kupon->tarif = filter_input(INPUT_POST, 'tarif', FILTER_VALIDATE_INT);
                    $kupon->save();
                }  else $overflow = true;
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $bilets = Bilet::findAllRelated();
        $klients = Klient::findAll();
        $this->view->display('kupon/add.twig', ['bilets' => $bilets, 'klients' => $klients, 'overflow' => $overflow, 'errors' => $errors]);
    }

    protected function actionEdit()
    {
        $errors = [];
        $overflow = false;
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
            $this->validator->inputRules();
            if(!$this->validator->getResultBool()) {
                $number = filter_input(INPUT_POST, 'nomer_bileta', FILTER_VALIDATE_INT);
                if(Kupon::countKupon($number) < 4) {
                    $kupon->nomer_bileta = $number;
                    $kupon->nomer_i_seriya_pasporta_klienta = filter_input(INPUT_POST, 'nomer_i_seriya_pasporta_klienta', FILTER_SANITIZE_STRING);
                    $kupon->nunkt_posadki = filter_input(INPUT_POST, 'nunkt_posadki', FILTER_SANITIZE_STRING);
                    $kupon->nunkt_vysadki = filter_input(INPUT_POST, 'nunkt_vysadki', FILTER_SANITIZE_STRING);
                    $kupon->tarif = filter_input(INPUT_POST, 'tarif', FILTER_VALIDATE_INT);
                    $kupon->save();
                    header('Location:/kupon/');
                    exit();
                } else $overflow = true;
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $this->view->display('kupon/edit.twig', ['kupon' => $kupon, 'bilets' => $bilets, 'klients' => $klients, 'overflow' => $overflow, 'errors' => $errors]);
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