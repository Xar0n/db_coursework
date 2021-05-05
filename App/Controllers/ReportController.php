<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Requests\Report;
use OzdemirBurak\JsonCsv\AbstractFile;
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
        if (isset($_POST['save'])) {
            $data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
            $clients = Report::listClientsOnDate($data_prodazhi);
            if(empty($clients)) $nope = true;
        } elseif (isset($_POST['report'])) {

            $data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
            $clients = Report::listClientsOnDate($data_prodazhi);
            $json = json_encode($clients);
            file_put_contents(__DIR__ . '/../../public/reports/reportgit.json', $json);
            $jsonConvert = new Json(__DIR__ . '/../../public/reports/report.json');
            $jsonConvert->setConversionKey('utf8_encoding', true);
            $jsonConvert->convertAndDownload();
        }
        $this->view->display('report/listClientsOnDate.twig', ['clients' => $clients, 'nope' => $nope]);
    }

    protected function actionSalesMonthSelectCompany()
    {
        debug(Report::salesMonthSelectCompany());
    }
}