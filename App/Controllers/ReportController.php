<?php


namespace App\Controllers;


use App\ControllerTwig;
use App\Models\Aviakompaniya;
use App\Requests\Report;

class ReportController extends ControllerTwig
{
    protected function actionGeneralSales()
    {
        $sales = Report::generalSales();
        if (isset($_POST['report'])) {
            $salesRep = array_map(function($sale) {
                return array(
                    'Шифр авиакомпании' => $sale['shifr_aviakompanii'],
                    'Название авиакомпании' => $sale['nazvanie'],
                    'Населенный пункт авиакомпании' => $sale['naselennyj_punkt'],
                    'Улица авиакомпании' => $sale['ulica'],
                    'Номер дома авиакомпании' => $sale['nomer_doma'],
                    'Офис авиакомпании' => $sale['ofis'],
                    'Сумма продаж' => $sale['sum_sales'],
                );
            }, $sales);
            arr_to_csv($salesRep, 'Общая сумма от продаж билетов каждой авиакомпании');
        }
        $this->view->display('report/generalSales.twig', ['sales' => $sales]);
    }

    protected function actionListClientsOnDate()
    {
        $clients = [];
        $nope = false;
        if(isset($_POST['show']) | isset($_POST['report'])) {
            $data_prodazhi = filter_input(INPUT_POST, 'data_prodazhi', FILTER_SANITIZE_STRING);
            $clients = Report::listClientsOnDate($data_prodazhi);
            if (isset($_POST['show']) and empty($clients)) $nope = true;
            if (isset($_POST['report'])) {
                $clientsRep = array_map(function($client) {
                    return array(
                        'Фамилия клиента' => $client['familiya'],
                        'Имя клиента' => $client['imya'],
                        'Отчетство клиента' => $client['otchestvo'],
                        'Шифр авиакомпании' => $client['shifr_aviakompanii'],
                        'Название авиакомпании' => $client['nazvanie'],
                        'Населенный пункт авиакомпании' => $client['naselennyj_punkt'],
                        'Улица авиакомпании' => $client['ulica'],
                        'Номер дома авиакомпании' => $client['nomer_doma'],
                        'Офис авиакомпании' => $client['ofis'],
                        'Пункт посадки' => $client['nunkt_posadki'],
                        'Пункт высадки' => $client['nunkt_vysadki'],
                        'Тариф купона' => $client['tarif'],
                        'Тип билета' => $client['tip'],
                        'Дата продажи билета' => $client['data_prodazhi']
                    );
                }, $clients);
                arr_to_csv($clientsRep, 'Список клиентов авиакомпаний на заданную дату');
            }

        }
        $this->view->display('report/listClientsOnDate.twig', ['clients' => $clients, 'nope' => $nope]);
    }

    protected function actionSalesMonthSelectCompany()
    {
        $nope = false;
        $bilets = [];
        if(isset($_POST['show']) | isset($_POST['report'])) {
            $shifr_aviakompanii = filter_input(INPUT_POST, 'shifr_aviakompanii', FILTER_SANITIZE_NUMBER_INT);
            $month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT);
            $bilets = Report::salesMonthSelectCompany($shifr_aviakompanii, $month);
            if (isset($_POST['show']) and empty($bilets)) $nope = true;
            if (isset($_POST['report'])) {
                $biletsRep = array_map(function($bilet) {
                    return array(
                        'Шифр авиакомпании' => $bilet['shifr_aviakompanii'],
                        'Название авиакомпании' => $bilet['nazvanie_a'],
                        'Населенный пункт авиакомпании' => $bilet['naselennyj_punkt_a'],
                        'Улица авиакомпании' => $bilet['ulica_a'],
                        'Номер дома авиакомпании' => $bilet['nomer_doma_a'],
                        'Офис авиакомпании' => $bilet['ofis_a'],
                        'Номер кассы' => $bilet['nomer_kassy'],
                        'Населенный пункт кассы' => $bilet['naselennyj_punkt'],
                        'Улица кассы' => $bilet['ulica'],
                        'Номер дома кассы' => $bilet['nomer_doma'],
                        'Табельный номер кассира' => $bilet['tabelnyj_nomer_kassira '],
                        'Фамилия кассира' => $bilet['familiya'],
                        'Имя кассира' => $bilet['imya'],
                        'Отчетство кассира' => $bilet['otchestvo'],
                        'Тип билета' => $bilet['tip'],
                        'Дата продажи билета' => $bilet['data_prodazhi']
                    );
                }, $bilets);
                arr_to_csv($biletsRep, 'Билеты проданные за указанный месяц указанной авиакомпании');
            }
        }
        $aviakompaniyas = Aviakompaniya::findAll();
        $this->view->display('report/salesMonthSelectCompany.twig', ['aviakompaniyas' => $aviakompaniyas, 'nope' => $nope, 'bilets' => $bilets]);
    }
}