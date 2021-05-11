<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Models\Aviakompaniya;
use App\Models\Bilet;
use App\Models\Kassa;
use App\Models\Kassir;
use App\Validators\BiletValidator;

class BiletController extends ControllerTwig
{
    protected $validator;
    public function __construct()
    {
        parent::__construct();
        $this->validator = new BiletValidator();
    }

    protected function actionIndex()
    {
        $bilets = Bilet::findAllRelated();
        $this->view->display('bilet/index.twig', ['bilets' => $bilets]);
    }

    protected function actionAdd()
    {
        $errors = [];
        if (isset($_POST['save'])) {
            $this->validator->inputRules();
            if(!$this->validator->getResultBool()) {
                $kassirId = filter_input(INPUT_POST, 'tabelnyj_nomer_kassira', FILTER_VALIDATE_INT);
                $kassaId = filter_input(INPUT_POST, 'nomer_kassy', FILTER_VALIDATE_INT);
                $kassir = Kassir::findById($kassirId);
                if($kassir->nomer_kassy == $kassaId) {
                    $bilet = new Bilet();
                    $bilet->shifr_aviakompanii = filter_input(INPUT_POST, 'shifr_aviakompanii', FILTER_VALIDATE_INT);
                    $bilet->nomer_kassy = $kassaId;
                    $bilet->tabelnyj_nomer_kassira = $kassirId;
                    $bilet->tip = filter_input(INPUT_POST, 'tip', FILTER_SANITIZE_STRING);
                    $bilet->data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
                    $bilet->save();
                }
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $aviakompaniyas = Aviakompaniya::findAll();
        $kassas = Kassa::findAll();
        $kassirs = Kassir::kassirsToKassa($kassas[0]->id);
        $this->view->display('bilet/add.twig', ['aviakompaniyas'=>$aviakompaniyas, 'kassas'=>$kassas, 'kassirs'=>$kassirs, 'errors' => $errors]);
    }

    protected function actionEdit()
    {
        $errors = [];
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $bilet = Bilet::findById($id);
            $aviakompaniyas = Aviakompaniya::findAll();
            $kassas = Kassa::findAll();
            $kassirs = Kassir::kassirsToKassa($kassas[0]->id);
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        }
        if (isset($_POST['save'])) {
            $this->validator->inputRules();
            if(!$this->validator->getResultBool()) {
                $kassirId = filter_input(INPUT_POST, 'tabelnyj_nomer_kassira', FILTER_VALIDATE_INT);
                $kassaId = filter_input(INPUT_POST, 'nomer_kassy', FILTER_VALIDATE_INT);
                $kassir = Kassir::findById($kassirId);
                if($kassir->nomer_kassy == $kassaId) {
                    $bilet->shifr_aviakompanii = filter_input(INPUT_POST, 'shifr_aviakompanii', FILTER_VALIDATE_INT);
                    $bilet->nomer_kassy = $kassaId;
                    $bilet->tabelnyj_nomer_kassira = $kassirId;
                    $bilet->tip = filter_input(INPUT_POST, 'tip', FILTER_SANITIZE_STRING);
                    $bilet->data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
                    $bilet->save();
                    header('Location:/bilet/');
                    exit();
                }
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $this->view->display('bilet/edit.twig', ['bilet' => $bilet, 'aviakompaniyas'=>$aviakompaniyas, 'kassas'=>$kassas, 'kassirs'=>$kassirs, 'errors' => $errors]);
    }

    protected function actionDelete()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $bilet = Bilet::findById($id);
            $bilet->delete();
            header('Location:/bilet/');
            exit();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        } catch (\InvalidArgumentException $e) {
            throw new Http415Exception;
        }
    }
}