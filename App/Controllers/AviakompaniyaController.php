<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Models\Aviakompaniya;

class AviakompaniyaController extends ControllerTwig
{
    protected function actionIndex()
    {
        $aviakompaniyas = Aviakompaniya::findAll();
        $this->view->display('aviakompaniya/index.twig', ['aviakompaniyas' => $aviakompaniyas]);
    }

    protected function actionAdd()
    {
        if (isset($_POST['save'])) {
            $aviakompaniya = new Aviakompaniya();
            $aviakompaniya->nazvanie = filter_input(INPUT_POST, 'nazvanie', FILTER_SANITIZE_STRING);
            $aviakompaniya->naselennyj_punkt = filter_input(INPUT_POST, 'naselennyj_punkt', FILTER_SANITIZE_STRING);
            $aviakompaniya->ulica = filter_input(INPUT_POST, 'ulica', FILTER_SANITIZE_STRING);
            $aviakompaniya->nomer_doma = filter_input(INPUT_POST, 'nomer_doma', FILTER_SANITIZE_STRING);
            $aviakompaniya->ofis = filter_input(INPUT_POST, 'ofis', FILTER_SANITIZE_STRING);
            $aviakompaniya->save();
        }
        $this->view->display('aviakompaniya/add.twig', []);
    }

    protected function actionEdit()
    {
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
            $aviakompaniya->nazvanie = filter_input(INPUT_POST, 'nazvanie', FILTER_SANITIZE_STRING);
            $aviakompaniya->naselennyj_punkt = filter_input(INPUT_POST, 'naselennyj_punkt', FILTER_SANITIZE_STRING);
            $aviakompaniya->ulica = filter_input(INPUT_POST, 'ulica', FILTER_SANITIZE_STRING);
            $aviakompaniya->nomer_doma = filter_input(INPUT_POST, 'nomer_doma', FILTER_SANITIZE_STRING);
            $aviakompaniya->ofis = filter_input(INPUT_POST, 'ofis', FILTER_SANITIZE_STRING);
            $aviakompaniya->save();
            header('Location:/aviakompaniya/');
            exit();
        }
        $this->view->display('aviakompaniya/edit.twig', ['aviakompaniya'=>$aviakompaniya]);
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