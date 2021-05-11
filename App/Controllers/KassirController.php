<?php


namespace App\Controllers;

use App\ControllerTwig;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Http\Http415Exception;
use App\Exceptions\Model\ItemNotFoundException;
use App\Models\Kassa;
use App\Models\Kassir;
use App\Validators\KassirValidator;

class KassirController extends ControllerTwig
{
    protected $validator;
    public function __construct()
    {
        parent::__construct();
        $this->validator = new KassirValidator();
    }

    protected function actionIndex()
    {
        $kassirs = Kassir::findAllRelated();
        $this->view->display('kassir/index.twig', ['kassirs' => $kassirs]);
    }

    protected function actionAdd()
    {
        $errors = [];
        if (isset($_POST['save'])) {
            $this->validator->inputRules();
            if (!$this->validator->getResultBool()) {
                $kassir = new Kassir();
                $kassir->nomer_kassy = filter_input(INPUT_POST, 'nomer_kassy', FILTER_VALIDATE_INT);
                $kassir->familiya = filter_input(INPUT_POST, 'familiya', FILTER_SANITIZE_STRING);
                $kassir->imya = filter_input(INPUT_POST, 'imya', FILTER_SANITIZE_STRING);
                $kassir->otchestvo = filter_input(INPUT_POST, 'otchestvo', FILTER_SANITIZE_STRING);
                $kassir->save();
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $kassas = Kassa::findAll();
        $this->view->display('kassir/add.twig', ['kassas' => $kassas, 'errors' => $errors]);
    }

    protected function actionEdit()
    {
        $errors = [];
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
            $this->validator->inputRules();
            if (!$this->validator->getResultBool()) {
                $kassir->nomer_kassy = filter_input(INPUT_POST, 'nomer_kassy', FILTER_VALIDATE_INT);
                $kassir->familiya = filter_input(INPUT_POST, 'familiya', FILTER_SANITIZE_STRING);
                $kassir->imya = filter_input(INPUT_POST, 'imya', FILTER_SANITIZE_STRING);
                $kassir->otchestvo = filter_input(INPUT_POST, 'otchestvo', FILTER_SANITIZE_STRING);
                $kassir->save();
                header('Location:/kassir/');
                exit();
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $this->view->display('kassir/edit.twig', ['kassir' => $kassir, 'kassas' => $kassas, 'errors' => $errors]);
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