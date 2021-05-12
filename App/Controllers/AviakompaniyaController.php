<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Models\Aviakompaniya;
use App\Validators\AviakompaniyaValidator;

class AviakompaniyaController extends ControllerTwig
{
    protected $validator;
    public function __construct()
    {
        parent::__construct();
        $this->validator = new AviakompaniyaValidator();
    }

    protected function actionIndex()
    {
        $aviakompaniyas = Aviakompaniya::findAll();
        $this->view->display('aviakompaniya/index.twig', ['aviakompaniyas' => $aviakompaniyas]);
    }

    protected function actionAdd()
    {
        $errors = [];
        if (isset($_POST['save'])) {
            $this->validator->inputRules();
            if(!$this->validator->getResultBool()) {
                $nazvanie = filter_input(INPUT_POST, 'nazvanie', FILTER_SANITIZE_STRING);
                if(Aviakompaniya::uniqueNazvanie($nazvanie)) {
                    $aviakompaniya = new Aviakompaniya();
                    $aviakompaniya->nazvanie = $nazvanie;
                    $aviakompaniya->naselennyj_punkt = filter_input(INPUT_POST, 'naselennyj_punkt', FILTER_SANITIZE_STRING);
                    $aviakompaniya->ulica = filter_input(INPUT_POST, 'ulica', FILTER_SANITIZE_STRING);
                    $aviakompaniya->nomer_doma = filter_input(INPUT_POST, 'nomer_doma', FILTER_SANITIZE_STRING);
                    $aviakompaniya->ofis = filter_input(INPUT_POST, 'ofis', FILTER_SANITIZE_STRING);
                    $aviakompaniya->save();
                } else $errors[] = 'Название авиакомпании не уникально';
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $this->view->display('aviakompaniya/add.twig', ['errors' => $errors]);
    }

    protected function actionEdit()
    {
        $errors = [];
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $aviakompaniya = Aviakompaniya::findById($id);
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        }
        if (isset($_POST['save'])) {
            $this->validator->inputRules();
            if(!$this->validator->getResultBool()) {
                $nazvanie = filter_input(INPUT_POST, 'nazvanie', FILTER_SANITIZE_STRING);
                if(Aviakompaniya::uniqueNazvanie($nazvanie)) {
                    $aviakompaniya->nazvanie = $nazvanie;
                    $aviakompaniya->naselennyj_punkt = filter_input(INPUT_POST, 'naselennyj_punkt', FILTER_SANITIZE_STRING);
                    $aviakompaniya->ulica = filter_input(INPUT_POST, 'ulica', FILTER_SANITIZE_STRING);
                    $aviakompaniya->nomer_doma = filter_input(INPUT_POST, 'nomer_doma', FILTER_SANITIZE_STRING);
                    $aviakompaniya->ofis = filter_input(INPUT_POST, 'ofis', FILTER_SANITIZE_STRING);
                    $aviakompaniya->save();
                    header('Location:/aviakompaniya/');
                    exit();
                } else $errors[] = 'Название авиакомпании не уникально';
            } else $errors = $this->validator->getResultErrors()->firstOfAll();
        }
        $this->view->display('aviakompaniya/edit.twig', ['aviakompaniya'=>$aviakompaniya, 'errors' => $errors]);
    }

    protected function actionDelete()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (empty($id)) {
                throw new \InvalidArgumentException;
            }
            $aviakompaniya = Aviakompaniya::findById($id);
            $aviakompaniya->delete();
            header('Location:/aviakompaniya/');
            exit();
        } catch (ItemNotFoundException $e) {
            throw new Http404Exception;
        } catch (\InvalidArgumentException $e) {
            throw new Http415Exception;
        }
    }
}