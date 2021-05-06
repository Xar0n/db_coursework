<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Models\Aviakompaniya;
use App\Requests\Report;
use OzdemirBurak\JsonCsv\File\Json;

class ReportController extends ControllerTwig
{
    protected function actionGeneralSales()
    {
        debug(Report::generalSales());
    }

    protected function actionListClientsOnDate()
    {
        $clients = [];
        $nope = false;
        if (isset($_POST['show'])) {
            $data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
            $clients = Report::listClientsOnDate($data_prodazhi);
            if(empty($clients)) $nope = true;
        } elseif (isset($_POST['report'])) {
            $data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
            $clients = Report::listClientsOnDate($data_prodazhi);
            $json = json_encode($clients);
            file_put_contents(__DIR__ . '/../../public/reports/report2.json', $json);
            $jsonConvert = new Json(__DIR__ . '/../../public/reports/report2.json');
            $jsonConvert->setConversionKey('utf8_encoding', true);
            $jsonConvert->setConversionKey('delimiter', ';');
            $jsonConvert->convertAndDownload();
        }
        $this->view->display('report/listClientsOnDate.twig', ['clients' => $clients, 'nope' => $nope]);
    }

    protected function actionSalesMonthSelectCompany()
    {
        $nope = false;
        $bilets = [];
        if (isset($_POST['show'])) {
            $shifr_aviakompanii = filter_input(INPUT_POST, 'shifr_aviakompanii', FILTER_SANITIZE_NUMBER_INT);
            $month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT);
            $bilets = Report::salesMonthSelectCompany($shifr_aviakompanii, $month);
            if(empty($bilets)) $nope = true;
        } elseif (isset($_POST['report'])) {

        }
        $aviakompaniyas = Aviakompaniya::findAll();
        $this->view->display('report/salesMonthSelectCompany.twig', ['aviakompaniyas' => $aviakompaniyas, 'nope' => $nope, 'bilets' => $bilets]);
    }
}