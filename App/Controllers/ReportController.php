<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Requests\Report;

class ReportController extends ControllerTwig
{
    protected function actionGeneralSales()
    {
        debug(Report::generalSales());
    }

    protected function actionListClientsOnDate()
    {
        if (isset($_POST['save'])) {
            $data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
            $klients = Report::listClientsOnDate($data_prodazhi);
        }
        $this->view->display('report/listClientsOnDate.twig', ['klients'=>$klients]);
    }

    protected function actionSalesMonthSelectCompany()
    {
        debug(Report::salesMonthSelectCompany());
    }
}