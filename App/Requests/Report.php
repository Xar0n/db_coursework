<?php

namespace App\Requests;
use App\Request;

class Report extends Request
{
    public static function generalSales()
    {
        $sql = 'SELECT bilet.shifr_aviakompanii, aviakompaniya.nazvanie, aviakompaniya.naselennyj_punkt, aviakompaniya.ulica, 
        aviakompaniya.nomer_doma, aviakompaniya.ofis, (SELECT SUM(kupon.tarif) FROM kupon WHERE  bilet.id = kupon.nomer_bileta 
        AND aviakompaniya.id = bilet.shifr_aviakompanii) AS sum_sales FROM `bilet`, `kupon`, `aviakompaniya` WHERE bilet.id = kupon.nomer_bileta 
        AND aviakompaniya.id = bilet.shifr_aviakompanii GROUP BY bilet.id';
        $results = self::request($sql);
        $sum = [];
        $exist = [];
        $new = [];
        foreach ($results as $result) {
            $sum[$result['shifr_aviakompanii']] = $sum[$result['shifr_aviakompanii']] + $result['sum_sales'];
        }
        foreach ($results as $result) {
            if ($exist[$result['shifr_aviakompanii']] == false ) {
                $exist[$result['shifr_aviakompanii']] = true;
                $result['sum_sales'] = $sum[$result['shifr_aviakompanii']];
                $new[] = $result;
            }
        }
        return $new;
    }

    public static function listClientsOnDate($date)
    {
        $sql='SELECT klient.nomer_i_seriya_pasporta, klient.familiya, klient.imya, klient.otchestvo, kupon.nunkt_posadki,
        kupon.nunkt_vysadki, kupon.tarif, bilet.tip, bilet.data_prodazhi, bilet.shifr_aviakompanii, aviakompaniya.nazvanie, aviakompaniya.naselennyj_punkt, 
        aviakompaniya.ulica, aviakompaniya.nomer_doma, aviakompaniya.ofis FROM `klient`, `kupon`, `bilet`, `aviakompaniya` 
        WHERE bilet.id = kupon.nomer_bileta AND klient.nomer_i_seriya_pasporta = kupon.nomer_i_seriya_pasporta_klienta 
        and bilet.shifr_aviakompanii = aviakompaniya.id and bilet.data_prodazhi =  \''.$date.'\'';
        return self::request($sql);
    }

    public static function salesMonthSelectCompany($shifr_aviakompanii, $month)
    {
        $sql = 'SELECT bilet.*, aviakompaniya.nazvanie AS nazvanie_a, aviakompaniya.naselennyj_punkt AS naselennyj_punkt_a, 
       aviakompaniya.ulica AS ulica_a, aviakompaniya.nomer_doma AS nomer_doma_a, aviakompaniya.ofis AS ofis_a, 
       kassa.naselennyj_punkt, kassa.ulica, kassa.nomer_doma, kassir.familiya, kassir.imya, kassir.otchestvo FROM `bilet`, 
       `aviakompaniya`, `kassa`, `kassir` WHERE month(`data_prodazhi`) = month(\'2020-'.$month.'-4\') 
       AND `shifr_aviakompanii` = '.$shifr_aviakompanii.' AND bilet.shifr_aviakompanii = aviakompaniya.id AND bilet.nomer_kassy = kassa.id 
                                          AND bilet.tabelnyj_nomer_kassira = kassir.id';
        return self::request($sql);
    }
}